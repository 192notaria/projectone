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
        Schema::create('catalogos_conceptos_pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_gasto_id')->nullable();
            $table->string('descripcion');
            $table->double('precio_sugerido');
            $table->double('impuestos')->nullable();
            $table->unsignedBigInteger('tipo_impuesto_id')->nullable();

            $table->foreign('categoria_gasto_id')
                ->references('id')
                ->on('catalogos_categoria_gastos')
                ->nullOnDelete();

            $table->foreign('tipo_impuesto_id')
                ->references('id')
                ->on('catalogos_tipo_impuestos')
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
        Schema::dropIfExists('catalogos_conceptos_pagos');
    }
};
