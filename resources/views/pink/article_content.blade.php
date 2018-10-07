<div id="content-single" class="content group">
    @if($article)
        <div class="hentry hentry-post blog-big group ">
            <!-- post featured & title -->
            <div class="thumbnail">
                <!-- post title -->
                <h1 class="post-title"><a>{{ $article->title }}</a></h1>
                <!-- post featured -->
                <div class="image-wrap">
                    <img src="{{ asset(config('settings.theme')) }}/images/{{ config('settings.articles_path') }}/{{ $article->img->max }}"
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
                    <span><a href="#comments"
                             title="Комментарии к {{ str_limit($article->title, 50) }}">{{ count($article->comments) }}
                            {{ Lang::choice('custom.comments', count($article->comments)) }}</a></span>
                </p>
            </div>
            <!-- post content -->
            <div class="the-content single group">
                <p>{!! $article->text !!}</p>
                @if($article->keywords)
                    <p class="tags">Теги:
                        @foreach($article->strExplode($article->keywords) as $i => $keyword){{ ($i !== 0) ? ', ' : '' }}<span style="font-weight: bold;" rel="tag">{{ $keyword }}</span>@endforeach
                    </p>
                @endif
                <div class="socials">
                    <h2>Поделитесь этим с друзьями:</h2>
                    <a href="#"
                       class="socials-small facebook-small" title="Facebook">facebook</a>
                    <a href="#"
                       class="socials-small twitter-small" title="Twitter">twitter</a>
                    <a href="#"
                       class="socials-small google-small" title="Google">google</a>
                    <a href="#"
                       class="socials-small pinterest-small" title="Pinterest">pinterest</a>
                    <a href="#"
                       class="socials-small bookmark-small" title="This is the title of the first article. Enjoy it.">bookmark</a>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <!-- START COMMENTS -->
        <div id="comments">
            <h3 id="comments-title">
                <span>{{ count($article->comments) }}</span> {{ Lang::choice('custom.comments', count($article->comments)) }}
            </h3>
            @if($article->comments)
                @set($com, $article->comments->groupBy('parent_id'))
                <ol class="commentlist group">
                    @foreach($com as $k => $comments)
                        @if($k !== 0)
                            @break
                        @endif
                        @include(config('settings.theme') . '.comment', ['items' => $comments])
                    @endforeach
                </ol>
            @endif

            <div id="respond">
                <h3 id="reply-title">Оставьте свой комментарий
                    <small><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display:none;"><span class="icon-remove-sign">&nbsp;Отменить</span></a></small>
                </h3>
                <form action="{{ route('comments.store') }}" method="post" id="commentform">
                    {{ csrf_field() }}
                    @if(!Auth::check())
                        <p class="comment-form-author">
                            <label for="name">Имя</label>
                            <input id="name" name="name" type="text" value="" size="30" aria-required="true"/>
                        </p>
                        <p class="comment-form-email">
                            <label for="email">E-mail</label>
                            <input id="email" name="email" type="text" value="" size="30" aria-required="true"/>
                        </p>
                        <p class="comment-form-url">
                            <label for="site">Сайт</label>
                            <input id="site" name="site" type="text" value="" size="30"/>
                        </p>
                    @endif

                    <p class="comment-form-comment">
                        <label for="text">Ваш&nbsp;комментарий</label>
                        <textarea id="text" name="text" cols="45" rows="8"></textarea>
                    </p>
                    <div class="clear"></div>
                    <p class="form-submit">
                        <input type="hidden" id="comment_post_ID" name="comment_post_ID" value="{{ $article->id }}">
                        <input type="hidden" id="comment_parent" name="comment_parent" value="0">
                        <input name="submit" type="submit" id="submit" value="Отправить"/>
                    </p>
                </form>
            </div>
            <!-- #respond -->
        </div>
        <!-- END COMMENTS -->
    @else
        <h3>{!! Lang::get('custom.article_no') !!}</h3>
    @endif
</div>