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

use App\Nadzir;

use Yajra\Datatables\Datatables;

class NadzirsController extends Controller
{
    public function index() {
      return view('nadzirs.index');
    }

    public function front(Request $request)
    {
        // Handle search functionality and sorting
        $search = $request->input('search');
        $sort = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');

        // Get nadzir names, wakif names and no_aiw from wakaf_lands table
        $nadzirs = DB::table('wakaf_lands')
            ->select('id as wakaflandid', 'nadzir_name as name', 'aiw_no', 'wakif_name')
            ->when($search, function($query) use ($search) {
                return $query->where('nadzir_name', 'like', "%{$search}%");
            })
            ->orderBy($sort, $direction)
            ->distinct()
            ->get();

        return view('nadzirs.front', compact('nadzirs'));
    }

    public function datatable() {
      $data = DB::table('wakaf_lands')
        ->select('no_aiw', 'nadzir_name as name') // Changed id to no_aiw
        ->distinct()
        ->get();

        return Datatables::of($data)
          ->addColumn('aksi', function ($data) {
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="edit('.$data->no_aiw.')" class="btn btn-info btn-lg" title="edit">'. // Changed id to no_aiw
                     '<label class="fa fa-pencil-alt"></label></button>'.
                     '<button type="button" onclick="hapus('.$data->no_aiw.')" class="btn btn-danger btn-lg" title="hapus">'. // Changed id to no_aiw
                     '<label class="fa fa-trash"></label></button>'.
                  '</div>';
          })
          ->rawColumns(['aksi'])
          ->addIndexColumn()
          ->make(true);
    }

    public function simpan(Request $req) {
      if ($req->no_aiw == null) { // Changed id to no_aiw
        DB::beginTransaction();
        try {
          DB::table("wakaf_lands")
              ->where('no_aiw', $req->wakaf_land_no_aiw) // Changed id to no_aiw
              ->update([
                "nadzir_name" => $req->name,
                "updated_at" => Carbon::now('Asia/Jakarta'),
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
          DB::table("wakaf_lands")
              ->where('no_aiw', $req->wakaf_land_no_aiw) // Changed id to no_aiw
              ->update([
                "nadzir_name" => $req->name,
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
        DB::table("wakaf_lands")
            ->where("no_aiw", $req->wakaf_land_no_aiw) // Changed id to no_aiw
            ->update([
              "nadzir_name" => null,
              "updated_at" => Carbon::now('Asia/Jakarta'),
            ]);

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }
    }

    public function edit(Request $req) {
      $data = DB::table("wakaf_lands")
              ->select('nadzir_name as name')
              ->where("no_aiw", $req->wakaf_land_no_aiw) // Changed id to no_aiw
              ->first();

      return response()->json($data);
    }
}
