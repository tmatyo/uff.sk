<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;

class Uff extends Controller
{
    
    /**
     * 
     * Generates a URL-safe string of 8 characters length, if not specified otherwise
     * 
     * @var $length 
     * @return String
     *
     */

    public static function generateUrl($length = 8) {

        // generate string for new url
        $string = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, $length);

        // check if newly generated short URL does already exist in DB
        $yn = Url::where('short_url', $string)->first();

        if(!empty($yn)) {
            // if exists, start all over
            this::generateUrl($length);
        } else {
            // if doesn't return the string
            return $string;
        }
    }

}
