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
        Schema::create('documentos_declaranots', function (Blueprint $table) {
            $table->id();
            $table->text("path");
            $table->unsignedBigInteger("declaracion_id")->nullable();

            $table->foreign('declaracion_id')
                ->references('id')
                ->on('declaranots')
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
        Schema::dropIfExists('documentos_declaranots');
    }
};
