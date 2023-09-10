<?php

use App\Models\Award;
use Livewire\Livewire;
use App\Livewire\Awards;
use function Pest\Laravel\get;

test('awards route is guarded by admin middleware', function() {
    get('/awards')
        ->assertStatus(403)
        ->assertSee('ADMIN AREA ONLY!');
});

test('awards livewire component is present on awards page', function() {
    $this->actingAs(adminUser())->get('/awards')
        ->assertSeeLivewire('awards');
});

it('displays a select list of aws s3 files as options', function () {
    Livewire::test(Awards::class)
        ->assertSeeHtml('<option value="vacancy-awards/2023/TEST_MAR_2023.tsv">vacancy-awards/2023/TEST_MAR_2023.tsv</option>');
});

test('storeAward method', function () {
    Livewire::test(Awards::class)
        ->set('selectedYear', '2023')
        ->set('selectedAwsFilePath', 'vacancy-awards/2023/TEST_MAR_2023.tsv')
        ->call('storeAwards');
        
    $this->assertDatabaseHas('awards', ['id' => 1, 'employee_number' => '224']);
});

test('truncateAward method', function() {
    Award::factory()->create();

    Livewire::test(Awards::class)
        ->call('truncateAwards');

    $this->assertDatabaseMissing('awards', ['id' => 1]);
});