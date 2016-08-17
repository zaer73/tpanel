<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeAndTextToTrashedSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trashed_s_m_s', function (Blueprint $table) {
            $table->tinyInteger('type');
            $table->string('text', 500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trashed_s_m_s', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('text');
        });
    }
}
