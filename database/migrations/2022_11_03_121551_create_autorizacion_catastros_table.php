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
        Schema::create('autorizacion_catastros', function (Blueprint $table) {
            $table->id();
            $table->string("comprobante");
            $table->string("cuenta_predial");
            $table->string("clave_catastral");
            $table->unsignedBigInteger("proceso_id");
            $table->unsignedBigInteger("subproceso_id");
            $table->unsignedBigInteger("proyecto_id");

            $table->foreign('proceso_id')
                ->references('id')
                ->on('procesos_servicios')
                ->cascadeOnDelete();

            $table->foreign('subproceso_id')
                ->references('id')
                ->on('subprocesos_catalogos')
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
        Schema::dropIfExists('autorizacion_catastros');
    }
};
