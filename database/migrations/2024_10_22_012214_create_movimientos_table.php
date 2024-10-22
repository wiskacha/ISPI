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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id_movimiento');
            $table->string('codigo', 100);
            $table->timestamp('fecha')->useCurrent();
            $table->timestamp('fecha_f')->nullable();
            $table->string('glose', 200)->nullable();
            $table->string('tipo', 100);
            $table->unsignedInteger('id_cliente')->nullable()->index('movimientos_id_cliente_foreign');
            $table->unsignedInteger('id_recinto')->nullable()->index('movimientos_id_recinto_foreign');
            $table->unsignedInteger('id_proveedor')->nullable()->index('movimientos_id_proveedor_foreign');
            $table->unsignedInteger('id_operador')->index('movimientos_id_operador_foreign');
            $table->unsignedInteger('id_almacen')->index('movimientos_id_almacen_foreign');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
