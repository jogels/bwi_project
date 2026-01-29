<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class LiterasiController extends Controller
{
    public function index()
    {
        $posts = Post::where('category', '!=', 'artikel')->get();

          $postsByCategory = $posts->groupBy('category');
  
          return view('literasi.index', compact('postsByCategory'));
      
    }
}
