<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('articulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('clasificacion', 30);
            $table->string('indexada', 2);
            $table->string('nombre_revista', 200)->nullable();
            $table->date('fechapublicacion');
            $table->string('evd_filiacion_upc', 2);
            $table->string('idioma', 15);
            $table->integer('ps_solicitados');
            $table->integer('bo_solicitados');
            $table->string('articulo_pdf');
            $table->string('publindex');
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
        Schema::dropIfExists('articulos');
    }

}
