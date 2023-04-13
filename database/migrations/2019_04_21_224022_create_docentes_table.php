<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocentesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('docentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipodoc', 60);
            $table->string('numero_documento', 15)->unique();
            $table->string('primer_nombre', 50);
            $table->string('segundo_nombre', 50)->nullable();
            $table->string('primer_apellido', 50);
            $table->string('segundo_apellido', 50)->nullable();
            $table->string('sexo')->nullable();
            $table->string('correo');
            $table->string('telefono', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('dedicacion', 100);
            $table->integer('puntos_iniciales')->default(0)->nullable();
            $table->string('user_change', 15);
            $table->integer('departamentof_id')->unsigned();
            $table->foreign('departamentof_id')->references('id')->on('departamentofs')->onDelete('cascade');
            $table->integer('categoria_id')->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('docentes');
    }

}
