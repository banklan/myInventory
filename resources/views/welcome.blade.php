<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Arimo|Eagle+Lake|Lato|Merienda+One|Open+Sans&display=swap" rel="stylesheet">
        <style>
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
            .top-left{
                position: absolute;
                left: 45px;
                top: 15px;
            }
            .top-left a{
                color: #ffff13;
                font-family: 'Sacramento', cursive;
                font-weight: 100;
                text-decoration: none;
                font-size: 28px;
            }
            .top-right {
                position: absolute;
                right: 10px;
                top: 25px;
            }
            .content {
                text-align: center;
                background-image: linear-gradient(to right bottom, rgba(15, 35, 42, .2), rgba(255, 53, 53, 0.3));
                padding: 15px;
                border-radius: 6px;
            }
            .content h3{
                color: var(--pry-col-yellow);
                font-size: 48px;
                font-weight: 100;
                font-family: 'Eagle Lake', sans-serif;
            }

            .links > a {
                color: #ffff13;
                padding: 0 25px;
                font-size: 14px;
                font-weight: 400;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                font-family: 'Lato', sans-serif;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height welcome_wrap">
            @if (Route::has('login'))
                <div class="top-left">
                    <a href="{{ url('/') }}">myInventory</h3>
                </div>
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('supervisor.login') }}">Supervisor</a>
                        <a href="{{ route('login') }}">Front Sales</a>
                        <!-- <a href="{{ route('register') }}">Register</a> -->
                    @endauth
                </div>
            @endif

            <div class="content">
                <h3>Inventory/POS manager</h3>
            </div>
        </div>
    </body>
</html>
