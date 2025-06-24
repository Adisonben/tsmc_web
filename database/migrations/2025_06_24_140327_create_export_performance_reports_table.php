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
        Schema::create('export_performance_reports', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('form_id');
            $table->integer('quarter')->comment('quarter of year. 1, 2, 3, 4');
            $table->string('org')->nullable()->comment('Organization ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('export_performance_reports');
    }
};
