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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_membresia');
            $table->unsignedBigInteger('id_clase');
            $table->decimal('monto');
            $table->date('fecha');

            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_membresia')->references('id')->on('membresias');
            $table->foreign('id_clase')->references('id')->on('clases');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
