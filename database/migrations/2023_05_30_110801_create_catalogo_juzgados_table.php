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
        Schema::create('catalogo_juzgados', function (Blueprint $table) {
            $table->id();
            $table->string("distrito");
            $table->string("adscripcion");
            $table->unsignedBigInteger("cliente_id")->nullable();
            $table->string("domicilio");

            $table->foreign("cliente_id")
                ->references("id")
                ->on("clientes")
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
        Schema::dropIfExists('catalogo_juzgados');
    }
};
