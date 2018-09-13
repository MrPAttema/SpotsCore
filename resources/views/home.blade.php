@extends('layouts.app')

@section('content')
<div id="app" class="centerd"></div>
    <div class="container columns centered bg-home">
        <div class="col-6 col-xs-12 centered">

            <div class="margin-15 white">
                <h3>
                    Home
                </h3>
            </div>

            @empty ($reservation)
                <div class="panel">
                    <div class="panel-heading">
                        <img class="empty-state" src="{{URL::asset('img/home_empty.svg')}}"/>
                        <span class="empty-state-text">Welkom! Er is nog niet veel te zien.</span>
                        <span class="empty-state-text-under">Er staan nog geen reservering in het systeem.</span>
                        <span class="empty-state-text-under">Klik hieronder op de knop om een reservering te maken.</span>
                    </div>
                    <div class="panel-body">
                        <form action="{{ url('/accommodations/all') }}">
                            <button type="submit" class="btn btn-margin btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Maak een nieuwe reservering</button>
                        </form>
                    </div>
                </div>
            @else 

                    <div class="panel">
                        <div class="margin-15">
                            <h2>
                                {{$reservation->location->location_name}}, {{$reservation->location->location_location}}
                            </h2>
                        </div>
                        <div class="col8-img"></div>    
                        <div class="panel-body">                  
                            <span>
                                Reserveringsnummer: <b>#{{$reservation->reservation_id}}</b>
                            </span>
                            <br>
                            <span>
                                @if ($reservation->res_status == 0)
                                    Status: <b style="color: orange;">Wachten op toewijzing</b>
                                @elseif ($reservation->res_status == 1)
                                    Status: <b class="text-checked text-mid">Week toegewezen, klik "Bekijk deze reservering"</b>
                                @elseif ($reservation->res_status == 2)
                                    Status: <b class="text-error text-mid">Vereist aandacht</b>
                                @elseif ($reservation->res_status == 3)
                                    Status: <b class="text-error text-mid">Vereist aandacht</b>
                                @endif
                            </span>
                            <form class="" action="{{ url('/reservations/myreservations') }}" method="get">
                                <button type="submit" class="btn btn-margin" id="panel-details-button"><i class="fa fa-arrow-right" aria-hidden="true"></i> Bekijk deze reservering</button>
                            </form>
                        </div>
                    </div>           

            <div class="panel">
                <div class="margin-15">
                    <h4>
                        Nieuwe reservering?
                    </h4>
                </div>
                <div class="panel-body">
                    <span>Wilt u nog een reservering maken? Dat kan door op de knop hier onder te klikken.</span>
                    <form action="{{ url('/accommodations/all') }}">
                        <button type="submit" class="btn btn-margin btn-primary">Beschikbare locaties bekijken</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
