<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Studiogenesis";
        $user->email = "joel.olmo@studiogenesis.es";
        $user->password = Hash::make('1234');
        $user->mode_id = 1;
        $user->api_token = Str::random(60);
        $user->is_admin = 1;
        $user->save();
    }
}
