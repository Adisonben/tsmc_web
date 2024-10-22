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
        Schema::create('form_plans', function (Blueprint $table) {
            $table->id();
            $table->text('header_data')->nullable();
            $table->string("user_id");
            $table->foreignId('form_id')->constrained('forms')->onDelete('cascade');
            $table->string("status")->default(0);
            $table->timestamps();
        });

        Schema::table('form_plan_records', function (Blueprint $table) {
            $table->foreignId('form_plan_id')->constrained('form_plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_plans');

        Schema::table('form_plan_records', function (Blueprint $table) {
            $table->dropColumn('form_plan_id');
        });
    }
};
