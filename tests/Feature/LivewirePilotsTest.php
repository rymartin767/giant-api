<?php

use App\Http\Livewire\Pilots;
use Livewire\Livewire;
use function Pest\Laravel\get;

test('pilots route is guarded by admin middleware', function() {
    get('/pilots')
        ->assertStatus(403)
        ->assertSee('ADMIN AREA ONLY!');
});

test('articles livewire component is present on articles page', function() {
    $this->actingAs(adminUser())->get('/pilots')
        ->assertSeeLivewire('pilots');
});

it('displays a select list of aws s3 files as options', function () {
    Livewire::test(Pilots::class)
        ->assertSeeHtml('<option value="seniority-lists/2023/03-10-2023.tsv">seniority-lists/2023/03-10-2023.tsv</option>');
});

test('storePilot method', function () {
    Livewire::test(Pilots::class)
        ->set('selectedAwsFilePath', 'seniority-lists/2023/testing-03-10-2023.tsv')
        ->call('storePilots');
        
    $this->assertDatabaseHas('pilots', ['id' => 1, 'employee_number' => '224']);
});