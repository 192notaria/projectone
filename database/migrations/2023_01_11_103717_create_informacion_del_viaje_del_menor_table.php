<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacion_del_viaje_del_menor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pais_procedencia");
            $table->unsignedBigInteger("pais_destino");
            $table->string("aereolinea")->nullable();
            $table->string("numero_vuelo")->nullable();
            $table->string("nombre_garita")->nullable();
            $table->integer("tiempo_extranjero");
            $table->text("domicilio_destino")->nullable();
            $table->text("personas_viaje");
            $table->unsignedBigInteger("proyecto_id");

            $table->foreign('pais_procedencia')
                ->references('id')
                ->on('paises')
                ->onDelete('cascade');

            $table->foreign('pais_destino')
                ->references('id')
                ->on('paises')
                ->onDelete('cascade');

            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informacion_del_viaje_del_menors');
    }
};
