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
        Schema::create('producto_adjuntos', function (Blueprint $table) {
            $table->increments('id_adjunto');
            $table->string('uri', 200);
            $table->string('descripcion', 100);
            $table->unsignedInteger('id_producto')->index('adjuntos_ibfk_1');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_adjuntos');
    }
};
