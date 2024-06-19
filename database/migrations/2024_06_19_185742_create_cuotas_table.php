<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->increments('id_cuota');
            $table->integer('numero');
            $table->string('codigo', 100)->unique('codigo');
            $table->string('concepto', 200);
            $table->date('fecha_venc');
            $table->decimal('monto_pagar', 10, 2);
            $table->decimal('monto_pagado', 10, 2);
            $table->decimal('monto_adeudado', 10, 2);
            $table->string('condicion', 100);
            $table->unsignedInteger('id_movimiento');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_movimiento', 'cuotas_ibfk_1')->references('id_movimiento')->on('movimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuotas');
    }
}
