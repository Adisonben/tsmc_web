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
        Schema::create('tsm_rp_002_datas', function (Blueprint $table) {
            $table->id();
            $table->string("work_num");
            $table->string("vehicle_plate");
            $table->string("employee_name");
            $table->dateTime("assign_date");
            $table->string("customer_name")->nullable();
            $table->string("receive_place")->nullable();
            $table->dateTime("receive_date")->nullable();
            $table->string("drop_place")->nullable();
            $table->dateTime("drop_date")->nullable();
            $table->string("product_volume")->nullable();
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("org")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsm_rp_002_datas');
    }
};
