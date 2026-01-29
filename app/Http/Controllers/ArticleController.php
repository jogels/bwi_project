<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\mMember;
use App\Authentication;
use Auth;
use Carbon\Carbon;
use Session;
use DB;
use Illuminate\Support\Collection;

class ArticleController extends Controller
{

    public function index(Request $request, $id)
    {
        $post = DB::table('posts')
        ->select('posts.*', 'users.full_name as author_name', 'post_photos.photo_url')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->leftJoin('post_photos', 'post_photos.post_id', '=', 'posts.id') // Relasi ke post_photos
        ->where('posts.id', $id)
        ->first();

        if (!$post) {
            abort(404);
        }

        return view('posts.show', compact('post'));
    }

}
