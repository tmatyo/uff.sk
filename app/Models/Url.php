<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Uff;

class Url extends Model
{
    use HasFactory;

    /**
     * 
     * Main functionality. 
     * Create and return a short url for the user, 
     * after he gives you the long one
     * 
     * @var $longUrl      
     * @return Url
     * 
     */

    public static function createShortUrl($longUrl) {
        $newUrl = Uff::generateUrl();

        //$yn = Url::where('short_url', substr($newUrl, -8))->first();

        // if(!empty($yn)) {
        //     this::createShortUrl($longUrl);
        // } else {
        //     Url::create()
        // }

        return response()->json([
            'shortUrl' => $newUrl,
    	], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
