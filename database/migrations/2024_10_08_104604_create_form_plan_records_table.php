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
        Schema::create('form_plan_records', function (Blueprint $table) {
            $table->id();
            $table->string("user_id");
            $table->foreignId('form_id')->constrained('forms')->onDelete('cascade');
            $table->foreignId('form_column')->constrained('form_columns')->onDelete('cascade');
            $table->foreignId('form_list')->constrained('form_lists')->onDelete('cascade');
            $table->integer("times")->nullable();
            $table->boolean("is_finish")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_plan_records');
    }
};
