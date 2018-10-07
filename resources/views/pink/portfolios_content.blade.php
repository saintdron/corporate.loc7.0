<div id="content-page" class="content group">
    <div class="hentry group">
        @if($portfolios)
            <div id="portfolio" class="portfolio-big-image">
                @foreach($portfolios as $k => $portfolio)
                    <div class="hentry work group {{ ($k === config('settings.articles_paginate') - 1) ? 'last' : '' }}">
                        <div class="work-thumbnail">
                            <div class="nozoom">
                                <img src="{{ asset(config('settings.theme')) }}/images/{{ config('settings.portfolios_path') }}/{{ $portfolio->img->max }}"
                                     alt="{{ $portfolio->title }}" title="{{ $portfolio->title }}"/>
                                <div class="overlay">
                                    <a class="overlay_img"
                                       href="{{ asset(config('settings.theme')) }}/images/{{ config('settings.portfolios_path') }}/{{ $portfolio->img->path }}"
                                       rel="lightbox" title="{{ $portfolio->title }}"></a>
                                    <a class="overlay_project"
                                       href="{{ route('portfolios.show', $portfolio->alias) }}"></a>
                                    <span class="overlay_title">{{ $portfolio->title }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="work-description desc-width">
                            <h3>{{ $portfolio->title }}</h3>
                            <p>{{ $portfolio->text }}</p>
                            <div class="clear"></div>
                            <div class="work-skillsdate">
                                <p class="skills"><span class="label">Раздел: </span>{{ $portfolio->filter->title }}</p>
                                @if($portfolio->customer)
                                <p class="workdate"><span class="label">Заказчик: </span>{{ $portfolio->customer }}</p>
                                @endif
                                <p class="workdate"><span class="label">Дата: </span>{{ $portfolio->date }}</p>
                            </div>
                            <a class="read-more" href="{{ route('portfolios.show', $portfolio->alias) }}">Смотреть работу</a>
                        </div>
                        <div class="clear"></div>
                    </div>
                @endforeach
            </div>
            <div class="clear"></div>

            <!-- pagination -->
            @if($portfolios->hasPages())
                <div class="general-pagination group">

                    @if(!$portfolios->onFirstPage())
                        <a href="{{ $portfolios->previousPageUrl() }}">{!! trans('pagination.previous') !!}</a>
                    @endif

                    @for($i = 1; $i <= $portfolios->lastPage(); $i++)
                        @if($portfolios->currentPage() === $i)
                            <a class="selected disabled">{{ $i }}</a>
                        @else
                            <a href="{{ $portfolios->url($i) }}">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($portfolios->hasMorePages())
                        <a href="{{ $portfolios->nextPageUrl() }}">{!! trans('pagination.next') !!}</a>
                    @endif
                </div>
            @endif
        @endif
    </div>
</div>