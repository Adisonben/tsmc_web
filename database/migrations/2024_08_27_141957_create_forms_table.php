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
            $table->string('category')->nullable();
            $table->boolean('select_user')->default(true);
            $table->boolean('select_vehicle')->default(false);
            $table->boolean('has_approve')->default(false);
            $table->string('created_by')->nullable();
            $table->string('org')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('is_sub_form')->default(false);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->softDeletes();
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
