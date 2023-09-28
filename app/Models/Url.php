<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return '';
    }
}
