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
            $table->increments('id_movimiento'); 
            $table->string('codigo', 100);
            $table->timestamp('fecha')->useCurrent(); 
            $table->string('glose', 200)->nullable();
            $table->string('tipo', 100);
            $table->unsignedInteger('id_cliente')->nullable();;
            $table->unsignedInteger('id_recinto')->nullable();;
            $table->unsignedInteger('id_proveedor')->nullable();;
            $table->unsignedInteger('id_operador');
            $table->unsignedInteger('id_almacen');
            $table->timestamps(); 
            $table->softDeletes(); 


            $table->foreign('id_cliente')->references('id_persona')->on('personas')->onDelete('cascade');
            $table->foreign('id_recinto')->references('id_recinto')->on('recintos')->onDelete('cascade');
            $table->foreign('id_proveedor')->references('id_persona')->on('personas')->onDelete('cascade');
            $table->foreign('id_operador')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes')->onDelete('cascade');
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
