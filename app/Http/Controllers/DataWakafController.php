<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\WakafLand;
use Illuminate\Support\Collection;
use DB;

class DataWakafController extends Controller
{
    private $wakafData;

    public function __construct()
    {
        $this->initializeWakafData();
    }

    /**
     * Initialize wakaf data for cities
     */
    private function initializeWakafData()
    {
        $cities = $this->getCitiesWithWakafData();
        $this->wakafData = $this->formatCityData($cities);
    }

    /**
     * Get cities with their wakaf land data
     */
    private function getCitiesWithWakafData()
    {
        return City::select('cities.id', 'cities.name')
            ->leftJoin('wakaf_lands', 'wakaf_lands.city_id', '=', 'cities.id')
            ->selectRaw('count(wakaf_lands.id) as jumlah')
            ->selectRaw('sum(wakaf_lands.area_size) as luas')
            ->groupBy('cities.id')
            ->get();
    }

    /**
     * Format city data with certificate details
     */
    private function formatCityData(Collection $cities)
    {
        return $cities->map(function ($city) {
            $certificateData = $this->getCertificateData($city->id);
            
            return [
                'name' => $city->name,
                'jumlah' => $city->jumlah ?? 0,
                'luas' => $city->luas ?? 0,
                'sudah_sertifikat_jumlah' => $certificateData['certified_count'],
                'sudah_sertifikat_luas' => $certificateData['certified_area'],
                'belum_sertifikat_jumlah' => $certificateData['uncertified_count'],
                'belum_sertifikat_luas' => $certificateData['uncertified_area'],
            ];
        });
    }

    /**
     * Get certificate data for a city
     */
    private function getCertificateData($cityId)
    {
        $certified = WakafLand::where('city_id', $cityId)
            ->whereNotNull('certificate_no')
            ->where('certificate_no', '!=', '-');

        $uncertified = WakafLand::where('city_id', $cityId)
            ->where(function ($query) {
                $query->whereNull('certificate_no')
                      ->orWhere('certificate_no', '-');
            });

        return [
            'certified_count' => $certified->count(),
            'certified_area' => $certified->sum('area_size'),
            'uncertified_count' => $uncertified->count(),
            'uncertified_area' => $uncertified->sum('area_size'),
        ];
    }

    /**
     * Display the main index page
     */
    public function index(Request $request)
    {
        return view("data_wakaf/index", [
            'region' => $request->query('region')
        ]);
    }

    /**
     * API endpoint for AJAX requests
     */
    public function getData(Request $request)
    {
        try {
            $region = $request->query('region');
            $search = $request->query('search');
            
            if ($region) {
                return $this->getRegionData($region, $search);
            }

            return $this->getFilteredData($request);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Get data for a specific region
     */
    private function getRegionData($region, $search)
    {
        $city = City::where('name', $region)->first();
        
        if (!$city) {
            return $this->errorResponse('Region not found', 404);
        }

        return $this->getSubDistrictData($city->id, $search);
    }

    /**
     * Get filtered and sorted data
     */
    private function getFilteredData(Request $request)
    {
        $data = $this->wakafData;

        // Apply search filter
        if ($request->search) {
            $data = $this->applySearch($data, $request->search);
        }

        // Apply sorting
        if ($request->sort && $request->direction) {
            $data = $this->applySort($data, $request->sort, $request->direction);
        }

        if ($data->isEmpty()) {
            return $this->errorResponse('No data found', 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data->values()->all()
        ]);
    }

    /**
     * Get subdistrict data for a city
     */
    private function getSubDistrictData($cityId, $search)
    {
        try {
            $query = DB::table('subdistricts')
                ->select(
                    'subdistricts.id',
                    'subdistricts.name',
                    DB::raw('COUNT(DISTINCT wakaf_lands.id) as jumlah'),
                    DB::raw('COALESCE(SUM(wakaf_lands.area_size), 0) as luas'),
                    DB::raw('COUNT(DISTINCT CASE WHEN wakaf_lands.certificate_no IS NOT NULL AND wakaf_lands.certificate_no != "-" AND wakaf_lands.certificate_no != "" THEN wakaf_lands.id END) as sudah_sertifikat_jumlah'),
                    DB::raw('COALESCE(SUM(CASE WHEN wakaf_lands.certificate_no IS NOT NULL AND wakaf_lands.certificate_no != "-" AND wakaf_lands.certificate_no != "" THEN wakaf_lands.area_size ELSE 0 END), 0) as sudah_sertifikat_luas'),
                    DB::raw('COUNT(DISTINCT CASE WHEN wakaf_lands.certificate_no IS NULL OR wakaf_lands.certificate_no = "-" OR wakaf_lands.certificate_no = "" THEN wakaf_lands.id END) as belum_sertifikat_jumlah'),
                    DB::raw('COALESCE(SUM(CASE WHEN wakaf_lands.certificate_no IS NULL OR wakaf_lands.certificate_no = "-" OR wakaf_lands.certificate_no = "" THEN wakaf_lands.area_size ELSE 0 END), 0) as belum_sertifikat_luas')
                )
                ->leftJoin('wakaf_lands', function($join) {
                    $join->on('wakaf_lands.subdistrict_id', '=', 'subdistricts.id');
                })
                ->where('subdistricts.city_id', $cityId)
                ->where('subdistricts.name', 'like', '%' . $search . '%')
                ->groupBy('subdistricts.id', 'subdistricts.name');

            \Log::info('Generated SQL Query:', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);

            $subRegions = $query->get();

            // Validate totals match
            foreach ($subRegions as $region) {
                if ($region->jumlah != ($region->sudah_sertifikat_jumlah + $region->belum_sertifikat_jumlah)) {
                    \Log::warning("Data mismatch found for subdistrict {$region->name}");
                }
                if (abs($region->luas - ($region->sudah_sertifikat_luas + $region->belum_sertifikat_luas)) > 0.01) {
                    \Log::warning("Area mismatch found for subdistrict {$region->name}");
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => $this->formatSubRegionData($subRegions)
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getSubDistrictData: ' . $e->getMessage());
            return $this->errorResponse('Error fetching sub-district data: ' . $e->getMessage());
        }
    }

    /**
     * Format subregion data
     */
    private function formatSubRegionData($subRegions)
    {
        return $subRegions->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'jumlah' => (int)$item->jumlah,
                'luas' => (int)$item->luas,
                'sudah_sertifikat_jumlah' => (int)$item->sudah_sertifikat_jumlah,
                'sudah_sertifikat_luas' => (int)$item->sudah_sertifikat_luas,
                'belum_sertifikat_jumlah' => (int)$item->belum_sertifikat_jumlah,
                'belum_sertifikat_luas' => (int)$item->belum_sertifikat_luas
            ];
        });
    }

    /**
     * Apply search filter to data
     */
    private function applySearch($data, $search)
    {
        $search = strtolower($search);
        return $data->filter(function ($item) use ($search) {
            return str_contains(strtolower($item['name']), $search);
        });
    }

    /**
     * Apply sorting to data
     */
    private function applySort($data, $field, $direction)
    {
        return $data->sortBy($field, SORT_REGULAR, $direction === 'desc');
    }

    /**
     * Generate error response
     */
    private function errorResponse($message, $code = 500)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => []
        ], $code);
    }
}
