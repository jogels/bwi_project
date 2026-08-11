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
                    'label' => $item->label,
                    'image' => !empty($item->image) ? asset($item->image) : null,
                    'image_missing' => !gallery_image_exists($item->image),
                ];
            });

        return view('gallery.index', compact('galleries'));
    }
}
