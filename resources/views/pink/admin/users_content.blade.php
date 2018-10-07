<div id="content-page" class="content group">
    <div class="hentry group">
        <h3 class="title_page">Пользователи</h3>
        <div class="short-table white">
            <table style="width: 100%" cellspacing="0" cellpadding="0">
                <thead>
                <th>Логин</th>
                <th>Имя</th>
                <th>E-mail</th>
                <th>Роль</th>
                <th>Действие</th>
                </thead>
                <tbody>
                @if($users)
                    @foreach($users as $user)
                        <tr>
                            {{--<td>{!! Html::link(route('admin.users.edit', ['users' => $user->id]), $user->login) !!}</td>--}}
                            @if((\Auth::user()->id === $user->id || \Auth::user()->roles->sortBy('id')->values()->first()->id <= $user->roles->sortBy('id')->values()->first()->id) && $user->login !== 'Guest')
                                <td>{!! Html::link(route('admin.users.edit', ['users' => $user->id]), $user->login) !!}</td>
                            @else
                                <td>{{ $user->login }}</td>
                            @endif
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles->implode('name', ', ') }}</td>
                            <td>
                                {!! Form::open(['url' => route('admin.users.destroy', ['users' => $user->id]), 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                                {!! method_field('delete') !!}
                                {!! Form::button('Удалить', ['class' => 'btn btn-french-5', 'type' => 'submit']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        {!! Html::link(route('admin.users.create'), 'Добавить  пользователя', ['class' => 'btn btn-the-salmon-dance-3']) !!}
    </div>
</div>