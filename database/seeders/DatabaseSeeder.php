<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Scale;
use App\Models\Airline;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'id' => env('ADMIN_KEY'),
            'name' => 'Administrator',
            'email' => 'ryan@nt4c.com',
            'password' => Hash::make('test1234')
        ]);

        Airline::factory()->has(Scale::factory())->create();
    }
}
