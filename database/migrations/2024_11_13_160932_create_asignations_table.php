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
        Schema::create('asignations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tab_id');
            $table->unsignedBigInteger('operator_id');
            $table->timestamps();

            $table->foreign('tab_id')->references('id')->on('num_tables')->onDelete('cascade');
            $table->foreign('operator_id')->references('id')->on('operators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignations');
    }
};
