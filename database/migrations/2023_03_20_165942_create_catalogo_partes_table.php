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
        Schema::create('catalogo_partes', function (Blueprint $table) {
            $table->id();
            $table->string("descripcion");
            $table->unsignedBigInteger("servicio_id");

            $table->foreign('servicio_id')
                ->references('id')
                ->on('servicios')
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
        Schema::dropIfExists('catalogo_partes');
    }
};
