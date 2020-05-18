<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new App\User;
        $user->firstname = 'Gretl';
        $user->lastname = 'Bauer';
        $user->address = 'Street 1';
        $user->zip = '4020';
        $user->city = 'Linz';
        $user->ctry = 'Austria';
        $user->email = 'searcher1@testangular.com';
        $user->password = bcrypt('secret');
        $user->volunteer=0;
        $user->save();

        $user = new App\User;
        $user->firstname = 'Maximilian';
        $user->lastname = 'Mustermann';
        $user->address = 'Street 1';
        $user->zip = '4020';
        $user->city = 'Linz';
        $user->ctry = 'Austria';
        $user->email = 'volunteer1@testangular.com';
        $user->password = bcrypt('secret');
        $user->volunteer=1;
        $user->save();

        $user = new App\User;
        $user->firstname = 'Oma';
        $user->lastname = 'Trudltraut';
        $user->address = 'Street 1';
        $user->zip = '4020';
        $user->city = 'Linz';
        $user->ctry = 'Austria';
        $user->email = 'searcher2@testangular.com';
        $user->password = bcrypt('secret');
        $user->volunteer=0;
        $user->save();

    }
}
