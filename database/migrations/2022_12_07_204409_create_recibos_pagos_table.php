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
        Schema::create('recibos_pagos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->text("path");
            $table->double("costo_recibo");
            $table->double("gastos_gestoria");
            $table->unsignedBigInteger("cliente_id");
            $table->unsignedBigInteger("proyecto_id");

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
        Schema::dropIfExists('recibos_pagos');
    }
};
