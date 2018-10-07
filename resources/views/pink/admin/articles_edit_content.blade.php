<div id="content-page" class="content group">
    <div class="hentry group">

        {!! Form::open(['url' => (isset($article->id)) ? route('admin.articles.update', ['articles' => $article->alias]) : route('admin.articles.store'), 'class' => 'contact-form', 'files' => true]) !!}

        @if(isset($article->id))
            {!! method_field('put') !!}
        @endif

        <ul>
            <li class="text-field">
                <label for="title">
                    <span class="label">Название*:</span><br/>
                    <span class="sublabel">Заголовок материала</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::text('title', isset($article->title) ? $article->title : old('title'), ['id' => 'title']) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="alias">
                    <span class="label">Псевдоним:</span><br/>
                    <span class="sublabel">Псевдоним материала</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::text('alias', isset($article->alias) ? $article->alias : old('alias'), ['id' => 'alias']) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="meta_desc">
                    <span class="label">Мета описание:</span><br/>
                    <span class="sublabel">Описание материала в результатах поиска</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::text('meta_desc', isset($article->meta_desc) ? $article->meta_desc : old('meta_desc'), ['id' => 'meta_desc']) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="keywords">
                    <span class="label">Ключевые слова:</span><br/>
                    <span class="sublabel">Ключевые слова материала</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::text('keywords', isset($article->keywords) ? $article->keywords : old('keywords'), ['id' => 'keywords']) !!}
                </div>
            </li>

            <li class="textarea-field">
                <label for="editor">
                    <span class="label">Краткий текст материала:</span>
                </label>
                <div class="input-prepend">
                    {!! Form::textarea('desc', isset($article->desc) ? $article->desc : old('desc'), ['id' => 'editor', 'class' => 'form-control']) !!}
                </div>
                <div class="msg-error"></div>
            </li>

            <li class="textarea-field">
                <label for="editor2">
                    <span class="label">Полный текст материала*:</span>
                </label>
                <div class="input-prepend">
                    {!! Form::textarea('text', isset($article->text) ? $article->text : old('text'), ['id' => 'editor2', 'class' => 'form-control']) !!}
                </div>
                <div class="msg-error"></div>
            </li>

            @if(isset($article->img->path))
                <li class="textarea-field">
                    <label>
                        <span class="label">Текущее изображение:&nbsp;</span>
                    </label>
                    {{ Html::image(asset(config('settings.theme')).'/images/' . config('settings.articles_path') . '/'.$article->img->path, '', ['style' => 'width: 400px']) }}
                    {!! Form::hidden('old_image', $article->img->path) !!}
                </li>
            @endif

            <li class="text-field">
                <label>
                    <span class="label">Изображение{{ (isset($article->id)) ? '' : '*'}}:</span><br/>
                    <span class="sublabel">Изображение материала</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::file('image', ['class' => 'filestyle', 'data-text' => 'Выберите изображение', 'data-btnClass' => "btn-primary", 'data-placeholder' => "Файла нет"]) !!}
                </div>
            </li>

            <li class="text-field">
                <label>
                    <span class="label">Категория:</span><br/>
                    <span class="sublabel">Категория материала</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::select('category_id', $categories, isset($article->category_id) ? $article->category_id  : '') !!}
                </div>
            </li>

            <li class="submit-button">
                {!! Form::button('Сохранить', ['class' => 'btn btn-the-salmon-dance-3', 'type'=>'submit']) !!}
            </li>
        </ul>

        {!! Form::close() !!}

        <script>
            CKEDITOR.replace('editor');
            CKEDITOR.replace('editor2');
        </script>
    </div>
</div>