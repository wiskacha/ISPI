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
        Schema::table('movimientos', function (Blueprint $table) {
            $table->foreign(['id_almacen'])->references(['id_almacen'])->on('almacenes')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_cliente'])->references(['id_persona'])->on('personas')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_operador'])->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_proveedor'])->references(['id_persona'])->on('personas')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_recinto'])->references(['id_recinto'])->on('recintos')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimientos', function (Blueprint $table) {
            $table->dropForeign('movimientos_id_almacen_foreign');
            $table->dropForeign('movimientos_id_cliente_foreign');
            $table->dropForeign('movimientos_id_operador_foreign');
            $table->dropForeign('movimientos_id_proveedor_foreign');
            $table->dropForeign('movimientos_id_recinto_foreign');
        });
    }
};
