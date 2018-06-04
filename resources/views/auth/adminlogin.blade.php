@extends('layouts.app')

@section('content')

<div class="container centered columns">
    <div class="column">
        <div class="col-4 col-xs-12 centered">

            <div class="margin-15"></div>

            <div class="panel">

            <ul class="tab tab-block">
                <li class="tab-item active">
                    <a href="/admin/login">Admin inloggen</a>
                </li>
                <li class="tab-item">
                    <a href="/login">Gebruiker inloggen</a>
                </li>
            </ul>
           
                <div class="column login-custom">

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-8 co col-xs-12 centered">
                                <input id="email" type="email" class="form-input centered" name="email" value="{{ old('email') }}" placeholder="E-mailadres" required autofocus>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
