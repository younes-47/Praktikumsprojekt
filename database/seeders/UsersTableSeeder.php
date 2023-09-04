<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Younes KHOUBAZ',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'remember_token'=> str::random(10),
        ]);
    }
}
