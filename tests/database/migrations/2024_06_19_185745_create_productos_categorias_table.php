<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_categorias', function (Blueprint $table) {
            $table->integer('id_producto');
            $table->integer('id_categoria');
            $table->timestamps();
            $table->softDeletes();
            
            $table->primary(['id_producto', 'id_categoria']);
            $table->foreign('id_producto', 'productos_categorias_ibfk_1')->references('id_producto')->on('productos');
            $table->foreign('id_categoria', 'productos_categorias_ibfk_2')->references('id_categoria')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_categorias');
    }
}
