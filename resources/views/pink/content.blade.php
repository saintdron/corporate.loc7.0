@if($portfolios && count($portfolios) > 0)
    <div id="content-home" class="content group">
        <div class="hentry group">
            <div class="section portfolio">

                <h3 class="title">{{ trans('custom.latest_projects') }}</h3>

                @foreach($portfolios as $k=>$portfolio)
                    @if ($k === 0)
                        <div class="hentry work group portfolio-sticky portfolio-full-description">
                            <div class="work-thumbnail">
                                <a class="thumb">
                                    <img src="{{ asset(config('settings.theme')) }}/images/{{ Config::get('settings.portfolios_path') }}/{{ $portfolio->img->max }}"
                                         alt="{{ $portfolio->title }}"
                                         title="{{ $portfolio->title }}"/>
                                </a>
                                <div class="work-overlay">
                                    <h3>
                                        <a href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}">{{ $portfolio->date }}</a>
                                    </h3>
                                    <p class="work-overlay-categories">
                                        <img src="{{ asset(config('settings.theme')) }}/images/categories.png"
                                             alt="Categories"/> Заказчик: <a href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}">{{ $portfolio->customer }}</a>
                                    </p>
                                </div>
                            </div>
                            <div class="work-description">
                                <h2>
                                    <a href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}">{{ $portfolio->title }}</a>
                                </h2>
                                <p class="work-categories">Раздел: <span>{{ $portfolio->filter->title }}</span></p>
                                <p>{{ str_limit($portfolio->text, config('settings.portfolio_index_preview_length')) }}</p>
                                <a href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}" class="read-more"><span class="icon-play"></span> Подробнее</a>
                            </div>
                        </div>

                        <div class="clear"></div>
                        @continue
                    @endif

                    @if ($k === 1)
                    <div class="portfolio-projects">
                    @endif
                        <div class="related_project {{ ($k === Config::get('settings.home_portfolios_count') - 1) ? 'related_project_last' : '' }}">
                            <div class="overlay_a related_img">
                                <div class="overlay_wrapper">
                                    <img src="{{ asset(config('settings.theme')) }}/images/{{ Config::get('settings.portfolios_path') }}/{{ $portfolio->img->mini }}" alt="{{ $portfolio->alias }}"
                                         title="{{ $portfolio->alias }}"/>
                                    <div class="overlay">
                                        <a class="overlay_img"
                                           href="{{ asset(config('settings.theme')) }}/images/{{ Config::get('settings.portfolios_path') }}/{{ $portfolio->img->path }}" rel="lightbox"
                                           title=""></a>
                                        <a class="overlay_project" href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}"></a>
                                        <span class="overlay_title">{{ $portfolio->title }}</span>
                                    </div>
                                </div>
                            </div>
                            <h4>
                                <a href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}">{{ $portfolio->title }}</a>
                            </h4>
                            <p>{{ str_limit($portfolio->text, config('settings.portfolio_index_preview_length')) }}</p>
                        </div>

                @endforeach
                    </div>
            </div>
            <div class="clear"></div>
        </div>

        <!-- START COMMENTS -->
        <div id="comments">
        </div>
        <!-- END COMMENTS -->
    </div>

@else
    <p>Нет портфолио</p>
@endif