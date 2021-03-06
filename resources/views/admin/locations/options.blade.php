@extends('layouts.admin')

@section('content')
<div class="container columns centered col-oneline">
    <div class="column col-12">
        <div class="margin-15">
            <h3>
                Locatiebeheer
            </h3>
        </div>
    </div>
</div>
<div class="container">
    <div class="columns">
        @foreach($locations as $location)
            <div class="column col-4 col-xs-12">
                <div class="card margin-15">
                    <div class="card-header">
                        <div class="card-title h5">{{$location->location_name}}, {{$location->location_location}}</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ URL::to('/media/upload') }}" method="post" enctype="multipart/form-data">
                            <label>Select image to upload:</label>
                            <input class="btn" type="file" name="file" id="file">
                            <input class="btn" type="submit" value="Upload" name="submit">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        </form>
                        <form method="post" action="/reservations/new">

                            <label for="email">Laagseizoen prijs: &#8364;</label>
                            <input class="form-input" type="text" name="adress" value="{{$location->location_price}}">

                            <label for="email">Hoogseizoen prijs: &#8364;</label>
                            <input class="form-input" type="text" name="adress" value="{{$location->location_price_high}}">

                            <label for="email">Toeristenbelasting: &#8364;</label>
                            <input class="form-input" type="text" name="adress" value="{{$location->location_tax}}">

                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input name="location_id" type="hidden" value="{{$location->id}}"></input>
                            {{ method_field('PATCH') }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-primary submit-btn" id="reservation-toewijs-button">Opslaan</button>
                        </div>
                    </div>         
                </form>                   
            </div>
        @endforeach
    </div>
</div>

@endsection
