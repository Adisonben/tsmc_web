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
        Schema::create('log_book_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('log_book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ma_item_id')->constrained()->cascadeOnDelete();
            $table->integer('schedule_column')->nullable();
            $table->date('date')->nullable();
            $table->unsignedInteger('mileage')->nullable();
            $table->boolean('action_check')->default(false);      // ตรวจสอบ
            $table->boolean('action_adjust')->default(false);     // ปรับตั้ง
            $table->boolean('action_replace')->default(false);    // เปลี่ยนใหม่
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_book_entries');
    }
};
