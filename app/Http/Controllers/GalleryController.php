<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        // Sementara data dummy untuk layout (belum konek database)
        $galleries = collect([
            (object) [
                'id' => 1,
                'title' => 'Kegiatan Sosialisasi Wakaf',
                'description' => 'Dokumentasi kegiatan sosialisasi wakaf kepada masyarakat.',
                'image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=800&q=80',
            ],
            (object) [
                'id' => 2,
                'title' => 'Pelatihan Nazhir',
                'description' => 'Pelatihan peningkatan kapasitas Nazhir di wilayah DKI Jakarta.',
                'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80',
            ],
            (object) [
                'id' => 3,
                'title' => 'Kunjungan Tanah Wakaf',
                'description' => 'Monitoring dan pendataan objek tanah wakaf.',
                'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80',
            ],
            (object) [
                'id' => 4,
                'title' => 'Rapat Koordinasi',
                'description' => 'Rapat koordinasi pengurus BWI Perwakilan DKI Jakarta.',
                'image' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=800&q=80',
            ],
            (object) [
                'id' => 5,
                'title' => 'Literasi Wakaf',
                'description' => 'Kegiatan literasi dan edukasi perwakafan.',
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=800&q=80',
            ],
            (object) [
                'id' => 6,
                'title' => 'Silaturahmi Stakeholders',
                'description' => 'Silaturahmi dengan pemangku kepentingan perwakafan.',
                'image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=800&q=80',
            ],
        ]);

        return view('gallery.index', compact('galleries'));
    }
}
