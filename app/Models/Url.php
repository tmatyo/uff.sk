<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $fillable = ['long_url', 'short_url', 'active'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function stat() {
        return $this->hasMany(Stat::class);
    }

    /**
     * Generates a URL-safe string of 8 characters length, if not specified otherwise
     */
     public static function generateUrl($length = 8) {

        // generate string for new url
        $string = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, $length);

        // check if newly generated short URL does already exist in DB
        $yn = Url::where('short_url', $string)->first();

        if(!empty($yn)) {
            // if exists, start all over
            Url::generateUrl($length);
        } else {
            // if doesn't return the string
            return $string;
        }
    }

}
