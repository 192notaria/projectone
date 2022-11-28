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
        Schema::create('subprocesos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("subproceso_id")->nullable();
            $table->unsignedBigInteger("proceso_id")->nullable();

            $table->foreign('subproceso_id')
                ->references('id')
                ->on('subprocesos_catalogos')
                ->nullOnDelete();

            $table->foreign('proceso_id')
                ->references('id')
                ->on('procesos_servicios')
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
        Schema::dropIfExists('subprocesos');
    }
};
