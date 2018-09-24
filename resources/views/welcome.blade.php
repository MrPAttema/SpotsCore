<!DOCTYPE html>
<html lang="en">
<!--[if lt IE 10]>
  <div id='error' style="background-color: red; color:white; text-align:center; height:50px; line-height:50px;">
      Deze website werkt niet goed op Internet Explorer 9 of lager. Gebruik een andere browser AUB.<br />
  </div>
<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:100,200,300,400,500,600" rel="stylesheet"> -->
        <link rel="icon" href="{{ asset('/img/favicon.png') }}" type="image/x-icon"/>
        <link rel="stylesheet" href="{{ asset('css/spectre.css') }}"/>


        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-45979619-5"></script>
        <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];        
            function gtag(){dataLayer.push(arguments);}        
            gtag('js', new Date());
            gtag('config', 'UA-45979619-5');
        </script>

        <!-- Styles -->
        <style>
            html, body {
                background-image: url(img/vlieland2.jpg);
                background-size: cover;
                color: white;
                background-repeat: no-repeat;
                color: #f1f1f1;
                font-weight: 300;
                height: 100vh;
                margin: 0;
                text-rendering: optimizeLegibility;
              }
              @keyframes fadein {
                  from { opacity: 0; }
                  to   { opacity: 1; }
              }
              /* Firefox < 16 */
              @-moz-keyframes fadein {
                  from { opacity: 0; }
                  to   { opacity: 1; }
              }

              /* Safari, Chrome and Opera > 12.1 */
              @-webkit-keyframes fadein {
                  from { opacity: 0; }
                  to   { opacity: 1; }
              }

              /* Internet Explorer */
              @-ms-keyframes fadein {
                  from { opacity: 0; }
                  to   { opacity: 1; }
              }

              /* Opera < 12.1 */
              @-o-keyframes fadein {
                  from { opacity: 0; }
                  to   { opacity: 1; }
              }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
                max-width: 100%;
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
                -webkit-animation: fadein 4s; /* Safari, Chrome and Opera > 12.1 */
                 -moz-animation: fadein 4s; /* Firefox < 16 */
                  -ms-animation: fadein 4s; /* Internet Explorer */
                   -o-animation: fadein 4s; /* Opera < 12.1 */
                      animation: fadein 4s;
            }

            .title {
                font-size: 84px;
                text-align: center;
            }


            .links .register {
              background: rgba(255, 255, 255, 0);
              color: #fff;
              padding: 10px 45px;
            }

            .links {
              margin-top: 30px;
            }

            a {
                /*display: none;*/
                color: #f1f1f1;
                text-decoration: none;
            }

            .m-b-md {
                /*margin-bottom: 30px;*/
            }

            .footer {
                height: 55px;
                width: 100%;
                background-color: #1d1d1d;
                line-height: 50px;
                text-align: center;
                font-family: inherit;
                font-size: 14px;
                position: fixed;
                bottom: 0px;
            }

            .container-under {
                height: 5px;
                background: #1c771d;
                color: white;
                opacity: 1;
            }

            img.footer-logo {
                height: 30px;
                margin: 10px 15px;
                float: right;
            }

            .frontpage-notify {
                background-color: #e40000;
                height: 35px;
                text-align: -webkit-center;
                line-height: 35px;
                font-weight: 500;
                display: inline-table;
                width: 100%;
                box-shadow: 0px 1px 5px #3a3a3a;
            }
            .btn {
                width: 10rem;
                font-weight: 500;
            }
            b {
                font-weight: 500;
            }
            @media screen and (max-width: 414px) {
              .title {
                  font-size: 46px;
                  text-align: inherit
              }
              .small-text {
                color: #f1f1f1;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 500;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
              }
              .col-md-1{
                width: 45%;
              }
              .register {
                padding: 10px 45px;
              }

              .links {
                margin-top: 30px;
              }

              img.footer-logo {
                  height: 30px;
                  margin: 10px 15px;
                  display: none;
              }
              .footer {
                  height: 30px;
                  width: 100%;
                  background-color: #1d1d1d;
                  line-height: 24px;
                  text-align: center;
                  font-family: inherit;
                  font-size: 14px;
                  position: fixed;
                  bottom: 0px;
              }
              .frontpage-notify {
                  background-color: #e40000;
                  font-size: 15px;
                  text-align: -webkit-center;
                  line-height: 20px;
                  font-weight: 500;
                  width: 100%;
                  box-shadow: 0px 1px 5px #3a3a3a;
              }

              .btn-link {
                color: #fff !important;
              }
            }
        </style>
    </head>
    <body>
   <!--      <div class="frontpage-notify">
            <b>Belangrijk:</b> Als u voor het eerst inlogt dient u een nieuw wachtwoord aan te vragen, dit kan door <a href="/password/reset"><b>HIER TE KLIKKEN</b></a>.
        </div> -->
        <!--[if gte IE 10]>
        <script src="//browser-update.org/update.js"></script>
        <![endif]-->
        <div class="container columns flex-center full-height">
            <div class="content columns col-12">
                <div class="title centered">
                    {{ config('app.name', 'Laravel') }}
                </div>

                <div class="small-text col-12">
                    <span>Welkom bij {{ config('app.name', 'Laravel') }}, voor al uw reserveringen.</span>
                </div>

                @if (Route::has('login'))
                    <div class="links col-12">
                        <a class="btn btn-primary col-md-1" href="{{ url('/login') }}">Inloggen</a>
                        {{-- <a class="btn col-md-1" href="{{ url('/register') }}">Registreren</a> --}}
                    </div>
                @endif

            </div>
        </div>

        <div class="footer">
            <div class="container-under"></div>
            <div class="logo">
                <img class="footer-logo" src="{{URL::asset('img/ssl-secured.svg')}}">
                <img class="footer-logo" src="{{URL::asset('img/ideal.svg')}}">
            </div>
            <div class="col-md-12"><span><a href="/admin/login"><b>Admin Login</b></a> - <a href="https://spots.patrickattema.nl">Spots By Patrick Attema 2016-2017</a></span></div>
        </div>

    </body>
</html>
