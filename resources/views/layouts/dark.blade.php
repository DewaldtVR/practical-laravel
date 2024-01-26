@extends("layouts.app")

@section("main_content")
<v-app dark id="app">
    @if(isset($serverData))
        <vue-store :server="{{$serverData}}"></vue-store>
    @endif
    @yield("main_app_content")
</v-app>
@endsection