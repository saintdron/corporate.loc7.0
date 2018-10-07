<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Article;
use Corp\Http\Requests\ArticleRequest;
use Corp\Repositories\ArticleRepository;
use Corp\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends AdminController
{
    public function __construct(ArticleRepository $a_rep, CategoryRepository $cat_rep)
    {
        parent::__construct();

        $this->a_rep = $a_rep;
        $this->cat_rep = $cat_rep;
        $this->template = 'admin.general';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('view', new Article())) {
//            abort(403);
            $key = 'custom.VIEW_ADMIN_ARTICLES';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $this->title = "Управление статьями";

        $articles = $this->getArticles();
        $this->content_view = view(config('settings.theme') . '.admin.articles_content')
            ->with('articles', $articles)
            ->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
/*        if (Gate::denies('create', new Article())) {
//            abort(403);
            $key = 'custom.CREATE_ARTICLES';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }*/

        $this->title = "Добавление нового материала";

        $list = $this->makeCategoriesList();
        $this->content_view = view(config('settings.theme') . '.admin.articles_edit_content')
            ->with('categories', $list)
            ->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $result = $this->a_rep->addArticle($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.articles.index')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
/*        if (Gate::denies('update', $article)) {
            abort(403);
        }*/

        $this->title = "Редактирование материала – " . $article->title;

        $article->img = json_decode($article->img);

        $list = $this->makeCategoriesList();
        $this->content_view = view(config('settings.theme') . '.admin.articles_edit_content')
            ->with(['categories' => $list, 'article' => $article])
            ->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $result = $this->a_rep->updateArticle($request, $article);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.articles.index')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $result = $this->a_rep->deleteArticle($article);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.articles.index')->with($result);
    }

    public function fix(Article $article, Request $request)
    {
        if (Gate::denies('update', $article)) {
//            abort(403);
            $key = 'custom.UPDATE_' . strtoupper(class_basename($article)) . 'S';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $data = $request->only('fixed');
        $data['fixed'] = ($data['fixed'] === 'true');
        if (!$article->update($data)) {
            return ['error' => 'Не удалось зафиксировать страницу'];
        }
    }

    public function getArticles()
    {
        return $this->a_rep->get();
    }

    public function getCategories()
    {
        return $this->cat_rep->get(['title', 'alias', 'parent_id', 'id']);
    }

    public function makeCategoriesList()
    {
        $categories = $this->getCategories();
        $list = [];
        foreach ($categories as $category) {
            if ($category->parent_id === 0) {
                $list[$category->title] = [];
            } else {
                $list[$categories->where('id', $category->parent_id)->first()->title][$category->id] = $category->title;
            }
        }
        return $list;
    }
}
