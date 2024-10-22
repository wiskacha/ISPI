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
        Schema::create('detalles', function (Blueprint $table) {
            $table->increments('id_detalle');
            $table->integer('cantidad');
            $table->decimal('precio', 10);
            $table->decimal('total', 10);
            $table->unsignedInteger('id_movimiento')->index('detalles_ibfk_1');
            $table->unsignedInteger('id_producto')->index('detalles_ibfk_2');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles');
    }
};
