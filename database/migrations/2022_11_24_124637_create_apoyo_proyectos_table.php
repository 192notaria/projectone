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
        Schema::create('apoyo_proyectos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("abogado_id");
            $table->unsignedBigInteger("abogado_apoyo_id");
            $table->unsignedBigInteger("proyecto_id");

            $table->foreign('abogado_id')
                ->references('id')
                ->on('users');

            $table->foreign('abogado_apoyo_id')
                ->references('id')
                ->on('users');

            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos');

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
        Schema::dropIfExists('apoyo_proyectos');
    }
};
