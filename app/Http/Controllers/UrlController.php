<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Uff;
use App\Models\Url;
use App\Models\User;

class UrlController extends Controller
{
        
    CONST URL_BASE = "https://uff.sk/";
    
    /**
     * 
     * Generates a URL-safe string of 8 characters length, if not specified otherwise
     * 
     * @var $length 
     * @return String
     *
     */
    public function createShortUrl(Request $req) {

        // validate input from request
        $validated = $req->validate([
            'url' => 'required|url:http,https|max:1000'
        ]);

        // TO DO: what if error

        // generate new short URL
        $newUrl = Uff::generateUrl();

        $url = new Url;

        $url->long_url = $validated['url'];
        $url->short_url = $newUrl;
        $url->user_id = $req->user()->id;
        $er = $url->save();

        return response()->json([
            'shortUrl' => self::URL_BASE . $newUrl,
            'longUrl' => $validated['url'],
            'userId' => $req->user()->id,
            'er' => $er,
    	], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * 
     * The Redirect
     * 
     */
    public function theRedirect(Request $req) {
        $url = Url::where([
            ['short_url', request('shortUrl')],
            ['active', 1]
            ])->first(['long_url']);
        
        if(isset($url['long_url'])) {
            header('Location: ' . $url['long_url'], true, 301);
        } else {
            header('Location: /');
        }

        exit();
    }

    /**
     * 
     * Retrieve URLs saved by the user. For the dashboard.
     * 
     * 
     */
    public function getMyUrls(Request $req) {

        $res = User::find($req->user()->id)->url;

        return response()->json($res, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
