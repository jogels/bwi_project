<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use File;

use Yajra\Datatables\Datatables;

use App\WakafLand;

use App\Subdistrict;
use App\Village;

use Illuminate\Support\Str;

use URL;

class WakaflandController extends Controller
{
    public function index() {
      $city = DB::table('cities')
        ->get();

      $city = DB::table('cities')->get();

      $sub = DB::table('subdistricts')
      ->get();

      $village = DB::table('villages')
      ->get();

      return view('wakafland.index', compact('city', 'sub', 'village'));
    }

    public function getSubdistricts($city_id)
    {
        try {
            $subdistricts = DB::table('subdistricts')
                ->where('city_id', $city_id)
                ->select('id', 'name')
                ->get();

            return response()->json($subdistricts);
        } catch (\Exception $e) {
            \Log::error('Error getting subdistricts: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load subdistricts'], 500);
        }
    }

    public function getVillages($subdistrict_id)
    {

      $villages = Village::where('subdistrict_id', $subdistrict_id)->get();

      // Kembalikan response dalam format JSON
      return response()->json($villages);
    }

    public function datatable(Request $request) {

      $query = DB::table('wakaf_lands')
          ->leftJoin('cities', 'wakaf_lands.city_id', '=', 'cities.id')
          ->leftJoin('subdistricts', 'wakaf_lands.subdistrict_id', '=', 'subdistricts.id')
          ->leftJoin('villages', 'wakaf_lands.village_id', '=', 'villages.id')
          ->select(
              'wakaf_lands.*',
              'cities.name as city_name',
              'subdistricts.name as subdistrict_name',
              'villages.name as village_name'
          );

      if($request->has('city_id') && $request->city_id) {
        $query->where('wakaf_lands.city_id', $request->city_id);
      }

      if ($request->has('subdistrict_id') && $request->subdistrict_id) {
        $query->where('wakaf_lands.subdistrict_id', $request->subdistrict_id);
      }
  
      $data = $query->get();
  
      return Datatables::of($data)
          ->addColumn('aksi', function ($data) {
              return '<div class="btn-group">' .
                  '<button type="button" onclick="edit(' . $data->id . ')" class="btn btn-info btn-lg" title="edit">' .
                  '<label class="fa fa-pencil-alt"></label></button>' .
                  '<button type="button" onclick="hapus(' . $data->id . ')" class="btn btn-danger btn-lg" title="hapus">' .
                  '<label class="fa fa-trash"></label></button>' .
                  '</div>';
          })
          ->rawColumns(['aksi'])
          ->addIndexColumn()
          ->make(true);
    }
  

    public function simpan(Request $req) {
      if ($req->id == null) {
        DB::beginTransaction();
        try {

          $max = DB::table("wakaf_lands")->max('id') + 1;

          // Determine status based on certificate_no
          $status = $req->certificate_no ? 'sudah' : 'belum';

          DB::table("wakaf_lands")
              ->insert([
              "id" => $max,
              "register_no" => $req->register_no,
              "city_id" => $req->city_id,
              "subdistrict_id" => $req->subdistrict_id,
              "village_id" => $req->village_id,
              "area_size" => $req->area_size,
              "used" => $req->used,
              "object_name" => $req->object_name,
              "address" => $req->address,
              "status" => $status,
              "certificate_no" => $req->certificate_no,
              "certificate_date" => Carbon::parse($req->certificate_date)->format('Y-m-d'),
              "aiw_no" => $req->aiw_no,
              "aiw_date" => Carbon::parse($req->aiw_date)->format('Y-m-d'),
              "latitude" => $req->latitude,
              "longitude" => $req->longitude,
              "wakif_name" => $req->wakif_name,
              "nadzir_name" => $req->nadzir_name,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

          $file = $req->file('photos');
          if (isset($file)) {
            foreach ($file as $key => $value) {
              $imgPath = null;
              $tgl = Carbon::now('Asia/Jakarta');
              $folder = $tgl->year . $tgl->month . $tgl->timestamp;
              $dir = 'image/uploads/WakafLand/' . $max . '/' . ($key + 1);
              $childPath = $dir . '/';
              $path = $childPath;

              $name = null;
              if ($value != null) {
                  $this->deleteDir($dir);
                  $name = $folder . '.' . $value->getClientOriginalExtension();
                  if (!File::exists($path)) {
                      if (File::makeDirectory($path, 0777, true)) {
                          $value->move($path, $name);
                          $imgPath = $childPath . $name;
                          compressImage($value->getClientOriginalExtension(),$imgPath,$imgPath,60);

                          DB::table("photos")
                              ->insert([
                                'url' => $imgPath,
                                'created_at' => Carbon::now('Asia/Jakarta')
                              ]);

                          $photoId = DB::getPdo()->lastInsertId();

                          DB::table("wakaf_land_photos")
                              ->insert([
                                'wakaf_land_id' => $max,
                                'photo_id' => $photoId
                              ]);

                      } else
                          $imgPath = null;
                  } else {
                      return 'already exist';
                  }
              }
            }
          }

          DB::commit();
          return response()->json(["status" => 1]);
        } catch (\Exception $e) {
          DB::rollback();
          \Log::error('Error in edit:', ['error' => $e->getMessage()]);
          return response()->json(["status" => 2, "message" => $e->getMessage()]);
        }
      } else {
        DB::beginTransaction();
        try {
          $status = $req->certificate_no ? 'sudah' : 'belum';

          // Handle Excel date number format
          $certificateDate = null;
          if ($req->certificate_date) {
              try {
                  // Convert Excel date number to PHP DateTime
                  $unixDate = ($req->certificate_date - 25569) * 86400;
                  $certificateDate = Carbon::createFromTimestamp($unixDate)->format('Y-m-d');
              } catch (\Exception $e) {
                  // If conversion fails, try parsing as regular date
                  $certificateDate = Carbon::parse($req->certificate_date)->format('Y-m-d');
              }
          }

          // Handle AIW date
          $aiwDate = null;
          if ($req->aiw_date) {
              try {
                  $aiwDate = Carbon::parse($req->aiw_date)->format('Y-m-d');
              } catch (\Exception $e) {
                  // If parsing fails, set to null or handle error as needed
                  $aiwDate = null;
              }
          }

          DB::table("wakaf_lands")
              ->where('id', $req->id)
              ->update([
                "register_no" => $req->register_no,
                "city_id" => $req->city_id,
                "subdistrict_id" => $req->subdistrict_id,
                "village_id" => $req->village_id,
                "area_size" => $req->area_size,
                "used" => $req->used,
                "object_name" => $req->object_name,
                "address" => $req->address,
                "status" => $status,
                "certificate_no" => $req->certificate_no,
                "certificate_date" => $certificateDate,
                "aiw_no" => $req->aiw_no,
                "aiw_date" => $aiwDate,
                "latitude" => $req->latitude,
                "longitude" => $req->longitude,
                "wakif_name" => $req->wakif_name,
                "nadzir_name" => $req->nadzir_name,
                "updated_at" => Carbon::now('Asia/Jakarta'),
              ]);

          $file = $req->file('photos');
          if (isset($file)) {
            foreach ($file as $key => $value) {
              $imgPath = null;
              $tgl = Carbon::now('Asia/Jakarta');
              $folder = $tgl->year . $tgl->month . $tgl->timestamp;
              $dir = 'image/uploads/WakafLand/' . $req->id . '/' . ($key + 1);
              $childPath = $dir . '/';
              $path = $childPath;

              $name = null;
              if ($value != null) {
                  $this->deleteDir($dir);
                  $name = $folder . '.' . $value->getClientOriginalExtension();
                  if (!File::exists($path)) {
                      if (File::makeDirectory($path, 0777, true)) {
                          $value->move($path, $name);
                          $imgPath = $childPath . $name;
                          compressImage($value->getClientOriginalExtension(),$imgPath,$imgPath,60);

                          DB::table("photos")
                              ->insert([
                                'url' => $imgPath,
                                'created_at' => Carbon::now('Asia/Jakarta')
                              ]);

                          $photoId = DB::getPdo()->lastInsertId();

                          DB::table("wakaf_land_photos")
                              ->insert([
                                'wakaf_land_id' => $req->id,
                                'photo_id' => $photoId
                              ]);

                      } else
                          $imgPath = null;
                  } else {
                      return 'already exist';
                  }
              }
            }
          }

          DB::commit();
          return response()->json(["status" => 3]);
        } catch (\Exception $e) {
          DB::rollback();
          \Log::error('Error in edit:', ['error' => $e->getMessage()]);
          return response()->json(["status" => 4, "message" => $e->getMessage()]);
        }
      }
    }

    public function hapus(Request $req) {
      DB::beginTransaction();
      try {
        $wakafLand = WakafLand::findOrFail($req->id);
        $wakafLand->delete();

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function edit(Request $req) {
        try {
            \Log::info('Edit request received:', ['id' => $req->id]);

            // Get wakaf land data
            $data = DB::table("wakaf_lands")
                ->where("wakaf_lands.id", $req->id)
                ->first();

            if ($data) {
                // Get photos separately
                $photos = DB::table('wakaf_land_photos')
                    ->join('photos', 'wakaf_land_photos.photo_id', '=', 'photos.id')
                    ->where('wakaf_land_photos.wakaf_land_id', $req->id)
                    ->select('photos.id as photo_id', 'photos.url')
                    ->get();

                // Add photos to data object
                $data->photo_ids = $photos->pluck('photo_id')->toArray();
                $data->photo_urls = $photos->pluck('url')->toArray();

                \Log::info('Data found:', ['data' => $data]);
            } else {
                \Log::warning('No data found for id:', ['id' => $req->id]);
            }

            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('Error in edit:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deletePhoto(Request $req) {
      DB::beginTransaction();
      try {
        // Get photo details
        $photo = DB::table('photos')
          ->join('wakaf_land_photos', 'photos.id', '=', 'wakaf_land_photos.photo_id')
          ->where('photos.id', $req->photo_id)
          ->first();

        if ($photo) {
          // Delete physical file
          if (File::exists(public_path($photo->url))) {
            File::delete(public_path($photo->url));
          }

          // Delete from wakaf_land_photos
          DB::table('wakaf_land_photos')
            ->where('photo_id', $req->photo_id)
            ->delete();

          // Delete from photos
          DB::table('photos')
            ->where('id', $req->photo_id)
            ->delete();
        }

        DB::commit();
        return response()->json(["status" => 1]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2, "message" => $e->getMessage()]);
      }
    }

    public function deleteDir($dirPath)
    {
       if (!is_dir($dirPath)) {
           return false;
       }
       if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
           $dirPath .= '/';
       }
       $files = glob($dirPath . '*', GLOB_MARK);
       foreach ($files as $file) {
           if (is_dir($file)) {
               self::deleteDir($file);
           } else {
               unlink($file);
           }
       }
       rmdir($dirPath);
   }
}
