<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('user_id');
            $table->string('title', 50);
            $table->string('description', 250);
            $table->float('talia_reg');
            $table->float('talia_lat');
            $table->float('talia_rec');
            $table->float('talia_smr');
            $table->float('spadana_reg');
            $table->float('spadana_lat');
            $table->float('spadana_rec');
            $table->float('spadana_smr');
            $table->float('kish_reg');
            $table->float('kish_lat');
            $table->float('kish_rec');
            $table->float('kish_smr');
            $table->float('irancell_reg');
            $table->float('irancell_lat');
            $table->float('irancell_rec');
            $table->float('irancell_smr');
            $table->float('rightel_reg');
            $table->float('rightel_lat');
            $table->float('rightel_rec');
            $table->float('rightel_smr');
            $table->float('hamrah_reg');
            $table->float('hamrah_lat');
            $table->float('hamrah_rec');
            $table->float('hamrah_smr');
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
        Schema::drop('price_groups');
    }
}
