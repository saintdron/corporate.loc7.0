<div id="content-page" class="content group">
    <div class="hentry group">

        {!! Form::open(['url' => (isset($portfolio->id)) ? route('admin.portfolios.update', ['portfolios' => $portfolio->alias]) : route('admin.portfolios.store'), 'class' => 'contact-form', 'files' => true]) !!}

        @if(isset($portfolio->id))
            {!! method_field('put') !!}
        @endif

        <ul>
            <li class="text-field">
                <label for="title">
                    <span class="label">Название*:</span><br/>
                    <span class="sublabel">Заголовок работы</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::text('title', $portfolio->title ?? old('title'), ['id' => 'title']) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="alias">
                    <span class="label">Псевдоним:</span><br/>
                    <span class="sublabel">Псевдоним работы</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::text('alias', $portfolio->alias ?? old('alias'), ['id' => 'alias']) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="meta_desc">
                    <span class="label">Мета описание:</span><br/>
                    <span class="sublabel">Описание работы в результатах поиска</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::text('meta_desc', $portfolio->meta_desc ?? old('meta_desc'), ['id' => 'meta_desc']) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="keywords">
                    <span class="label">Ключевые слова:</span><br/>
                    <span class="sublabel">Ключевые слова, характеризующие работу</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::text('keywords', $portfolio->keywords ?? old('keywords'), ['id' => 'keywords']) !!}
                </div>
            </li>

            <li class="textarea-field">
                <label for="text">
                    <span class="label">Описание*:</span>
                </label>
                <div class="input-prepend">
                    {!! Form::textarea('text', $portfolio->text ?? old('text'), ['id' => 'text', 'class' => 'form-control']) !!}
                </div>
            </li>

            @if(isset($portfolio->img->path))
                <li class="textarea-field">
                    <label>
                        <span class="label">Текущее изображение:&nbsp;</span>
                    </label>
                    {{ Html::image(asset(config('settings.theme')).'/images/' . config('settings.portfolios_path') . '/'.$portfolio->img->path, '', ['style' => 'width: 400px']) }}
                    {!! Form::hidden('old_image', $portfolio->img->path) !!}
                </li>
            @endif

            <li class="text-field">
                <label>
                    <span class="label">Изображение{{ (isset($portfolio->id)) ? '' : '*'}}:</span><br/>
                    <span class="sublabel">{{ (isset($portfolio->id)) ? 'Новое изображение работы' : 'Изображение работы'}}</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::file('image', ['class' => 'filestyle', 'data-text' => 'Выберите изображение', 'data-btnClass' => "btn-primary", 'data-placeholder' => "Файла нет"]) !!}
                </div>
            </li>

            <li class="text-field">
                <label>
                    <span class="label">Раздел:</span><br/>
                    <span class="sublabel">Соответствующий для работы раздел</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::select('filter_alias', $filters, $portfolio->filter_alias ?? '') !!}
                </div>
            </li>
            <div class="clear"></div>

            <li class="text-field">
                <label for="customer">
                    <span class="label">Заказчик:</span><br/>
                    <span class="sublabel">Заказчик работы</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::text('customer', $portfolio->customer ?? old('customer'), ['id' => 'customer']) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="date">
                    <span class="label">Дата*:</span><br/>
                    <span class="sublabel">Дата выполнения работы</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::text('date', $portfolio->date ?? (old('date') ?? 'Январь 2018'), ['id' => 'date', 'class' => 'monthPicker', 'autocomplete' => 'off']) !!}
                </div>
            </li>

            <li class="submit-button">
                {!! Form::button('Сохранить', ['class' => 'btn btn-the-salmon-dance-3', 'type'=>'submit']) !!}
            </li>
        </ul>

        {!! Form::close() !!}
    </div>
</div>