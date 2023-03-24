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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apaterno');
            $table->string('amaterno');
            $table->unsignedBigInteger('municipio_nacimiento_id')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->unsignedBigInteger('ocupacion')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('genero');
            $table->string('curp')->nullable();
            $table->string('rfc')->nullable();
            $table->string('tipo_cliente')->nullable();
            $table->string("firebase_key")->nullable();

            $table->foreign('municipio_nacimiento_id')
                ->references('id')
                ->on('municipios')
                ->onDelete('set null');

            $table->foreign('ocupacion')
                ->references('id')
                ->on('ocupaciones')
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
        Schema::dropIfExists('clientes');
    }
};
