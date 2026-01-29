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

class UsersController extends Controller
{
    public function index() {
      return view('users.index');
    }

    public function datatable() {
      $data = DB::table('users')
        ->get();

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

    public function simpan(Request $req) {
      if ($req->id == null) {
        DB::beginTransaction();
        try {

          $max = DB::table("users")->max('id') + 1;

          DB::table("users")
              ->insert([
              "id" => $max,
              "full_name" => $req->full_name,
              "username" => $req->username,
              "password" => sha1(md5('passwordAllah'). $req->password),
              "created_at" => Carbon::now('Asia/Jakarta'),
            ]);

          DB::commit();
          return response()->json(["status" => 1]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 2]);
        }
      } else {
        DB::beginTransaction();
        try {

            DB::table("users")
                ->where('id', $req->id)
                ->update([
                "full_name" => $req->full_name,
                "username" => $req->username,
                "password" => sha1(md5('passwordAllah'). $req->password),
                "updated_at" => Carbon::now('Asia/Jakarta'),
              ]);

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

        $cek = DB::table("users")->where("id", $req->id)->count();

        DB::table("users")
            ->where("id", $req->id)
            ->delete();

        DB::commit();
        return response()->json(["status" => 5]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 6]);
      }

    }

    public function edit(Request $req) {
      $data = DB::table("users")
              ->where("id", $req->id)
              ->first();

      return response()->json($data);
    }

}
