<?php

namespace App\Models;

use App\Enums\FlashcardCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'question', 'answer', 'question_image_url', 'answer_image_url'];

    protected $casts = [
        'category' => FlashcardCategory::class
    ];

    public function path() : string
    {
        return "/flashcards/$this->id";
    }
}
