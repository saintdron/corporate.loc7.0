<div id="content-page" class="content group">
    <div class="hentry group">

        {!! Form::open(['url' => (isset($user->id)) ? route('admin.users.update', ['user' => $user->id]) : route('admin.users.store'), 'class' => 'contact-form', 'method' => 'POST']) !!}

        @if(isset($user->id))
            {!! method_field('put') !!}
        @endif

        <ul>
            <li class="text-field">
                <label for="login">
                    <span class="label">Логин*:</span><br/>
                    <span class="sublabel">Логин пользователя</span><br/>
                </label>
                <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                    {!! Form::text('login', $user->login ?? old('login'), ['id' => 'login']) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="name">
                    <span class="label">Имя*:</span><br/>
                    <span class="sublabel">Имя пользователя</span><br/>
                </label>
                <div class="input-prepend"><span class="add-on"><i class="icon-group"></i></span>
                    {!! Form::text('name', $user->name ?? old('name'), ['id' => 'name']) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="password">
                    <span class="label">Пароль*:</span><br/>
                    <span class="sublabel">Пароль пользователя</span><br/>
                </label>
                <div class="input-prepend"><span class="add-on"><i class="icon-lock"></i></span>
                    {!! Form::password('password') !!}
                </div>
            </li>

            <li class="text-field">
                <label for="password_confirmation">
                    <span class="label">Повтор пароля*:</span><br/>
                    <span class="sublabel">Повтор создаваемого пароля</span><br/>
                </label>
                <div class="input-prepend"><span class="add-on"><i class="icon-lock"></i></span>
                    {!! Form::password('password_confirmation') !!}
                </div>
            </li>

            <li class="text-field">
                <label for="email">
                    <span class="label">E-mail*:</span><br/>
                    <span class="sublabel">Электронная почта</span><br/>
                </label>
                <div class="input-prepend"><span class="add-on"><i class="icon-envelope"></i></span>
                    {!! Form::text('email', $user->email ?? old('email'), ['id' => 'email']) !!}
                </div>
            </li>

            <li class="text-field">
                <label>
                    <span class="label">Роль:</span><br/>
                    <span class="sublabel">Роль пользователя</span><br/>
                </label>
                <div class="input-prepend">
                    {!! Form::select('role_id', $roles, (isset($user)) ? $user->roles()->first()->id : 3) !!}
                </div>
            </li>

            <li class="submit-button">
                {!! Form::button('Сохранить', ['class' => 'btn btn-the-salmon-dance-3', 'type' => 'submit']) !!}
            </li>
        </ul>

        {!! Form::close() !!}

    </div>
</div>