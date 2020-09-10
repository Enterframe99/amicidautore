<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_user', function (Blueprint $table) {
            $table->id();
            /*$table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->on('users')->references('id'); sostituito da stringa seguente */
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            /*$table->bigInteger('book_id')->unsigned();
            $table->foreign('book_id')->on('users')->references('id'); sostituito da stringa seguente */
            $table->foreignId('book_id')->constrained();
            $table->tinyInteger('order')->unsigned();
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
        Schema::dropIfExists('book_user');
    }
}
