<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('user_id');
            $table->string('title', 50);
            $table->tinyInteger('type');
            $table->mediumInteger('line_id');
            $table->timestamp('started_at');
            $table->timestamp('finished_at');
            $table->string('question', 500);
            $table->string('answer', 50);
            $table->string('reply', 500);
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
        Schema::drop('polls');
    }
}
