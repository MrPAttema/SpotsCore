@extends('layouts.app')

@section('content')
<div class="container">
    <div class="column col-6 col-md-12 centered">
        <div class="margin-15">
            <h3>
                Nieuw reservering
            </h3>
        </div>

        <div class="panel reservation-step-two">
            <ul class="step">
                <li class="step-item">
                    <a href="#" class="tooltip" data-tooltip="Selecteer een boekingsjaar.">Stap 1</a>
                </li>
                <li class="step-item active">
                    <a href="#" class="tooltip" data-tooltip="Selecteer uw week(en).">Stap 2</a>
                </li>
                <li class="step-item">
                    <a href="#" class="tooltip" data-tooltip="Vul uw gegevens in.">Stap 3</a>
                </li>
            </ul>
            <div class="divider"></div>
            <form method="get" action="/reservations/new/stepthree">
                <div class="columns col-oneline col-gapless">
                    <div class="column col-10 centered">
                        <reservationsteptwo :id="{{$location->id}}" :res_year="{{$res_year}}" :ronde1="{{$ronde1}}" :ronde2="{{$ronde2}}" :weeks="{{ json_encode($weeks) }}"></reservationsteptwo>
                    </div>
                </div>
                <div class="column col-10 centered">
                    <button type="button" onclick="history.go(-1);" class="btn bottom-10"><i class="fa fa-arrow-left" aria-hidden="true"></i> Terug naar stap 1</button>
                    <button type="submit" class="btn btn-primary button-left bottom-10"><i class="fa fa-arrow-right" aria-hidden="true"></i> Verder naar stap 3</button>
                    <input type="hidden" name="res_year" value="{{$res_year}}">
                    <input type="hidden" name="location_id" value="{{$location_id}}">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
