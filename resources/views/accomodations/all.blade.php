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

                        <div class="slides">
                            <img src="/img/locations/{{$Location->location_name}}/{{$Location->location_name}}1.jpg">
                            <img src="/img/locations/{{$Location->location_name}}/{{$Location->location_name}}2.jpg">
                            <img src="/img/locations/{{$Location->location_name}}/{{$Location->location_name}}3.jpg">
                            <img src="/img/locations/{{$Location->location_name}}/{{$Location->location_name}}4.jpg">
                        </div>
                            {{--  <div class="mySlides{{$key}} fade">
                            <div class="slideshow-container">
                                    <div class="numbertext">1 / 3</div>
                                    <img src="{{URL::asset('img/vlieland1.jpg')}}" style="width:100%">
                                </div>

                                <div class="mySlides{{$key}} fade">
                                    <div class="numbertext">2 / 3</div>
                                    <img src="{{URL::asset('img/vlieland2.jpg')}}" style="width:100%">
                                </div>

                                <div class="mySlides{{$key}} fade">
                                    <div class="numbertext">3 / 3</div>
                                    <img src="{{URL::asset('img/vlieland3.jpg')}}" style="width:100%">
                                </div>

                                <a class="prev" onclick="plusSlides(-1, {{$key}})">&#10094;</a>
                                <a class="next" onclick="plusSlides(1, {{$key}})">&#10095;</a>
                                </div>
                                <br>

                                <div style="text-align:center">
                            </div>  --}}
                       {{--  <img src="{{URL::asset('img/vlieland1.jpg')}}" class="img-responsive">  --}}
                    </div>
                    <div class="card-header">
                        <div class="card-title h5">{{$Location->location_name}}</div>
                        <div class="card-subtitle text-gray">
                            Gelegen in/op {{$Location->location_location}}.
                        </div>
                        @if (($Location->change_day) == 5)
                            <span>Wisseldag is: <b>Vrijdag</b></span>
                        @elseif (($Location->change_day) == 6)
                            <span>Wisseldag is: <b>Zaterdag</b></span>
                        @endif
                        <div class="card-subtitle text-gray">
                            @if (($autotoewijzen) == 0)
                                {{--    --}}
                            @else
                                <i>Deze locatie krijgt u direct toegewezen.</i>
                            @endif
                        </div>
                    </div>    
                    <div class="card-body">
                        Vanaf: <b>&euro; {{$Location->location_price}},-</b> per week
                        @if ($touristTax == 0)
                            <div class="location-toerist-tax">
                                Incl toeristenbelasting: &euro;{{$Location->location_tax}} per week.
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <form method="post" action="/reservations/new">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input name="location_id" type="hidden" value="{{$Location->id}}"></input>
                            @if($ronde1 == 1 || $ronde2 == 1)
                            <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right" aria-hidden="true"></i> Reservering aanvragen</button>
                            @else
                            <button type="button" class="btn button-warning"><i class="fa fa-ban" aria-hidden="true"></i> Reserveren niet mogelijk</button>
                            @endif
                            <button type="button" class="btn modal-open"><i class="fa fa-info" aria-hidden="true"></i> Details</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal">
                <div class="modal-overlay"></div>
                <div class="modal-container">
                    <div class="modal-header">
                        <button class="btn btn-clear modal-clear float-right"></button>
                        <div class="modal-title h4">Informatie</div>
                    </div>
                    <div class="modal-body">
                        <div class="content">
                            {{$Location->location_discription}}
                            <hr>
                            <h5>Voorzieningen</h5>
                                <hr>
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/rooms.svg')}}">
                                    {{$Location->location_bedrooms}} Slaapkamers
                                </div>
                                <hr>
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/singlebed.svg')}}">
                                    {{$Location->location_beds}} Bedden
                                </div>
                                <hr>
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/family.svg')}}">
                                    {{$Location->location_maxpersons}} Personen
                                </div>
                                <hr>
                            @if (($Location->location_family) == 0)
                            @else
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/family.svg')}}">
                                    Gezins/kindvriendelijk
                                </div>
                                <hr>
                            @endif
                            @if (($Location->location_fireplace) == 0)
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/no_fireplace.svg')}}">
                                    Geen openhaard
                                </div>
                                <hr>
                            @else
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/fireplace.svg')}}">
                                    Openhaard
                                </div>
                                <hr>
                            @endif
                            @if (($Location->location_tv) == 0)
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/no_tv.svg')}}">
                                    Geen TV
                                </div>
                                <hr>
                            @else
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/tv.svg')}}">
                                    TV
                                </div>
                                <hr>
                            @endif
                            @if (($Location->location_radio) == 0)
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/no_radio.svg')}}">
                                    Geen Radio
                                </div>
                                <hr>
                            @else
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/radio.svg')}}">
                                    Radio
                                </div>
                                <hr>
                            @endif
                            @if (($Location->location_shower) == 0)
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/no_shower.svg')}}">
                                    Geen Douche
                                </div>
                                <hr>
                            @else
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/shower.svg')}}">
                                    Douche
                                </div>
                                <hr>
                            @endif
                            @if (($Location->location_publictransport) == 0)
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/no_bus.svg')}}">
                                    Geen OV station dichtbij
                                </div>
                                <hr>
                            @else
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/bus.svg')}}">
                                    OV station dichtbij
                                </div>
                                <hr>
                            @endif
                            @if (($Location->location_wifi) == 0)
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/no_wifi.svg')}}">
                                    Geen Wi-Fi
                                </div>
                                <hr>
                            @else
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/wifi.svg')}}">
                                    Wi-Fi Aanwezig
                                </div>
                                <hr>
                            @endif
                            @if (($Location->location_smoking) == 0)
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/no_smoking.svg')}}">
                                    Roken niet toegestaan
                                </div>
                                <hr>
                            @else
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/smoking.svg')}}">
                                    Roken toegestaan
                                </div>
                                <hr>
                            @endif
                            @if (($Location->location_pets) == 0)
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/no_pets.svg')}}">
                                    Huisdieren niet toegestaan
                                </div>
                                <hr>
                            @else
                                <div class="panel-body-location-details">
                                    <img class="location-icons" src="{{URL::asset('icons/v2/pets.svg')}}">
                                    Huisdieren toegestaan
                                </div>
                                <hr>
                            @endif

                            <h5>Indeling</h5>
                            <img class="location-icons" src="{{URL::asset('icons/v2/bunkbed.svg')}}">
                            <img class="location-icons" src="{{URL::asset('icons/v2/bunkbed.svg')}}">
                            <img class="location-icons" src="{{URL::asset('icons/v2/dubblebed.svg')}}">
                            2 stapelbedden,
                            1 tweepersoonsbed
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
