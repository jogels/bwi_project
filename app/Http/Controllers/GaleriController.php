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

                $src = asset($row->image);
                $missing = !gallery_image_exists($row->image);
                $badge = $missing
                    ? '<div style="font-size:11px;color:#c0392b;margin-top:4px;">File belum ada di server</div>'
                    : '';

                return '<img src="' . e($src) . '" alt="' . e($row->title) . '" style="width:70px;height:50px;object-fit:cover;border-radius:6px;">' . $badge;
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

    public function edit(Request $req)
    {
        $data = DB::table('galeri')->where('id', $req->id)->first();

        if (!$data) {
            return response()->json(['status' => 0, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $data->id,
            'title' => $data->title,
            'description' => $data->description,
            'image' => $data->image,
            'image_url' => $data->image ? asset($data->image) : null,
            'label' => $data->label,
            'sort_order' => $data->sort_order,
            'status' => $data->status,
        ]);
    }

    public function simpan(Request $req)
    {
        $req->validate([
            'id' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'label' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|in:aktif,nonaktif',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $isUpdate = !empty($req->id);

        DB::beginTransaction();
        try {
            if ($isUpdate) {
                $existing = DB::table('galeri')->where('id', $req->id)->first();
                if (!$existing) {
                    throw new \RuntimeException('Data galeri tidak ditemukan.');
                }

                $imagePath = $existing->image;

                if ($req->hasFile('image')) {
                    $newImage = $this->storeGaleriImage($req->file('image'));
                    $this->deleteGaleriImageFile($existing->image);
                    $imagePath = $newImage;
                }

                // Hanya UPDATE baris di tabel galeri
                DB::table('galeri')
                    ->where('id', $req->id)
                    ->update([
                        'title' => $req->title,
                        'description' => $req->description,
                        'image' => $imagePath,
                        'label' => $req->label,
                        'sort_order' => (int) ($req->sort_order ?? 0),
                        'status' => $req->status ?: 'aktif',
                        'updated_at' => Carbon::now('Asia/Jakarta'),
                    ]);

                DB::commit();

                return response()->json([
                    'status' => 3,
                    'message' => 'Data galeri berhasil diubah',
                    'image_url' => $imagePath ? asset($imagePath) : null,
                ]);
            }

            $imagePath = null;
            if ($req->hasFile('image')) {
                $imagePath = $this->storeGaleriImage($req->file('image'));
            }

            // Hanya INSERT ke tabel galeri
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
                'image_url' => $imagePath ? asset($imagePath) : null,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 2,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function hapus(Request $req)
    {
        $id = $req->id;
        if (empty($id)) {
            return response()->json(['status' => 4, 'message' => 'ID tidak valid'], 400);
        }

        DB::beginTransaction();
        try {
            // Ambil hanya dari tabel galeri
            $data = DB::table('galeri')->where('id', $id)->first();
            if (!$data) {
                throw new \RuntimeException('Data galeri tidak ditemukan.');
            }

            // Hapus file gambar galeri saja (jika path-nya milik Galeri)
            $this->deleteGaleriImageFile($data->image);

            // Hapus hanya 1 baris di tabel galeri
            DB::table('galeri')->where('id', $id)->delete();

            DB::commit();

            return response()->json([
                'status' => 3,
                'message' => 'Data galeri berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 4,
                'message' => 'Gagal menghapus data: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function storeGaleriImage($file): string
    {
        $tgl = Carbon::now('Asia/Jakarta');
        $folder = $tgl->year . $tgl->month . $tgl->timestamp;
        $dir = 'image/uploads/Galeri/' . $folder;
        $childPath = $dir . '/';
        $path = $childPath;
        $name = $folder . '.' . $file->getClientOriginalExtension();

        if (!File::exists($path)) {
            if (!File::makeDirectory($path, 0777, true)) {
                throw new \RuntimeException('Gagal membuat folder upload galeri.');
            }
        }

        $file->move($path, $name);
        $imagePath = $childPath . $name;

        if (function_exists('compressImage')) {
            try {
                compressImage($file->getClientOriginalExtension(), $imagePath, $imagePath, 60);
            } catch (\Throwable $e) {
                // biarkan file asli
            }
        }

        if (!gallery_image_exists($imagePath)) {
            throw new \RuntimeException('Upload gambar gagal: file tidak ditemukan setelah disimpan.');
        }

        return $imagePath;
    }

    private function deleteGaleriImageFile($imagePath): void
    {
        if (empty($imagePath)) {
            return;
        }

        $relative = ltrim(str_replace('\\', '/', $imagePath), '/');

        // Amankan: hanya hapus file di folder Galeri
        if (strpos($relative, 'image/uploads/Galeri/') !== 0) {
            return;
        }

        $candidates = [
            base_path($relative),
            public_path($relative),
        ];

        foreach ($candidates as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }

        // Hapus folder kosong jika memungkinkan
        $dir = dirname(base_path($relative));
        if (is_dir($dir) && count(glob($dir . '/*')) === 0) {
            @rmdir($dir);
        }
    }
}
