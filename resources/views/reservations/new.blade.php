@extends('layouts.app')

@section('content')
<div class="container">
    <div class="column col-6 col-xs-12 centered">

        <div class="margin-15">
            <h3>
                Nieuw reservering
            </h3>
        </div>

        <div class="panel">
            <ul class="step">
                <li class="step-item active">
                    <a href="#" class="tooltip" data-tooltip="Selecteer een boekingsjaar.">Stap 1</a>
                </li>
                <li class="step-item">
                    <a href="#" class="tooltip" data-tooltip="Selecteer uw week(en).">Stap 2</a>
                </li>
                <li class="step-item">
                    <a href="#" class="tooltip" data-tooltip="Vul uw gegevens in.">Stap 3</a>
                </li>
            </ul>
            <div class="divider"></div>
            <div class="columns col-oneline col-gapless">
                <div class="column col-6 col-xs-12">
                    @foreach ($location as $Location)
                    <form class="" action="/reservations/new/steptwo/" method="get">
                            @if (($autotoewijzen) == 0)
                                <div class="panel-heading-accomodation"><h2>{{$Location->location_name}}, {{$Location->location_location}}</h2>
                            @else
                            <div class="panel-heading-accomodation"><h2>{{$Location->location_name}}, {{$Location->location_location}}</h2> 
                            <div class="get-direct-text"><i class="fa fa-bolt fa-lg" aria-hidden="true"></i> Open reservering, reserveer een overgebleven week.</div>
                            @endif
                        </div>

                        <div class="panel-body">
                            {{$Location->location_discription}}
                        </div>

                        <div class="panel-body reservation-step-one">
                        <hr>
                        <p>Kies het jaar waarvoor u een boeking wilt maken. In de volgende stap kunt u uw voorkeursweken voor de reservering door geven.</p>
                        <hr>
                        <div class="form-group">
                            <label for="res_year">Selecteer een jaar:</label>
                            <select  name="res_year">
                                <option selected hidden value="">Maak een keuze</option>
                                @if (($res_yearOld) > 0)
                                    <option value="{{$res_yearOld}}">{{$res_yearOld}}</option>
                                    <option value="{{$res_year}}">{{$res_year}}</option>
                                @else
                                    <option value="{{$res_year}}">{{$res_year}}</option>
                                @endif
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary post_year submit-btn bottom-10"><i class="fa fa-arrow-right" aria-hidden="true"></i> Verder naar stap 2</button>
                        <input type="hidden" name="location_id" value="{{$Location->id}}">
                        </div>
                    </form>
                    @endforeach
                </div>
                <div class="column col-6 col-xs-12">
                    <img class="location-image" src="/img/locations/{{$Location->location_name}}/{{$Location->location_name}}2.jpg">
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
