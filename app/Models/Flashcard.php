<?php

namespace App\Models;

use App\Enums\FlashcardCategory;
use App\Enums\FlashcardReference;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'question', 'answer', 'question_image_url', 'answer_image_url', 'reference'];

    protected $casts = [
        'category' => FlashcardCategory::class,
        'reference' => FlashcardReference::class
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];

    public function path() : string
    {
        return "/flashcards/$this->id";
    }
}
