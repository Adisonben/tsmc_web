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
        Schema::create('form_list_has_columns', function (Blueprint $table) {
            $table->unsignedBigInteger('list_id');
            $table->unsignedBigInteger('column_id');
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->foreign('list_id')
                ->references('id')
                ->on('form_lists')
                ->onDelete('cascade');

            $table->foreign('column_id')
                ->references('id')
                ->on('form_columns')
                ->onDelete('cascade');

            $table->primary(['list_id', 'column_id'], 'list_has_columns_list_id_column_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_list_has_columns');
    }
};
