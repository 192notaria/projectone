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
        Schema::create('cotejos_copias', function (Blueprint $table) {
            $table->id();
            $table->integer("costo_copia");
            $table->integer("cantidad_copias");
            $table->integer("juegos");
            $table->string("cliente")->nullable();
            $table->text("path_copias")->nullable();

            $table->unsignedBigInteger("proyecto_id")->nullable();
            $table->unsignedBigInteger("cliente_id")->nullable();

            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos')
                ->cascadeOnDelete();

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
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
        Schema::dropIfExists('cotejos_copias');
    }
};
