<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->integer('id_producto')->primary();
            $table->string('codigo', 100);
            $table->string('nombre', 100);
            $table->decimal('precio', 10, 2);
            $table->string('presentacion', 200)->default('unidad');
            $table->string('unidad', 100);
            $table->integer('id_empresa')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_empresa', 'productos_ibfk_1')->references('id_empresa')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
