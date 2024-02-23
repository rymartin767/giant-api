<?php

use App\Models\Pilot;
use Livewire\Livewire;
use App\Models\Staffing;
use App\Livewire\Pilots;
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
        ->assertSeeHtml('<option value="seniority-lists/v1/2024/v1-01-10-2024.tsv">seniority-lists/v1/2024/v1-01-10-2024.tsv</option>');
                         
});

test('storePilot method', function () {
    Livewire::test(Pilots::class)
        ->set('selectedAwsFilePath', 'seniority-lists/2023/test-03-10-2023.tsv')
        ->call('storePilots');

    $this->assertDatabaseHas('pilots', ['id' => 1, 'employee_number' => '224']);

    expect(Pilot::count())->toBe(10);
});

test('storeStaffingReport method', function () {
    seedPilots(15, '03/15/2023');

    Livewire::test(Pilots::class)
        ->set('selectedAwsFilePath', 'seniority-lists/2023/test-03-10-2023.tsv')
        ->call('storePilots', 15);

    $this->assertDatabaseHas('staffings', ['id' => 1, 'list_date' => '2023-03-10']);

    expect(Staffing::count())->toBe(1);
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

    $r = $this->actingAs(adminUser())->get('/pilots');
    
    expect(Pilot::count())->toBe(30);
});