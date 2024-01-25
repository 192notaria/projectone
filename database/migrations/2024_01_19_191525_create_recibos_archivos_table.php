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
        Schema::create('recibos_archivos', function (Blueprint $table) {
            $table->id();
            $table->text("path")->nullable();
            $table->unsignedBigInteger("proyecto_id");
            $table->unsignedBigInteger("usuario_entrega_id")->nullable();
            $table->unsignedBigInteger("usuario_recibe_id")->nullable();

            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos')
                ->cascadeOnDelete();

            $table->foreign('usuario_entrega_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->foreign('usuario_recibe_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('recibos_archivos');
    }
};
