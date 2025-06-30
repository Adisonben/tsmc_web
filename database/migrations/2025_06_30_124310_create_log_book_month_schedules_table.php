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
        Schema::create('log_book_month_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('log_book_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('month_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_book_month_schedules');
    }
};
