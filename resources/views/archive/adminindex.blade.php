@extends('layouts.admin')

@section('content')
<div class="container columns margin-15">
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
            <form class="" action="/admin/archive/yeardata" method="post">
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
                Archief overzicht voor {{$res_year}}
            </h3>
        </div>
        @else
        <div class="margin-15">
            <h3>
                Uw archief overzicht
            </h3>
        </div>
        @endif

        @if (count($records) > 1)
            @foreach ($records as $Record)
                <div class="panel panel-default">
                    <div class="panel-heading-adminreserveringen" style="cursor:pointer">
                        @if ($Record->tax_status == 1)
                            <i class="fa fa-circle" style="color: #00abff; " aria-hidden="true"></i>
                        @elseif ($Record->payment_status == 1)
                            <i class="fa fa-circle" style="color: green; " aria-hidden="true"></i>
                        @elseif ($Record->res_status == 1)
                            <i class="fa fa-circle" style="color: orange; " aria-hidden="true"></i>
                        @elseif ($Record->res_toegewezen_week == 0)
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
                                <th>Werk</th>
                                <th>Toewijzen</th>
                                <th>Actie</th>
                            </tr>
                            <tr>
                                <td>{{$Record->res_week1}}</td>
                                <td>{{$Record->res_week2}}</td>
                                <td>{{$Record->res_week3}}</td>
                                <td>{{$Record->firstname}} {{$Record->lastname}}</td>
                                <td>{{$Record->work_location}}</td>
                                <td>
                                @if ($Record->res_toegewezen_week == 0)
                                    <form method="post" class="form-toewijzen" action="{{ url('/admin/allreservations') }}">
                                        <input required="" type="text-small" size="2" value="" name="toegewezen"></input>
                                        <input type="hidden" value="{{$Record->id}}" name="reservation_id"></input>
                                        <input type="hidden" name="_method" value="PATCH">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn button"> Toewijzen</button>
                                    </form>
                                    @else
                                        <input required="" class="btn button" type="text-small" disabled size="2" value="{{$Record->res_toegewezen_week}}" name="toegewezen"></input>
                                    @endif
                                </td>
                                <td>
                                    @if ($Record->res_toegewezen_week == 0)
                                        <form class="form-toewijzen" action="{{ url('/admin/allreservations/rejected') }}" method="post">
                                            <input type="hidden" value="{{$Record->id}}" name="reservation_id"></input>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn button"> Reservering afwijzen</button>
                                        </form>
                                    @else
                                        <form class="form-toewijzen" action="{{ url('/admin/allreservations/cancel') }}" method="post">
                                            <input type="hidden" value="{{$Record->id}}" name="reservation_id"></input>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn button"> Reservering annuleren</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            {{ method_field('patch') }}
                        </table>
                        <div class="payment-status-adminreserveringen">
                            <div class="reservation-number">
                                <form class="form-toewijzen" action="{{ url('/admin/archive/update/tax') }}" method="post">             
                                    @if ($Record->tax_status == 0)
                                            Toeristenbelasting: <span style="color: red; font-weight: 500;">Niet Betaald</span>
                                            <input type="date" name="toeristenbelasting"></input>
                                        @elseif ($Record->tax_status == 1)
                                            Toeristenbelasting: <span style="color: green; font-weight: 500;">Betaald</span>
                                            <span>{{$Record->updated_at}}</span>
                                        @elseif ($Record->tax_status == 2)
                                            Toeristenbelasting: <span style="color: green; font-weight: 500;">Betaling afgebroken</span>
                                    @endif
                                    @if ($Record->tax_status == 0)
                                        <input type="hidden" value="{{$Record->res_year}}" name="res_year"></input>
                                        <input type="hidden" value="{{$Record->id}}" name="reservation_id"></input>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button class="btn button">Updaten</button>
                                    @endif
                                </form>                         
                            </div>
                            <div class="reservation-number">
                                <form class="form-toewijzen" action="{{ url('/admin/archive/update/rent') }}" method="post">
                                    @if ($Record->payment_status == 0)
                                            Huurbetaling: <span style="color: red; font-weight: 500;">Niet Betaald</span>
                                            <input type="date" name="huurbetaling"></input>
                                        @elseif ($Record->payment_status == 1)
                                            Huurbetaling: <span style="color: green; font-weight: 500;">Betaald</span>
                                            <span>{{$Record->updated_at}}</span>
                                        @elseif ($Record->payment_status == 2)
                                            Huurbetaling: <span style="color: red; font-weight: 500;">Betaling afgebroken</span>
                                    @endif
                                    @if ($Record->payment_status == 0)
                                        <input type="hidden" value="{{$Record->res_year}}" name="res_year"></input>
                                        <input type="hidden" value="{{$Record->id}}" name="reservation_id"></input>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button class="btn button">Updaten</button>
                                    @endif
                                </form>      
                            </div>
                        </div>
                    </div>
                    
                </div>
            @endforeach
        @else
            <div class="panel">
                <div class="panel-heading margin-15">
                    <img class="empty-state" src="{{URL::asset('img/home_empty.svg')}}"/>
                    <span class="empty-state-text">Welkom in het archief.</span>
                    <span class="empty-state-text-under">Er staan nog geen reservering in het archief.</span>
                    <span class="empty-state-text-under">Het archief word gevult aan het einde van elk jaar.</span>
                    <span class="empty-state-text-under">Dit onder voorwaarde dat u een boeking heeft gedaan.</span>
                </div>
            </div>
        @endif

        <div class="col-md-9" id="search-results" style="display: block;">
            
        </div>

    </div>
</div>

@endsection
