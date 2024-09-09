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
        Schema::create('position_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('org')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on('position_permissions')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('org')
                ->references('id')
                ->on('organizations')
                ->onDelete('cascade');

            $table->primary(['position_id', 'permission_id', 'user_id'], 'position_has_permissions_position_id_permission_id_user_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position_has_permissions');
    }
};
