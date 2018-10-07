@foreach($items as $item)
    <tr>
        <td style="text-align: left;">{!! Html::link(route('admin.menus.edit', ['menus' => $item->id]), $paddingLeft . $item->title) !!}</td>
        <td>{{ $item->url() }}</td>
        <td>
            {!! Form::open(['url' => route('admin.menus.destroy', ['menus' => $item->id]), 'class' => 'form-horizontal', 'method' => 'POST']) !!}
            {!! method_field('delete') !!}
            {!! Form::button('Удалить', ['class' => 'btn btn-french-5', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </td>
    </tr>

    @if($item->hasChildren())
        @include(config('settings.theme') . '.admin.customMenuItems', ['items' => $item->children(), 'paddingLeft' => $paddingLeft . '--- '])
    @endif
@endforeach