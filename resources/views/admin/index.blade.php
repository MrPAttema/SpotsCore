@extends('layouts.admin')

@section('content')
<div class="container centered columns">
    <div class="column">

        <div class="margin-15"></div>

        <div class="col-6 col-xs-12 centered">
            <div class="panel">
                <h5 class="margin-15">Meldingen:</h5>
                <div class="panel-body-adminreserveringen">
                  Welkom in het Mijn Belboei Administratie paneel.
                </div>
            </div>
        </div>
        <div class="col-6 col-xs-12 centered">
            <div class="panel">
                <h5 class="margin-15">Statistieken:</h5>
                <div class="panel-body-adminreserveringen">
                    Huidig boekingsjaar: <b>{{$boekingsjaar}}</b>
                    <hr>
                    Aantal geregistreerde gebruikers: <b>{{count($users)}}</b>
                </div>
            </div>
        </div>

        <div class="col-6 col-xs-12 centered">
            <div class="panel">
              <h5 class="margin-15">Systeem gegevens:</h5>
                <div class="panel-body-adminreserveringen">
                    <img class="powerd_by_img" src="{{URL::asset('img/PowerdBy.svg')}}">
                    Software versie: <b>{{$currentSoftwareVersion}}</b>
                    <br>
                    API versie: <b>{{$currentAPIVersion}}</b>
                    <br>
                    Software ID: <b>{{$currentSoftwareID}}</b>
                    <br>
                    Software status: <b>{{$currentSoftwareStatus}}</b>
                    {{--  <hr>
                    Laatste Software Update: <b>20-01-2017</b>
                    <form action="{{ action('UpdateCore@checkRequest') }}" method="GET">
                        <button class="btn btn-primary">Check voor updates</button>
                    </form>  --}}
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
