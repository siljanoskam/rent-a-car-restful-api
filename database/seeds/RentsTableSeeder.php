<?php

use App\Rent;
use Illuminate\Database\Seeder;

class RentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Rent::class, 10)->create();
    }
}
