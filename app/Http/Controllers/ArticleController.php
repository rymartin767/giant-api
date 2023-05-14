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
        // !No Models Exist = Empty Response
        if (!Article::exists()) {
            return new EmptyResponse();
        }

        // !ID Parameter is Present (Model Response)
        if ($request->has('id')) {
            // Empty Parameter
            if (!$request->filled('id')) {
                return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
            }

            // Model Handling
            try {
                $article = $this->query->handle(
                    query: Article::query(),
                    id: request('id')
                )->firstOrFail();
            } catch (ModelNotFoundException) {
                $exception = new ModelNotFoundException('Article not found. Please check your id.');
                return new ErrorResponse(404, $exception);
            }

            // Model Response
            return new ModelResponse($article); 
        }

        // !ID Parameter is Missing (Collection Response)

        // Bad Parameter
        if ($request->collect()->isNotEmpty()) {
            return new ErrorResponse(401, new BadRequestException('Please check your request parameters.'));
        }

        // Collection Handling
        $articles = $this->query->handle(
            query: Article::query(),
        )->latest('date')->get();

        // Empty Response if collection is empty
        if ($articles->isEmpty())
        {
            return new EmptyResponse();
        }
        
        // Collection Response
        return new CollectionResponse(
            data: new ArticleCollection($articles),
        );
    }
}