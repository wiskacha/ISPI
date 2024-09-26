<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoAdjuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_adjuntos', function (Blueprint $table) {
            $table->increments('id_adjunto');
            $table->text('uri'); // Usar TEXT para almacenar rutas más largas
            $table->string('descripcion', 255)->nullable(); // Descripción más larga y opcional
            $table->unsignedInteger('id_producto'); // Cambiar a unsignedBigInteger si es necesario
            $table->string('mime_type', 100)->nullable(); // Almacenar el tipo de archivo si es necesario
            $table->timestamps();
            $table->softDeletes();

            // Clave foránea
            $table->foreign('id_producto', 'producto_adjuntos_ibfk_1')->references('id_producto')->on('productos');

            // Índices
            $table->index('id_producto');
            $table->index('uri');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_adjuntos');
    }
}
