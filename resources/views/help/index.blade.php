@extends('layouts.app')

@section('content')
<div class="container columns">
    <div class="column ">

        <div class="margin-15 col-6 col-xs-12 centered">
            <h3>
                Help & Veelgestelde vragen
            </h3>
        </div>
        
        <div class="panel col-6 col-xs-12 centered">
            <div class="panel-body-voorwaarden-privacy">
                <p></p>
                  <p>Laatst gewijzigd: 23 februari 2017</p>
                  <p>
                    Heeft u een vraag kijk dan goed bij het juiste hoofdstuk hieronder. Kijk goed of een antwoord op uw vraag er tussen staat. Dit voorkomt lange e-mails voor veelal een klein probleem.
                  </p>
                  <br>
                <h4>1. Reserveringen</h4>
                Onderstaand vind u veelgestelde vragen over reserveringen, en het daarbijhorende process.
                <p>
                  <ul>
                    <li><b>Vraag: De week die ik wil reserveren staat er niet tussen.</b> Antwoord: Indien dit het geval is tijdens de "Open reservering" (herkenbaar aan dit symbool <img class="get-direct" src="{{URL::asset('img/direct.svg')}}"/>) wil dat zeggen dat er iemand anders voor u is geweest die deze week al heeft gereserveerd.</li>
                    <li><b>Vraag: Ik krijg een e-mail over een statuswijziging, wat houd dat in?</b> Antwoord: Indien u een reservering maakt krijg u een e-mail, in deze email staat een link zodat u de status van uw reserving kunt bekijken.</li>
                  </ul>

                <br>

                <h4>2. Reservering status:</h4>
                Op de overzichtpagina van "Mijn reserveringen" staat, indien u een reservering heeft gedaan een status. Hieronder vind u wat deze betekend.
                <ul>
                  <li><b>Vraag: Wat betekend "<span style="color: green;">Week toegewezen</span>"?</b> Antwoord: De week die u bij uw reservering heeft opgegeven is aan u toegewezen.</li>
                  <li><b>Vraag: Wat betekend "<span style="color: orange;">Wachten op toewijzing</span>"?</b> Antwoord: Deze status ziet u wanneer u een nieuwe aanvraag heeft gedaan. De aanvraag is in behandeling genomen, het kan enkele dagen duren voordat deze status veranderd.</li>
                  <li><b>Vraag: Wat betekend "<span style="color: red;">Reservering afgewezen</span>"?</b> Antwoord: Deze status betekend dat de week die u heeft opgegeven niet (meer) beschikbaar is.</li>
                  <li><b>Vraag: Wat betekend "<span style="color: red;">Reservering geannuleerd</span>"?</b> Antwoord: Deze status ziet u omdat uw reservering per direct is geannuleerd, uw reservering is dan ook niet meer geldig.</li>
                </ul>

                <br>

                <h4>3. Betalingen</h4>

                <ul>
                  <li><b>Vraag: Ik heb een week toegewezen gekregen en wil graag de huur betalen, hoe kan ik dit doen?</b> Antwoord: U kunt op de pagina "Mijn reserveringen" naar de openstaande reservering gaan en op "Huur Betaling" klikken.</li>
                  <li><b>Vraag: Is het mogelijk een bedrag over te maken op een rekeningnummer?</b> Antwoord: Helaas is dit niet meer mogelijk sinds 1 september 2017. Al onze betalingsadministratie wordt automatisch verwerkt.</li>
                  <li><b>Vraag: Ik heb een betaling gedaan, maar de status van mijn huurbetaling staat nog op "<span style="color: red;">Niet Betaald</span>"?</b> Antwoord: Wij wachten op uw bank om te zien of uw betaling is door gekomen. Over het agemeen is dit direct. Mocht dit niet het geval zijn dan kunt u over een aantal minuten nog eens bij uw betalingen kijken.</li>
                  <li><b>Vraag: Ik heb een betaling gedaan, maar de status van mijn toeristenbelasting staat nog op "<span style="color: red;">Niet Betaald</span>"?</b> Antwoord: Wij wachten op uw bank om te zien of uw betaling is door gekomen. Over het agemeen is dit direct. Mocht dit niet het geval zijn dan kunt u over een aantal minuten nog eens bij uw betalingen kijken.</li>
                  <li>Als je een betaling maakt op Mijn Belboei, gaat deze transactie via Mollie B.V.</li>
                </ul>

                <br>

                  <h4>4. Annuleringsvoorwaarden</h4>

                  <ul>
                    <li>Accommodatiekosten (het totale nachttarief dat je moet betalen) worden zoals hieronder beschreven onder bepaalde omstandigheden terugbetaald.</li>
                    <li>Als er een klacht is, moet Mijn Belboei binnen 24 uur na het inchecken op de hoogte worden gesteld.</li>
                    <li>Een reservering is pas officieel geannuleerd wanneer je op de annuleerknop van de annulerings bevestigingspagina klikt, deze vind je op je Dashboard > Je Reizen > Wijzigen of Annuleren.</li>
                    <li>Toepasbare belastingen zullen worden ingehouden en afgedragen.</li>
                  </ul>
                  <hr>
                    <a class="terms" href="{{ url('/terms') }}">Voorwaarden & Privacy</a>
                    <br>
                    <a class="terms" href="{{ url('/terms/cancellation') }}">Annuleringsvoorwaarden</a>
                  <hr>
            </div>
        </div>
    </div>
</div>
@endsection
