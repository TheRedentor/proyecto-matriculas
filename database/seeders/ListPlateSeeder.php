<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ListPlate;

class ListPlateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list_plate = new ListPlate();
        $list_plate->list_id = "1";
        $list_plate->plate_id = "1";
        $list_plate->save();

        $list_plate = new ListPlate();
        $list_plate->list_id = "2";
        $list_plate->plate_id = "2";
        $list_plate->save();
    }
}
