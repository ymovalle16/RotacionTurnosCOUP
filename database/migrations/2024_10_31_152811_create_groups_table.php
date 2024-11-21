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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('basin_id');
            $table->unsignedBigInteger('operator_id');
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('basin_id')->references('id')->on('basins')->onDelete('cascade');
            $table->foreign('operator_id')->references('id')->on('operators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');

        Schema::table('groups', function (Blueprint $table) {
            $table->foreignId('operator_id')->nullable()->constrained()->onDelete('cascade');
        });
        
    }

    
};
