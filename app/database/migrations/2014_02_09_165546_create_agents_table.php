<?php

use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('agents', function($table) {
                    $table->increments('id');
                    $table->string('email')->unique();
                    $table->string('fName');
                    $table->string('lName');
                    $table->string('phone');
                    $table->string('sex');
                    $table->string('nif');
                    $table->string('cin');
                    $table->string('birthday');
                    $table->string('department');
                    $table->string('lRank');
                    $table->string('hRank');
                    $table->string('aDate');
                    $table->string('idResepag');
                    $table->string('so');
                    $table->string('desc');
                    $table->string('cSection');
                    $table->string('city');
                    $table->string('tTotal');
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
        Schema::drop('agents');
    }

}