<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNumberBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number', 20)->unique();
            $table->mediumInteger('province_id');
            $table->mediumInteger('city_id');
            $table->mediumInteger('job_id');
            $table->mediumInteger('postal_code_id');
            $table->mediumInteger('gender');
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
        Schema::drop('number_banks');
    }
}
