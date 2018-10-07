<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Http\Requests\PortfolioRequest;
use Corp\Portfolio;
use Corp\Repositories\FilterRepository;
use Corp\Repositories\PortfolioRepository;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class PortfolioController extends AdminController
{
    public function __construct(PortfolioRepository $p_rep, FilterRepository $f_rep)
    {
        parent::__construct();

        $this->p_rep = $p_rep;
        $this->f_rep = $f_rep;
        $this->template = 'admin.general';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('view', new Portfolio())) {
            $key = 'custom.VIEW_ADMIN_PORTFOLIOS';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $this->title = "Управление работами";

        $portfolios = $this->getPortfolios();
        $this->content_view = view(config('settings.theme') . '.admin.portfolios_content')
            ->with('portfolios', $portfolios)
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
        $this->title = "Добавление новой работы";

        $list = $this->makeFiltersList();
        $this->content_view = view(config('settings.theme') . '.admin.portfolios_edit_content')
            ->with('filters', $list)
            ->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PortfolioRequest $request)
    {
        $result = $this->p_rep->addPortfolio($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.portfolios.index')->with($result);
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
    public function edit(Portfolio $portfolio)
    {
        $this->title = "Редактирование работы – " . $portfolio->title;

        $portfolio->img = json_decode($portfolio->img);

        $list = $this->makeFiltersList();
        $this->content_view = view(config('settings.theme') . '.admin.portfolios_edit_content')
            ->with(['filters' => $list, 'portfolio' => $portfolio])
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
    public function update(PortfolioRequest $request, Portfolio $portfolio)
    {
        $result = $this->p_rep->updatePortfolio($request, $portfolio);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.portfolios.index')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {
        $result = $this->p_rep->deletePortfolio($portfolio);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.portfolios.index')->with($result);
    }

    public function getPortfolios()
    {
        return $this->p_rep->get(['id', 'title', 'text', 'customer', 'alias', 'date', 'img', 'filter_alias', 'meta_desc', 'keywords']);
    }

    public function getFilters()
    {
        return $this->f_rep->get(['title', 'alias']);
    }

    public function makeFiltersList()
    {
        $filters = $this->getFilters();
        $list = [];
        foreach ($filters as $filter) {
            $list[$filter->alias] = $filter->title;
        }
        return $list;
    }
}
