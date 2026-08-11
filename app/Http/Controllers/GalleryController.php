<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $galleries = Gallery::query()
            ->where('status', 'aktif')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'style' => $item->style ?: 'foto',
                    'photo_position' => $item->photo_position ?: 'kanan',
                    'image' => !empty($item->image) ? asset($item->image) : null,
                    'sort_order' => $item->sort_order,
                ];
            });

        return view('gallery.index', compact('galleries'));
    }
}
