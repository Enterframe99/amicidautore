<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookuserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_user', function (Blueprint $table) {
            $table->text('quote', 10000)->nullable();
            $table->text('review', 10000)->nullable();
            $table->tinyInteger('related')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_user', function (Blueprint $table) {
            $table->dropColumn(array('quote', 'review', 'related'));
        });
    }
}
