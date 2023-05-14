<?php

use App\Models\Article;
use App\Enums\ArticleCategory;

test('article attribute casting for category', function () {
    $article = Article::factory()->create();
    $this->assertSame(ArticleCategory::class, $article->getCasts()['category']);
});

test('article attribute casting for date', function () {
    $article = Article::factory()->create();
    $this->assertSame('immutable_datetime:m/d/Y', $article->getCasts()['date']);
});

test('article date casting format for json', function () {
    $article = Article::factory()->create(['date' => now()]);
    $json = json_decode($article);
    $this->assertSame(now()->format('m/d/Y'), $json->date);
});
