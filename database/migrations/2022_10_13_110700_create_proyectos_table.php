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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("servicio_id")->nullable();
            $table->unsignedBigInteger("cliente_id")->nullable();
            $table->unsignedBigInteger("usuario_id")->nullable();
            $table->integer("status");

            $table->foreign('servicio_id')
                ->references('id')
                ->on('servicios')
                ->onDelete('set null');

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
                ->onDelete('set null');

            $table->foreign('usuario_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

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
        Schema::dropIfExists('proyectos');
    }
};
