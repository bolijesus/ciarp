<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwaresTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('softwares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titular');
            $table->string('result_pares');
            $table->string('impacto_upc', 2);
            $table->string('codigo');
            $table->string('instrucciones');
            $table->string('ejecutable');
            $table->string('cert_registro');
            $table->string('cert_imp_upc');
            $table->string('manual');
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
        Schema::dropIfExists('softwares');
    }

}
