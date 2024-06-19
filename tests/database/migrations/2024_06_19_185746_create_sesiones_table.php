<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSesionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sesiones', function (Blueprint $table) {
            $table->string('id_sesion')->primary();
            $table->integer('id_usuario')->nullable();
            $table->string('direc_ip', 45)->nullable();
            $table->text('medio')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index('last_activity');
            
            $table->foreign('id_usuario', 'sesiones_ibfk_1')->references('id_usuario')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sesiones');
    }
}
