<?php

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unitKG = new App\Unit;
        $unitKG->name = strtoupper('kg');
        $unitKG->save();

        $unitPC = new App\Unit;
        $unitPC->name = strtoupper('stk');
        $unitPC->save();

        $unitLiter = new App\Unit;
        $unitLiter->name = strtoupper('Liter');
        $unitLiter->save();

    }
}
