<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
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

    public function simpan(Request $req)
    {
        $req->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'label' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|in:aktif,nonaktif',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Hanya INSERT ke tabel galeri. Tidak menghapus/mengubah data lain.
        DB::beginTransaction();
        try {
            $imagePath = null;

            if ($req->hasFile('image')) {
                $file = $req->file('image');
                $extension = strtolower($file->getClientOriginalExtension());
                $tgl = Carbon::now('Asia/Jakarta');
                $folder = $tgl->format('Ym') . $tgl->timestamp;
                $dir = 'image/uploads/Galeri/' . $folder;
                $absoluteDir = public_path($dir);

                if (!File::exists($absoluteDir)) {
                    File::makeDirectory($absoluteDir, 0777, true);
                }

                $name = 'galeri_' . $tgl->timestamp . '.' . $extension;
                $file->move($absoluteDir, $name);

                $imagePath = $dir . '/' . $name;
                $absoluteImagePath = public_path($imagePath);

                // Kompresi opsional; jangan gagalkan simpan jika compress gagal
                if (function_exists('compressImage') && File::exists($absoluteImagePath) && in_array($extension, ['jpg', 'jpeg', 'png', 'gif'], true)) {
                    try {
                        compressImage($extension, $absoluteImagePath, $absoluteImagePath, 60);
                    } catch (\Throwable $compressError) {
                        // Biarkan file asli tetap dipakai
                    }
                }
            }

            DB::table('galeri')->insert([
                'title' => $req->title,
                'description' => $req->description,
                'image' => $imagePath,
                'label' => $req->label,
                'sort_order' => (int) ($req->sort_order ?? 0),
                'status' => $req->status ?: 'aktif',
                'created_at' => Carbon::now('Asia/Jakarta'),
                'updated_at' => Carbon::now('Asia/Jakarta'),
            ]);

            DB::commit();

            return response()->json([
                'status' => 1,
                'message' => 'Data galeri berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 2,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
