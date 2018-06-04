@extends('layouts.app')

@section('content')
<div class="container columns">
    <div class="column">
        <div class="col-4 col-xs-12 centered">

            <div class="margin-15"></div>
            
            <div class="panel panel-default">
                
                <ul class="tab tab-block">
                    <li class="tab-item">
                        <a href="/login">Inloggen</a>
                    </li>
                    <li class="tab-item active">
                        <a href="/register">Registreren</a>
                    </li>
                </ul>
           

                    <form class="form-horizontal facebook-login" role="form" method="get" action="{{ url('/login/facebook') }}">
                        <div class="col-8 col-xs-12 centered">
                            <button type="submit" class="btn btn-facebook"><i class="fa fa-facebook-f"></i>
                              Registreer met Facebook
                            </button>
                        </div>
                    </form>

                    <div class="divider text-center" data-content="Of maak een Mijn Belboei account"></div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <div class="col-8 col-xs-12 centered">
                                <input id="firstname" type="text" class="form-input" name="firstname" value="{{ old('firstname') }}" placeholder="Voornaam" autofocus>

                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <div class="col-8 col-xs-12 centered">
                                <input id="lastname" type="text" class="form-input" name="lastname" value="{{ old('lastname') }}" placeholder="Achternaam" autofocus>

                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-8 col-xs-12 centered">
                                <input id="email" type="email" class="form-input" name="email" value="{{ old('email') }}" placeholder="E-mailadres">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-8 col-xs-12 centered">
                                <input id="password" type="password" class="form-input" name="password" placeholder="Wachtwoord">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-8 col-xs-12 centered">
                                <input id="password-confirm" type="password" class="form-input" name="password_confirmation" placeholder="Wachtwoord herhalen">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-8 col-xs-12 centered">
                                <button type="submit" class="btn btn-primary col-12 centered submit-btn">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> Registreren
                                </button>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group col-12 centered">
                            <label class="form-checkbox">
                                <input type="checkbox" name="akkoord" value="">
                                <i class="form-icon" checked type="checkbox" name="remember"></i> 
                                Door op 'Registreren' of 'Registreer met Facebook' te klikken, ga ik akkoord met de <a href="/terms">Voorwaarden & Privacy</a> van {{ config('app.name') }}.
                            </label>
                        </div>

                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
