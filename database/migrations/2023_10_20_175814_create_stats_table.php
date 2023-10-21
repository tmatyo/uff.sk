<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip_address')->nullable();
            $table->string('http_x_forwarded_for')->nullable();
            $table->boolean('is_mobile');
            $table->boolean('is_desktop');
            $table->boolean('is_phone');
            $table->boolean('is_tablet');
            $table->boolean('is_robot');
            $table->string('robot_name')->nullable();
            $table->string('device', 50);
            $table->string('platform', 50);
            $table->string('browser', 50);
            $table->string('referer')->nullable();
            $table->string('query_string')->nullable();
            $table->string('languages')->nullable();
            $table->integer('request_duration_in_ms');
            $table->foreignId('url_id')->nullable();
            $table->datetime('request_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
