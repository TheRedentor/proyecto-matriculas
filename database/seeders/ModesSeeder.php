<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Mode;
use Illuminate\Support\Str;

class ModesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mode = new Mode();
        $mode->name = "Sin cache";
        $mode->cache = false;
        $mode->sources = false;
        $mode->save();

        $mode = new Mode();
        $mode->name = "Con cache";
        $mode->cache = true;
        $mode->sources = true;
        $mode->save();
    }
}
