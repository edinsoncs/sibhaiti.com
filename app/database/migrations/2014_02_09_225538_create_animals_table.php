<?php

use Illuminate\Database\Migrations\Migration;

class CreateAnimalsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('animals', function($table) {
                    $table->increments('id');
                    $table->string('carnet')->unique();
                    $table->string('type');
                    $table->string('tag')->unique();
                    $table->string('birthday');
                    $table->string('isVaccinated');
                    $table->string('mTag');
                    $table->string('fTag');
                    $table->string('eleveur');
                    $table->string('dDate');
                    $table->string('desc');
                    $table->boolean('isActv');
                    $table->timestamps();
                });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('animals');
    }

}