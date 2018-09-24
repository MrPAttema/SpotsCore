@extends('layouts.admin')

@section('content')
<div class="container top-15">
        <div class="bottom-30">
            <h3>
                Alle reserveringen
            </h3>
        </div>
    <div class="columns centered col-oneline col-12 col-sm-12">
        <div class="column col-2 col-sm-2">
            <div class="search-bar">
                <div class="input-group">
                    <input autofocus type="text" class="search" id="allZoeken" placeholder="Zoeken" name="keyword">
                </div>
            </div>
            {{-- <form method="POST" class="" action="{{ action('SearchController@inputStatus') }}" --}}
                {{-- <div class="status-search">
                    <div class="status-sorting">
                        <span><b>Status</b></span>
                        <hr>
                        <a value="" href="open" class="btn btn-link search-list-item">Open</a>
                        <a value="" href="paid" class="btn btn-link search-list-item">Betaald</a>
                        <a value="" href="unpaid" class="btn btn-link search-list-item">Niet Betaald</a>
                        <a value="" href="assigned" class="btn btn-link search-list-item">Toegewezen</a>
                        <a value="" href="rejected" class="btn btn-link search-list-item">Afgewezen</a>
                    </div>  --}}
            </div>
        </div>

        <div class="column col-12 col-sm-12">

            

            <table class="table table-striped table-hover" id="allReservations">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Week 1</th>
                        <th>Week 2</th>
                        <th>Toewijzen</th>
                        <th>Actie</th>
                        <th>Betaling</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $Reservation)
                        <tr>
                            <td> 
                                @if (($Reservation->touristtax->tax_status == 1) && ($Reservation->payment->payment_status == 1))
                                    <span class="label label-rounded label-primary">Afgehandeld</span>
                                @elseif (($Reservation->touristtax->tax_status == 1) || ($Reservation->payment->payment_status == 1))
                                    <span class="label label-rounded label-success">Huur voldaan</span>
                                @elseif ($Reservation->res_status == 1)
                                    <span class="label label-rounded label-warning">Toegewezen</span>
                                @elseif ($Reservation->payment->payment_status == 0)
                                    <span class="label label-rounded label-error">Niet toegewezen</span>
                            @endif
                            </td>
                            <td>{{$Reservation->reservation_id}}</td>
                            <td>{{Crypt::decrypt($Reservation->user->firstname)}} {{Crypt::decrypt($Reservation->user->lastname)}}</td>
                            <td>{{$Reservation->res_week1}}</td>
                            <td>{{$Reservation->res_week2}}</td>
                            <td>
                                @if ($Reservation->res_toegewezen_week == 0)
                                <form method="post" class="form-toewijzen" action="{{ url('/admin/allreservations') }}">
                                    <input required="" type="text-small" size="2" value="" name="toegewezen"></input>
                                    <input type="hidden" value="{{$Reservation->id}}" name="reservation_id"></input>
                                    <input type="hidden" name="_method" value="PATCH">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn button"> Toewijzen</button>
                                </form>
                                @else
                                    {{$Reservation->res_toegewezen_week}}
                                @endif
                            </td>
                            <td>
                                @if ($Reservation->res_toegewezen_week == 0)
                                    <form class="form-toewijzen" action="{{ url('/admin/allreservations/reject') }}" method="post">
                                        <input type="hidden" value="{{$Reservation->id}}" name="reservation_id"></input>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn button"> Reservering afwijzen</button>
                                    </form>
                                @else
                                    <form class="form-toewijzen" action="{{ url('/admin/allreservations/cancel') }}" method="post">
                                        <input type="hidden" value="{{$Reservation->id}}" name="reservation_id"></input>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn button"> Reservering annuleren</button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if ($Reservation->payment->payment_status == 0)
                                Huurbetaling: <span style="color: red; font-weight: 500;">Niet Betaald</span>
                                @elseif ($Reservation->payment->payment_status == 1)
                                    Huurbetaling: <span style="color: green; font-weight: 500;">Betaald</span>
                                    <span>{{ Carbon\Carbon::parse($Reservation->payment->payment_time)->format('d M Y - H:i') }}</span>
                                @elseif ($Reservation->payment->payment_status == 2)
                                    Huurbetaling: <span style="color: red; font-weight: 500;">Betaling afgebroken</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        
            {{-- @foreach ($reservations as $Reservation)
            <div class="panel panel-default">
                <div class="panel-heading-adminreserveringen" style="cursor:pointer">
                    @if (($Reservation->touristtax->tax_status == 1) && ($Reservation->payment->payment_status == 1))
                        <i class="fa fa-circle" style="color: #00abff; " aria-hidden="true"></i>
                    @elseif (($Reservation->touristtax->tax_status == 1) || ($Reservation->payment->payment_status == 1))
                        <i class="fa fa-circle" style="color: green; " aria-hidden="true"></i>
                    @elseif ($Reservation->res_status == 1)
                        <i class="fa fa-circle" style="color: orange; " aria-hidden="true"></i>
                    @elseif ($Reservation->payment->payment_status == 0)
                        <i class="fa fa-circle" style="color: red; " aria-hidden="true"></i>
                    @endif
                Reserveringsnummer: #{{$Reservation->id}} - Toegewezen: {{$Reservation->res_toegewezen_week}}
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
                        <td>{{$Reservation->res_week1}}</td>
                        <td>{{$Reservation->res_week2}}</td>
                        <td>{{$Reservation->res_week3}}</td>
                        <td>{{Crypt::decrypt($Reservation->user->firstname)}} {{Crypt::decrypt($Reservation->user->lastname)}}</td>
                        <td>{{Crypt::decrypt($Reservation->user->work_location)}}</td>
                        <td>
                            @if ($Reservation->res_toegewezen_week == 0)
                              <form method="post" class="form-toewijzen" action="{{ url('/admin/allreservations') }}">
                                  <input required="" type="text-small" size="2" value="" name="toegewezen"></input>
                                  <input type="hidden" value="{{$Reservation->id}}" name="reservation_id"></input>
                                  <input type="hidden" name="_method" value="PATCH">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <button type="submit" class="btn button"> Toewijzen</button>
                              </form>
                              @else
                                  <input required="" class="btn button" type="text-small" disabled size="2" value="{{$Reservation->res_toegewezen_week}}" name="toegewezen"></input>
                              @endif
                        </td>
                        <td>
                            @if ($Reservation->res_toegewezen_week == 0)
                                <form class="form-toewijzen" action="{{ url('/admin/allreservations/reject') }}" method="post">
                                    <input type="hidden" value="{{$Reservation->id}}" name="reservation_id"></input>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn button"> Reservering afwijzen</button>
                                </form>
                            @else
                                <form class="form-toewijzen" action="{{ url('/admin/allreservations/cancel') }}" method="post">
                                    <input type="hidden" value="{{$Reservation->id}}" name="reservation_id"></input>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn button"> Reservering annuleeren</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    {{ method_field('patch') }}
                </table>
                <div class="payment-status-adminreserveringen">
                    <div class="reservation-number">
                        @if ($Reservation->touristtax->tax_status == 0)
                              Toeristenbelasting: <span style="color: red; font-weight: 500;">Niet Betaald</span>
                            @elseif ($Reservation->touristtax->tax_status == 1)
                              Toeristenbelasting: <span style="color: green; font-weight: 500;">Betaald</span>
                              <span>{{ Carbon\Carbon::parse($Reservation->touristtax->updated_at)->format('d M Y - H:i') }}</span>
                            @elseif ($Reservation->touristtax->tax_status == 2)
                              Toeristenbelasting: <span style="color: green; font-weight: 500;">Betaling afgebroken</span>
                        @endif
                    </div>
                    <div class="reservation-number">
                        @if ($Reservation->payment->payment_status == 0)
                              Huurbetaling: <span style="color: red; font-weight: 500;">Niet Betaald</span>
                          @elseif ($Reservation->payment->payment_status == 1)
                              Huurbetaling: <span style="color: green; font-weight: 500;">Betaald</span>
                              <span>{{ Carbon\Carbon::parse($Reservation->payment->payment_time)->format('d M Y - H:i') }}</span>
                          @elseif ($Reservation->payment->payment_status == 2)
                              Huurbetaling: <span style="color: red; font-weight: 500;">Betaling afgebroken</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach --}}

        {{ $reservations->links() }}

    </div>
</div>

@endsection
