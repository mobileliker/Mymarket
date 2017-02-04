<?php

namespace App\Observers;

use App\Article;
use Cache;

class ArticleObserver
{
    public function saved(Article $article)
    {
        $slug = $article->slug;
        Cache::forget('article_'.$slug);
        Cache::put('article_'.$slug, $article);
    }

    public function deleted(Article $article){
        $slug = $article->slug;
        Cache::forget('article_'.$article->slug);
    }
}