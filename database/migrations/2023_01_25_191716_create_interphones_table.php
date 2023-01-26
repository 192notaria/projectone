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
        Schema::create('interphones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("from");
            $table->unsignedBigInteger("to");
            $table->text("path");
            $table->boolean("view")->nullable();

            $table->foreign('from')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('to')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('interphones');
    }
};
