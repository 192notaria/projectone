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
        Schema::create('avance_proyectos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("proyecto_id");
            $table->unsignedBigInteger("proceso_id");
            $table->unsignedBigInteger("subproceso_id");

            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos')
                ->onDelete('cascade');

            $table->foreign('proceso_id')
                ->references('id')
                ->on('procesos_servicios')
                ->onDelete('cascade');

            $table->foreign('subproceso_id')
                ->references('id')
                ->on('subprocesos_catalogos')
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
        Schema::dropIfExists('avance_proyectos');
    }
};
