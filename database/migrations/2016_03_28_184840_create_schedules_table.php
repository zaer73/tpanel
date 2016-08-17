<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('user_id');
            $table->string('title', 35);
            $table->string('type', 20);
            $table->string('clock', 20)->nullable();
            $table->string('day', 20)->nullable();
            $table->string('month')->nullable();
            $table->timestamp('start_at');
            $table->timestamp('finish_at');
            $table->timestamp('next_time')->index();
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
        Schema::drop('schedules');
    }
}
