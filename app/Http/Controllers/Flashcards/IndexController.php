<?php

namespace App\Http\Controllers\Flashcards;

use App\Models\Flashcard;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\CollectionResponse;

final class IndexController
{
    public function __invoke()
    {
        $flashcards = Flashcard::query()->get(['category', 'question', 'answer', 'question_image_url', 'answer_image_url']);

        if ($flashcards->isEmpty())
        {
            return new EmptyResponse();
        }

        return new CollectionResponse($flashcards);
    }
}