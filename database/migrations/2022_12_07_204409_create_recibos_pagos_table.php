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
            $table->unsignedBigInteger("proyecto_id")->nullable();
            $table->unsignedBigInteger("subproceso_id")->nullable();

            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos')
                ->nullOnDelete();

            $table->foreign('subproceso_id')
                ->references('id')
                ->on('subprocesos_catalogos')
                ->nullOnDelete();

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
