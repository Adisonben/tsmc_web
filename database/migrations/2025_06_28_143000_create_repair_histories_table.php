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
        Schema::create('repair_histories', function (Blueprint $table) {
            $table->id();
            $table->string("vehicle_id");
            $table->string("vehicle_plate");
            $table->date("repair_date");
            $table->string("repair_detail")->nullable();
            $table->integer("mileage");
            $table->string("ma_item_id");
            $table->decimal('repair_cost', 10, 2)->default(0);
            $table->string("repair_operator");
            $table->text("note")->nullable();
            $table->string("create_by");
            $table->string("org_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_histories');
    }
};
