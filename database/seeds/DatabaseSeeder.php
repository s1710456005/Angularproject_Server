<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(ShoppinglistsTableSeeder::class);
        $this->call(ShoppingitemsTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
    }
}
