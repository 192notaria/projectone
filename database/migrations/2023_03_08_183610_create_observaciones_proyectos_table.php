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
        Schema::create('observaciones_proyectos', function (Blueprint $table) {
            $table->id();
            $table->text("comentarios");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("proyecto_id");

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('observaciones_proyectos');
    }
};
