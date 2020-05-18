<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusOpen = new \App\Status;
        $statusOpen->name = 'open';
        $statusOpen->save();

        $statusProgress = new \App\Status;
        $statusProgress->name = 'inprogress';
        $statusProgress->save();

        $statusDone = new \App\Status;
        $statusDone->name = 'done';
        $statusDone->save();
    }
}
