<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article, App\ArticleCategory;
use Session, Redirect;

class ArticlesController extends Controller
{
    private $panel = [
        'left'   => ['width' => '2'],
        'center' => ['width' => '10'],
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $panel = $this->panel;
        $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        return view('articles.index', compact('articles','panel'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $panel = $this->panel;
        $categories = ArticleCategory::all();
        $groupCategories = ['' => '单页面'];
        foreach($categories as $category){
            $groupCategories[$category->id] = $category->display_name;
        }

        return view('articles.create', compact('groupCategories','panel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return $this->storeOrUpdate($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $article = Article::find($id);
        if($article == null){
            Session::push('message', '该文章不存在');
            if($article == null) return Redirect::to('wpanel/articles');
        }
        $panel = $this->panel;

        $categories = ArticleCategory::all();
        $groupCategories = ['' => '单页面'];
        foreach($categories as $category){
            $groupCategories[$category->id] = $category->display_name;
        }

        return view('articles.edit', compact('panel', 'article', 'groupCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        return $this->storeOrUpdate($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $article = Article::find($id);
        if($article == null){
            Session::push('message', '该文章已被删除,无法重复删除');
            return Redirect::back();
        }else{
            if($article->delete()){
                Session::push('message', '文章删除成功');
                return Redirect::back();
            }else{
                Session::push('message', '文章删除失败');
                return Redirect::back();
            }
        }
    }

    public function storeOrUpdate($request, $id = -1)
    {
        $this->validate($request, [
            'title' => 'required',
            'sort' => 'required',
        ]);

        $title = $request->get('title');
        $slug = $request->get('slug');
        $category_id = $request->get('category_id');
        $content = $request->get('content');
        $sort = $request->get('sort');

        if($id == -1){
            $article = new Article;
        }else{
            $article = Article::find($id);
            if($article == null){
                Session::push('message', '该文章已被删除');
                return Redirect::to('wpanel/articles');
            }
        }

        $article->title = $title;
        $article->slug = $slug;
        if($category_id == null || $category_id == '') $article->category_id = null;
        else $article->category_id = $category_id;
        $article->content = $content;
        $article->sort = $sort;

        if($article->save()){
            if($id == -1) Session::push('message', '新增文章成功');
            else Session::push('message', '修改文章成功');
        }else{
            if($id == -1) Session::push('message', '新增文章失败');
            else Session::push('message', '修改文章失败');
        }
        return Redirect::to('wpanel/articles');
    }

    public function slug($slug)
    {
        $labels = ProductsController::getTopRated(0, 1, true);
        $article = Article::where('slug', $slug)->first();
        if($article == null){
            abort(404);
        }else{
            return view('szy.page.show', compact('article', 'labels'));
        }
    }
}
