@extends('layouts.app')

@section('content')
<div class="container columns margin-15">
    <div class="col-8 col-sm-12 centered">
        @foreach($reservations as $reservation)
            <div class="text-center">
                <button type="button" name="submit" class="print" onclick="myFunction()"><i class="fa fa-print" aria-hidden="true"></i> Printen</button>
                <h2>Huurtoeslag Factuur</h2>
            </div>

            <hr>

            <div class="columns col-oneline">
                <div class="column col-4">
                    <div class="panel height">
                        <h6 class="margin-15">Reservering Details</h6>
                        <div class="panel-body">
                            <strong>Reserveringsnummer: </strong>{{$reservation->id}}<br>
                            <strong>Aangevraagd op: </strong>{{ Carbon\Carbon::parse($reservation->created_at)->format('d M Y - H:i') }}<br>
                            <strong>Toegewezen week: </strong>{{$reservation->res_toegewezen_week}}<br>
                            <strong>Boekingsjaar: </strong>2017<br>
                            <strong>Locatie: </strong>{{$reservation->location->location_name}}, {{$reservation->location->location_location}}<br>
                        </div>
                    </div>
                </div>
        @endforeach
                <div class="column col-4">
                    <div class="panel height">
                        <h6 class="margin-15">Betalings Informatie</h6>
                        <div class="panel-body">
                            <strong>Betalingsstatus:</strong>
                                @if (count($reservation->payment->payment_status) == 0)
                                    Niet Voldaan
                                @else
                                    Voldaan
                                @endif
                            <br>
                            <strong>Betaald op:</strong> {{ Carbon\Carbon::parse($reservation->payment->payment_time)->format('d M Y - H:i') }}<br>
                            <strong>Betalings ID:</strong> {{$reservation->payment->id}}<br>
                        </div>
                    </div>
                </div>
                <div class="column col-4">
                    <div class="panel height">
                        <h6 class="margin-15">Gegevens Reserveerder</h6>
                        <div class="panel-body">
                            <strong>Naam:</strong> {{$reservation->user->firstname}} {{$reservation->user->lastname}}<br>
                            <strong>Adres:</strong> {{$reservation->user->adress}}<br>
                            <strong>Woonplaats:</strong> {{$reservation->user->city}}<br>
                            <strong>Telefoonnummer:</strong> {{$reservation->user->phone}}<br>
                            <strong></strong><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-8 col-sm-12 centered">
        <!-- <div class="barcode">
            {!!DNS2D::getBarcodeSVG("{{$reservation->payment->id}}", "DATAMATRIX")!!}
        </div> -->
        <p>Beste heer/ mevrouw {{$reservation->lastname}},</p>
        <br>
        <p>Wij willen u hartelijk danken voor uw reservering op Mijn Belboei.</p>
        <p>Hier onder ziet u een overzicht van uw kosten, ook kunt u de status van uw betaling zien.
        De betaling voor de huur van de Belboei dient uiterlijk twee weken voor vertek te zijn voldaan. Doet u dit niet, dan zal uw reservering automatisch worden geannuleerd en zal de aan u toegewezen week opnieuw ter beschikking worden gesteld.<sup>1</sup></p>
        <p>Bovenaan deze pagina kunt u deze factuur afdrukken voor eventuele eigen administratie.</p>
        <p><i>Na verblijf dient u de opgaaf voor de toeristenbelatsing te voltooien.</i></p>
        <br>
        <p>Heeft u reeds uw betaling voldaan, dan wensen wij u een prettig verblijf toe op Vlieland.</p>
        <br>
    </div>
    
    <div class="col-8 col-sm-12 centered">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="text-center">Kosten overzicht</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <td><strong>Verblijfplaats</strong></td>
                                <td class="text-center"><strong>Prijs</strong></td>
                                <td class="text-center"><strong>Aantal</strong></td>
                                <td class="text-center"><strong>Totaal</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$reservation->location->location_name}}, {{$reservation->location->location_location}}</td>
                                <td class="text-center">€{{$reservation->location->location_price}}</td>
                                <td class="text-center">1 week</td>
                                <td class="text-center">€{{$reservation->location->location_price}}</td>
                            </tr>
                            <tr>
                                <td class="highrow"></td>
                                <td class="highrow"></td>
                                <td class="highrow text-center"><strong>Subtotaal</strong></td>
                                <td class="highrow text-center">€{{$reservation->location->location_price}}</td>
                            </tr>
                            <tr class="total_price">
                                <td class="emptyrow"></td>
                                <td class="emptyrow"></td>
                                <td class="emptyrow text-center"><strong>Totaal</strong></td>
                                <td class="emptyrow text-center">€{{$reservation->location->location_price}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-8 col-sm-12 centered">
        <h4 class="centered">Mijn Belboei</h4>
        <hr>
        <div class="footer-under">
            <ul>
                <p>De kosten van deze factuur zijn inclusief BTW. <sup>1</sup>Annuleringsvoorwaarden: Bepaalde vergoedingen en belastingen zijn mogelijk niet-restitueerbaar. Ga <a href="/terms/cancellation">hierheen</a> voor meer informatie.</p>
                <p><sup>2</sup> Mijn Belboei heeft Mollie B.V. als betaalagent. Dit betekent alle betalingen via dit systeem zullen gaan en extern verwerkt zullen worden. Mijn Belboei is niet aansprakelijk voor eventuele foutive betalingen. Controller uw betalingsdata altijd goed. Terugbetalingsverzoeken zullen in overeenstemming worden verwerkt met de annuleringsvoorwaarden van Mijn Belboei.</p>
                <br>
                <p>Mijn Belboei is onderdeel van Stichting Personeelsbelangen Oranjeoord, KvK 41004737, Achlumerdijk 2, 8862 AJ, HARLINGEN.</p>
            </ul>
        </div>
    </div>
</div>

<style>
    .container{
    font-weight: 400;
    }
    b, strong {
        font-weight: 700;
    }
    .pay{
        float: right;
        background: green;
        color: white;
        padding: 6px 15px;
        border-style: none;
        border-radius: 5px;
    }
    .print{
        float: right;
        background: white;
        color: black;
        padding: 6px 15px;
        border-style: solid;
        border-width: thin;
        border-color: #b8b8b8;
        border-radius: 5px;
    }
    .height {
        min-height: 200px;
    }
    tr.total_price {
        background: #e8e8e8;
        font-size: 18px;
    }

    .icon {
        font-size: 35px;
        color: #95cf58;
    }
    .barcode {
        float: right;
        height: 0px;
    }
    .iconbig {
        font-size: 77px;
        color: #95cf58;
    }

    .table > tbody > tr > .emptyrow {
        border-top: none;
    }

    .table > thead > tr > .emptyrow {
        border-bottom: none;
    }

    .table > tbody > tr > .highrow {
        border-top: 3px solid;
    }

</style>
<script>
    function myFunction() {
        window.print();
    }
</script>
@endsection
