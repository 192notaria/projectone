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
        Schema::create('cotizacion_proyectos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("concepto_id")->nullable();
            $table->double("subtotal");
            $table->double("impuestos");
            $table->double("gestoria")->nullable();
            $table->string("pago")->nullable();
            $table->string("metodo_pago")->nullable();
            $table->text("observaciones")->nullable();
            $table->unsignedBigInteger("proyecto_id")->nullable();

            $table->foreign('concepto_id')
                ->references('id')
                ->on('catalogos_conceptos_pagos')
                ->cascadeOnDelete();

            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('cotizacion_proyectos');
    }
};
