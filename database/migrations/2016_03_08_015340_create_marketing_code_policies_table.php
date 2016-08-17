<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketingCodePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_code_policies', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('user_id');
            $table->mediumInteger('signing_up_credit');
            $table->mediumInteger('marketer_credit');
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
        Schema::drop('marketing_code_policies');
    }
}
