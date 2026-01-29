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

class SubdistrictsController extends Controller
{
    public function index() {
      $data = DB::table('cities')
        ->get();

      return view('subdistricts.index', compact('data'));
    }

    public function datatable() {
      $data = DB::table('subdistricts')
        ->join("cities", "cities.id", "=", "subdistricts.city_id")
        ->select("cities.name as city", "subdistricts.id as id", "subdistricts.name as name")
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
      // dd(;
      if ($req->id == null) {
        DB::beginTransaction();
        try {

          $max = DB::table("subdistricts")->max('id') + 1;

          DB::table("subdistricts")
              ->insert([
              "id" => $max,
              "city_id" => $req->city,
              "name" => $req->name,
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

          DB::table("subdistricts")
              ->where('id', $req->id)
              ->update([
              "name" => $req->name,
              "city_id" => $req->city,
              "created_at" => Carbon::now('Asia/Jakarta'),
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

        DB::table("subdistricts")
            ->where("id", $req->id)
            ->delete();

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function edit(Request $req) {
      $data = DB::table("subdistricts")
              ->where("subdistricts.id", $req->id)
              ->join("cities", "cities.id", "=", "subdistricts.city_id")
              ->select("cities.name as city", "subdistricts.id as id", "subdistricts.name as name", "cities.id as city_id")
              ->first();

      return response()->json($data);
    }
}
