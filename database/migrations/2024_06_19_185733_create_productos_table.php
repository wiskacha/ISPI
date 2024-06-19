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
            $table->increments('id_producto');
            $table->string('codigo', 100);
            $table->string('nombre', 100);
            $table->decimal('precio', 10, 2);
            $table->string('presentacion', 200)->default('unidad');
            $table->string('unidad', 100);
            $table->unsignedInteger('id_empresa')->nullable(); // Use unsignedInteger for referencing an integer primary key
            $table->timestamps();
            $table->softDeletes();
            
            // Define foreign key constraint
            $table->foreign('id_empresa')->references('id_empresa')->on('empresas');
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
