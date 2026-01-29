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

class AboutController extends Controller
{

    public function index(Request $request)
    {
        return view("about/index");
    }

}
