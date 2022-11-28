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
        Schema::create('servicios_procesos_servicio', function (Blueprint $table) {
            $table->id();

            $table->foreignId("servicio_id")
                ->nullable()
                ->constrained("servicios")
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId("proceso_servicio_id")
                ->nullable()
                ->constrained("procesos_servicios")
                ->cascadeOnUpdate()
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
        Schema::dropIfExists('servicios_procesos_servicio');
    }
};
