<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditUpgradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_upgrades', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('user_id');
            $table->bigInteger('value');
            $table->tinyInteger('status');
            $table->mediumInteger('payment_id');
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
        Schema::drop('credit_upgrades');
    }
}
