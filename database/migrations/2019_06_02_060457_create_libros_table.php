<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibrosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('libros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo', 5);
            $table->date('fecha_publicacion');
            $table->string('editorial', 100);
            $table->string('idioma', 15);
            $table->string('num_editorial')->nullable();
            $table->string('libro_pdf');
            $table->string('cert_vicerrectoria')->nullable();
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
        Schema::dropIfExists('libros');
    }

}
