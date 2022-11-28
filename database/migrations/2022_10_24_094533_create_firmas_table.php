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
        Schema::create('firmas', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->timestamp("fecha_inicio");
            $table->timestamp("fecha_fin");
            $table->unsignedBigInteger("proceso_id");
            $table->unsignedBigInteger("cliente_id");
            $table->unsignedBigInteger("proyecto_id");

            $table->foreign('proceso_id')
                ->references('id')
                ->on('procesos_servicios')
                ->onDelete('cascade');

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
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
        Schema::dropIfExists('firmas');
    }
};
