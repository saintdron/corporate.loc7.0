<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Category;
use Corp\Filter;
use Corp\Http\Requests\MenuRequest;
use Menu;
use Gate;
use Corp\Repositories\ArticleRepository;
use Corp\Repositories\MenuRepository;
use Corp\Repositories\PortfolioRepository;
use Illuminate\Http\Request;

class MenuController extends AdminController
{
    protected $m_rep;

    public function __construct(MenuRepository $m_rep, ArticleRepository $a_rep, PortfolioRepository $p_rep)
    {
        parent::__construct();

        $this->m_rep = $m_rep;
        $this->a_rep = $a_rep;
        $this->p_rep = $p_rep;

        $this->template = 'admin.general';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('view', new \Corp\Menu())) {
//            abort(403);
            $key = 'custom.VIEW_MENUS';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];;
        }

        $this->title = "Управление меню";

        $menus = $this->getMenus();
        $this->content_view = view(config('settings.theme') . '.admin.menus_content')
            ->with('menus', $menus)
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
        /*        if (Gate::denies('create', new \Corp\Menu())) {
        //            abort(403);
                    $key = 'custom.CREATE_MENUS';
                    return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];;
                }*/

        $this->title = "Новый пункт меню";

        $menus = $this->getMenus()->roots()->reduce(function ($carry, $item) {
            return array_add($carry, $item->id, $item->title);
        }, ['0' => 'Родительский пункт меню']);

        $categories = Category::select(['id', 'title', 'alias', 'parent_id'])->get();
        $list = ['0' => 'Не используется'];
        $list = array_add($list, 'parent', 'Раздел блог');
        foreach ($categories as $category) {
            if ($category->parent_id === 0) {
                $list[$category->title] = [];
            } else {
                $list[$categories->where('id', $category->parent_id)->first()->title][$category->alias] = $category->title;
            }
        }

        $articles = $this->a_rep->get(['id', 'title', 'alias'])->reduce(function ($carry, $item) {
            return array_add($carry, $item->alias, $item->title);
        }, []);

        $filters = Filter::select(['id', 'title', 'alias'])->get()->reduce(function ($carry, $item) {
            return array_add($carry, $item->alias, $item->title);
        }, ['parent' => 'Раздел портфолио']);

        $portfolios = $this->p_rep->get(['id', 'title', 'alias'])->reduce(function ($carry, $item) {
            return array_add($carry, $item->alias, $item->title);
        }, []);

        $this->content_view = view(config('settings.theme') . '.admin.menus_edit_content')
            ->with(['menus' => $menus, 'categories' => $list, 'articles' => $articles, 'filters' => $filters, 'portfolios' => $portfolios])
            ->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $result = $this->m_rep->addMenu($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.menus.index')->with($result);
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
    public function edit(\Corp\Menu $menu)
    {
        /*        if (Gate::denies('update', new \Corp\Menu())) {
                    abort(403);
                }*/


        $this->title = "Редактирование пункта меню – " . $menu->title;

        try {
            $route = app('router')->getRoutes()->match(app('request')->create($menu->path));
        } catch (\Exception $exception) {
            $type = 'customLink';
            $option = '';
        }

        if (isset($route)) {
            $routeAlias = $route->getName();
            $parameters = $route->parameters();
            switch ($routeAlias) {
                case 'articles.index':
                case 'articlesCat':
                    $type = 'blogLink';
                    $option = $parameters['cat_alias'] ?? 'parent';
                    break;
                case 'articles.show':
                    $type = 'blogLink';
                    $option = $parameters['alias'] ?? '';
                    break;
                case 'portfolios.index':
                    $type = 'portfolioLink';
                    $option = 'parent';
                    break;
                case 'portfolios.show':
                    $type = 'portfolioLink';
                    $option = $parameters['alias'] ?? '';
                    break;
                default:
                    $type = 'customLink';
                    $option = '';
            }
        }


        $menus = $this->getMenus()->roots()->reduce(function ($carry, $item) {
            return array_add($carry, $item->id, $item->title);
        }, ['0' => 'Родительский пункт меню']);

        $categories = Category::select(['id', 'title', 'alias', 'parent_id'])->get();
        $list = ['0' => 'Не используется'];
        $list = array_add($list, 'parent', 'Раздел блог');
        foreach ($categories as $category) {
            if ($category->parent_id === 0) {
                $list[$category->title] = [];
            } else {
                $list[$categories->where('id', $category->parent_id)->first()->title][$category->alias] = $category->title;
            }
        }

        $articles = $this->a_rep->get(['id', 'title', 'alias'])->reduce(function ($carry, $item) {
            return array_add($carry, $item->alias, $item->title);
        }, []);

        $filters = Filter::select(['id', 'title', 'alias'])->get()->reduce(function ($carry, $item) {
            return array_add($carry, $item->alias, $item->title);
        }, ['parent' => 'Раздел портфолио']);

        $portfolios = $this->p_rep->get(['id', 'title', 'alias'])->reduce(function ($carry, $item) {
            return array_add($carry, $item->alias, $item->title);
        }, []);

        $this->content_view = view(config('settings.theme') . '.admin.menus_edit_content')
            ->with(['menu' => $menu, 'type' => $type, 'option' => $option, 'menus' => $menus, 'categories' => $list, 'articles' => $articles, 'filters' => $filters, 'portfolios' => $portfolios])
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
    public function update(MenuRequest $request, \Corp\Menu $menu)
    {
        $result = $this->m_rep->updateMenu($request, $menu);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.menus.index')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\Corp\Menu $menu)
    {
        $result = $this->m_rep->deleteMenu($menu);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.menus.index')->with($result);
    }

    public function getMenus()
    {
        $menu = $this->m_rep->get(['id', 'title', 'path', 'parent_id']);

        if ($menu->isEmpty()) {
            return false;
        }

        return Menu::make('forMenusContent', function ($m) use ($menu) {
            foreach ($menu as $item) {
                if ($item->parent_id === 0) {
                    $m->add($item->title, $item->path)->id($item->id);
                }
            }
            foreach ($menu as $item) {
                if ($item->parent_id !== 0) {
                    $m->find($item->parent_id)->add($item->title, $item->path)->id($item->id);
                }
            }
        });
    }
}
