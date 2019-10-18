<!DOCTYPE html>

<html lang="{{ config('app.locale') }}">

<head>

        @include('partials.header')

</head>

<body>

    <div id="app">

        @include('partials.nav')

        @yield('content')

        @include('partials.sidebar')

    </div>

        @include('partials.footer')

</body>

</html>