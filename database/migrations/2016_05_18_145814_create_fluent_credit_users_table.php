<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFluentCreditUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fluent_credit_users', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('user_id');
            $table->mediumInteger('group_hash');
            $table->mediumInteger('ceil');
            $table->mediumInteger('fee');
            $table->tinyInteger('status');
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
        Schema::drop('fluent_credit_users');
    }
}
