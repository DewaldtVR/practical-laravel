@extends('layouts.authenticated')

@section('pagetitle',"System settings")

@section('content')
    <grid url="{{route('settings.list')}}" title="Setting list"
          mode="{{\Auth::user()->hasRight("setting_management")?"edit":null}}"></grid>
@endsection


@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {}
            }
        });
    </script>
@endprepend
