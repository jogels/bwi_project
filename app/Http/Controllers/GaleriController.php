<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class GaleriController extends Controller
{
    private $styleLabels = [
        'foto' => 'foto',
        'foto_deskripsi' => 'foto+Deskripsi',
        'carousel' => 'Carousel',
    ];

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
            ->addColumn('style_label', function ($row) {
                $style = $row->style ?? 'foto';
                $text = $this->styleLabels[$style] ?? $style;
                if ($style === 'foto_deskripsi') {
                    $pos = ($row->photo_position ?? 'kanan') === 'kiri' ? 'foto kiri' : 'foto kanan';
                    $text .= ' (' . $pos . ')';
                }
                return $text;
            })
            ->editColumn('description', function ($row) {
                return $row->description ?: '-';
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
            'style' => $data->style ?? 'foto',
            'photo_position' => $data->photo_position ?? 'kanan',
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
            'style' => 'required|in:foto,foto_deskripsi,carousel',
            'photo_position' => 'nullable|in:kiri,kanan',
            'status' => 'nullable|in:aktif,nonaktif',
            'remove_image' => 'nullable|in:0,1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $isUpdate = !empty($req->id);
        $style = $req->style;
        $photoPosition = $style === 'foto_deskripsi'
            ? ($req->photo_position ?: 'kanan')
            : null;
        $removeImage = $req->input('remove_image') === '1';

        DB::beginTransaction();
        try {
            if ($style === 'carousel') {
                return $this->simpanCarousel($req, $isUpdate, $removeImage);
            }

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

                DB::table('galeri')
                    ->where('id', $req->id)
                    ->update([
                        'title' => $req->title,
                        'description' => $req->description,
                        'image' => $imagePath,
                        'style' => $style,
                        'photo_position' => $photoPosition,
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

            if (!$req->hasFile('image')) {
                throw new \RuntimeException('Gambar wajib diupload untuk data baru.');
            }

            $imagePath = $this->storeGaleriImage($req->file('image'));
            $nextOrder = ((int) DB::table('galeri')->max('sort_order')) + 1;

            DB::table('galeri')->insert([
                'title' => $req->title,
                'description' => $req->description,
                'image' => $imagePath,
                'style' => $style,
                'photo_position' => $photoPosition,
                'sort_order' => $nextOrder,
                'status' => $req->status ?: 'aktif',
                'created_at' => Carbon::now('Asia/Jakarta'),
                'updated_at' => Carbon::now('Asia/Jakarta'),
            ]);

            DB::commit();

            return response()->json([
                'status' => 1,
                'message' => 'Data galeri berhasil disimpan',
                'image_url' => asset($imagePath),
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 2,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function simpanCarousel(Request $req, bool $isUpdate, bool $removeImage)
    {
        $files = $req->file('images', []);
        if (!is_array($files)) {
            $files = $files ? [$files] : [];
        }
        $files = array_values(array_filter($files));

        if ($isUpdate) {
            $existing = DB::table('galeri')->where('id', $req->id)->first();
            if (!$existing) {
                throw new \RuntimeException('Data galeri tidak ditemukan.');
            }

            $imagePath = $existing->image;
            $fileIndex = 0;

            if ($removeImage) {
                $this->deleteGaleriImageFile($existing->image);
                $imagePath = null;
            }

            if (count($files) > 0) {
                if ($imagePath) {
                    $this->deleteGaleriImageFile($imagePath);
                }
                $imagePath = $this->storeGaleriImage($files[0]);
                $fileIndex = 1;
            }

            if (!$imagePath) {
                throw new \RuntimeException('Minimal 1 foto untuk Carousel.');
            }

            DB::table('galeri')
                ->where('id', $req->id)
                ->update([
                    'title' => $req->title,
                    'description' => $req->description,
                    'image' => $imagePath,
                    'style' => 'carousel',
                    'photo_position' => null,
                    'status' => $req->status ?: 'aktif',
                    'updated_at' => Carbon::now('Asia/Jakarta'),
                ]);

            // Foto tambahan jadi record carousel baru
            $nextOrder = ((int) DB::table('galeri')->max('sort_order')) + 1;
            for ($i = $fileIndex; $i < count($files); $i++) {
                $path = $this->storeGaleriImage($files[$i]);
                DB::table('galeri')->insert([
                    'title' => $req->title,
                    'description' => $req->description,
                    'image' => $path,
                    'style' => 'carousel',
                    'photo_position' => null,
                    'sort_order' => $nextOrder++,
                    'status' => $req->status ?: 'aktif',
                    'created_at' => Carbon::now('Asia/Jakarta'),
                    'updated_at' => Carbon::now('Asia/Jakarta'),
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 3,
                'message' => 'Data carousel berhasil diubah',
            ]);
        }

        if (count($files) === 0) {
            throw new \RuntimeException('Minimal 1 foto untuk Carousel.');
        }

        $nextOrder = ((int) DB::table('galeri')->max('sort_order')) + 1;
        foreach ($files as $file) {
            $path = $this->storeGaleriImage($file);
            DB::table('galeri')->insert([
                'title' => $req->title,
                'description' => $req->description,
                'image' => $path,
                'style' => 'carousel',
                'photo_position' => null,
                'sort_order' => $nextOrder++,
                'status' => $req->status ?: 'aktif',
                'created_at' => Carbon::now('Asia/Jakarta'),
                'updated_at' => Carbon::now('Asia/Jakarta'),
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => 1,
            'message' => count($files) . ' foto carousel berhasil disimpan',
        ]);
    }

    public function hapus(Request $req)
    {
        $id = $req->id;
        if (empty($id)) {
            return response()->json(['status' => 4, 'message' => 'ID tidak valid'], 400);
        }

        DB::beginTransaction();
        try {
            $data = DB::table('galeri')->where('id', $id)->first();
            if (!$data) {
                throw new \RuntimeException('Data galeri tidak ditemukan.');
            }

            $this->deleteGaleriImageFile($data->image);
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
        if (strpos($relative, 'image/uploads/Galeri/') !== 0) {
            return;
        }

        foreach ([base_path($relative), public_path($relative)] as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }

        $dir = dirname(base_path($relative));
        if (is_dir($dir) && count(glob($dir . '/*')) === 0) {
            @rmdir($dir);
        }
    }
}
