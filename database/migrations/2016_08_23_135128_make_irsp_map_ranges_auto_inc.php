<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeIrspMapRangesAutoInc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('irsp_maps_range', function (Blueprint $table) {
            $table->dropColumn('rangeid');
            $table->increments('rangeid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('irsp_maps_range', function (Blueprint $table) {
            $table->dropColumn('rangeid');
        });
    }
}
