@extends('layouts.app')

@section('content')
<div class="container columns">
    <div class="column">
        <div class="col-6 col-sm-12 centered">

            <div class="margin-15">
                <h3>
                    Opgave Toeristenbelasting
                </h3>
            </div>

            <div class="panel panel-default">
                <div class="panel-body margin-5">
                  <p class="reservation-text">U dient per overnachting het aantal personen op te geven dat in De Belboei is verbleven.</p>
                  <p class="reservation-text">Uw opgave wordt pas verwerkt nadat uw betaling binnen is voltooid.</p>
                  <span class="reservation-text">De toeristenbelasting voor 2017 is: &#8364;<b>{{$amount}}</b> p.p.p.n.</span>
                  <hr>
                    <form method="post" action="{{ action('PaymentsCore@checkPayment') }}">
                      {{ csrf_field() }}
                      <div class="form-group">
                          <label >Zaterdag op Zondag:</label>
                            <select name="za-zo" class="form-control" required>
                              <option value="" hidden="hidden">Maak uw keuze</option>
                              <option value="0">0 Personen</option>
                              <option value="1">1 Persoon</option>
                              <option value="2">2 Personen</option>
                              <option value="3">3 Personen</option>
                              <option value="4">4 Personen</option>
                              <option value="5">5 Personen</option>
                              <option value="6">6 Personen</option>
                            </select>
                      </div>
                      <div class="form-group">
                          <label for="projectname">Zondag op Maandag:</label>
                          <select name="zo-ma" class="form-control" required>
                            <option value="" hidden="hidden">Maak uw keuze</option>
                            <option value="0">0 Personen</option>
                            <option value="1">1 Persoon</option>
                            <option value="2">2 Personen</option>
                            <option value="3">3 Personen</option>
                            <option value="4">4 Personen</option>
                            <option value="5">5 Personen</option>
                            <option value="6">6 Personen</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label>Maandag op Dinsdag:</label>
                          <select name="ma-di" class="form-control" required>
                            <option value="" hidden="hidden">Maak uw keuze</option>
                            <option value="0">0 Personen</option>
                            <option value="1">1 Persoon</option>
                            <option value="2">2 Personen</option>
                            <option value="3">3 Personen</option>
                            <option value="4">4 Personen</option>
                            <option value="5">5 Personen</option>
                            <option value="6">6 Personen</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label>Dinsdag op Woensdag:</label>
                          <select name="di-wo" class="form-control" required>
                            <option value="" hidden="hidden">Maak uw keuze</option>
                            <option value="0">0 Personen</option>
                            <option value="1">1 Persoon</option>
                            <option value="2">2 Personen</option>
                            <option value="3">3 Personen</option>
                            <option value="4">4 Personen</option>
                            <option value="5">5 Personen</option>
                            <option value="6">6 Personen</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label>Woensdag op Donderdag:</label>
                          <select name="wo-do" class="form-control" required>
                            <option value="" hidden="hidden">Maak uw keuze</option>
                            <option value="0">0 Personen</option>
                            <option value="1">1 Persoon</option>
                            <option value="2">2 Personen</option>
                            <option value="3">3 Personen</option>
                            <option value="4">4 Personen</option>
                            <option value="5">5 Personen</option>
                            <option value="6">6 Personen</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label>Donderdag op Vrijdag:</label>
                          <select name="do-vrij" class="form-control" required>
                            <option value="" hidden="hidden">Maak uw keuze</option>
                            <option value="0">0 Personen</option>
                            <option value="1">1 Persoon</option>
                            <option value="2">2 Personen</option>
                            <option value="3">3 Personen</option>
                            <option value="4">4 Personen</option>
                            <option value="5">5 Personen</option>
                            <option value="6">6 Personen</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label>Vrijdag op Zaterdag:</label>
                          <select name="vrij-za" class="form-control" required>
                            <option value="" hidden="hidden">Maak uw keuze</option>
                            <option value="0">0 Personen</option>
                            <option value="1">1 Persoon</option>
                            <option value="2">2 Personen</option>
                            <option value="3">3 Personen</option>
                            <option value="4">4 Personen</option>
                            <option value="5">5 Personen</option>
                            <option value="6">6 Personen</option>
                          </select>
                      </div>
                      <hr />
                      <span class="total-text">Het totaalbedrag is: &#8364;</span><b><span id='sum'></span></b>
                      <hr>
                      <input type="hidden" id="reservation_id" name="reservation_id" value="{{$reservation_id}}">
                      <input type="hidden" id="type_id" name="type_id" value="2">
                      <input type="hidden" id="amount" name="amount" value="">
                      <button type="submit" class="btn btn-primary submit-btn" id="location-details-button"><i class="fa fa-credit-card" aria-hidden="true"></i> Betalen & afronden</button>
                    </form>
                    </div>
                </div>
        </div>
    </div>
</div>
<script>
$('select').change(function(){
    var num = 0;
    $('select :selected').each(function() {
        num += Number($(this).val() * 1.50 );
    });
      var n = num.toFixed(2);
      $('#amount').val(n);
     $("#sum").html(n);
});
</script>
@endsection
