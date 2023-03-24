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
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("costo_id");
            $table->unsignedBigInteger("proyecto_id");
            $table->double("monto");
            $table->double("gestoria");
            $table->double("impuestos");
            $table->timestamp("fecha_egreso");
            $table->string("comentarios");
            $table->text("path")->nullable();

            $table->foreign('costo_id')
                ->references('id')
                ->on('costos')
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
        Schema::dropIfExists('egresos');
    }
};
