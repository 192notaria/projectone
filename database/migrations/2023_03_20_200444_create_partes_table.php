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
        Schema::create('partes', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("apaterno")->nullable();
            $table->string("amaterno")->nullable();
            $table->string("tipo_persona");
            $table->string("curp")->nullable();
            $table->string("rfc")->nullable();
            $table->string("tipo");
            $table->double("porcentaje")->nullable();
            $table->unsignedBigInteger("proyecto_id")->nullable();
            $table->unsignedBigInteger("cliente_id")->nullable();

            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos')
                ->nullOnDelete();

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
        Schema::dropIfExists('partes');
    }
};
