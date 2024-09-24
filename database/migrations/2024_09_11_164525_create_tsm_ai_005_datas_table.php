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
        Schema::create('tsm_ai_005_datas', function (Blueprint $table) {
            $table->id();
            $table->string("driver_name");
            $table->string("phone")->nullable();
            $table->string("car_plate")->nullable();
            $table->string("repair_list");
            $table->string("amount");
            $table->string("repair_type");
            $table->string("repair_by");
            $table->string("created_by");
            $table->string("org")->nullable();
            $table->string("status")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsm_ai_005_datas');
    }
};
