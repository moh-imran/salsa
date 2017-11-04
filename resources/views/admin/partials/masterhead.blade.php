<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('favicon.ico?') }}">

    <title>SALSA</title>

    <!-- Elixir Stylesheet Minification File -->
    <link href="{{ asset('css/admin/admin.css') }}" rel="stylesheet" type="text/css" />

    <!-- Elixir Stylesheet Minification File -->

    <!-- Elixir Javascript Minification File -->

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <script type="text/javascript" src="{{ asset('js/admin/admin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vue.js') }}"></script>

    <!-- Elixir Javascript Minification File -->

</head>