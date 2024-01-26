@extends("layouts.app")

@section("main_content")
    <v-app light id="app">
        @if(isset($serverData))
            <vue-store :server="{{$serverData}}"></vue-store>
        @endif
        @yield("main_app_content")
    </v-app>
@endsection

@prepend('beforeScripts')
    <style>
        #app {
            background: url('');
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
@endprepend