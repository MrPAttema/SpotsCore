@extends('layouts.app')

@section('content')
<div class="container centered columns">
    <div class="column">
        <div class="col-6 col-sm-12 centered">

            <div class="margin-15">
                <h3>
                    Gebruiker gegevens
                </h3>
            </div>

            <div class="panel">
                <div class="margin-15">
                    @foreach ($users as $user)
                    @php
                        $user = (object) $user;
                        $firstname = decrypt($user->firstname);
                        $lastname = decrypt($user->lastname);
                        $email = decrypt($user->email);
                        $phone = decrypt($user->phone);
                        $adress = decrypt($user->adress);
                        $postcode = decrypt($user->postcode);
                        $city = decrypt($user->city);
                        $work_location = decrypt($user->work_location);
                        $work_department = decrypt($user->work_department);
                    @endphp
                    <form class="user-panel" method="post">
                        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <label for="firstname">Voornaam:</label>
                            <input readonly class="form-input" type="text" name="firstname" value="{{$firstname}}">
                            @if ($errors->has('firstname')) 
                                <span class="help-block">
                                    <strong>{{ $errors->first('firstname') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <label for="lastname">Achternaam:</label>
                            <input readonly class="form-input" type="text" name="lastname" value="{{$lastname}}">
                            @if ($errors->has('lastname')) 
                                <span class="help-block">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">E-mailadres:</label>
                            <input class="form-input" type="text" name="email" value="{{$email}}" autofocus>
                            @if ($errors->has('email')) 
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="email">Telefoon:</label>
                            <input class="form-input" type="text" name="phone" value="{{$phone}}">
                            @if ($errors->has('phone')) 
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('adress') ? ' has-error' : '' }}">
                            <label for="email">Adres:</label>
                            <input class="form-input" type="text" name="adress" value="{{$adress}}">
                            @if ($errors->has('adress')) 
                                <span class="help-block">
                                    <strong>{{ $errors->first('adress') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
                            <label for="email">Postcode:</label>
                            <input class="form-input" type="text" name="postcode" uppercase maxlength="6" value="{{$postcode}}">
                            @if ($errors->has('postcode')) 
                                <span class="help-block">
                                    <strong>{{ $errors->first('postcode') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="email">Telefoon:</label>
                            <input class="form-input" type="text" name="phone" value="{{$phone}}">
                            @if ($errors->has('phone')) 
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="email">Woonplaats:</label>
                            <input class="form-input" type="text" name="city" value="{{$city}}">
                            @if ($errors->has('city')) 
                                <span class="help-block">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">Werkomgeving:</label>
                              <select class="select work" name="work_location">
                                @if ($work_location == null)
                                    <option selected hidden value="">Maak een keuze</option>
                                @else
                                    <option selected hidden value="{{$work_location}}">{{$work_location}}</option>
                                @endif
                                <option value="MCL BV">MCL BV</option>
                                <option value="NOORDERBREEDTE BV">NOORDERBREEDTE BV</option>
                                <option value="Geen ZPF">Geen ZPF</option>
                              </select>
                        </div>
                        {{-- <div class="form-group{{ $errors->has('work_department') ? ' has-error' : '' }}">
                            <label for="email">Afdeling:</label>
                            <input class="form-input" type="text" name="work_department" value="{{$work_department}}">
                            @if ($errors->has('work_department')) 
                                <span class="help-block">
                                    <strong>{{ $errors->first('work_department') }}</strong>
                                </span>
                            @endif
                        </div> --}}
                        <hr>
                        <div class="reservation-details-buttons">
                            <input class="form-input" type="hidden" name="_token" value="{{ csrf_token() }}">
                            {{ method_field('PATCH') }}
                            <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-save" aria-hidden="true"></i> Opslaan</button>
                            <button type="button" class="btn cancable" onClick="{{ url('/home') }}">Annuleeren</button>
                        </div>
                      </form>
                      </div>
                      @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
