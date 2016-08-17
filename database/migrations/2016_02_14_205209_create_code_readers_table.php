<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodeReadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_readers', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('user_id');
            $table->string('title', 50);
            $table->mediumInteger('line_id');
            $table->string('condition_text', 500);
            $table->tinyInteger('condition_type');
            $table->tinyInteger('reaction_type');
            $table->string('reaction_text', 500);
            $table->mediumInteger('reaction_group');
            $table->tinyInteger('status');
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
        Schema::drop('code_readers');
    }
}
