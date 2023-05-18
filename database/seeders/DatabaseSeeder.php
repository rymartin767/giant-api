<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Airline;
use App\Models\Article;
use App\Models\Flashcard;
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

        $this->command->info('User: Administrator (ryan@nt4c.com) created!');

        Airline::factory()->create(['sector' => 1, 'name' => 'Atlas Air', 'icao' => 'GTI', 'iata' => '5Y']);
        Airline::factory()->create(['sector' => 1, 'name' => 'United Parcel Service', 'icao' => 'UPS', 'iata' => '5X']);
        Airline::factory()->create(['sector' => 1, 'name' => 'Fedex Express', 'icao' => 'FDX', 'iata' => 'FX']);
        Airline::factory()->create(['sector' => 1, 'name' => 'Delta Air Lines', 'icao' => 'DAL', 'iata' => 'DL']);
        
        $this->command->info('Airlines Created!');

        Article::factory()->create();

        $this->command->info('Article created!');

        Event::factory()->create();

        $this->command->info('Event created!');

        Flashcard::factory()->create(['question' => 'What is the Maximum Operating Altitude', 'answer' => 'FL431']);
        
        $this->command->info('Flashcard: Limitation created!');
    }
}
