<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Article;
use Livewire\Component;

class Articles extends Component
{
    public $loaded = false;
    public $status;

    public function render()
    {
        return view('livewire.dashboard.articles');
    }

    public function initLoading() : void
    {
        $article = Article::latest()->get()->first();
        $this->status = str($article->title ?? 'No Articles')->limit(15) . ' published ' . $article?->created_at->diffForHumans();

        $this->loaded = true;
    }
}
