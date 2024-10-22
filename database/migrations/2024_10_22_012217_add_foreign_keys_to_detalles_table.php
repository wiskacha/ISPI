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
        Schema::table('detalles', function (Blueprint $table) {
            $table->foreign(['id_movimiento'], 'detalles_ibfk_1')->references(['id_movimiento'])->on('movimientos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_producto'], 'detalles_ibfk_2')->references(['id_producto'])->on('productos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalles', function (Blueprint $table) {
            $table->dropForeign('detalles_ibfk_1');
            $table->dropForeign('detalles_ibfk_2');
        });
    }
};