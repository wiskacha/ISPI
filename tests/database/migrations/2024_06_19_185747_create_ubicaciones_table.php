<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->integer('id_ubicacion')->primary();
            $table->string('direccion', 200);
            $table->integer('telefono')->nullable();
            $table->string('tipo', 100);
            $table->string('nota', 200)->nullable();
            $table->integer('id_persona');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_persona', 'ubicaciones_ibfk_1')->references('id_persona')->on('personas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ubicaciones');
    }
}
