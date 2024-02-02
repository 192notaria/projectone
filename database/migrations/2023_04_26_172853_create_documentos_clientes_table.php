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
        Schema::create('documentos_clientes', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("tipo")->nullable();
            $table->unsignedBigInteger("tipo_doc_id")->nullable();
            $table->text("path");
            $table->unsignedBigInteger("cliente_id")->nullable();

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
                ->nullOnDelete();

            $table->foreign('tipo_doc_id')
                ->references('id')
                ->on('catalogo_documentos_generales')
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
        Schema::dropIfExists('documentos_clientes');
    }
};
