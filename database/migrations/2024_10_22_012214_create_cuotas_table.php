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
        Schema::create('cuotas', function (Blueprint $table) {
            $table->increments('id_cuota');
            $table->integer('numero');
            $table->string('codigo', 100)->unique('codigo');
            $table->string('concepto', 200);
            $table->date('fecha_venc');
            $table->decimal('monto_pagar', 10);
            $table->decimal('monto_pagado', 10);
            $table->decimal('monto_adeudado', 10);
            $table->string('condicion', 100);
            $table->unsignedInteger('id_movimiento')->index('cuotas_ibfk_1');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuotas');
    }
};
