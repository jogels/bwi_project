<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WakafLand;
use DB;

class JumlahWakafController extends Controller
{
    public function index(Request $request)
    {
        $subDistrictId = $request->query('id');
        $type = $request->query('type');

        // Base query with relations
        $query = WakafLand::select([
                'wakaf_lands.id',
                'villages.name as kelurahan', 
                'wakaf_lands.area_size as luas',
                'wakaf_lands.used as penggunaan',
                'wakaf_lands.wakif_name',
                'wakaf_lands.nadzir_name',
                'wakaf_lands.certificate_no as nomor_sertifikat',
                'wakaf_lands.certificate_date as tanggal_sertifikat',
                'wakaf_lands.aiw_no as nomor_aiw',
                'wakaf_lands.aiw_date as tanggal_aiw',
            ])
            ->leftJoin('villages', 'villages.id', '=', 'wakaf_lands.village_id')
            ->where('wakaf_lands.subdistrict_id', $subDistrictId);

        // Apply certification type filter
        if ($type === 'certified') {
            $query->whereNotNull('wakaf_lands.certificate_no')
                  ->where('wakaf_lands.certificate_no', '!=', '-');
        } elseif ($type === 'uncertified') {
            $query->where(function($q) {
                $q->whereNull('wakaf_lands.certificate_no')
                  ->orWhere('wakaf_lands.certificate_no', '-');
            });
        }

        // Get the data
        $data = $query->get()
            ->map(function ($wakaf, $index) {
                return [
                    'no' => $index + 1,
                    'id' => $wakaf->id,
                    'kelurahan' => $wakaf->kelurahan ?? 'N/A',
                    'luas' => (int)$wakaf->luas,
                    'penggunaan' => $wakaf->penggunaan ?? 'N/A',
                    'wakif' => $wakaf->wakif_name ?? 'N/A',
                    'nazhir' => $wakaf->nadzir_name ?? 'N/A',
                    'nomor_sertifikat' => $wakaf->nomor_sertifikat ?? 'N/A',
                    'tanggal_sertifikat' => $wakaf->tanggal_sertifikat ? date('d-m-Y', strtotime($wakaf->tanggal_sertifikat)) : 'N/A',
                    'nomor_aiw' => $wakaf->nomor_aiw ?? 'N/A',
                    'tanggal_aiw' => $wakaf->tanggal_aiw ? date('d-m-Y', strtotime($wakaf->tanggal_aiw)) : 'N/A',
                ];
            });

        // Get subdistrict name for the title
        $subDistrictName = DB::table('subdistricts')
            ->where('id', $subDistrictId)
            ->value('name');

        // Get certification type text for the title
        $typeText = $type === 'certified' ? 'Sudah Bersertifikat' : 
                   ($type === 'uncertified' ? 'Belum Bersertifikat' : 'Semua Status');

        return view("jumlah_wakaf.index", compact('data', 'subDistrictName', 'typeText'));
    }
}
