<div id="content-blog" class="content group">
    @if($articles)
        @foreach($articles as $article)
            <div class="hentry hentry-post blog-big group">
                <!-- post featured & title -->
                <div class="thumbnail">
                    <!-- post title -->
                    <h2 class="post-title"><a
                                href="{{ route('articles.show', ['alias' => $article->alias]) }}">{{ $article->title }}</a>
                    </h2>
                    <!-- post featured -->
                    <div class="image-wrap">
                        <img src="{{ asset(config('settings.theme')) }}/images/{{ Config::get('settings.articles_path') }}/{{ $article->img->max }}"
                             alt="{{ $article->title }}" title="{{ $article->title }}"/>
                    </div>
                    <p class="date">
                        <span class="month">{{ $article->formatCreatedAtDate('%b') }}</span>
                        <span class="day">{{ $article->formatCreatedAtDate('%d') }}</span>
                    </p>
                </div>
                <!-- post meta -->
                <div class="meta group">
                    <p class="author">
                        <span>Автор: {{ $article->user->name }}</span>
                    </p>
                    <p class="categories">
                    <span>Рубрика: <a
                                href="{{ route('articlesCat', $article->category->alias) }}"
                                title="Читайте все новости в {{ $article->category->title }}"
                                rel="category tag">{{ $article->category->title }}</a></span>
                    </p>
                    <p class="comments">
                    <span title="Комментарии к {{ str_limit($article->title, 50) }}">
                        <a href="{{ route('articles.show', ['alias' => $article->alias]) . '#comments' }}">
                            {{ count($article->comments) }}
                            {{ Lang::choice('custom.comments', count($article->comments)) }}</a>
                    </span>
                    </p>
                </div>
                <!-- post content -->
                <div class="the-content group">
                    {!! $article->desc !!}
                    <p>
                        <a href="{{ route('articles.show', ['alias' => $article->alias]) }}"
                           class="btn btn-beetle-bus-goes-jamba-juice-4 btn-more-link">→ {{ trans('custom.read_more') }}</a>
                    </p>
                </div>
                <div class="clear"></div>
            </div>
        @endforeach

        <!-- pagination -->
        @if($articles->hasPages())
            <div class="general-pagination group">

                @if(!$articles->onFirstPage())
                    <a href="{{ $articles->previousPageUrl() }}">{!! trans('pagination.previous') !!}</a>
                @endif

                @for($i = 1; $i <= $articles->lastPage(); $i++)
                    @if($articles->currentPage() === $i)
                        <a class="selected disabled">{{ $i }}</a>
                    @else
                        <a href="{{ $articles->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor

                @if($articles->hasMorePages())
                    <a href="{{ $articles->nextPageUrl() }}">{!! trans('pagination.next') !!}</a>
                @endif
            </div>
        @endif
    @else
        <h3>{!! Lang::get('custom.articles_no') !!}</h3>
    @endif
</div>