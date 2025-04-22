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
        Schema::create('renewal_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // โค้ดที่ใช้กรอก
            $table->integer('max_uses')->default(0); // ใช้ได้กี่ครั้ง
            $table->timestamp('expires_at')->nullable(); // วันหมดอายุของโค้ด
            $table->timestamps();
        });

        Schema::create('renewal_code_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renewal_code_id')->constrained('renewal_codes')->onDelete('cascade');
            $table->string('type'); // user | Organization
            $table->string('target'); // user_id | organization_id
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renewal_codes');
    }
};
