<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $message1 = new \App\Message;
        $user =App\User::find(1);
        $message1->user()->associate($user);
        $message1->messagetext = 'tralalalala';

        $itemList = App\Unit::all()->first();
        //set relation to foreign key of unit
        $message1->shoppinglist()->associate($itemList);

        $message1->save();
    }
}
