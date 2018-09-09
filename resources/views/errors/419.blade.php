<!DOCTYPE html>
<html>
    <head>
        <title>Sessie verlopen.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }

            .btn {
                transition: all .2s ease;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background: #fff;
                border: 0.05rem solid #667189;
                border-radius: 0.2rem;
                color: #667189;
                cursor: pointer;
                display: inline-block;
                font-family: inherit;
                font-size: 1.5rem;
                font-weight: 600;
                height: 1.8rem;
                line-height: 0;
                outline: none;
                padding: 1.35rem 2.4rem;
                text-align: center;
                text-decoration: none;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                vertical-align: middle;
                white-space: nowrap;
                margin-right: 0.4rem;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">419.</div>
                <h2>Deze sessie voor deze pagina is verlopen.</h2>
                <h2>Misschien bent u te lang bezig met uw boeking?</h2>
                <a href="{{ url('/home') }}"><button class="btn">Terug naar home</button></a>
            </div>
        </div>
    </body>
</html>
