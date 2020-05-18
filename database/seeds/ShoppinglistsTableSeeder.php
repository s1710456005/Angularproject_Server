<?php

use Illuminate\Database\Seeder;

class ShoppinglistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shoppingList1 = new \App\Shoppinglist;
        $shoppingList1->title = 'Ein Bioeinkauf Bitte';

        //set foreignkey to liststatus and listuser
        $listStatus = App\Status::find(2);
        $shoppingList1->status()->associate($listStatus);
        $listUser = App\User::all()->first();
        $shoppingList1->user()->associate($listUser);
        $shoppingList1->volunteer_id = 2;
        $shoppingList1->deadline = new DateTime();
        $shoppingList1->save();

        $shoppingList2 = new \App\Shoppinglist;
        $shoppingList2->title = 'Billa sagt nicht das Geldbörserl';
        //set foreignkey to liststatus and listuser
        $listStatus2 = App\Status::all()->first();
        $shoppingList2->status()->associate($listStatus2);
        $listUser2 = App\User::where('id', 3)->first();
        $shoppingList2->user()->associate($listUser2);
        $shoppingList2->title = 'Ein Bioeinkauf Bitte';
        $shoppingList2->deadline = new DateTime();
        $shoppingList2->save();

        $shoppingList3 = new \App\Shoppinglist;
        $shoppingList3->title = 'Billa sagt nicht das Geldbörserl';
        //set foreignkey to liststatus and listuser
        $listStatus2 = App\Status::find(3);
        $shoppingList3->status()->associate($listStatus2);
        $listUser2 = App\User::where('id', 3)->first();
        $shoppingList3->user()->associate($listUser2);
        $shoppingList3->title = 'Ein Bioeinkauf Bitte';
        $volunteer_user = App\User::where('id', 2)->first();
        $shoppingList3->volunteer()->associate($volunteer_user);
        $shoppingList3->deadline = new DateTime();
        $shoppingList3->save();





    }
}
