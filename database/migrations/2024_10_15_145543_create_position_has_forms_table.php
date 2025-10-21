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
        Schema::create('position_has_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('form_id');

            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onDelete('cascade');

            $table->foreign('form_id')
                ->references('id')
                ->on('forms')
                ->onDelete('cascade');
            $table->primary(['position_id', 'form_id'], 'position_has_form_position_id_form_type_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position_has_forms');
    }
};
