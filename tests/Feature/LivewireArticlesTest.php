<?php

use Livewire\Livewire;
use App\Models\Article;
use function Pest\Laravel\get;
use App\Http\Livewire\articles;

test('articles route is guarded by admin middleware', function() {
    get('/articles')
        ->assertStatus(403)
        ->assertSee('ADMIN AREA ONLY!');
});

test('articles livewire component is present on articles page', function() {
    $this->actingAs(adminUser())->get('/articles')
        ->assertSeeLivewire('articles');
});

test('articles livewire component shows articles in database', function() {
    $article = Article::factory()->create();

    Livewire::test(articles::class)
        ->assertSee($article->title);
});

test('articles livewire component storeArticle method', function() {
    $article = Article::factory()->raw();

    Livewire::test(Articles::class)
        ->set('category', 1)
        ->set('date', now())
        ->set('title', 'Atlas Air pilots gain massive contractual improvements.')
        ->set('author', 'Loadstar Cargo')
        ->set('story', $article['story'])
        ->set('web_url', $article['web_url'])
        ->call('storeArticle');

    $this->assertDatabaseHas('articles', [
        'id' => 1, 
        'title' => 'Atlas Air pilots gain massive contractual improvements.', 
        'slug' => now()->format('Y/m/d') . '/atlas-air-pilots-gain-massive-contractual-improvements'
    ]);
});

