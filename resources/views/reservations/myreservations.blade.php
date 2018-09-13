@extends('layouts.app')

@section('content')
<div class="container columns centered col-oneline">
    <div class="column col-6 col-xs-12 centered top-10">
        <h3>
            Open reserveringen
        </h3>
    </div>
</div>
<div class="container columns centered">
	<div class="column col-6 col-xs-12 centered">
		@empty ($reservations)

			<div class="panel">
				<div class="panel-heading">
					<img class="empty-state" src="{{URL::asset('img/reservation_empty.svg')}}"/>
					<span class="empty-state-text">Ohnee! Wij kunnen geen reserveringen vinden.</span>
					<span class="empty-state-text-under">U heeft nog geen reservering gemaakt.</span>
					<span class="empty-state-text-under">Klik hier onder op de knop om uw eerste reservering te maken.</span>
				</div>
				<div class="panel-body">
					<form class="bottom-10 top-10" action="{{ url('/accommodations/all') }}">
						<button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Maak een nieuwe reservering</button>
					</form>
				</div>
			</div>

		@else

		@foreach ($reservations as $Reservation)
			<div class="panel columns">
				<div class="column col-12 col-xs-12">
                    <div class="margin-5">
                        <h2>
                            {{$Reservation->location->location_name}}, {{$Reservation->location->location_location}}
                        </h2>
                    </div>
                    <div class="columns col-oneline">
                        <div class="column col-4 col-xs-12 panel-body">
                            <span>
                                Reserveringsnummer: <b>#{{$Reservation->reservation_id}}</b>
                            </span>
                            <br>
                            <span>
                                Boekingsjaar: <b>{{$Reservation->res_year}}</b>
                            </span>
                            <br>
                            <span>
                                @if ($Reservation->payment->payment_status == 0)
                                    Huurbetaling: <span class="text-error text-mid">Niet Betaald</span>
                                @elseif ($Reservation->payment->payment_status == 1)
                                    Huurbetaling: <span class="text-checked text-mid">Betaald</span>
                                @elseif ($Reservation->payment->payment_status == 2)
                                    Huurbetaling: <span class="text-error text-mid">Betaling afgebroken</span>
                                @endif
                            </span>
                            <br>
                            <span>
                                @if ($Reservation->touristtax->tax_status == 0)
                                    Toeristenbelasting: <span class="text-error text-mid">Niet Betaald</span>
                                @elseif ($Reservation->touristtax->tax_status == 1)
                                    Toeristenbelasting: <span class="text-checked text-mid">Betaald</span>
                                @elseif ($Reservation->touristtax->tax_status == 2)
                                    Toeristenbelasting: <span class="text-error text-mid">Betaling afgebroken</span>
                                @endif
                            </span>
                            <br>
                            <span>
                                @if ($Reservation->res_status == 0)
                                    Status: <span class="text-warning text-mid">Wachten op toewijzing</span>
                                @elseif ($Reservation->res_status == 1)
                                    Status: <span class="text-checked text-mid">Week {{$Reservation->res_toegewezen_week}} toegewezen</span>
                                @elseif ($Reservation->res_status == 2)
                                    Status: <span class="text-error text-mid">Reservering afgewezen</span>
                                @elseif ($Reservation->res_status == 3)
                                    Status: <span class="text-error text-mid">Reservering geannuleerd</span>
                                @endif
                            </span>
                        </div>						
                
                        <div class="column col-8 col-xs-12 panel-body">
                            <span class="trip-in-out-data">
                                @if ($Reservation->res_status == 1)
                                    @php
                                        $reservationID = $Reservation->id;
                                        $locationEnterDay = $Reservation->location->change_day;
                                        if ($locationEnterDay == 6) {
                                            \Carbon\Carbon::setWeekStartsAt(\Carbon\Carbon::SATURDAY);
                                            \Carbon\Carbon::setWeekEndsAt(\Carbon\Carbon::SATURDAY);
                                        } elseif ($locationEnterDay == 5) {
                                            \Carbon\Carbon::setWeekStartsAt(\Carbon\Carbon::FRIDAY);
                                            \Carbon\Carbon::setWeekEndsAt(\Carbon\Carbon::FRIDAY);
                                        } 

                                        $carbon = \Carbon\Carbon::now();
                                        
                                        $carbon->setISODate($Reservation->res_year, $Reservation->res_toegewezen_week);
                                        $enterDate = $carbon->startOfWeek()->format('d-m-Y');
                                        $exitDate = $carbon->addWeek()->format('d-m-Y');
                                    @endphp
                                    <div id="trip-data-checkin">
                                        <div class="trip-data-text">
                                            Aankomst:
                                        </div>
                                        {{-- Zaterdag in week: {{$Reservation->res_toegewezen_week-1}} --}}
                                        <p>Aankomst na <b>{{$Reservation->location->location_entertime}}</b><br>
                                        op <b>{{$enterDate}}</b></p>
                                    </div>
                                    <div id="trip-data-checkout">
                                            <div class="trip-data-text">
                                                Vertrek:
                                            </div>
                                        {{-- Zaterdag in week: {{$Reservation->res_toegewezen_week}} --}}
                                        <p>Vertrek voor <b>{{$Reservation->location->location_exittime}}</b><br>
                                        op <b>{{$exitDate}}</b></p>
                                    </div>
                                @endif
                            </span>
                        </div>
                    </div>	
