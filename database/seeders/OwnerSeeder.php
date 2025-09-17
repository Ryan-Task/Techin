<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
    
class OwnerSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'owner@usaha.com'],
            [
                'no_wa' => '089523419590',
                'name' => 'Owner Usaha',
                'password' => Hash::make('password123'),
                'role' => 'owner'
            ]
        );
    }
}