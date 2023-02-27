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
        Schema::create('cuentas_bancarias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uso_id')->nullable();
            $table->unsignedBigInteger('tipo_cuenta_id')->nullable();
            $table->unsignedBigInteger('banco_id')->nullable();
            $table->string('titular');
            $table->integer('numero_cuenta');
            $table->integer('clabe_interbancaria');
            $table->text('observaciones');

            $table->foreign('uso_id')
                ->references('id')
                ->on('catalogos_uso_de_cuentas')
                ->nullOnDelete();

            $table->foreign('tipo_cuenta_id')
                ->references('id')
                ->on('catalogos_tipo_cuentas')
                ->nullOnDelete();

            $table->foreign('banco_id')
                ->references('id')
                ->on('catalogos_bancos')
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
        Schema::dropIfExists('cuentas_bancarias');
    }
};
