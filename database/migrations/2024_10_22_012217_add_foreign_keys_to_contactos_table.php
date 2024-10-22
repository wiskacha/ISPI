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
        Schema::table('contactos', function (Blueprint $table) {
            $table->foreign(['id_persona'], 'contactos_ibfk_1')->references(['id_persona'])->on('personas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_empresa'], 'contactos_ibfk_2')->references(['id_empresa'])->on('empresas')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contactos', function (Blueprint $table) {
            $table->dropForeign('contactos_ibfk_1');
            $table->dropForeign('contactos_ibfk_2');
        });
    }
};
