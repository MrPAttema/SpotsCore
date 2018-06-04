<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/spectre.css') }}"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="{{ asset('/img/favicon.png') }}" type="image/x-icon"/>
    
    <!-- Scripts -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('/js/all.js') }}"></script>
    <script>
      $(document).ready(function(){
        $('.panel-heading-adminreserveringen').click(function(){
          $(this).next('.panel-body-adminreserveringen').slideToggle(200);
        });
      });
    </script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-45979619-5"></script>
    <script>
        window.dataLayer = window.dataLayer || [];        
        function gtag(){dataLayer.push(arguments);}        
        gtag('js', new Date());
        gtag('config', 'UA-45979619-8');
    </script>
</head>
<body>
    <div id="app">
        <header class="navbar">

            <section class="navbar-section">
                @if (Auth::guest())
                    <!--  -->
                @else
                    <a class="btn btn-link" href="{{ url('/balie') }}"><i class="fa fa-suitcase" aria-hidden="true"></i> Alle reserveringen</a>
                    <!-- <a class="btn btn-link" href="{{ url('/admin/accounts') }}"><i class="fa fa-users" aria-hidden="true"></i> Overzicht gebruikers</a> -->
                @endif
            </section>

            <section class="navbar-center">
                <a class="btn btn-link" href="/home"><h5 class="navbar-brand">{{ config('app.name', 'Laravel') }}</h5></a>
            </section>

            <section class="navbar-section">
                <li class="cookieConsent">
                    <a href="#"><img src="{{URL::asset('img/cookie.svg')}}" class="cookie-icon"></a>
                    <div class="cookieConsent-popOut">
                        <header>
                            <h2>Have a cookie</h2>
                        </header>
                        <main>
                            <p>
                                Mijn Belboei gebruikt cookies om inhoud en de gebruikerservaring te personaliseren.
                                Ook gebruiken we cookies voor het gebruik van analytics.
                            </p>
                        </main>
                        <footer>
                            <a class="button btn-primary" onclick="cookiesAccepted();" data-event-category="Top" data-event-action="Cookies" data-event-label="OK" data-event-non-interaction="true">Prima!</a>
                            <span>
                                of <a href="/terms/" data-event-category="Top" data-event-action="Cookies" data-event-label="More information" data-event-non-interaction="true">meer info</a>
                            </span>
                        </footer>
                    </div>
                </li>
                <!-- <a class="btn btn-link" href="{{ url('/admin/archive') }}"><i class="fa fa-archive" aria-hidden="true"></i> Reservering Archief</a> -->
                <a class="btn btn-link" href="{{ url('/help') }}"><i class="fa fa-question" aria-hidden="true"></i> Help</a>
                <div class="dropdown dropdown-right">
                    @if (Auth::guest())
                    <!--  -->
                @else
                    <a class="btn btn-link dropdown-toggle" tabindex="0" href="#" class="dropdown-toggle" >Balie <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                @endif 
                    <ul class="menu">
                        <li class="menu-item">
                            <a href="{{ url('/logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i>
                                Uitloggen
                            </a>
                            <form id="logout-form" action="{{ url('/balie/logout') }}" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>

            </section>
        </header>

        <div class="container columns notifications">
            @if (Session::has('message'))
                <div class="column toast toast-success col-5 centered">
                    <button class="btn btn-clear toast-clear float-right"></button>
                    <h4>Gelukt!</h4>
                    {{ Session::get('message') }}
                </div>
            @endif

            @if (Session::has('info'))
                <div class="column toast toast-warning col-5 centered">
                    <button class="btn btn-clear toast-clear float-right"></button>
                    <h4>Informatie</h4>
                    {{ Session::get('info') }}
                </div>
            @endif

            @if (Session::has('error'))
                <div class="column toast toast-error col-5 centered">
                    <button class="btn btn-clear toast-clear float-right"></button>
                    <h4>Fout!</h4>
                    {{ Session::get('error') }}
                </div>
            @endif
        </div>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
