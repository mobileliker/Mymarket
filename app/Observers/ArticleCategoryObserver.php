<?php

namespace App\Observers;

use App\ArticleCategory;
use Cache;

class ArticleCategoryObserver
{
    public function saved(ArticleCategory $articleCategory)
    {
        //更新product_categories
        $articleCategories = ArticleCategory::all();
        Cache::forget('product_categories');
        Cache::put('product_categories', $articleCategories);

        //更新子分类
        Cache::forget('article_category_'.$articleCategory->id);
        Cache::put('article_category_'.$articleCategory->id, $articleCategory->articles);

    }
}