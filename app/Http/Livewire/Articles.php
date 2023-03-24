<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;
use App\Http\Requests\ArticleRequest;

class Articles extends Component
{
    // FORMDATA
    public $category;
    public $date;
    public $title;
    public $author;
    public $story;
    public $web_url;
    public $slug;

    protected function rules(): array
    {
        return (new ArticleRequest())->rules();
    }

    public function render()
    {
        return view('livewire.articles', [
            'articles' => Article::all()
        ]);
    }

    public function storeArticle()
    {
        $validatedData = $this->validate();

        Article::create($validatedData);
    }
}
