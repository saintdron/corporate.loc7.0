@extends(config('settings.theme') . '.layouts.site')

@section('navigation')
    {!! $navigation_view !!}
@endsection

@section('content')
    <div id="content-index" class="content group">
        <img class="error-404-image group" src="{{ asset(config('settings.theme')) }}/images/features/404.png" title="{{ $title }}"
             alt="404"/>
        <div class="error-404-text group">
            <p>Мы сожалеем, но страница, которую вы ищете, не существует.<br/>
                Вы можете вернуться на <a href="{{ route('home') }}">домашнюю страницу</a>.
            </p>
        </div>
    </div>
@endsection

@section('footer')
    @include(config('settings.theme').'.footer')
@endsection

