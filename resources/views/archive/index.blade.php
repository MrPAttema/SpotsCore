@extends('layouts.app')

@section('content')
<div class="container centered columns margin-15">
    <div class="columns column col-oneline">
        <div class="column col-3 col-sm-12">
        <div class="margin-15">
            <h3>
               Zoeken
            </h3>
        </div>
            {{--  <div class="search-bar">
                <div class="input-group">
                    <input autofocus type="text" class="search" placeholder="Trefwoord.." id="keyword">
                    <div class="input-group-btn">
                        <button id="search-admin-reservations" class="btn btn-default search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>  --}}
            <hr>
            <form class="" action="/archive/yeardata" method="post">
                {{ csrf_field() }}
                <label for="weekOne">Selecteer het jaar:</label>
                <div class="columns column col-oneline">  
                    <div class="form-group col-9">
                        <select required name="res_year">
                            <option selected hidden value="">Maak een keuze</option>
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                        </select>
                    </div>
                    <button class="btn btn-primary margin-2 col-12">Selecteer</button>
                </div>   
            </form>
            <br>
            <hr>
            {{--  <div class="status-search">
                <div class="status-sorting">
                    <label for="weekOne">Status:</label>
                    <span class="btn search-list-item">Open</span>
                    <span class="btn search-list-item">Betaald</span>
                    <span class="btn search-list-item">Niet Betaald</span>
                    <span class="btn search-list-item">Toegewezen</span>
                    <span class="btn search-list-item">Afgewezen</span>
                </div>
            </div>   --}}
        </div>

        <div class="column col-9 col-md-9" id="default-results">
        @if ($res_year > 1)
            <div class="margin-15">
                <h3>
                    Uw archief overzicht voor {{$res_year}}
                </h3>
            </div>
        @else
            <div class="margin-15">
                <h3>
                    Uw archief overzicht
                </h3>
            </div>
        @endif
        @empty ($records)
            <div class="panel">
                <div class="panel-heading margin-15">
                    <img class="empty-state" src="{{URL::asset('img/home_empty.svg')}}"/>
                    <span class="empty-state-text">Welkom in het archief.</span>
                    <span class="empty-state-text-under">Er staan nog geen reservering in het archief.</span>
                    <span class="empty-state-text-under">Het archief word gevult aan het einde van elk jaar.</span>
                    <span class="empty-state-text-under">Dit onder voorwaarde dat u een boeking heeft gedaan.</span>

                </div>
            </div>
        @else
            @foreach ($records as $Record)
                <div class="panel panel-default">
                    <div class="panel-heading-adminreserveringen" style="cursor:pointer">
                        @if ($Record->tax_status == 1)
                            <i class="fa fa-circle" style="color: #00abff; " aria-hidden="true"></i>
                        @elseif ($Record->payment_status == 1)
                            <i class="fa fa-circle" style="color: green; " aria-hidden="true"></i>
                        @elseif ($Record->res_status == 1)
                            <i class="fa fa-circle" style="color: orange; " aria-hidden="true"></i>
                        @elseif ($Record->payment_status == 0)
                            <i class="fa fa-circle" style="color: red; " aria-hidden="true"></i>
                        @endif
                        Reserveringsnummer: #{{$Record->id}} - Toegewezen: {{$Record->res_toegewezen_week}}
                    </div>
                    <div class="panel-body-adminreserveringen" style="display:none;">
                        <table class="table table-bordered">
                            <tr>
                                <th>Week 1</th>
                                <th>Week 2</th>
                                <th>Week 3</th>
                                <th>Naam</th>
                                <th>Betalen</th>
                                <th>Betalen</th>
                            </tr>
                            <tr>
                                <td>{{$Record->res_week1}}</td>
                                <td>{{$Record->res_week2}}</td>
                                <td>{{$Record->res_week3}}</td>
                                <td>{{$Record->firstname}} {{$Record->lastname}}</td>
                                <td>
                                    <form method="post" action="{{ action('TouristtaxController@index') }}">
                                        @if ($Record->payment_status == 0)
                                            <input type="hidden" id="reservation_id" name="reservation_id" value="{{$Record->id}}">
                                            <input type="hidden" id="location_id" name="location_id" value="{{$Record->location_id}}">
                                            <input type="hidden" id="is_archive" name="is_archive" value="1">
                                            <button type="submit" class="btn btn-primary submit-btn col-xs-12 margin-5"><i class="fa fa-credit-card" aria-hidden="true"></i> Toeristenbelasting betalen</button>
                                        @elseif ($Record->payment_status == 1)
                                            <!-- NIETS LATEN DOEN -->
                                        @elseif ($Record->payment_status == 2)
                                            <input type="hidden" id="reservation_id" name="reservation_id" value="{{$Record->id}}">
                                            <input type="hidden" id="location_id" name="location_id" value="{{$Record->location_id}}">
                                            <input type="hidden" id="is_archive" name="is_archive" value="1">
                                            <button type="submit" class="btn btn-primary submit-btn col-xs-12 margin-5"><i class="fa fa-credit-card" aria-hidden="true"></i> Toeristenbelasting betalen</button>
                                        @endif
                                        {{ csrf_field() }}

                                    </form>
                                </td>
                                <td>
                                    <form method="post" action="{{ action('PaymentsController@TouristtaxPayment') }}">
                                
                                        @if ($Record->payment_status == 0)
                                            <input type="hidden" id="reservation_id" name="reservation_id" value="{{$Record->id}}">
                                            <input type="hidden" id="location_id" name="location_id" value="{{$Record->location_id}}">
                                            <button type="submit" class="btn btn-primary submit-btn col-xs-12 margin-5"><i class="fa fa-credit-card" aria-hidden="true"></i> Huur betalen</button>
                                        @elseif ($Record->payment_status == 1)
                                            <!-- NIETS LATEN DOEN -->
                                        @elseif ($Record->payment_status == 2)
                                            <input type="hidden" id="reservation_id" name="reservation_id" value="{{$Record->id}}">
                                            <input type="hidden" id="location_id" name="location_id" value="{{$Record->location_id}}">
                                            <button type="submit" class="btn btn-primary submit-btn col-xs-12 margin-5"><i class="fa fa-credit-card" aria-hidden="true"></i> Huur betalen</button>
                                        @endif
                                        {{ csrf_field() }}

                                    </form>
                                </td>
                            </tr>
                            {{ method_field('patch') }}
                        </table>
                        <div class="payment-status-adminreserveringen">
                            <div class="reservation-number">
                            @if ($Record->tax_status == 0)
                                    Toeristenbelasting: <span style="color: red; font-weight: 500;">Niet Betaald</span>
                                @elseif ($Record->tax_status == 1)
                                    Toeristenbelasting: <span style="color: green; font-weight: 500;">Betaald</span>
                                    <span>{{ Carbon\Carbon::parse($Record->updated_at)->format('d M Y - H:i') }}</span>
                                @elseif ($Record->tax_status == 2)
                                    Toeristenbelasting: <span style="color: green; font-weight: 500;">Betaling afgebroken</span>
                            @endif
                            </div>
                            <div class="reservation-number">
                            @if ($Record->payment_status == 0)
                                    Huurbetaling: <span style="color: red; font-weight: 500;">Niet Betaald</span>
                                @elseif ($Record->payment_status == 1)
                                    Huurbetaling: <span style="color: green; font-weight: 500;">Betaald</span>
                                    <span>{{ Carbon\Carbon::parse($Record->payment_time)->format('d M Y - H:i') }}</span>
                                @elseif ($Record->payment_status == 2)
                                    Huurbetaling: <span style="color: red; font-weight: 500;">Betaling afgebroken</span>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="col-md-9" id="search-results" style="display: block;">
            
        </div>

    </div>
</div>

@endsection
