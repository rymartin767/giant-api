<?php

namespace App\Models;

use App\Enums\ArticleCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'category', 
        'date', // MYSQL YYYY-MM-DD
        'title',
        'author',
        'story',
        'web_url',
        'slug'
    ];

    protected $casts = [
        'category' => ArticleCategory::class,
        'date' => 'immutable_datetime:m/d/Y', 
    ];

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn () => Carbon::parse($this->date)->format('Y/m/d') . '/' . str($this->title)->slug(),
        );
    }

    public function path()
    {
        return "articles/$this->slug";
    }
}
