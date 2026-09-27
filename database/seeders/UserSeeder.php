<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => "Mohammed",
            'slug' => Str::slug('Mohammed'),
            'email' => "med.rh.med27@gmail.com",
            'phone' => "0666666666",
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        User::factory()->create([
            'name' => "Alabax",
            'slug' => Str::slug('Alabax'),
            'email' => "alabax@mail.com",
            'phone' => "0666666667",
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}
