<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Uff;
use App\Models\Url;

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
    public function createShortUrl(Request $request) {

        // validate input from request
        $validated = $request->validate([
            'url' => 'required|url:http,https|max:1000'
        ]);

        // TO DO: what if error

        // generate new short URL
        $newUrl = Uff::generateUrl();

        $url = new Url;

        $url->long_url = $validated['url'];
        $url->short_url = $newUrl;
        $er = $url->save();

        return response()->json([
            'shortUrl' => self::URL_BASE . $newUrl,
            'longUrl' => $validated['url'],
            'er' => $er,
    	], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
