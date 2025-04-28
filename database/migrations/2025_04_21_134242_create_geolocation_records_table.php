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
        Schema::create('geolocation_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_id')->constrained('work_records')->onDelete('cascade'); // FK ไปยัง table work_records
            $table->float('latitude');
            $table->float('longitude');
            $table->float('temperature')->nullable();
            $table->float('windspeed')->nullable();
            $table->integer('weather_code')->nullable();
            $table->integer('radius')->nullable();
            $table->string('type')->nullable(); // ประเภท ['start', 'checkin', 'end']
            $table->dateTime('recorded_at')->nullable(); // เวลาที่บันทึกพิกัด
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geolocation_records');
    }
};
