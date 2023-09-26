<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Uff extends Controller
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

    public static function generateUrl($length = 8) {
        return self::URL_BASE . substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, $length);
    }
}
