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
        Schema::create('tsm_has__orgs', function (Blueprint $table) {
            $table->unsignedBigInteger('tsm_id');
            $table->unsignedBigInteger('org_id');

            $table->foreign('tsm_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('org_id')
                ->references('id')
                ->on('organizations')
                ->onDelete('cascade');
            $table->primary(['tsm_id', 'org_id'], 'tsm_has_org_tsm_id_org_id_primary');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsm_has__orgs');
    }
};
