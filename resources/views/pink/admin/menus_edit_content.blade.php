<div id="content-page" class="content group">
    <div class="hentry group">

        {!! Form::open(['url' => (isset($menu->id)) ? route('admin.menus.update', ['menus' => $menu->id]) : route('admin.menus.store'), 'class' => 'contact-form', 'files' => true]) !!}

        @if(isset($menu->id))
            {!! method_field('put') !!}
        @endif

        <ul>
            <li class="text-field">
                <label for="title">
                    <span class="label">Заголовок*:</span><br/>
                    <span class="sublabel">Название пункта меню</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::text('title', $menu->title ?? old('title'), ['id' => 'title']) !!}
                </div>
            </li>

            <li class="text-field">
                <label>
                    <span class="label">Родитель:</span><br/>
                    <span class="sublabel">Родительский пункт меню</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::select('parent_id', $menus, $menu->parent_id ?? null, ['id' => 'parent_id']) !!}
                </div>
            </li>
        </ul>

        <span class="label">Тип меню*:</span>

        <div id="accordion">
            <h3>{!! Form::radio('type', 'customLink', (isset($type) && $type == 'customLink') || !isset($type), ['class' => 'radioMenu', 'style' => 'opacity: 0.01; margin-left: -20px;']) !!}
                <span class="label">Пользовательская ссылка</span>
            </h3>
            <ul>
                <li class="text-field">
                    <label for="custom_link">
                        <span class="label">Путь для ссылки:</span><br/>
                        <span class="sublabel">Путь для создаваемой ссылки</span><br/>
                    </label>
                    <div class="input-prepend">
                        {!! Form::text('custom_link', (isset($menu->path) && $type === 'customLink') ? $menu->path : old('custom_link'), ['id' => 'custom_link']) !!}
                    </div>
                </li>
                <div style="clear: both;"></div>
            </ul>

            <h3>{!! Form::radio('type', 'blogLink', isset($type) && $type === 'blogLink', ['class' => 'radioMenu', 'style' => 'opacity: 0.01; margin-left: -20px;']) !!}
                <span class="label">Раздел Блог</span>
            </h3>
            <ul>
                <li class="text-field">
                    <label>
                        <span class="label">Ссылка на категорию блога:</span><br/>
                        <span class="sublabel">Ссылка на категорию блога</span><br/>
                    </label>
                    <div class="input-prepend">
                        @if($categories)
                            {!! Form::select('category_alias', $categories, (isset($option) && $option) ? $option : FALSE) !!}
                        @endif
                    </div>
                </li>

                <li class="text-field">
                    <label>
                        <span class="label">Ссылка на материал блога:</span><br/>
                        <span class="sublabel">Ссылка на материал блога</span><br/>
                    </label>
                    <div class="input-prepend">
                        {!! Form::select('article_alias', $articles, (isset($option) && $option) ? $option : FALSE, ['placeholder' => 'Не используется']) !!}
                    </div>
                </li>
                <div style="clear: both;"></div>
            </ul>


            <h3>{!! Form::radio('type', 'portfolioLink', isset($type) && $type == 'portfolioLink', ['class' => 'radioMenu', 'style' => 'opacity: 0.01; margin-left: -20px;']) !!}
                <span class="label">Раздел портфолио</span>
            </h3>
            <ul>
                <li class="text-field">
                    <label>
                        <span class="label">Портфолио:</span><br/>
                        <span class="sublabel">Портфолио</span><br/>
                    </label>
                    <div class="input-prepend">
                        {!! Form::select('filter_alias', $filters, (isset($option) && $option) ? $option : FALSE, ['placeholder' => 'Не используется']) !!}
                    </div>
                </li>

                <li class="text-field">
                    <label>
                        <span class="label">Ссылка на запись портфолио:</span><br/>
                        <span class="sublabel">Ссылка на запись портфолио</span><br/>
                    </label>
                    <div class="input-prepend">
                        {!! Form::select('portfolio_alias', $portfolios, (isset($option) && $option) ? $option : FALSE, ['placeholder' => 'Не используется']) !!}
                    </div>
                </li>
            </ul>
        </div>
        <br/>

        <ul>
            <li class="submit-button">
                {!! Form::button('Сохранить', ['class' => 'btn btn-the-salmon-dance-3', 'type' => 'submit']) !!}
            </li>
        </ul>

        {!! Form::close() !!}

    </div>
</div>

<script>
    jQuery(function ($) {
        $('#accordion').accordion({
            activate: function (event, ui) {
                ui.newPanel.prev().find('input[type="radio"]').attr('checked', 'checked');
            }
        });
        let active = 0;
        $('#accordion input[type=radio]').each(function(index, element) {
            if($(element).prop('checked')) {
                active = index;
            }
        });
        $('#accordion').accordion('option', 'active', active);
    });
</script>