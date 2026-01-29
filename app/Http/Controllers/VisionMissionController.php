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

class VisionMissionController extends Controller
{

    public function index(Request $request)
    {
        // Get vision mission data from database
        $data = DB::table('vision_misions')
            ->select('vision', 'mission', 'photos.url as photo_url')
            ->leftJoin('photos', 'vision_misions.photo_id', '=', 'photos.id')
            ->whereNull('vision_misions.deleted_at')
            ->first();

        return view("vision_mission/index", compact('data'));
    }

}
