@extends('layouts.authenticated')

@section('pagetitle','Manage Web Content')

@section('content')

    <grid url="{{route('content.data')}}" title="Content" mode="edit"></grid>

@endsection


@prepend('beforeScripts')
    <script type="text/javascript">
        Laravel.vueMixins.push({
            data() {
                return {}
            },
            mounted() {},
            watch: {},
            computed: {},
            methods: {}
        });
    </script>
@endprepend
