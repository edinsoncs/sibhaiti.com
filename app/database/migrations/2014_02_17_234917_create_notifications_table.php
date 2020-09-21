<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('notifications', function($table) {
                    $table->increments('id');
                    $table->string('date');
                    $table->string('type');
                    $table->string('rId');
                    $table->string('rOb');
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
        Schema::drop('notifications');
    }

}
