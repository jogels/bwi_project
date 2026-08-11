<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use Auth;
use Carbon\Carbon;
use Session;
use DB;
use File;
use Yajra\Datatables\Datatables;

class GaleriController extends Controller
{
    public function index()
    {
        return view('galeri.index');
    }

    public function datatable()
    {
        $data = DB::table('galeri')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return Datatables::of($data)
            ->addColumn('aksi', function ($data) {
                return '<div class="btn-group">' .
                    '<button type="button" onclick="edit(' . $data->id . ')" class="btn btn-info btn-lg" title="edit">' .
                    '<label class="fa fa-pencil-alt"></label></button>' .
                    '<button type="button" onclick="hapus(' . $data->id . ')" class="btn btn-danger btn-lg" title="hapus">' .
                    '<label class="fa fa-trash"></label></button>' .
                    '</div>';
            })
            ->addColumn('gambar', function ($data) {
                if (empty($data->image)) {
                    return '-';
                }

                $src = (strpos($data->image, 'http') === 0) ? $data->image : asset($data->image);
                return '<img src="' . $src . '" alt="' . e($data->title) . '" style="width:70px;height:50px;object-fit:cover;border-radius:6px;">';
            })
            ->rawColumns(['aksi', 'gambar'])
            ->addIndexColumn()
            ->make(true);
    }
}
