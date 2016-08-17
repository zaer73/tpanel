<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalsToPriceGroupsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_groups', function (Blueprint $table) {
            $table->tinyInteger('tax')->default('0');
            $table->float('tax_percent');
            $table->mediumInteger('character_limit');
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
            $table->dropColumn('tax');
            $table->dropColumn('tax_percent');
            $table->dropColumn('character_limit');
        });
    }
}
