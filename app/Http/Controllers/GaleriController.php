<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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
            ->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('aksi', function ($row) {
                return '<div class="btn-group">' .
                    '<button type="button" onclick="edit(' . $row->id . ')" class="btn btn-info btn-lg" title="edit">' .
                    '<label class="fa fa-pencil-alt"></label></button>' .
                    '<button type="button" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-lg" title="hapus">' .
                    '<label class="fa fa-trash"></label></button>' .
                    '</div>';
            })
            ->addColumn('gambar', function ($row) {
                if (empty($row->image)) {
                    return '-';
                }

                $src = (strpos($row->image, 'http') === 0) ? $row->image : asset($row->image);

                return '<img src="' . e($src) . '" alt="' . e($row->title) . '" style="width:70px;height:50px;object-fit:cover;border-radius:6px;">';
            })
            ->editColumn('description', function ($row) {
                return $row->description ?: '-';
            })
            ->editColumn('label', function ($row) {
                return $row->label ?: '-';
            })
            ->rawColumns(['aksi', 'gambar'])
            ->addIndexColumn()
            ->make(true);
    }
}
