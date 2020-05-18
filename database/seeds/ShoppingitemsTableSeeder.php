<?php

use Illuminate\Database\Seeder;

class ShoppingitemsTableSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shoppingitem = new \App\Shoppingitem;
        $shoppingitem->title ='Kopfsalat';
        $shoppingitem->quantity = '2';

        //TODO beziehung zu list

        $shoppingitem->price = 1.256;

        $itemUnit = App\Unit::find(2);
        //set relation to foreign key of unit
        $shoppingitem->unit()->associate($itemUnit);

        $itemList = App\Unit::all()->first();
        //set relation to foreign key of unit
        $shoppingitem->shoppinglist()->associate($itemList);

        $shoppingitem->save();

    }
}
