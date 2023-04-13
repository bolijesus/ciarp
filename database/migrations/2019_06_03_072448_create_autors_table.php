<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('autors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('solicitud_id')->unsigned();
            $table->foreign('solicitud_id')->references('id')->on('solicituds')->onDelete('cascade');
            $table->bigInteger('docente_id')->unsigned();
            $table->foreign('docente_id')->references('id')->on('docentes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('autors');
    }

}
