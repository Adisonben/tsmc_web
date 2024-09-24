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
        Schema::create('tsm_v_002_datas', function (Blueprint $table) {
            $table->id();
            $table->string('driver_name');
            $table->string('car_id');
            $table->string('car_plate');
            $table->string('car_type');
            $table->string('car_model');
            $table->string('order_num');
            $table->string('repair_type');
            $table->integer('mileage')->default(0);
            $table->float('cost_amount')->default(0.00);
            $table->string('create_by')->nullable();
            $table->string('org')->nullable();
            $table->string('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsm_v_002_datas');
    }
};
