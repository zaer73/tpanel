<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenderToPriceGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_groups', function (Blueprint $table) {
            $table->float('gender_reg')->default(1);
            $table->float('gender_lat')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('price_groups', function (Blueprint $table) {
            $table->dropColumn('gender_reg');
            $table->dropColumn('gender_lat');
        });
    }
}
