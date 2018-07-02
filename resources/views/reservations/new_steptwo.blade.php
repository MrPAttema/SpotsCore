@extends('layouts.app')

@section('content')
<div class="container">
    <div class="column col-6 col-xs-12 centered">
        <div class="margin-15">
            <h3>
                Nieuw reservering
            </h3>
        </div>

        <div class="panel reservation-step-two">
            <ul class="step">
                <li class="step-item">
                    <a href="/reservations/new/" class="tooltip" data-tooltip="Selecteer een boekingsjaar.">Stap 1</a>
                </li>
                <li class="step-item active">
                    <a href="#" class="tooltip" data-tooltip="Selecteer een weeknummer.">Stap 2</a>
                </li>
                <li class="step-item">
                    <a href="#" class="tooltip" data-tooltip="Vul uw gegevens in.">Stap 3</a>
                </li>
            </ul>
            <div class="divider"></div>
            <div class="columns col-oneline col-gapless">
                <div class="column col-6 col-xs-12">
                    @if (($ronde2) == 0)
                        <div class="panel-heading-accomodation"><h2>{{$location->location_name}}, {{$location->location_location}}</h2>
                    @else
                        <div class="panel-heading-accomodation"><h2>{{$location->location_name}}, {{$location->location_location}}</h2> 
                        <div class="get-direct-text"><i class="fa fa-bolt fa-lg" aria-hidden="true"></i> Open reservering, reserveer een overgebleven week.</div>
                    @endif
                    </div>
                        <div class="panel-body">
                        <hr>
                        Vul onderstaand de weken in die u graag wilt reserveren.
                        Deze weken zijn <b>NIET</b> definitief en u zult spoedig een bevestiging krijgen.
                        Ook betalen doet u na toewijzing van een van de door u geselecteerde weken.
                        <hr>
                        <form method="post" action="{{ url('/reservations/new/stepthree') }}">
                            <div class="form-group">
                                <div class="slide-upper">
                                    <div class="form-group">
                                        <label id="res_week1" for="res_week1">Selecteer uw eerste voorkeursweek:</label>
                                        <select required="" class="" name="res_week1">
                                            <option selected hidden value="">Maak een keuze</option>
                                            @foreach ($weeks as $week)
                                                @if(in_array($week->week, $datesHigh) == false) 
                                                    <option name="" value='{"week":"{{$week->week}}","prijs":"{{$amount_low}}","in":"{{ $week->enterDate }}","uit":"{{ $week->exitDate }}"}'>{{$week->week}}</option>
                                                @else
                                                    <option name="" value='{"week":"{{$week->week}}","prijs":"{{$amount_high}}","in":"{{ $week->enterDate }}","uit":"{{ $week->exitDate }}"}'>{{$week->week}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 centered">
                                <label class="form-checkbox">
                                    <input type="checkbox" id="two_weeks">
                                    <i class="form-icon"></i> Ik wil twee weken achter elkaar.
                                </label>
                            </div>
                            {{-- <div class="popover popover-right">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                <div class="popover-container">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title h5">
                                                Twee weken aan een.
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            Indien u deze optie aan vinkt zullen we een week aan uw eerste week vast zetten.
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <hr>
                            @if (($ronde2) == 0)
                            <div class="form-group" id="second-week">
                                <div class="slide-upper">
                                   <label for="res_week2">Selecteer voorkeursweek twee:</label>
                                    <select required="" class="" name="res_week2">
                                        <option selected hidden value="">Maak een keuze</option>
                                        <option name="" value="0">Geen Voorkeur</option>
                                        @foreach ($weeks as $week)
                                            @if(in_array($week->week, $datesHigh) == false) 
                                                <option name="" value='{"week_two":"{{$week->week}}","prijs_two":"{{$amount_low}}","in_two":"{{ $week->enterDate }}","uit_two":"{{ $week->exitDate }}"}'>{{$week->week}}</option>
                                            @else
                                                <option name="" value='{"week_two":"{{$week->week}}","prijs_two":"{{$amount_high}}","in_two":"{{ $week->enterDate }}","uit_two":"{{ $week->exitDate }}"}'>{{$week->week}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                            </div>
                            @endif
                            <button type="button" onclick="history.go(-1);" class="btn bottom-10"><i class="fa fa-arrow-left" aria-hidden="true"></i> Terug naar stap 1</button>
                            <button type="post" class="btn btn-primary button-left bottom-10"><i class="fa fa-arrow-right" aria-hidden="true"></i> Verder naar stap 3</button>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="res_year" value="{{$res_year}}">
                            <input type="hidden" name="location_id" value="{{$location_id}}">
                        </form>
                    </div>
                </div>
                <div class="column col-6 col-xs-12">
                    <img class="location-image" src="/img/locations/{{$location->location_name}}/{{$location->location_name}}2.jpg">
                    <hr>
                    <div class="card-body">
                        Incheckdatum: <b><span id="in">Selecteer week</span></b>.
                        <br>
                        Uitcheckdatum: <b><span id="uit">Selecteer week</span></b>.
                        <br>
                        Prijs: <b>&euro; <span id="priceOne">..</span>,-</b> per week.
                        @if ($touristTax == 1)
                            <div class="location-toerist-tax">
                                Excl toeristenbelasting: &euro; {{$location->location_tax}} {{$taxtype}}
                            </div>
                        @endif
                    </div>
                    <hr>
                    <div class="card-body">
                        Incheckdatum: <b><span id="inTwo">Selecteer week</span></b>.
                        <br>
                        Uitcheckdatum: <b><span id="uitTwo">Selecteer week</span></b>.
                        <br>
                        <b>&euro; <span id="priceTwo">..</span>,-</b> per week.
                        @if ($touristTax == 1)
                            <div class="location-toerist-tax">
                                Excl toeristenbelasting: &euro; {{$location->location_tax}} {{$taxtype}}
                            </div>
                        @endif
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
