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
        Schema::create('contactos', function (Blueprint $table) {
            $table->unsignedInteger('id_persona');
            $table->unsignedInteger('id_empresa')->index('contactos_ibfk_2');
            $table->timestamps();
            $table->softDeletes();

            $table->primary(['id_persona', 'id_empresa']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
