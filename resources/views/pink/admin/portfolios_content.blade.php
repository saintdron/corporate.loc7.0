@if($portfolios)
    <div id="content-page" class="content group">
        <div class="hentry group">
            <h3>Добавленные работы</h3>
            <div class="short-table white">
                <table style="width: 100%" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th>Заголовок</th>
                        <th>Текст</th>
                        <th>Изображение</th>
                        <th>Раздел</th>
                        <th>Заказчик</th>
                        <th>Дата</th>
                        <th>Псевдоним</th>
                        <th>Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($portfolios as $portfolio)
                        <tr>
                            <td class="align-left">{!! Html::link(route('admin.portfolios.edit', ['portfolios' => $portfolio->alias]), $portfolio->title) !!}</td>
                            <td class="align-left">{!! str_limit($portfolio->text, 200) !!}</td>
                            <td>
                                @if(isset($portfolio->img->mini))
                                    {!! Html::image(asset(config('settings.theme')) . '/images/' . config('settings.portfolios_path') . '/' . $portfolio->img->mini) !!}
                                @endif
                            </td>
                            <td>{{$portfolio->filter_alias}}</td>
                            <td>{{$portfolio->customer}}</td>
                            <td>{{$portfolio->date}}</td>
                            <td>{{$portfolio->alias}}</td>
                            <td>
                                {!! Form::open(['url' => route('admin.portfolios.destroy', ['portfolios' => $portfolio->alias]), 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                                {!! method_field('delete') !!}
                                {!! Form::button('Удалить', ['class' => 'btn btn-french-5', 'type' => 'submit', 'title' => 'Удалить работу']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {!! HTML::link(route('admin.portfolios.create'), 'Добавить работу', ['class' => 'btn btn-the-salmon-dance-3']) !!}
        </div>
    </div>
@endif