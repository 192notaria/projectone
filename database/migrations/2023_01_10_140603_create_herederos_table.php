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
        Schema::create('herederos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("cliente_id");
            $table->unsignedBigInteger("proyecto_id");
            $table->string("tipo");
            $table->text("acta_nacimiento")->nullable();
            $table->text("acta_matrimonio")->nullable();
            $table->text("curp")->nullable();
            $table->text("rfc")->nullable();
            $table->text("identificacion_oficial_con_foto")->nullable();
            $table->text("comprobante_domicilio")->nullable();
            $table->boolean("hijo")->nullable();

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
        Schema::dropIfExists('herederos');
    }
};
