<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function($table) {
                    $table->increments('id');
                    $table->string('email')->unique();
                    $table->string('fName');
                    $table->string('lName');
                    $table->string('phone');
                    $table->string('role');
                    $table->string('password');
                    $table->string('confirmed');
                    $table->boolean('isActv');
                    $table->string('lRank');
                    $table->string('hRank');
                    $table->string('desc');
                    $table->timestamps();
                });
    }

    public function down() {
        Schema::drop('users');
    }

}