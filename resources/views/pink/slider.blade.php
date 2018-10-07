@if (count($slider) > 0)
    <div id="slider-cycle" class="slider cycle no-responsive slider_cycle group" style="height: 485px;">
        <ul class="slider">
            @set($i, 1)
            @foreach($slider as $slide)
                <li>
                    <div class="slide-holder" style="height: 483px; background: url('{{ asset(config('settings.theme')) }}/images/{{ $slide->img }}') no-repeat center center;">
                        <div class="slide-content-holder inner" style="height: 483px;">
                            <div class="slide-content-holder-content {{ $slide->position->class }}">
                                <div class="slide-title">
                                    {!! $slide->title !!}
                                </div>
                                <div class="slide-content" style="color:#fff">
                                    <p>{!! $slide->desc !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @set($i, $i+1)
            @endforeach
        </ul>

        <div id="yit-widget-area" class="group">
            <div class="yit-widget-content inner group">
                <div class="widget-first yit-widget widget col1_4 one-fourth col widget-icon-text group">
                    <a href="https://tproger.ru/tag/job-interview/">
                        <img class="icon-img" src="{{ asset(config('settings.theme')) }}/images/job-770-80x80.webp"
                             alt=""/>
                        <p>Все, что нужно знать программисту для собеседования</p>
                    </a>
                </div>
                <div class="yit-widget widget col1_4 one-fourth col widget-last-post group">
                    <a href="https://tproger.ru/tag/web/">
                        <img class="icon-img" src="{{ asset(config('settings.theme')) }}/images/web770-80x80.webp"
                             alt=""/>
                        <p>Все для веб-разработчиков: дизайн, верстка, программы</p>
                    </a>
                </div>
                <div class="widget-last yit-widget widget col1_4 one-fourth col yit_text_quote">
                    <blockquote class="text-quote-quote">
                        “Всегда пишите код так, будто сопровождать его будет склонный к насилию психопат, знающий, где вы живете.”
                    </blockquote>
                    <cite class="text-quote-author">Мартин Голдинг</cite>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {

            var yit_slider_cycle_fx = 'easing',
                yit_slider_cycle_speed = 800,
                yit_slider_cycle_timeout = 3000,
                yit_slider_cycle_directionNav = true,
                yit_slider_cycle_directionNavHide = true,
                yit_slider_cycle_autoplay = true;

            var yit_widget_area_position = function () {
                $('#yit-widget-area').css({top: 33 - $('#yit-widget-area').height()});
            };
            $(window).resize(yit_widget_area_position);
            yit_widget_area_position();

            if ($.browser.msie && parseInt($.browser.version.substr(0, 1), 10) <= '8') {
                $('#slider-cycle ul.slider').anythingSlider({
                    expand: true,
                    startStopped: false,
                    buildArrows: yit_slider_cycle_directionNav,
                    buildNavigation: false,
                    buildStartStop: false,
                    delay: yit_slider_cycle_timeout,
                    animationTime: yit_slider_cycle_speed,
                    easing: yit_slider_cycle_fx,
                    autoPlay: yit_slider_cycle_autoplay ? true : false,
                    pauseOnHover: true,
                    toggleArrows: false,
                    resizeContents: true
                });
            } else {
                $('#slider-cycle ul.slider').anythingSlider({
                    expand: true,
                    startStopped: false,
                    buildArrows: yit_slider_cycle_directionNav,
                    buildNavigation: false,
                    buildStartStop: false,
                    delay: yit_slider_cycle_timeout,
                    animationTime: yit_slider_cycle_speed,
                    easing: yit_slider_cycle_fx,
                    autoPlay: yit_slider_cycle_autoplay ? true : false,
                    pauseOnHover: true,
                    toggleArrows: yit_slider_cycle_directionNavHide ? true : false,
                    onSlideComplete: function (slider) {
                    },
                    resizeContents: true,
                    onSlideBegin: function (slider) {
                    },
                    onSlideComplete: function (slider) {
                    }
                });

            }
        });
    </script>

    <div class="mobile-slider">
        <div class="slider fixed-image inner">
            <img src="{{ asset(config('settings.theme')) }}/images/{{ Config::get('settings.slider_path') }}/cycle-fixed.jpg"
                 alt=""/>
        </div>
    </div>
@endif