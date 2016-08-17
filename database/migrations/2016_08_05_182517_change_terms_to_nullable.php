<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTermsToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('name')->nullable()->change();
            $table->string('mobile')->nullable()->change();
            $table->string('national_code')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name', 25)->nullable(false)->change();
            $table->string('last_name', 25)->nullable(false)->change();
            $table->string('name', 50)->nullable(false)->change();
            $table->string('mobile', 15)->nullable(false)->change();
            $table->string('national_code', 15)->nullable(false)->change();
            $table->string('email', 50)->nullable(false);
        });
    }
}
