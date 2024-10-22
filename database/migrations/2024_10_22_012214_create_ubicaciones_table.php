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
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->increments('id_ubicacion');
            $table->string('direccion', 200);
            $table->integer('telefono')->nullable();
            $table->string('tipo', 100);
            $table->string('nota', 200)->nullable();
            $table->unsignedInteger('id_persona')->index('ubicaciones_ibfk_1');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicaciones');
    }
};
