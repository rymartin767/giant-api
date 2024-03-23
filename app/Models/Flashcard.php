<?php

namespace App\Models;

use App\Enums\FlashcardCategory;
use App\Enums\FlashcardEicasType;
use App\Enums\FlashcardReference;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'question',
        'answer',
        'question_image_url',
        'answer_image_url',
        'reference',
        'eicas_type',
        'eicas_message',
        'question_image_caption',
        'answer_image_caption'
    ];

    protected $casts = [
        'category' => FlashcardCategory::class,
        'reference' => FlashcardReference::class,
        'eicas_type' => FlashcardEicasType::class
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected static function booted()
    {
        static::deleting(function ($flashcard) {
            if (! is_null($flashcard->question_image_url)) {
                Storage::disk('s3-public')->delete($flashcard->question_image_url);
            }

            if (! is_null($flashcard->answer_image_url)) {
                Storage::disk('s3-public')->delete($flashcard->answer_image_url);
            }
        });
    }

    public function path() : string
    {
        return "/flashcards/$this->id";
    }
}
