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
        Schema::create('costos_cobrados', function (Blueprint $table) {
            $table->id();
            $table->double('monto');
            $table->unsignedBigInteger('costo_id');
            $table->unsignedBigInteger('cobro_id');

            $table->foreign('costo_id')
                ->references('id')
                ->on('costos')
                ->cascadeOnDelete();

            $table->foreign('cobro_id')
                ->references('id')
                ->on('cobros')
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
        Schema::dropIfExists('costos_cobrados');
    }
};
