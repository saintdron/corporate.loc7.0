@extends(config('settings.theme') . '.layouts.admin')

@section('navigation')
    {!! $menu_view !!}
@endsection

@section('content')
    {!! $content_view !!}
@endsection

@section('footer')
    {!! $footer_view !!}
@endsection