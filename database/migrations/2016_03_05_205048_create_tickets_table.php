<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('user_id');
            $table->mediumInteger('code');
            $table->string('title', 50);
            $table->tinyInteger('status');
            $table->mediumInteger('supervisor_id');
            $table->string('text', 3000);
            $table->string('answer', 3000);
            $table->tinyInteger('priority');
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
        Schema::drop('tickets');
    }
}
