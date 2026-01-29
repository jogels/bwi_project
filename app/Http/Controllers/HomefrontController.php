<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;

class HomefrontController extends Controller
{
    public function index() {
        $data = [
            'highlights' => $this->getHighlights(),
            'posts' => $this->getPosts(),
            'banners' => $this->getBanners(),
            'trending' => $this->getTrendingPosts(),
        ];
        return view("home_front", compact('data'));
    }

    private function getTrendingPosts() {
        return DB::table('posts')
            ->select('posts.*', 'users.full_name as author_name', 'post_photos.photo_url')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('post_photos', 'post_photos.post_id', '=', 'posts.id')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function($post) {
                // Extract first image from body content if exists
                preg_match('/<img[^>]+src="([^">]+)"/', $post->body ?? '', $matches);
                $post->image_url = $matches[1] ?? 'assets/imgs/default.jpg'; // Use a default image if none found
                return $post;
            });
    }

    private function getHighlights() {
        return DB::table('posts')
            ->select('posts.*', 'users.full_name as author_name', 'post_photos.photo_url')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('post_photos', 'post_photos.post_id', '=', 'posts.id')
            ->where('is_highlight', 'Y')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get()
            ->map(function($post) {
                // Extract first image from body content if exists
                preg_match('/<img[^>]+src="([^">]+)"/', $post->body ?? '', $matches);
                $post->image_url = $matches[1] ?? 'assets/imgs/default.png'; // Use a default image if none found
                return $post;
            });
    }

    private function getPosts() {
        $posts = DB::table('posts')
        ->select('posts.*', 'users.full_name as author_name', 'post_photos.photo_url')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->leftJoin('post_photos', 'post_photos.post_id', '=', 'posts.id')
        ->where('posts.category', '=', 'artikel')
        ->orderBy('posts.created_at', 'desc')
        ->paginate(5); // Pagination untuk Laravel 5.4

        $posts->getCollection()->transform(function ($post) {
            // Extract first image from body content if exists
            preg_match('/<img[^>]+src="([^">]+)"/', $post->body ?? '', $matches);
            $post->image_url = $matches[1] ?? 'assets/imgs/default.png';
            return $post;
        });

        return $posts;
    }

    private function getBanners() {
        return DB::table('banner')
            ->select('banner.*', 'banner_photos.photo_url')
            ->join('banner_photos', 'banner_photos.banner_id', '=', 'banner.id')
            ->get();
    }

    // JSON API endpoint
    public function getHomeData() {
        $data = [
            'highlights' => $this->getHighlights(),
            'posts' => $this->getPosts(),
            'banners' => $this->getBanners(),
            'trending' => $this->getTrendingPosts()
        ];
        
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function visimisi() {
        $data = DB::table("vision_misions")
            ->join("photos", "photos.id", "=", "vision_misions.photo_id")
            ->where('vision_misions.id', 1)
            ->first();

        return view("front.visimisi.index", compact("data"));
    }
}
