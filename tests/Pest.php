<?php

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Pilot;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Actions\Pilots\GenerateStaffingReport;
use Illuminate\Foundation\Testing\RefreshDatabase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, RefreshDatabase::class)->in('Feature');
uses(TestCase::class, RefreshDatabase::class)->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function adminUser() : User
{
    return User::factory()->create(['id' => env('ADMIN_KEY')]);
}

function sanctumToken() : User
{
    return Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );
}

function seedPilots(int $count, string $date) : void
{
    $file = Storage::disk('public')->get('pilots.json');
    $pilots = json_decode($file);

    foreach ($pilots as $pilot) {
        if ($count > 0) {
            Pilot::create([
                'seniority_number' => $pilot->seniority_number,
                'employee_number' => $pilot->employee_number,
                'doh' => Carbon::parse($pilot->doh)->format('Y-m-d'),
                'seat' => $pilot->seat,
                'fleet' => $pilot->fleet,
                'domicile' => $pilot->domicile,
                'retire' => Carbon::parse($pilot->retire)->format('Y-m-d'),
                'status' => $pilot->status,
                'month' => Carbon::parse($date)->format('Y-m-d')
            ]);

            $count--;
        }
    }
}
