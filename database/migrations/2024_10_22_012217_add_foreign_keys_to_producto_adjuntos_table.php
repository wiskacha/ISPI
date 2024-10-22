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
        Schema::table('producto_adjuntos', function (Blueprint $table) {
            $table->foreign(['id_producto'], 'producto_adjuntos_ibfk_1')->references(['id_producto'])->on('productos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('producto_adjuntos', function (Blueprint $table) {
            $table->dropForeign('producto_adjuntos_ibfk_1');
        });
    }
};
