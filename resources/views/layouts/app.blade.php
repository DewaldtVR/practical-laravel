<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
    <link href="//cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet" />
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'vueMixins' => []
        ]); ?>;
    </script>
</head>
<body onload="on_Load()">
@stack('beforeScripts')
@yield("main_content")

<script src="{{ mix('js/app.js') }}"></script>
<script type="text/javascript">
    function on_Load() {
        document.getElementById("app").classList.add('init');
    }
</script>
@stack('afterScripts')

</body>

<style>

</style>
</html>
