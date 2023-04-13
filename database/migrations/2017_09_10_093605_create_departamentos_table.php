<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo_dane')->nullable();
            $table->string('nombre');
            $table->integer('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('pais')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('departamentos');
    }

}
