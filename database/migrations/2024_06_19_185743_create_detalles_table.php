<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles', function (Blueprint $table) {
            $table->increments('id_detalle');
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->decimal('total', 10, 2);
            $table->unsignedInteger('id_movimiento');
            $table->unsignedInteger('id_producto');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_movimiento', 'detalles_ibfk_1')->references('id_movimiento')->on('movimientos');
            $table->foreign('id_producto', 'detalles_ibfk_2')->references('id_producto')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles');
    }
}
