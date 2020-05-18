<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            //$table->foreign('user_id')->references('id')s->on('users');

            $table->integer('shoppinglist_id')->unsigned();
            $table->foreign('shoppinglist_id')->references('id')
                ->on('shoppinglists')
                ->onDelete('cascade');

            $table->string('messagetext');

            //only needed if the messagefeature on navigationbar is implemented
            //$table->boolean('read')->default(false);
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
        Schema::dropIfExists('messages');
    }
}
