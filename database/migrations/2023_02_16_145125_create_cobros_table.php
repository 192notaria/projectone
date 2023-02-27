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
        Schema::create('cobros', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha');
            $table->string('cliente')->nullable();
            $table->double('monto');
            $table->unsignedBigInteger('metodo_pago_id')->nullable();
            $table->unsignedBigInteger('fatura_id')->nullable();
            $table->unsignedBigInteger('cuenta_id')->nullable();
            $table->unsignedBigInteger('proyecto_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->text('observaciones')->nullable();

            $table->foreign('metodo_pago_id')
                ->references('id')
                ->on('catalogo_metodos_pagos')
                ->nullOnDelete();

            $table->foreign('fatura_id')
                ->references('id')
                ->on('facturas')
                ->nullOnDelete();

            $table->foreign('cuenta_id')
                ->references('id')
                ->on('cuentas_bancarias')
                ->nullOnDelete();

            $table->foreign('usuario_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos')
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
        Schema::dropIfExists('cobros');
    }
};
