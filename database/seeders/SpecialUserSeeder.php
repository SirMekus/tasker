<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class SpecialUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            ['name' => [
                'firstname' => "Emeka",
                'lastname' => "Ohakwe",
            ],
            'email' => "mekus600@gmail.com",
            'password' => 'password',
            'remember_token' => Str::random(10),
            ]
        );
    }
}
