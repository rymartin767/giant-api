<?php

use Carbon\Carbon;
use App\Models\Article;
use function Pest\Laravel\get;

test('response for unauthenticated request', function() {
    get('v1/articles')
        ->assertStatus(302);
});

it('can return an empty response', function() {
    $this->actingAs(sanctumToken())->get('v1/articles')
        ->assertExactJson(['data' => []])
        ->assertOk();
});

it('can return a collection response', function() {
    $data = Article::factory()->create();
    $dataTwo = Article::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/articles')
        ->assertExactJson(['data' => [
            [
                'id' => $data->id,
                'category' => $data->category,
                'date' => Carbon::parse($data->date)->format('m/d/Y'),
                'title' => $data->title,
                'author' => $data->author,
                'story' => $data->story,
                'web_url' => $data->web_url,
                'slug' => $data->slug,
            ],
            [
                'id' => $dataTwo->id,
                'category' => $dataTwo->category,
                'date' => Carbon::parse($dataTwo->date)->format('m/d/Y'),
                'title' => $dataTwo->title,
                'author' => $dataTwo->author,
                'story' => $dataTwo->story,
                'web_url' => $dataTwo->web_url,
                'slug' => $dataTwo->slug,
            ],
        ]])
        ->assertOk();
});

test('collection response sorts by latest articles', function() {
    $middle = Article::factory()->create(['date' => now()->subWeek()]);
    $newest = Article::factory()->create(['date' => now()]);
    $oldest = Article::factory()->create(['date' => now()->subWeeks(2)]);

    $this->actingAs(sanctumToken())->get('v1/articles')
        ->assertExactJson(['data' => [
            [
                'id' => $newest->id,
                'category' => $newest->category,
                'date' => Carbon::parse($newest->date)->format('m/d/Y'),
                'title' => $newest->title,
                'author' => $newest->author,
                'story' => $newest->story,
                'web_url' => $newest->web_url,
                'slug' => $newest->slug,
            ],
            [
                'id' => $middle->id,
                'category' => $middle->category,
                'date' => Carbon::parse($middle->date)->format('m/d/Y'),
                'title' => $middle->title,
                'author' => $middle->author,
                'story' => $middle->story,
                'web_url' => $middle->web_url,
                'slug' => $middle->slug,
            ],
            [
                'id' => $oldest->id,
                'category' => $oldest->category,
                'date' => Carbon::parse($oldest->date)->format('m/d/Y'),
                'title' => $oldest->title,
                'author' => $oldest->author,
                'story' => $oldest->story,
                'web_url' => $oldest->web_url,
                'slug' => $oldest->slug,
            ],
        ]])
        ->assertOk();
});

it('can return a model response', function() {
    $data = Article::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/articles?id=1')
        ->assertExactJson(['data' => [
            [
                'id' => $data->id,
                'category' => $data->category,
                'date' => Carbon::parse($data->date)->format('m/d/Y'),
                'title' => $data->title,
                'author' => $data->author,
                'story' => $data->story,
                'web_url' => $data->web_url,
                'slug' => $data->slug,
            ]
        ]])
        ->assertOk();
});

test('error response for model not found', function() {
    Article::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/articles?id=3')
        ->assertExactJson(['error' => [
            'message' => 'Article not found. Please check your id.',
            'type' => 'Illuminate\Database\Eloquent\ModelNotFoundException',
            'code' => 404
        ]])
        ->assertStatus(404);
});

test('error response for bad parameter name', function() {
    Article::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/articles?ic=1')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});

test('error response for id parameter not being filled', function() {
    Article::factory()->create();

    $this->actingAs(sanctumToken())->get('v1/articles?id=')
        ->assertExactJson(['error' => [
            'message' => 'Please check your request parameters.',
            'type' => 'Symfony\Component\HttpFoundation\Exception\BadRequestException',
            'code' => 401
        ]])
        ->assertStatus(401);
});