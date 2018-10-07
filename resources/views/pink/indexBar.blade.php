@if($articles && !$articles->isEmpty())
    <div class="widget-first widget recent-posts">
        <h3>{{ trans('custom.from_blog') }}</h3>
        <div class="recent-post group">
            @foreach($articles as $article)
                <div class="hentry-post group">
                    <div class="thumb-img">
                        <img src="{{ asset(config('settings.theme')) }}/images/{{ Config::get('settings.articles_path') }}/{{ $article->img->mini }}"
                             alt="{{ $article->title }}" title="{{ $article->title }}"/>
                    </div>
                    <div class="text">
                        <a href="{{ route('articles.show', ['alias' => $article->alias]) }}"
                           title="{{ $article->title }}"
                           class="title">{{ $article->title }}</a>
                        <p class="post-date">{{ $article->formatCreatedAtDate('%B %d, %Y') }}</p>
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
