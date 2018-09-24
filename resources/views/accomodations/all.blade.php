@extends('layouts.app')

@section('content')
<div class="container columns centered col-oneline">
<div class="column col-12">
    <div class="margin-15">
        <h3>
            Beschikbare locaties
        </h3>
    </div>
</div>
</div>
<div class="container">
<div class="columns">
    <!-- {{$key = 0}} -->
    @foreach ($locations as $Location)
    <!-- {{$key++}} --> 
        <div class="column col-4 col-xs-12">
            <div class="card margin-15">
                <div class="card-image">
                    <img src="{{URL::to('/')}}/img/locations/{{$Location->location_name}}/{{$Location->location_name}}1.jpg" style="width:100%">
                    {{-- <div class="slideshow-container">
                        <img src="{{URL::to('/')}}/img/locations/{{$Location->location_name}}/{{$Location->location_name}}2.jpg" style="width:100%">
                        <img src="{{URL::to('/')}}/img/locations/{{$Location->location_name}}/{{$Location->location_name}}3.jpg" style="width:100%">
                    </div> --}}
                </div>
                <div class="card-header">
                    <div class="card-title h5">{{$Location->location_name}}</div>
                    {{-- <div class="card-subtitle text-gray">
                        Gelegen in/op {{$Location->location_location}}.
                    </div> --}}
                    @if (($Location->change_day) == 5)
                        <span>Wisseldag is: <b>Vrijdag</b></span>
                    @elseif (($Location->change_day) == 6)
                        <span>Wisseldag is: <b>Zaterdag</b></span>
                    @endif
                    <div class="card-subtitle text-gray">
                        @if (($autotoewijzen) == 1)
                            <i>Deze locatie krijgt u direct toegewezen na betaling.</i>
                        @endif
                    </div>
                </div>    
                <div class="card-body">
                    Vanaf: <b>&euro; {{$Location->location_price}},-</b> per week
                    @if ($touristTax == 0)
                        <div class="location-toerist-tax">
                            Excl toeristenbelasting: &euro;{{$Location->location_tax}} per week.
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <form method="get" action="/reservations/new/">
                        <input type="hidden" name="location_id" value="{{$Location->id}}">
                        @if($ronde1 == 1 || $ronde2 == 1)
                        <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right" aria-hidden="true"></i> Reservering aanvragen</button>
                        @else
                        <div class="card-subtitle text-gray">
                            <i>Reservering opent op {{ Carbon\Carbon::parse($openYear)->format('d-m-Y - H:i') }}</i>
                        </div>
                        <button type="button" class="btn button-warning"><i class="fa fa-ban" aria-hidden="true"></i> Geen reservering mogelijk</button>
                        @endif
                        <button type="button" class="btn modal-open" id="{{$Location->id}}"><i class="fa fa-info" aria-hidden="true"></i> Details</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="modal-{{$Location->id}}">
            <div class="modal-overlay" id="modal-{{$Location->id}}"></div>
            <div class="modal-container">
                <div class="modal-header">
                    <button class="btn btn-clear modal-clear float-right"></button>
                    <div class="modal-title h4">Informatie over {{$Location->location_name}}</div>
                </div>
                <div class="modal-body">
                    <div class="content">
                        {{$Location->location_discription}}
                        <hr>
                        <h5>Voorzieningen</h5>
                            <hr>
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/rooms.svg')}}">
                                {{$Location->location_bedrooms}} Slaapkamers
                            </div>
                            <hr>
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/singlebed.svg')}}">
                                {{$Location->location_beds}} Bedden
                            </div>
                            <hr>
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/family.svg')}}">
                                {{$Location->location_maxpersons}} Personen
                            </div>
                            <hr>
                        @if (($Location->location_family) == 0)
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/family.svg')}}">
                                Gezins/kindvriendelijk
                            </div>
                            <hr>
                        @endif
                        @if (($Location->location_fireplace) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_fireplace.svg')}}">
                                Geen openhaard
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/fireplace.svg')}}">
                                Openhaard
                            </div>
                            <hr>
                        @endif
                         @if (($Location->location_wifi) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_wifi.svg')}}">
                                Geen Wi-Fi
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/wifi.svg')}}">
                                Wi-Fi Aanwezig
                            </div>
                            <hr>
                        @endif
                        @if (($Location->location_tv) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_tv.svg')}}">
                                Geen TV
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/tv.svg')}}">
                                TV
                            </div>
                            <hr>
                        @endif
                        @if (($Location->location_radio) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_radio.svg')}}">
                                Geen Radio
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/radio.svg')}}">
                                Radio
                            </div>
                            <hr>
                        @endif
                        @if (($Location->location_shower) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_shower.svg')}}">
                                Geen Douche
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/shower.svg')}}">
                                Douche
                            </div>
                            <hr>
                        @endif
                        @if (($Location->location_central_heating) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_bus.svg')}}">
                                Geen centrale verwarming
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/bus.svg')}}">
                                Centrale verwarming
                            </div>
                            <hr>
                        @endif
                        @if (($Location->location_fridge) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_fridge.svg')}}">
                                Geen koelkast
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/fridge.svg')}}">
                                Koelkast
                            </div>
                            <hr>
                        @endif
                        @if (($Location->location_coffee) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_coffee.svg')}}">
                                Geen koffiezet apparaat
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/coffee.svg')}}">
                                Koffiezet apparaat
                            </div>
                            <hr>
                        @endif
                        @if (($Location->location_washingmachine) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_washingmachine.svg')}}">
                                Geen wasmachine
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/washingmachine.svg')}}">
                                Wasmachine
                            </div>
                            <hr>
                        @endif
                        @if (($Location->location_dryer) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_dryer.svg')}}">
                                Geen droger
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/dryer.svg')}}">
                                Droger
                            </div>
                            <hr>
                        @endif
                        @if (($Location->location_dishwasher) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_dishwasher.svg')}}">
                                Geen vaatwasser
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/dishwasher.svg')}}">
                                Vaatwasser
                            </div>
                            <hr>
                        @endif
                        {{-- @if (($Location->location_publictransport) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_bus.svg')}}">
                                Geen OV station dichtbij
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/bus.svg')}}">
                                OV station dichtbij
                            </div>
                            <hr>
                        @endif --}}
                        @if (($Location->location_smoking) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_smoking.svg')}}">
                                Roken niet toegestaan
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/smoking.svg')}}">
                                Roken toegestaan
                            </div>
                            <hr>
                        @endif
                        @if (($Location->location_pets) == 0)
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/no_pets.svg')}}">
                                Huisdieren niet toegestaan
                            </div>
                            <hr>
                        @else
                            <div class="panel-body-location-details">
                                <img class="location-icons" src="{{URL::to('/img/icons/v2/pets.svg')}}">
                                Huisdieren toegestaan
                            </div>
                            <hr>
                        @endif

                        <h5>Indeling</h5>
                        <div class="panel-body-location-details">
                            {{-- <img class="location-icons" src="{{URL::to('/img/icons/v2/bunkbed.svg')}}"> --}}
                            {{-- <img class="location-icons" src="{{URL::to('/img/icons/v2/bunkbed.svg')}}"> --}}
                            2x stappelbedden
                        </div>
                        <hr>
                        <div class="panel-body-location-details">
                            {{-- <img class="location-icons" src="{{URL::to('/img/icons/v2/dubblebed.svg')}}"> --}}
                            1 tweepersoonsbed
                        </div>
                    </div>
                    <div class="content-right">
                        <div class="slideshow-container">
                            <img src="{{URL::to('/')}}/img/locations/{{$Location->location_name}}/{{$Location->location_name}}1.jpg" style="width:100%">
                            <img src="{{URL::to('/')}}/img/locations/{{$Location->location_name}}/{{$Location->location_name}}2.jpg" style="width:100%">
                            <img src="{{URL::to('/')}}/img/locations/{{$Location->location_name}}/{{$Location->location_name}}3.jpg" style="width:100%">
                        </div>
                        <div class="right-text">
                            <p>
                                {{$Location->location_description}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    Bijgewerkt op: {{$Location->updated_at}}
                </div>
            </div>
        </div>
    @endforeach
</div>
</div>
@endsection
