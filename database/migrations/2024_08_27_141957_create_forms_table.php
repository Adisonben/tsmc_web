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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->uuid('form_id')->unique();
            $table->string('title');
            $table->string('category');
            $table->boolean('has_comment')->default(false);
            $table->boolean('has_score')->default(false);
            $table->boolean('has_approve')->default(false);
            $table->string('created_by')->nullable();
            $table->string('org')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
