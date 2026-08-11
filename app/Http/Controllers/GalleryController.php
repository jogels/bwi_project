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
                'description' => 'Dokumentasi kegiatan sosialisasi wakaf kepada masyarakat sebagai bagian dari upaya edukasi dan peningkatan literasi perwakafan di wilayah DKI Jakarta.',
                'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=900&q=80',
            ],
            (object) [
                'id' => 2,
                'title' => 'Pelatihan Nazhir',
                'description' => 'Pelatihan peningkatan kapasitas Nazhir agar pengelolaan aset wakaf berlangsung lebih profesional, transparan, dan bermanfaat bagi umat.',
                'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80',
            ],
            (object) [
                'id' => 3,
                'title' => 'Kunjungan Tanah Wakaf',
                'description' => 'Monitoring dan pendataan objek tanah wakaf.',
                'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=800&q=80',
            ],
            (object) [
                'id' => 4,
                'title' => 'Rapat Koordinasi',
                'description' => 'Rapat koordinasi pengurus BWI Perwakilan DKI Jakarta.',
                'image' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=800&q=80',
            ],
            (object) [
                'id' => 5,
                'title' => 'Literasi Wakaf',
                'description' => 'Kegiatan literasi dan edukasi perwakafan untuk memperkuat pemahaman masyarakat tentang potensi wakaf produktif dan peranannya dalam pembangunan sosial ekonomi.',
                'image' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=900&q=80',
            ],
            (object) [
                'id' => 6,
                'title' => 'Silaturahmi Stakeholders',
                'description' => 'Silaturahmi dengan pemangku kepentingan perwakafan untuk memperkuat sinergi program dan kolaborasi lintas lembaga.',
                'image' => 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?auto=format&fit=crop&w=1200&q=80',
            ],
        ]);

        return view('gallery.index', compact('galleries'));
    }
}
