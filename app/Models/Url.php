<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $fillable = ['long_url', 'short_url', 'active'];

    /**
     * 
     * Relationship to Users
     * 
     */

     public function user() {
        return $this->belongsTo(User::class);
    }

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
