<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\MenuRepository;
use Corp\Repositories\PortfolioRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class PortfolioController extends SiteController
{
    public function __construct(MenuRepository $m_rep, PortfolioRepository $p_rep)
    {
        parent::__construct($m_rep);

        $this->template = 'portfolios';
        $this->p_rep = $p_rep;
    }

    public function index()
    {
        $this->title = 'Портфолио';
        $this->keywords = 'Портфолио_ключи';
        $this->meta_desc = 'Портфолио_описание';

        $portfolios = $this->getPortfolios(false, Config::get('settings.portfolios_paginate'));
        $content = view(config('settings.theme') . '.portfolios_content')
            ->with('portfolios', $portfolios)
            ->render();
        $this->vars = array_add($this->vars, 'content_view', $content);

        return $this->renderOutput();
    }

    public function show($alias)
    {
        $portfolio = $this->getPortfolio($alias);

        $this->title = $portfolio->title;
        $this->keywords = $portfolio->keywords;
        $this->meta_desc = $portfolio->meta_desc;

        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), false);

        $content_view = view(config('settings.theme') . '.portfolio_content')
            ->with(['portfolio' => $portfolio, 'portfolios' => $portfolios])
            ->render();
        $this->vars = array_add($this->vars, 'content_view', $content_view);

        return $this->renderOutput();
    }

    protected function getPortfolios($take = false, $pagination = false)
    {
        return $this->p_rep->get(['title', 'text', 'alias', 'customer', 'img', 'date', 'filter_alias', 'created_at'], $take, $pagination);
    }

    protected function getPortfolio($alias)
    {
        return $this->p_rep->one($alias, ['title', 'text', 'alias', 'customer', 'img', 'date', 'filter_alias', 'created_at']);
    }
}