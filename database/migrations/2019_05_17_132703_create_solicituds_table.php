<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('solicituds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('radicado')->unique();
            $table->string('tipo', 20);
            $table->string('titulo')->nullable();
            $table->integer('num_autores')->nullable();
            $table->string('evd_cred_upc', 5)->nullable();
            $table->string('cvlac')->nullable();
            $table->string('gruplac')->nullable();
            $table->integer('puntos_aproximados_ps')->nullable();
            $table->integer('puntos_aproximados_bo')->nullable();
            $table->integer('puntos_ps')->nullable();
            $table->integer('puntos_bo')->nullable();
            $table->string('estado', 50)->default('EN ESPERA');
            $table->string('observacion')->nullable();
            $table->string('grupo_investigacion')->nullable();
            $table->string('isbn')->nullable();
            $table->string('issn')->nullable();
            $table->string('acta', 200)->nullable();
            $table->string('user_change', 15);
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
        Schema::dropIfExists('solicituds');
    }

}
