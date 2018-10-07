@extends(config('settings.theme') . '.layouts.site')

@section('navigation')
    {!! $navigation_view !!}
@endsection

@section('content')
    {!! $content_view !!}
@endsection

@section('sidebar')
    {!! $rightBar_view !!}
@endsection

@section('footer')
    {!! $footer_view !!}
@endsection