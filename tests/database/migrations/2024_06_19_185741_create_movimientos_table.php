<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->integer('id_movimiento')->primary();
            $table->string('codigo', 100);
            $table->dateTime('fecha')->default('current_timestamp()');
            $table->string('glose', 200)->nullable();
            $table->string('tipo', 100);
            $table->integer('id_cliente')->nullable();
            $table->integer('id_recinto')->nullable();
            $table->integer('id_proveedor')->nullable();
            $table->integer('id_operador');
            $table->integer('id_almacen');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_cliente', 'movimientos_ibfk_1')->references('id_persona')->on('personas');
            $table->foreign('id_recinto', 'movimientos_ibfk_2')->references('id_recinto')->on('recintos');
            $table->foreign('id_proveedor', 'movimientos_ibfk_3')->references('id_persona')->on('personas');
            $table->foreign('id_operador', 'movimientos_ibfk_4')->references('id_usuario')->on('usuarios');
            $table->foreign('id_almacen', 'movimientos_ibfk_5')->references('id_almacen')->on('almacenes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimientos');
    }
}
