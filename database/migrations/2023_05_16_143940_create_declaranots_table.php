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
        Schema::create('declaranots', function (Blueprint $table) {
            $table->id();
            $table->date("fecha");
            $table->unsignedBigInteger("proyecto_id")->nullable();
            $table->unsignedBigInteger("usuario_id")->nullable();
            $table->text("observaciones")->nullable();

            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos')
                ->nullOnDelete();

            $table->foreign('usuario_id')
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
        Schema::dropIfExists('declaranots');
    }
};
