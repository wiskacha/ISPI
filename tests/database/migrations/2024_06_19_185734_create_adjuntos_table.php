<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjuntos', function (Blueprint $table) {
            $table->integer('id_adjunto')->primary();
            $table->string('uri', 200);
            $table->string('descripcion', 100);
            $table->integer('id_producto');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_producto', 'adjuntos_ibfk_1')->references('id_producto')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adjuntos');
    }
}
