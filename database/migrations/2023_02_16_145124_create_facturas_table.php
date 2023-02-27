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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->double('monto');
            $table->string('folio_factura');
            $table->string('rfc_receptor');
            $table->timestamp('fecha');
            $table->string('origen');
            $table->unsignedBigInteger('concepto_pago_id')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('xml')->nullable();
            $table->text('pdf')->nullable();
            $table->unsignedBigInteger('proyecto_id');

            $table->foreign('concepto_pago_id')
                ->references('id')
                ->on('costos')
                ->nullOnDelete();

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
        Schema::dropIfExists('facturas');
    }
};
