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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('license_category')->nullable();
            $table->string('license_plate')->unique();
            $table->string('registration_province')->nullable();
            $table->string('brand');
            $table->string('model')->nullable();
            $table->string('type')->nullable();
            $table->string('standard')->nullable();
            $table->string('ins_company')->nullable();
            $table->string('ins_type')->nullable();
            $table->foreignId('org_id')->constrained('organizations')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
