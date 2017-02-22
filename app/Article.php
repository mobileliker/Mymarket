<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * 要触发的所有关联关系
     *
     * @var array
     */
    protected $touches = ['category'];
    protected $table = 'articles';

    //
    public function category()
    {
        return $this->belongsTo('App\ArticleCategory', 'category_id', 'id');
    }
}
