<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppingitems', function (Blueprint $table) {
            $table->increments('id');


            $table->integer('shoppinglist_id')->unsigned();
            $table->foreign('shoppinglist_id')->references('id')
                ->on('shoppinglists')
                ->onDelete('cascade');

            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')
                ->on('units');

            $table->string('title');
            $table->integer('quantity')->nullable();
            $table->decimal('price')->nullable();
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
        Schema::dropIfExists('shoppingitems');
    }
}
