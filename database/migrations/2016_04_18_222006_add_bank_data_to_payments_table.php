<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBankDataToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->mediumInteger('invoice_id');
            $table->string('gateway');
            $table->string('RefId', 50);
            $table->mediumInteger('ResCode');
            $table->bigInteger('saleOrderId');
            $table->bigInteger('SaleReferenceId');
            $table->string('CardHolderInfo', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            //
        });
    }
}
