<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\WakafLand;
use App\Wakif;

class ProfileWakifController extends Controller
{
    public function index($wakif, Request $request)
    {
        $wakifName = urldecode($wakif);
        $wakafLandId = $request->query('wakaf_land_id');

        // Get wakaf land data directly since wakif name is stored in wakaf_lands table
        $query = WakafLand::with(['city', 'subdistrict', 'village', 'photos'])
            ->where('wakif_name', $wakifName);

        // Filter by specific wakaf_land_id if provided
        if ($wakafLandId) {
            $query->where('id', $wakafLandId);
        }

        $wakafLand = $query->firstOrFail();
        
        // Format gallery data from photos relationship
        $gallery = [];
        if ($wakafLand->photos) {
            foreach ($wakafLand->photos as $photo) {
                if ($photo && $photo->url) {
                    $gallery[] = [
                        'id' => $photo->id,
                        'url' => $photo->url,
                        'caption' => $photo->caption ?? '',
                        'date' => $photo->created_at ? $photo->created_at->format('Y-m-d') : null
                    ];
                }
            }
        }

        $data = [
            'wakaf_info' => [
                'peruntukan' => $wakafLand->used ?? '-',
                'provinsi' => 'DKI Jakarta',
                'kabupaten' => $wakafLand->city->name ?? '-',
                'kecamatan' => $wakafLand->subdistrict->name ?? '-',
                'kelurahan' => $wakafLand->village->name ?? '-',
                'alamat' => $wakafLand->address ?? '-',
                'luas_tanah' => $wakafLand->area_size ?? '0,00',
                'luas_bangunan' => '0,00',
            ],
            'wakif_info' => [
                'nama_wakif' => $wakafLand->wakif_name ?? '-',
                'nama_nazhir' => $wakafLand->nadzir_name ?? '-', 
                'status' => $wakafLand->status ?? '-',
                'no_sertifikat' => $wakafLand->certificate_no,
                'tanggal_sertifikat' => $wakafLand->certificate_date ?? '-',
                'no_aiw' => $wakafLand->aiw_no ?? '-',
                'tanggal_aiw' => $wakafLand->aiw_date ?? '-',
            ],
            'location' => [
                'latitude' => $wakafLand->latitude ?? 0,
                'longitude' => $wakafLand->longitude ?? 0,
                'zoom' => 15,
            ],
            'gallery' => $gallery
        ];

        return view('profile_wakif.index', compact('data'));
    }
}
