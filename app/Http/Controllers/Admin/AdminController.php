<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Article;
use Corp\Http\Controllers\Controller;
use Corp\Permission;
use Corp\Portfolio;
use Corp\Slider;
use Corp\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;
use Menu;

class AdminController extends Controller
{
    protected $p_rep;
    protected $a_rep;
    protected $cat_rep;
    protected $user;
    protected $template;
    protected $content_view = false;
    protected $title;
    protected $vars = [];

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $menu = $this->getAdminMenu();
        $menu_view = view(config('settings.theme') . '.admin.menu')
            ->with('menu', $menu)
            ->render();
        $this->vars = array_add($this->vars, 'menu_view', $menu_view);

        if ($this->content_view) {
            $this->vars = array_add($this->vars, 'content_view', $this->content_view);
        }

        $footer_view = view(config('settings.theme') . '.footer')
            ->render();
        $this->vars = array_add($this->vars, 'footer_view', $footer_view);

        return view(config('settings.theme') . '.' . $this->template)
            ->with($this->vars);
    }

    public function getAdminMenu()
    {
        return Menu::make('adminMenu', function ($menu) {
            if (Gate::allows('view', new Slider())) {
                $menu->add('Слайды', ['route' => 'admin.sliders.index']);
            }
            if (Gate::allows('view', new Article())) {
                $menu->add('Статьи', ['route' => 'admin.articles.index']);
            }
            if (Gate::allows('view', new Portfolio())) {
                $menu->add('Портфолио', ['route' => 'admin.portfolios.index']);
            }
            if (Gate::allows('view', new \Corp\Menu())) {
                $menu->add('Меню', ['route' => 'admin.menus.index']);
            }
            if (Gate::allows('view', new User())) {
                $menu->add('Пользователи', ['route' => 'admin.users.index']);
            }
            if (Gate::allows('view', new Permission())) {
                $menu->add('Привилегии', ['route' => 'admin.permissions.index']);
            }
        });
    }
}
