<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->unsignedInteger('id_persona');
            $table->unsignedInteger('id_empresa');
            $table->timestamps();
            $table->softDeletes();
            
            $table->primary(['id_persona', 'id_empresa']);
            $table->foreign('id_persona', 'contactos_ibfk_1')->references('id_persona')->on('personas');
            $table->foreign('id_empresa', 'contactos_ibfk_2')->references('id_empresa')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contactos');
    }
}
