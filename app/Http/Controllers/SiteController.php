<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\MenuRepository;
use Illuminate\Http\Request;
use Menu;

class SiteController extends Controller
{
    protected $p_rep; // PortfolioRepository
    protected $s_rep; // SliderRepository
    protected $a_rep; // ArticleRepository
    protected $m_rep; // MenuRepository
    protected $c_rep; // CommentRepository
    protected $cat_rep; // CategoryRepository

    protected $keywords;
    protected $meta_desc;
    protected $title;

    protected $template; // the name of the returned template
    protected $vars = []; // list of variables to be passed to the template

    protected $bar = 'no'; // whether the sidebar is enabled
    protected $contentLeftBar = null; // content of the left bar
    protected $contentRightBar = null; // content of the right bar
    protected $stickyBar = false;

    public function __construct(MenuRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput()
    {
        $navigation_view = view(config('settings.theme') . '.navigation')
            ->with('menu', $this->getMenu())
            ->render();
        $this->vars = array_add($this->vars, 'navigation_view', $navigation_view);

        if ($this->contentRightBar) {
            $rightBar_view = view(config('settings.theme') . '.rightBar')
                ->with(['content_rightBar' => $this->contentRightBar, 'sticky' => $this->stickyBar])
                ->render();
            $this->vars = array_add($this->vars, 'rightBar_view', $rightBar_view);
        }
        if ($this->contentLeftBar) {
            $leftBar_view = view(config('settings.theme') . '.leftBar')
                ->with(['content_leftBar' => $this->contentLeftBar, 'sticky' => $this->stickyBar])
                ->render();
            $this->vars = array_add($this->vars, 'leftBar_view', $leftBar_view);
        }
        $this->vars = array_add($this->vars, 'bar', $this->bar);

        $footer_view = view(config('settings.theme') . '.footer')
            ->render();
        $this->vars = array_add($this->vars, 'footer_view', $footer_view);

        $this->vars = array_merge($this->vars, [
            'keywords' => $this->keywords,
            'meta_desc' => $this->meta_desc,
            'title' => $this->title
        ]);

        return view(config('settings.theme') . '.' . $this->template)
            ->with($this->vars);
    }

    public function getMenu()
    {
        $menu = $this->m_rep->get();

        return Menu::make('MyNav', function ($m) use ($menu) {
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
