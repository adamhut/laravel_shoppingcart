<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <title>
        @yield('title')
    </title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
    .list-group-item >  .label{
        margin-right: 1em;
    }
    .flex{
        flex:1;
    }
    </style>
    <!-- Scripts -->
    <script>
        window.Laracasts = {!! json_encode([
            'csrfToken' => csrf_token(),
            'stripeKey' => config('services.stripe.key'),
            'user' => auth()->user(),
        ]) !!};
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <style>
        body {
            padding-bottom: 100px;
        }
        .level{
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div id="app">
        @include('partials.header')
        <div class="container">
            @yield('content')
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    
</body>
</html>
