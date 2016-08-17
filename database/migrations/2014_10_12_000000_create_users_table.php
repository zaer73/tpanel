<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('type');
            $table->string('first_name', 25);
            $table->string('last_name', 25);
            $table->string('name', 50);
            $table->string('username', 25)->unique();
            $table->string('mobile', 15);
            $table->string('national_code', 15);
            $table->string('email', 50)->unique();
            $table->string('password', 60);
            $table->string('link_first_name', 25);
            $table->string('link_last_name', 25);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
