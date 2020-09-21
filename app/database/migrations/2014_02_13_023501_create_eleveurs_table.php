<?php

use Illuminate\Database\Migrations\Migration;

class CreateEleveursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eleveurs', function($table) {
                    $table->increments('id');
                    $table->string('idEleveur');
                    $table->string('email')->unique();
                    $table->string('phone');
                    $table->string('fName');
                    $table->string('lName');                   
                    $table->string('cin');
                    $table->string('department');
                    $table->string('idResepag');
                    $table->string('so');
                    $table->string('desc');
                    $table->string('cSection');
                    $table->boolean('isActv');
                    $table->timestamps();
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		 Schema::drop('eleveurs');
	}

}