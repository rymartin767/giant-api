<?php

use App\Models\Pilot;
use Livewire\Livewire;
use App\Http\Livewire\Pilots;
use function Pest\Laravel\get;

test('pilots route is guarded by admin middleware', function() {
    get('/pilots')
        ->assertStatus(403)
        ->assertSee('ADMIN AREA ONLY!');
});

test('pilots livewire component is present on pilots page', function() {
    $this->actingAs(adminUser())->get('/pilots')
        ->assertSeeLivewire('pilots');
});

it('displays a select list of aws s3 files as options', function () {
    Livewire::test(Pilots::class)
        ->assertSeeHtml('<option value="seniority-lists/2023/03-10-2023.tsv">seniority-lists/2023/03-10-2023.tsv</option>');
});

test('storePilot method', function () {
    Livewire::test(Pilots::class)
        ->set('selectedAwsFilePath', 'seniority-lists/2023/test-03-10-2023.tsv')
        ->call('storePilots')
        ->assertSet('status', '10 Pilots Saved!');

    $this->assertDatabaseHas('pilots', ['id' => 1, 'employee_number' => '224']);
    expect(Pilot::count())->toBe(10);
});

test('validation can fail', function() {
    Livewire::test(Pilots::class)
        ->set('selectedAwsFilePath', 'seniority-lists/2023/fail-03-10-2023.tsv')
        ->call('storePilots')
        ->assertSet('status', 'Row #9 failed validation for the following error: The selected domicile is invalid.');
});

it('only displays pilots in index for most current seniority list', function() {
    seedPilots(15, '02/15/2023');
    seedPilots(15, '03/15/2023');

    $this->actingAs(adminUser())->get('/pilots')
        ->assertSee('Mar 2023')
        ->assertDontSee('Feb 2023');
    
    expect(Pilot::count())->toBe(30);
});