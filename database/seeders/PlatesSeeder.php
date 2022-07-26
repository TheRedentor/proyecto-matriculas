<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plate;

class PlatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $plate = new Plate();
        $plate->number = "1234-BCD";
        $plate->save();

        $plate = new Plate();
        $plate->number = "3547-NXB";
        $plate->save();
        */

        $plate = new Plate();
        $plate->number = "2345-ABC";
        $plate->save();

        $plate = new Plate();
        $plate->number = "5555-AAA";
        $plate->save();
    }
}
