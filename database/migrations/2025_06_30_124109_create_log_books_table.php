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
        Schema::create('log_books', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_id');
            $table->unsignedInteger('start_mileage');
            $table->string('vehicle_plate');
            $table->string('vehicle_type');
            $table->string('org_name');
            $table->string('org_id');
            $table->string('create_by');
            $table->date('start_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_books');
    }
};
