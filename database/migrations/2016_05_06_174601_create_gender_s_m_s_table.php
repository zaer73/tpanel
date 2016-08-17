<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenderSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gender_s_m_s', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('user_id');
            $table->string('text', 1000);
            $table->string('inputs', 1000);
            $table->string('returnId', 50);
            $table->mediumInteger('credit');
            $table->boolean('canceled');
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
        Schema::drop('gender_s_m_s');
    }
}
