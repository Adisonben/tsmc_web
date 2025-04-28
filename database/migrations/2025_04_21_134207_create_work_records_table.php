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
        Schema::create('work_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK ไปยัง table users
            $table->dateTime('start_at'); // รวมวันที่และเวลา
            $table->dateTime('end_at')->nullable(); // เวลาสิ้นสุดงาน (nullable ถ้าไม่ได้ระบุ)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_records');
    }
};
