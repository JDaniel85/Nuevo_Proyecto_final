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
        Schema::table('clase_user', function (Blueprint $table) {
            $table->unsignedBigInteger('membresia_id')->nullable()->after('clase_id');
            $table->foreign('membresia_id')->references('id')->on('membresias')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clase_user', function (Blueprint $table) {
            $table->dropForeign(['membresia_id']);
            $table->dropColumn('membresia_id');
        });
    }
};