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
        Schema::create('num_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name_table');
            $table->unsignedBigInteger('basin_id');
            $table->timestamps();

            $table->foreign('basin_id')->references('id')->on('basins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('num_tables');
    }
};
