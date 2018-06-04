<!DOCTYPE html>
<html>
    <head>
        <title>Be right back.</title>

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
                <div class="title">404.</div>
                <h2>Deze pagina is niet gevonden.</h2>
                <h2>Dat is nooit goed! Misschien ben je verdwaald?</h2>
                <a href="{{ url('/home') }}"><button class="btn">Terug</button></a>
            </div>
        </div>
    </body>
</html>