<!-- 				<div class="col-6">
						<img class="img-responsive" src="{{URL::asset('img/vlieland1.jpg')}}"/>
					</div> -->
				</div>
				<div class="divider"></div>
				<div class="column margin-5">
					<div class="reservation-details-buttons">

							@if (($Reservation->res_status == 0) || ($Reservation->res_status == 2))
								<form method="post" action="/reservations/myreservations/delete">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" id="reservation_id" name="reservation_id" value="{{$Reservation->id}}">
									<button class="btn col-xs-12"><i class="fa fa-ban" aria-hidden="true"></i> Reservering annuleren</button>
								</form>
							@else 
								<!-- NIETS LATEN DOEN -->
							@endif

						<form method="post">		
							@if (($Reservation->res_status == 1) && ($Reservation->payment->payment_status == 0) || ($Reservation->payment->payment_status == 2))
								<input type="hidden" id="reservation_id" name="reservation_id" value="{{$Reservation->id}}">
								<button type="submit" class="btn btn-primary submit-btn col-xs-12"><i class="fa fa-credit-card" aria-hidden="true"></i> Huur betalen</button>
							@endif
							    {{ csrf_field() }}
						</form>
                        
                        @if ($touristTax == 1)
                            @if ($Reservation->payment->payment_status == 1)
                                <form  method="post" action="/invoice/receipt">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="reservation_id" name="reservation_id" value="{{$Reservation->id}}">
                                    <input type="hidden" id="location_id" name="location_id" value="{{$Reservation->location_id}}">
                                    <button type="submit" class="btn col-xs-12"><i class="fa fa-file-alt"></i> Huurtoeslag factuur #{{$Reservation->id}}</button>
                                </form>
                            @endif

                            @if ($Reservation->touristtax->tax_status == 1)
                                <form  method="post" action="/invoice/taxreceipt">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="reservation_id" name="reservation_id" value="{{$Reservation->id}}">
                                    <input type="hidden" id="location_id" name="location_id" value="{{$Reservation->location_id}}">
                                    <button type="submit" class="btn col-xs-12"><i class="fa file-alt"></i> Toeristenbelasting factuur #{{$Reservation->id}}</button>
                                </form>
                            @endif

                            <form method="post" action="{{ action('TouristtaxController@index') }}">
                                {{ csrf_field() }}
                                @if (($Reservation->res_status == 0) || ($Reservation->res_status == 1) && ($Reservation->touristtax->tax_status == 0) || ($Reservation->touristtax->tax_status == 2))
                                    <input type="hidden" id="reservation_id" name="reservation_id" value="{{$Reservation->id}}">
                                    <input type="hidden" id="type_id" name="type_id" value="2">
                                    <button type="submit" class="btn submit-btn col-xs-12"><i class="fa fa-users" aria-hidden="true"></i> Toeristenbelasting opgeven</button>
                                @elseif ($Reservation->res_status == 3)
                                    <!-- NIETS LATEN DOEN -->
                                @else
                                    <!-- NIETS LATEN DOEN -->
                                @endif
                            </form>
                        @endif
						<button class="btn modal-open"><i class="fa fa-info" aria-hidden="true"></i> Details</button>

					</div>
				</div>

				<div class="modal">
		            <div class="modal-overlay"></div>
		                <div class="modal-container">
		                    <div class="modal-header">
		                        <button class="btn btn-clear modal-clear float-right"></button>
		                        <div class="modal-title h5">Informatie</div>
		                    </div>
		                    <div class="modal-body">
	                        	<span>
									Aanvraagtijd: <b>{{ Carbon\Carbon::parse($Reservation->created_at)->format('d M Y - H:i') }}</b>
								</span>
								<div id="reservation-weeks-total">
									Aangevraagde voorkeursweken:
									<div id="reservation-week">
										@if ($Reservation->res_week1 > 0)
												<span>Keuze 1:<b> Week {{$Reservation->res_week1}}</b></span>
										@endif
									</div>
									<div id="reservation-week">
										@if ($Reservation->res_week2 > 0)
												<span>Keuze 2:<b> Week {{$Reservation->res_week2}}</b></span>
										@endif
									</div>
									<div id="reservation-week">
										@if ($Reservation->res_week3 > 0)
												<span>Keuze 3:<b> Week {{$Reservation->res_week3}}</b></span>
										@endif
									</div>
									<div id="reservation-week">
										@if ($Reservation->res_week4 > 0)
												<span>Keuze 4:<b> Week {{$Reservation->res_week4}}</b></span>
										@endif
									</div>
								</div>
		                    </div>
		                    <div class="modal-footer">
		                        Bijgewerkt op: <b>{{ Carbon\Carbon::parse($Reservation->updated_at)->format('d M Y - H:i') }}</b>
		                    </div>
		                </div>
		            </div>
	           	</div>
			@endforeach
		
		@endif

		<div class="pagination">
			{{ $reservations->links() }}			
		</div>

		
		</div>
	</div>
</div>
<script type="text/javascript">
	$('select').on('change', function() {
		window.location=( this.value );
	})
</script>
@endsection
