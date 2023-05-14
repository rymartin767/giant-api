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
        
        $this->command->info('Airline: GTI created!');

        $this->call(AirlineScalesSeeder::class);

        $this->command->info('737 Scales created for Atlas');

        Article::factory()->create();

        $this->command->info('Article created!');

        Event::factory()->create();

        $this->command->info('Event created!');

        Flashcard::factory()->create(['question' => 'What is the Maximum Operating Altitude', 'answer' => 'FL431']);
        
        $this->command->info('Flashcard: Limitation created!');
    }
}
