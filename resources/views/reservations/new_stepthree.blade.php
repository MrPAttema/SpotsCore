@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-6 col-ms-12 centered">
        <div class="margin-15">
            <h3>
                Nieuw reservering
            </h3>
        </div>

        <div class="panel reservation-step-three">
            <ul class="step">
                <li class="step-item">
                    <a href="#" class="tooltip" data-tooltip="Selecteer een boekingsjaar.">Stap 1</a>
                </li>
                <li class="step-item">
                    <a href="#" class="tooltip" data-tooltip="Selecteer een weeknummer.">Stap 2</a>
                </li>
                <li class="step-item active">
                    <a href="#" class="tooltip" data-tooltip="Vul uw gegevens in.">Stap 3</a>
                </li>
            </ul>
            <div class="divider"></div>
            <div class="columns">
                <div class="column col-12 col-xs-12 margin-10">
                    <p class="reservation-text">Vul in het onderstaande scherm uw gegevens in.</p>
                    <p class="reservation-text">Uw gegevens zijn nodig op de reservering aan te maken.</p>
                    <p><i>Als deze reeds voor u ingevuld zijn controleer deze dan nauwkeurig.</i></p>
                    <br>
                    <form method="post" action="/reservations/new/save" class="user-panel">
                        <div class="form-group">
                            <label for="email">E-mailadres:</label>
                            <input required type="text" name="email" value="{{ Crypt::decrypt(Auth::user()->email) }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Telefoonnummer (Mobiel):</label>
                            <input required type="text" name="phone" value="{{ Crypt::decrypt(Auth::user()->phone) }}">
                        </div>
                        <div class="form-group">
                            <label for="city">Woonplaats:</label>
                            <input required type="text" name="city" value="{{ Crypt::decrypt(Auth::user()->city) }}">
                        </div>
                        <div class="form-group">
                            <label for="adress">Adres:</label>
                            <input required type="text" name="adress" value="{{ Crypt::decrypt(Auth::user()->adress) }}">
                        </div>
                        <div class="form-group">
                            <label for="postcode">Postcode:</label>
                            <input style="text-transform:uppercase" required type="text" name="postcode" value="{{ Crypt::decrypt(Auth::user()->postcode) }}">
                        </div>

                        <div class="form-group">
                            <label for="email">Werkomgeving:</label>
                            <select class="select work" name="work_location">
                                @if (Auth::user()->work_location == null)
                                    <option selected hidden value="">Maak een keuze</option>
                                @else
                                    <option selected hidden value="{{Crypt::decrypt(Auth::user()->work_location) }}">{{Crypt::decrypt(Auth::user()->work_location) }}</option>
                                @endif
                                <option value="MCL">MCL</option>
                                <option value="Noorderbreete">Noorderbreete</option>
                                <option value="Geen ZPF">Geen ZPF</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="email">Afdeling:</label>
                            <input required type="text" name="work_department" value="{{Crypt::decrypt(Auth::user()->work_department) }}">
                        </div>

                        <hr>

                        <div class="form-group col-12 col-xs-12 centered">
                            <label class="form-checkbox">
                                <input required="" id="checkbox-submit" type="checkbox" name="res_akkoord" value="1">
                                <i class="form-icon" checked type="checkbox" name="remember"></i> Ik bevestig mijn reservering en ga akkoord met de <a href="/terms">Voorwaarden</a>.
                            </label>
                        </div>
                        <hr>
                        <div class="reservation-details-buttons">
                            <button type="button" onclick="history.go(-1);" class="btn button-left"><i class="fa fa-arrow-left" aria-hidden="true"></i> Terug naar stap 2</button>
                            <button type="get" action="/home" class="btn cancable">Annuleeren</button>
                            <button type="submit" class="btn btn-primary submit-btn"><i class="fa fa-arrow-right" aria-hidden="true"></i> Aanvraag indienen</button>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="res_year" value="{{$res_year}}">
                            <input type="hidden" name="location_id" value="{{$location_id}}">
                            <input type="hidden" name="res_week1" value="{{$res_week1}}">
                            <input type="hidden" name="res_week2" value="{{$res_week2}}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
