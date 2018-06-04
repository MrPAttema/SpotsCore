@extends('layouts.app')

@section('content')

<div class="container columns centered">
    <div class="column">
        <div class="col-4 col-xs-12 centered">

            <div class="margin-15"></div>

            <div class="panel">

            <ul class="tab tab-block">
                <li class="tab-item active">
                    <a href="/login">Inloggen</a>
                </li>
                <li class="tab-item">
                    <a href="/register">Registreren</a>
                </li>
            </ul>
           
                <div class="column login-custom">

                    @if ($facebookauth == 1)
                        <form class="form-horizontal facebook-login " role="form" method="get" action="{{ url('/login/facebook') }}">
                            <div class="col-8 col-xs-12 centered">
                                <button type="submit" class="btn btn-facebook submit-btn"><i class="fab fa-facebook-f"></i>
                                Inloggen met Facebook
                                </button>
                            </div>
                        </form>
                        <div class="divider text-center" data-content="Of log in met uw Spots account"></div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-8 co col-xs-12 centered">
                                <input id="email" class="form-input centered" name="email" value="{{ old('email') }}" placeholder="E-mailadres of Personeelsnummer" autofocus>
                                @if ($errors->has('email')) 
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-8 col-xs-12 centered">
                                <input id="password" type="password" class="form-input centered" name="password" placeholder="Wachtwoord " required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group col-8 col-xs-12 centered">
                            <label class="form-checkbox">
                                <input type="checkbox">
                                <i class="form-icon" checked type="checkbox" name="remember"></i> Houd mij ingelogd
                            </label>
                        </div>

                        <div class="form-group">
                            <div class="col-8 col-xs-12 centered">
                                <button type="submit" class="btn btn-primary col-12 centered submit-btn"><i class="fa fa-sign-in-alt" aria-hidden="true"></i>
                                    Inloggen
                                </button>
                            </div>
                        </div>
                    </form>
                            
                    <hr>

                    <div class="form-group-voorwaarden">
                        Bent u uw wachtwoord vergeten? Dan kunt u hieronder klikken.
                        <a class="btn btn-link col-md-8 col-xs-12 centered" href="{{ url('/password/reset') }}">
                            Wachtwoord vergeten?
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
