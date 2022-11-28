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
        Schema::create('registro_firmas', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->timestamp("fechayhora");
            $table->unsignedBigInteger("proceso_id");
            $table->unsignedBigInteger("subproceso_id");
            $table->unsignedBigInteger("cliente_id");
            $table->unsignedBigInteger("proyecto_id");

            $table->foreign('proceso_id')
                ->references('id')
                ->on('procesos_servicios')
                ->cascadeOnDelete();

            $table->foreign('subproceso_id')
                ->references('id')
                ->on('subprocesos_catalogos')
                ->cascadeOnDelete();

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
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
        Schema::dropIfExists('registro_firmas');
    }
};
