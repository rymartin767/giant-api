<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Queries\FetchArticles;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\ModelResponse;
use App\Http\Resources\ArticleCollection;
use App\Http\Responses\CollectionResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class ArticleController
{
    public function __construct(
        private readonly FetchArticles $query
    ) {}

    public function __invoke(Request $request)
    { 
        if ($request->has('id') && $request->filled('id')) {

            try {
                $article = $this->query->handle(
                    query: Article::query(),
                    id: request('id')
                )->firstOrFail();
            } catch (ModelNotFoundException) {
                $exception = new ModelNotFoundException('Article not found. Please check your id.');
                return new ErrorResponse(404, $exception);
            }
    
            return new ModelResponse($article);
        }

        if ($request->collect()->isNotEmpty()) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        $articles = $this->query->handle(
            query: Article::query(),
        )->orderByDesc('date')->get();

        if ($articles->isEmpty())
        {
            return new EmptyResponse();
        }

        return new CollectionResponse(
            data: new ArticleCollection($articles),
        );
    }
}