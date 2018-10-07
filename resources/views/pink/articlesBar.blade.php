@if($portfolios && !$portfolios->isEmpty())
    <div class="widget-first widget recent-posts">
        <h3>{{ trans('custom.recent_posts') }}</h3>
        <div class="recent-post group">
            @foreach($portfolios as $portfolio)
                <div class="hentry-post group">
                    <div class="thumb-img">
                        <img style="width: 55px"
                             src="{{ asset(config('settings.theme')) }}/images/{{ config('settings.portfolios_path') }}/{{ $portfolio->img->mini }}"
                             alt="{{ $portfolio->title }}" title="{{ $portfolio->title }}"/></div>
                    <div class="text">
                        <a href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}"
                           title="{{ $portfolio->title }}" class="title">{{ $portfolio->title }}</a>
                        <p>{{ str_limit($portfolio->text, config('settings.portfolio_bar_preview_length')) }}</p>
                        <a class="read-more" href="{{ route('portfolios.show', ['alias' => $portfolio->alias]) }}">&rarr; {{ trans('custom.read_more') }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@if($comments && !$comments->isEmpty())
    <div class="widget-last widget recent-comments">
        <h3>{{ trans('custom.recent_comments') }}</h3>
        <div class="recent-post recent-comments group">
            @foreach($comments as $comment)
                <div class="the-post group">
                    <div class="avatar">
                        @set($hash, ($comment->email) ? md5($comment->email) : (($comment->user) ? md5($comment->user->email) : ''))
                        <img alt="{{ $comment->name }}" src="https://www.gravatar.com/avatar/{{ $hash }}?d=mp&s=55"/>
                    </div>
                    <span class="author"><strong><a href="{{ route('articles.show', ['alias' => $comment->article->alias]) . '#comments' }}">{{ ($comment->name) ? $comment->name : (($comment->user && $comment->user->name) ? $comment->user->name : 'Аноним') }}</a></strong> в</span>
                    <a class="title" href="{{ route('articles.show', ['alias' => $comment->article->alias]) }}">{{ $comment->article->title }}</a>
                    <p class="comment">
                        {{ str_limit($comment->text, config('settings.comment_bar_preview_length')) }}
                        <a class="goto" href="{{ route('articles.show', ['alias' => $comment->article->alias]) }}">&#187;</a>
                    </p>
                </div>
            @endforeach
        </div>
    </div>
@endif