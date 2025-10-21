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
        Schema::table('renewal_codes', function (Blueprint $table) {
            $table->integer('renew_day')->default(30); // จำนวนวันที่ต่ออายุ
            $table->integer('use_per_user')->default(1); // ใช้ได้กี่ครั้งต่อคน
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('renewal_codes', function (Blueprint $table) {
            //
        });
    }
};
