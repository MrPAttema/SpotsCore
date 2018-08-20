<!DOCTYPE html>
<html lang="nl" class=" no-cookies">
<!--[if lt IE 11]>
  <div id='error' style="background-color: red; color:white; text-align:center; height:50px; line-height:50px;">
      Deze website werkt niet goed op Internet Explorer 9 of lager. Gebruik een andere browser AUB.<br />
  </div>
<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//ajax.googleapis.com">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="{{ asset('/css/jquery-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/jquery-ui.theme.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/spectre.css') }}"/>
    <link rel="icon" href="{{ asset('/img/favicon.png') }}" type="image/x-icon"/>
    {{-- <link rel="stylesheet" href="{{ asset('/css/font-awesome.css') }}"/>  --}}
    {{-- <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre.min.css"> --}}

    <script type="text/javascript" src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    
    <script type="text/javascript" src="{{ asset('/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/sliders.js') }}"></script>
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
    <header class="navbar">

        <a style="font-size:15px;" class="mobileIcon"><i class="fas fa-bars"></i></a>
        <section class="mobile-menu ">
            @if (Auth::guest())
                {{-- --}}
            @else
                <a class="btn btn-link-mobile" href="{{ url('/home') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                <a class="btn btn-link-mobile" href="{{ url('/reservations/myreservations') }}"><i class="fa fa-suitcase" aria-hidden="true"></i> Open reserveringen</a>
                <a class="btn btn-link-mobile" href="{{ url('/archive') }}"><i class="fa fa-archive" aria-hidden="true"></i></i> Mijn archief</a>
                <a class="btn btn-link-mobile" href="{{ url('/help') }}"><i class="fa fa-question" aria-hidden="true"></i> Help</a>
                <div class="dropdown dropdown-right btn-link-mobile">
                @if (Auth::guest())
                    {{--  --}}
                @else                       
                    <a class="btn btn-link-mobile dropdown-toggle badge" data-badge="{{$messageCount}}" tabindex="0" href="#" class="dropdown-toggle" >{{ Crypt::decrypt(Auth::user()->firstname) }} {{ Crypt::decrypt(Auth::user()->lastname) }} <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                @endif
                    
                    <ul class="menu">
                        <li class="divider" data-content="Profiel"></li>
                        <li class="menu-item">
                            <a href="{{ url('/users/profile') }}"><i class="fa fa-user" aria-hidden="true"></i>
                                Mijn profiel
                            </a>
                            @if ($messageCount === 0)
                                <a href="{{ url('/users/inbox') }}"><i class="fa fa-envelope-square" aria-hidden="true"></i>
                                    Mijn Berichten
                                </a>
                            @else
                                <a class="badge" href="{{ url('/users/inbox') }}"><i class="fa fa-envelope-square" aria-hidden="true"></i>
                                    Mijn Berichten
                                </a>
                            @endif
                            <a href="{{ url('/users/privacy') }}"><i class="fa fa-lock" aria-hidden="true"></i>
                                Veiligheid
                            </a>
                            <a href="{{ url('/users/settings') }}"><i class="fa fa-wrench" aria-hidden="true"></i>
                                Instellingen
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li class="menu-item">
                            <a href="{{ url('/logout') }}"
                                onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="fa fa-sign-out-alt" aria-hidden="true"></i>
                                Uitloggen
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            @endif
        </section>

        <section class="navbar-section desktop-menu">
            @if (Auth::guest())
                {{-- --}}
            @else
                <a class="btn btn-link" href="{{ url('/home') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                <a class="btn btn-link" href="{{ url('/reservations/myreservations') }}"><i class="fa fa-suitcase" aria-hidden="true"></i> Open reserveringen</a>
                <a class="btn btn-link" href="{{ url('/archive') }}"><i class="fa fa-archive" aria-hidden="true"></i></i> Mijn archief</a>
            @endif
        </section>

        <section class="navbar-center desktop-menu">
            <a class="btn btn-link brand" href="/home"><h5 class="navbar-brand">{{ config('app.name', 'Laravel') }}</h5></a>
        </section>

        <section class="navbar-section desktop-menu">
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

            <div class="dropdown dropdown-right">
                @if (Auth::guest())
                    {{--  --}}
                @else 
                <a class="btn btn-link dropdown-toggle" tabindex="0" href="#" class="dropdown-toggle">Algemene Informatie <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                <ul class="menu">
                    <li class="divider" data-content="Informatie"></li>
                    <li class="menu-item">
                        <a href="{{ url('/hoehetwerkt') }}"><i class="fa fa-info" aria-hidden="true"></i>
                            Hoe het werkt
                        </a>
                        <a href="{{ url('/over-ons') }}"><i class="fa fa-book" aria-hidden="true"></i>
                            De vereniging
                        </a>
                    </li>
                    <li class="divider" data-content="FAQ"></li>
                    <li class="menu-item">
                        <a href="{{ url('/help') }}"><i class="fa fa-question" aria-hidden="true"></i> 
                            Help
                        </a>
                    </li>
                </ul>
                @endif
            </div>
            <div class="dropdown dropdown-right">
                @if (Auth::guest())
                    {{--  --}}
                @else
                    <a class="btn btn-link dropdown-toggle badge" data-badge="{{$messageCount}}" tabindex="0" href="#" class="dropdown-toggle" >{{  Crypt::decrypt(Auth::user()->firstname) }} {{ Crypt::decrypt(Auth::user()->lastname) }} <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                @endif     
                <ul class="menu">
                    <li class="divider" data-content="Profiel"></li>
                    <li class="menu-item">
                        <a href="{{ url('/users/profile') }}"><i class="fa fa-user" aria-hidden="true"></i>
                            Mijn profiel
                        </a>
                        @if ($messageCount === 0)
                            <a href="{{ url('/users/inbox') }}"><i class="fa fa-envelope-square" aria-hidden="true"></i>
                                Mijn Berichten
                            </a>
                        @else
                            <a class="badge" href="{{ url('/users/inbox') }}"><i class="fa fa-envelope-square" aria-hidden="true"></i>
                                Mijn Berichten
                            </a>
                        @endif
                        <a href="{{ url('/users/privacy') }}"><i class="fa fa-lock" aria-hidden="true"></i>
                            Veiligheid
                        </a>
                        <a href="{{ url('/users/settings') }}"><i class="fa fa-wrench" aria-hidden="true"></i>
                            Instellingen
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li class="menu-item">
                        <a href="{{ url('/logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="fa fa-sign-out-alt" aria-hidden="true"></i>
                            Uitloggen
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
        </section>
    </header>

    <div class="container-toast columns notifications">
        @if ($errors->any())
            <div class="column toast toast-error col-5 centered">
                <button class="btn btn-clear toast-clear float-right"></button>
                <h4>Fout!</h4>
                @foreach ($errors->all() as $error)
                    - {{ $error }}
                @endforeach
            </div>
        @endif
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

<div class="main">
    <div id="vue">
        
        @yield('content')

        <div class="footer">
            &copy; Spots by Digital Den - 2018
            <a href="/terms"><span class="text-right">Algemene & Privacy Voorwaarden</span></a>
            <a href="/terms/cancellation"><span class="text-right"> Annulerings Voorwaarden</span></a>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('/js/serviceWorker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/push.js') }}"></script>    
<script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.slideshow-container').slick({
            infinite: true,
            speed: 200,
            autoplay: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            lazyLoad: 'progressive',
            fade: true,
            cssEase: 'linear'
        });
    });
</script>
        
</body> 
</html>
