<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePonenciasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ponencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre_evento', 100);
            $table->date('fecha_evento');
            $table->string('lugar', 100);
            $table->string('tipo', 15);
            $table->string('idioma', 15);
            $table->string('paginaweb', 100);
            $table->string('presenta_memorias', 2);
            $table->integer('num_reconocidas');
            $table->string('archivo_memorias', 100);
            $table->string('cert_ponente', 100);
            $table->string('user_change', 15);
            $table->bigInteger('solicitud_id')->unsigned();
            $table->foreign('solicitud_id')->references('id')->on('solicituds')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('ponencias');
    }

}
