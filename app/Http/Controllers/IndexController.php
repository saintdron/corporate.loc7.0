<?php

namespace Corp\Http\Controllers;

use Corp\Menu;
use Corp\Repositories\ArticleRepository;
use Corp\Repositories\CommentRepository;
use Corp\Repositories\MenuRepository;
use Corp\Repositories\PortfolioRepository;
use Corp\Repositories\SliderRepository;
use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class IndexController extends SiteController
{
    public function __construct(MenuRepository $m_rep, SliderRepository $s_rep, PortfolioRepository $p_rep,
                                ArticleRepository $a_rep, CommentRepository $c_rep)
    {
        parent::__construct($m_rep);

        $this->template = 'index';
        $this->bar = 'right';
        $this->s_rep = $s_rep;
        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;
        $this->c_rep = $c_rep;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->title = 'Tproger';
        $this->keywords = 'Tproger';
        $this->meta_desc = 'Tproger';

        $slider_view = view(config('settings.theme') . '.slider')
            ->with('slider', $this->getSlider())
            ->render();

        $portfolios = $this->getPortfolios();
        $content_view = view(config('settings.theme') . '.content')
            ->with('portfolios', $portfolios)
            ->render();

        $this->vars = array_merge($this->vars, [
            'slider_view' => $slider_view,
            'content_view' => $content_view
        ]);

        $this->formContentRightBar();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function getArticles($take)
    {
        $articles = $this->a_rep->get(['title', 'img', 'created_at', 'alias'], $take);
        return $articles;
    }

    protected function getComments($take)
    {
        $comments = $this->c_rep->get(['name', 'email', 'text', 'site', 'article_id', 'user_id'], $take);
        if ($comments) {
            $comments->load('article', 'user');
        }
        return $comments;
    }

    protected function getPortfolios()
    {
        $portfolios = $this->p_rep->get('*', Config::get('settings.home_portfolios_count'));
        if ($portfolios) {
            $portfolios->load('filter');
        }
        return $portfolios;
    }

    protected function getSlider()
    {
        $slider = $this->s_rep->get(['id', 'img', 'desc', 'title', 'position']);

        if ($slider->isEmpty()) {
            return false;
        }

        $slider->transform(function ($item) {
            $item->img = Config::get('settings.slider_path') . '/' . $item->img;

            $obj = new \stdClass();
            $obj->value = $item->position;
            switch ($item->position) {
                case 2:
                    $obj->text = 'Нижний правый угол';
                    $obj->class = 'slider-bottom-right';
                    break;
                case 3:
                    $obj->text = 'Нижний левый угол';
                    $obj->class = 'slider-bottom-left';
                    break;
                case 3:
                    $obj->text = 'Верхний левый угол';
                    $obj->class = 'slider-top-left';
                    break;
                default:
                    $obj->text = 'Верхний правый угол';
                    $obj->class = 'slider-top-right';
            }
            $item->position = $obj;

            return $item;
        });

        return $slider;
    }

    protected function formContentRightBar()
    {
        $fixed = $this->a_rep->get(['title', 'img', 'created_at', 'alias'], config('settings.home_articles_count'), false, ['fixed', 1]);
        $restCount = config('settings.home_articles_count') - count($fixed);
        if ($restCount) {
            $restArticles = $this->a_rep->get(['title', 'img', 'created_at', 'alias'], $restCount, false, ['fixed', 0]);
            $articles = $fixed->concat($restArticles);
        } else {
            $articles = $fixed;
        }

        $comments = $this->getComments(config('settings.recent_comments'));

        $this->contentRightBar = view(config('settings.theme') . '.indexBar')
            ->with(['comments' => $comments, 'articles' => $articles])
            ->render();
    }
}
