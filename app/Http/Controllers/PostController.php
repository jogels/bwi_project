<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\mMember;


use Auth;

use Carbon\Carbon;

use Log;
use Session;

use DB;

use File;

use Yajra\Datatables\Datatables;

use App\Post;

class PostController extends Controller
{
    public function index() {
      return view('posts.index');
    }

    public function datatable(Request $request) {
      $data = DB::table('posts');
      
      if($request->has('search') && $request->search['value'] != '') {
        $search = $request->search['value'];
        $data = $data->where(function($query) use ($search) {
          $query->where('title', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%");
        });
      }

      $data = $data->get();
  
      return Datatables::of($data)
          ->addColumn('aksi', function ($data) {
              $highlightClass = $data->is_highlight == "N" ? "btn-success" : "btn-warning";
              $highlightTitle = $data->is_highlight == "N" ? "Activate Highlight" : "Deactivate Highlight";
              $highlightIcon = $data->is_highlight == "N" ? "fa-bars" : "fa-check";
  
              return  '<div class="btn-group">'.
                       '<button type="button" onclick="highlight('.$data->id.')" class="btn '.$highlightClass.' btn-lg" title="'.$highlightTitle.'">'.
                       '<label class="fa '.$highlightIcon.'"></label></button>'.
                       '<button type="button" onclick="edit('.$data->id.')" class="btn btn-info btn-lg" title="Edit">'.
                       '<label class="fa fa-pencil-alt"></label></button>'.
                       '<button type="button" onclick="hapus('.$data->id.')" class="btn btn-danger btn-lg" title="Hapus">'.
                       '<label class="fa fa-trash"></label></button>'.
                    '</div>';
          })
          ->addColumn('body', function ($data) {
              return mb_strimwidth($data->body, 0, 255, "...");
          })
          ->addColumn('is_highlight', function ($data) {
              return $data->is_highlight == "Y" ? "Yes" : "No";
          })
          ->rawColumns(['aksi', 'body'])
          ->addIndexColumn()
          ->make(true);
  }
  

    public function tambah() {
      return view('posts.tambah');
    }

    public function simpan(Request $req) {
      if ($req->id == null) {
        DB::beginTransaction();
        try {

          $max = DB::table("posts")->max('id') + 1;

          DB::table("posts")
              ->insert([
              "id" => $max,
              "user_id" => Auth::user()->id,
              "title" => $req->title,
              "body" => $req->body,
              "category" => $req->category,
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

          $file = $req->file('file');
          if (isset($file)) {
          foreach ($file as $key => $value) {

            $imgPath = null;
            $tgl = Carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'image/uploads/Posts/' . $max . '/' . ($key + 1) ;
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
                        compressImage(strtolower($value->getClientOriginalExtension()),$imgPath,$imgPath,60); 

                        DB::table("post_photos")
                            ->insert([
                              'post_id' => $max,
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

          $max = DB::table("posts")->where("id", $req->id)->max('id');

          DB::table("posts")
              ->where("id", $req->id)
              ->update([
              "user_id" => Auth::user()->id,
              "title" => $req->title,
              "body" => $req->body,
              "category" => $req->category,
              "updated_at" => Carbon::now('Asia/Jakarta'),
            ]);

          $file = $req->file('file');
          if (isset($file)) {
            foreach ($file as $key => $value) {
              // dd($file);
              $imgPath = null;
              $tgl = Carbon::now('Asia/Jakarta');
              $folder = $tgl->year . $tgl->month . $tgl->timestamp;

              $dir = 'image/uploads/Posts/' . $req->id . '/' . ($max + ($key + 1)) ;

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

                        DB::table("post_photos")
                            ->insert([
                              'post_id' => $max,
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

        DB::table("posts")
            ->where("id", $req->id)
            ->delete();

        DB::table("post_photos")
          ->where("post_id", $req->id)
          ->delete();

        $dir = 'image/uploads/Posts/' . $req->id;
        $childPath = $dir . '/';

        $this->deleteDir($dir);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }
    }

    public function highlight(Request $req) {
      DB::beginTransaction();
      try {
          // Cek apakah post dengan ID yang diberikan ada
          $post = DB::table("posts")
                  ->where("id", $req->id)
                  ->first();

          if (!$post) {
              return response()->json(["status" => 404, "message" => "Post not found"]);
          }

          // Jika post saat ini sudah di-highlight (is_highlight = "Y"), ubah menjadi "N"
          if ($post->is_highlight == "Y") {
              DB::table("posts")
                ->where("id", $req->id)
                ->update([
                    "is_highlight" => "N",
                ]);
          } else {
              // Set semua post lainnya menjadi "N" sebelum mengubah post ini menjadi "Y"
              DB::table("posts")
                ->update([
                    "is_highlight" => "N",
                ]);

              // Ubah post yang dipilih menjadi "Y"
              DB::table("posts")
                ->where("id", $req->id)
                ->update([
                    "is_highlight" => "Y",
                ]);
          }

          DB::commit();
          return response()->json(["status" => 3, "message" => "Highlight updated successfully"]);
      } catch (\Exception $e) {
          DB::rollback();
          return response()->json([
              "status" => 4,
              "message" => "An error occurred",
              "error" => $e->getMessage(),
          ]);
      }
    }

    public function edit($id) {
      return view('posts.edit', compact('id'));
    }

    public function doedit(Request $req) {
      $id = $req->id;

      $dataposts = DB::table("posts")->where("id", $id)->first();

      $dataimage = DB::table("post_photos")->where("post_id", $id)->get();

      return response()->json([
        'posts' => $dataposts,
        'image' => $dataimage
      ]);
    }

    public function removeimage(Request $req) {
      DB::table("post_photos")->where("id", $req->id)->delete();

      $dir = 'image/uploads/Posts/' . $req->id;
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
