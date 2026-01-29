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

class BannerController extends Controller
{
    public function index() {
      return view('banner.index');
    }

    public function datatable() {
      $data = DB::table('banner')
        ->get();


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
          ->addColumn('aksi', function ($data) {
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="edit('.$data->id.')" class="btn btn-info btn-lg" title="edit">'.
                     '<label class="fa fa-pencil-alt"></label></button>'.
                     '<button type="button" onclick="hapus('.$data->id.')" class="btn btn-danger btn-lg" title="hapus">'.
                     '<label class="fa fa-trash"></label></button>'.
                  '</div>';
          })
          ->rawColumns(['aksi'])
          ->addIndexColumn()
          ->make(true);
    }

    public function tambah() {
      return view('banner.tambah');
    }

    public function simpan(Request $req) {
      if ($req->id == null) {
        DB::beginTransaction();
        try {

          $max = DB::table("banner")->max('id') + 1;

          DB::table("banner")
              ->insert([
              "id" => $max,
              "title" => $req->title,
            ]);

          $file = $req->file('file');
          if (isset($file)) {
          foreach ($file as $key => $value) {

            $imgPath = null;
            $tgl = Carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'image/uploads/Banner/' . $max . '/' . ($key + 1) ;
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

                        DB::table("banner_photos")
                            ->insert([
                              'banner_id' => $max,
                              'photo_url' => $imgPath,
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
          return response()->json(["status" => 2]);
        }
      } else {
        DB::beginTransaction();
        try {

          $max = DB::table("banner")->where("id", $req->id)->max('id');

          DB::table("banner")
              ->where("id", $req->id)
              ->update([
              "title" => $req->title,
            ]);

          $file = $req->file('file');
          if (isset($file)) {
            foreach ($file as $key => $value) {
              // dd($file);
              $imgPath = null;
              $tgl = Carbon::now('Asia/Jakarta');
              $folder = $tgl->year . $tgl->month . $tgl->timestamp;

              $dir = 'image/uploads/Banner/' . $req->id . '/' . ($max + ($key + 1)) ;

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

                        DB::table("banner_photos")
                            ->insert([
                              'banner_id' => $max,
                              'photo_url' => $imgPath,
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
          return response()->json(["status" => 4]);
        }
      }

    }

    public function hapus(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("banner")
            ->where("id", $req->id)
            ->delete();

        DB::table("banner_photos")
          ->where("banner_id", $req->id)
          ->delete();

        $dir = 'image/uploads/Banner/' . $req->id;
        $childPath = $dir . '/';

        $this->deleteDir($dir);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }
    }

    public function edit($id) {
      return view('banner.edit', compact('id'));
    }

    public function doedit(Request $req) {
      $id = $req->id;

      $dataposts = DB::table("banner")->where("id", $id)->first();

      $dataimage = DB::table("banner_photos")->where("banner_id", $id)->get();

      return response()->json([
        'posts' => $dataposts,
        'image' => $dataimage
      ]);
    }

    public function removeimage(Request $req) {
      DB::table("banner_photos")->where("id", $req->id)->delete();

      $dir = 'image/uploads/Banner/' . $cek->id;
      $childPath = $dir . '/';

      $this->deleteDir($dir);

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
