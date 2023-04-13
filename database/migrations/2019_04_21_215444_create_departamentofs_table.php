<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentofsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('departamentofs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('facultad_id')->unsigned();
            $table->foreign('facultad_id')->references('id')->on('facultads')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('departamentofs');
    }

}
