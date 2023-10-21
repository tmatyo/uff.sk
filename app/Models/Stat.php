<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'http_x_forwarded_for',
        'is_mobile',
        'is_desktop',
        'is_phone',
        'is_tablet',
        'is_robot',
        'robot_name',
        'device',
        'platform',
        'browser',
        'referer',
        'query_string',
        'languages',
        'request_duration_in_ms',
        'url_id',
        'request_time'
    ];

    public function url() {
        return $this->belongsTo(Url::class);
    }
}
