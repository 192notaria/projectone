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
        Schema::create('registro_recibos', function (Blueprint $table) {
            $table->id();
            $table->integer("monto");
            $table->text("descripcion")->nullable();
            $table->boolean("factura");
            $table->string("metodo_pago");
            $table->text("recibo")->nullable();
            $table->unsignedBigInteger("cliente_id")->nullable();
            $table->unsignedBigInteger("proyecto_id");
            $table->unsignedBigInteger("usuario_id")->nullable();

            $table->foreign('proyecto_id')
                ->references('id')
                ->on('proyectos')
                ->cascadeOnDelete();

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes')
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
        Schema::dropIfExists('registro_recibos');
    }
};
