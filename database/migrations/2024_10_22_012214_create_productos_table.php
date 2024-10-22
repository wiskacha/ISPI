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
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id_producto');
            $table->string('codigo', 100);
            $table->string('nombre', 100)->unique();
            $table->decimal('precio', 10);
            $table->string('presentacion', 200)->default('unidad');
            $table->string('unidad', 100);
            $table->unsignedInteger('id_empresa')->nullable()->index('productos_id_empresa_foreign');
            $table->longText('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
