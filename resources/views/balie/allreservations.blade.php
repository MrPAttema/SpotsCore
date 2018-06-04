@extends('layouts.balie')

@section('content')
<div class="container columns">
	  <div class="column">
		<div class="col-6 col-sm-12 centered">

		<!-- <div class="search_bar">
			<form class="navbar-form" action="/admin/allreservations" method="post" role="search">
				<div class="input-group">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input autofocus type="text" class="search" placeholder="Zoek naar een Reservering" name="keyword">
					<div class="input-group-btn">
						<button class="btn btn-default search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
					</div>
				</div>
			</form>
		</div> -->

		<div class="margin-15"></div>
		
		@foreach ($reservations as $Reservation)
			<div class="panel panel-default">
				<div class="panel-heading-adminreserveringen" style="cursor:pointer">
				@if ($Reservation->payment->payment_status == 1)
					<i class="fa fa-circle" style="color: green; "aria-hidden="true"></i>
				@elseif ($Reservation->payment->payment_status == 0)
					<i class="fa fa-circle" style="color: red; "aria-hidden="true"></i>
				@endif Toegewezen week: #{{$Reservation->res_toegewezen_week}}</div>
				<div class="panel-body-adminreserveringen" style="display:none;">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Naam</th>
								<th>Tel Nummer</th>
							</tr>
						</thead>
						<tbody>
							<tr class="active">
								<td>{{$Reservation->user->firstname}} {{$Reservation->user->lastname}}</td>
								<td>{{$Reservation->user->phone}}</td>
							</tr>
						</tbody>
					</table>
					<br>
					<div class="payment-status-adminreserveringen">
						@if ($Reservation->payment->payment_status == 0)
								Huurbetaling: <span style="color: red; font-weight: 500;">Niet Betaald</span>
							@elseif ($Reservation->payment->payment_status == 1)
								Huurbetaling: <span style="color: green; font-weight: 500;">Betaald</span>
								<span>{{ Carbon\Carbon::parse($Reservation->payment->payment_time)->format('d M Y - H:i') }}</span>
							@elseif ($Reservation->payment->payment_status == 2)
								Huurbetaling: <span style="color: red; font-weight: 500;">Betaling afgebroken</span>
						@endif
					</div>
					<div>
						<form class="form-toewijzen" action="{{ url('/balie/update') }}" method="post">
						@if ($Reservation->payment->payment_status == 0)
								<span><b>Sleuteluitgifte niet mogelijk. Huur is niet betaald.</b></span>
							@elseif ($Reservation->payment->payment_status == 1)
								<select class="input-short" name="key_id">
									@foreach ($keys as $key)
										@if ($key->key_status == 0)
											<option value="{{$key->key_id}}">{{$key->key_id}} - {{$key->key_name}}</option>
										@else
											<!-- Niets Doen -->
										@endif
									@endforeach
								</select>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<button type="submit" class="btn btn-primary">Sleuteluitgifte registreren</button>
							@elseif ($Reservation->payment->payment_status == 2)
								<span><b>Sleuteluitgifte niet mogelijk. Huur is niet betaald.</b></span>
					  	@endif
					  	</form>
					</div>
				</div>
			</div>
			@endforeach

			{{ $reservations->links() }}
		</div>
	</div>
</div>

@endsection
