<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFechacierresTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fechacierres', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fechainicio');
            $table->dateTime('fechafin');
            $table->string('estado', 15);
            $table->string('user_change', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('fechacierres');
    }

}
