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
        Schema::create('domicilios_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('calle');
            $table->unsignedBigInteger('colonia_id')->nullable();
            $table->string('numero_ext');
            $table->string('numero_int');
            $table->unsignedBigInteger('cliente_id')->nullable();

            $table->foreign('colonia_id')
                ->references('id')
                ->on('colonias')
                ->onDelete('cascade');

            $table->timestamps();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domicilios_clientes');
    }
};
