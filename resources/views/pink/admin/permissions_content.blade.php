<div id="content-page" class="content group">
    <div class="hentry group">
        <h3 class="title_page">{{ trans('custom.title_page_permission') }}</h3>
        <form action="{{ route('admin.permissions.store') }}" method="post">
            {{ csrf_field() }}
            <div class="short-table white">
                <table style="width: 100%">
                    <thead>
                    <th>Привилегии</th>
                    @if(!$roles->isEmpty())
                        @foreach($roles as $role)
                            <th>{{ $role->name }}</th>
                        @endforeach
                    @endif
                    </thead>
                    <tbody>
                    @if(!$permissions->isEmpty())
                        @foreach($permissions as $perm)
                            <tr>
                                <td style="text-align: left">{{ trans('custom.' . $perm->name) }}</td>
                                @foreach($roles as $role)
                                    <td>
                                        <input type="checkbox" name="roles[{{ $role->id }}][]" value="{{ $perm->id }}"
                                                {{ ($role->hasPermission($perm->name)) ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <input class="btn btn-the-salmon-dance-3" type="submit" value="Обновить">
        </form>
    </div>
</div>