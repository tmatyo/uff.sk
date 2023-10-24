<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StatController extends Controller
{

    /**
     * 
     * Retrieve statistics about url traffic. 
     *  
     */
    public function getMyStats(Request $req) {
        
        if(!Auth::check()) {
            return Redirect::route('login');
        }

        $user = $req->user();

        $res = $user->stat()->with(['url' => function($query) {
            $query->select('id', 'short_url');
        }])->get();

        return response()->json($res, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
