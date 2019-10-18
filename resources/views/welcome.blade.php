<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Cake Co</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('sidebar.less') }}" rel="stylesheet">

        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            Logout {{ Auth::user()->name }}
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    @else
                        @if (Auth::guest())
                            @if (\App\User::count() > 0)
                                <a href="{{ url('/login') }}">Login</a>
                            @else
                                <a href="{{ url('/register') }}">Registre</a>
                            @endif
                        @endif
                    @endif
                </div>
            @endif

            <div class="content">

                {{--message--}}
                @if(Session::has('message'))
                    <div class="alert alert-info">
                        {{ Session::get('message') }}
                    </div>
                @endif

                <div class="title m-b-md">
                    Cake Co
                </div>

                <div class="links">

                    <a href="/commande">Commandes</a>
                    <a href="/recette">Recettes</a>
                    <a href="/ingredient">Stock</a>

                </div>
            </div>

        </div>
        {{--sidebar--}}
        <script>
            $(document).ready(function () {
                var trigger = $('.hamburger'),
                    overlay = $('.overlay'),
                    isClosed = false;

                trigger.click(function () {
                    hamburger_cross();
                });

                function hamburger_cross() {

                    if (isClosed == true) {
                        overlay.hide();
                        trigger.removeClass('is-open');
                        trigger.addClass('is-closed');
                        isClosed = false;
                    } else {
                        overlay.show();
                        trigger.removeClass('is-closed');
                        trigger.addClass('is-open');
                        isClosed = true;
                    }
                }

                $('[data-toggle="offcanvas"]').click(function () {
                    $('#wrapper').toggleClass('toggled');
                });
            });
        </script>
    </body>
</html>
