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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('id_clase');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_profesor');
            $table->unsignedBigInteger('id_membresia');

            $table->foreign('id_clase')->references('id')->on('clases');
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_profesor')->references('id')->on('users');
            $table->foreign('id_membresia')->references('id')->on('membresias');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
