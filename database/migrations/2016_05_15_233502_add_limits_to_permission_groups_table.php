<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLimitsToPermissionGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permission_groups', function (Blueprint $table) {
            $table->mediumInteger('agent_limit');
            $table->mediumInteger('user_limit');
            $table->mediumInteger('lawyer_limit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_groups', function (Blueprint $table) {
            $table->dropColumn('agent_limit');
            $table->dropColumn('user_limit');
            $table->dropColumn('lawyer_limit');
        });
    }
}
