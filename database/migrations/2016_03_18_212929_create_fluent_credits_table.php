<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFluentCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fluent_credits', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('user_id');
            $table->bigInteger('ceil');
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
        Schema::drop('fluent_credits');
    }
}
