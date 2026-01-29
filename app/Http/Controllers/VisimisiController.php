<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use File;

class VisimisiController extends Controller
{

     public function index() {
        $data = DB::table("vision_misions")
        ->join("photos", "photos.id", "=", "vision_misions.photo_id")
        ->where('vision_misions.id', 1)
        ->first();

       return view("profil.visimisi.index", compact("data"));
     }

     public function save(Request $req) {
       DB::beginTransaction();
       try {

            $imgPath = null;
            $tgl = carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'image/uploads/Photos';
            $childPath = $dir . '/';
            $path = $childPath;

            $file = $req->file('image');
            $name = null;
            if ($file != null) {
                $this->deleteDir($dir);
                $name = $folder . '.' . $file->getClientOriginalExtension();
                if (!File::exists($path)) {
                    if (File::makeDirectory($path, 0777, true)) {
                      // compressImage($_FILES['image']['type'],$_FILES['image']['tmp_name'],$_FILES['image']['tmp_name'],50);
                        $file->move($path, $name);
                        $imgPath = $childPath . $name;
                    } else
                        $imgPath = null;
                } else {
                    return 'already exist';
                }
            }

            $data = DB::table("vision_misions")->get();

            if (count($data) != 0) {
                $photo = DB::table("photos")
                            ->where("id", $data[0]->photo_id)
                            ->first();

                $this->deleteDir($photo->url);
                            
                DB::table("photos")
                ->where("id", $data[0]->photo_id)
                ->delete();

                $id = DB::table("photos")
                ->insertGetId([
                  'url' => $imgPath,
                  'created_at' => Carbon::now('Asia/Jakarta')
                ]);

                DB::table("vision_misions")
                  ->where('id', 1)
                  ->update([
                    'title' => $req->title,
                    'vision' => $req->vision,
                    'mission' => $req->mission,
                    'photo_id' => $id,
                    'updated_at' => Carbon::now('Asia/Jakarta')
                  ]);
            } else {
                $id = DB::table("photos")
                ->insertGetId([
                  'url' => $imgPath,
                  'created_at' => Carbon::now('Asia/Jakarta')
                ]);

                DB::table("vision_misions")
                  ->insert([
                    'id' => 1,
                    'title' => $req->title,
                    'vision' => $req->vision,
                    'mission' => $req->mission,
                    'photo_id' => $id,
                    'updated_at' => Carbon::now('Asia/Jakarta')
                  ]);
            }

            DB::commit();
            Session::flash('sukses', 'sukses');

            return back()->with('sukses','sukses');
       } catch (\Exception $e) {
            DB::rollback();
            Session::flash('gagal', 'gagal');

            return back()->with('gagal','gagal');
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

