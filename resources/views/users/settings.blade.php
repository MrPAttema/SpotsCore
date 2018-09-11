@extends('layouts.app')

@section('content')
<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
<div class="container centered columns">
    <div class="column">
        <div class="col-6 col-sm-12 centered">

            <div class="margin-15">
                <h3>
                    Account instellingen
                </h3>
            </div>
    
          <div class="panel">
              <div class="panel-heading-meldingen">Verander uw wachtwoord:</div>
              <div class="panel-body">
                  <form class="user-panel top-5 bottom-10" method="post">
                    <div class="form-group{{ $errors->has('newPassword') ? ' has-error' : '' }}">
                        <label for="newPassword">Nieuw Wachtwoord (Minimaal 12 karakters)</label>
                        <div class="col-6 col-sm-12">
                            <input class="form-input" id="newPassword" type="password" class="form-control" name="newPassword" required>
                            @if ($errors->has('newPassword'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('newPassword') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('newPassword_confirmation') ? ' has-error' : '' }}">
                        <label for="password-confirm">Herhaal Wachtwoord</label>
                        <div class="col-6 col-sm-12">
                            <input class="form-input" id="password-confirm" type="password" class="form-control" name="newPassword_confirmation" required>

                            @if ($errors->has('newPassword_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('newPassword_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                      <div class="reservation-details-buttons">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          {{ method_field('PATCH') }}
                          <button type="submit" class="btn btn-primary" onClick="{{ url('/home') }}">Wijzigingen opslaan</button>
                      </div>
                    </form>
                </div>
            </div>

            {{-- <div class="panel panel-default">
                <div class="panel-heading-meldingen">Notificatie instellingen:</div>
                    <div class="panel-body-adminreserveringen">
                        {{ method_field('PATCH') }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-primary push-subscription-button"></button>
                    </div>
                </div> --}}

            <div class="panel panel-default">
                <div class="panel-heading-meldingen">Privacy instellingen:</div>
                    <div class="panel-body-adminreserveringen">
                        @if($saveloginhistory == 1)
                            <div class="form-group">
                                <label class="form-switch">
                                    <input checked type="checkbox" name="saveloginhistory">
                                    <i class="form-icon"></i> Log-in Historie opslaan
                                </label>
                                <div class="popover popover-top">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <div class="popover-container">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title h5">
                                                    Log-in Historie Opslaan
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                Als u deze optie aan zet, zal uw log-in history opgeslagen worden voor maximaal 14 dagen. Zo kunt u zien of er in wordt gelogd vanaf een apparaat of vanuit een locatie waar u niet bekend mee bent. <i>Mocht u bepaalde loginpoginen niet vertrouwen, u kunt altijd uw wachtwoord wijzigen.</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="form-group">
                                <label class="form-switch">
                                    <input type="checkbox" name="saveloginhistory">
                                    <i class="form-icon"></i> Log-in Historie opslaan
                                </label>
                                <div class="popover popover-top">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <div class="popover-container">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title h5">
                                                    Log-in Historie Opslaan
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                Als u deze optie aan zet, zal uw log-in history opgeslagen worden voor maximaal 14 dagen. Zo kunt u zien of er in wordt gelogd vanaf een apparaat of vanuit een locatie waar u niet bekend mee bent. <i>Mocht u bepaalde loginpoginen niet vertrouwen, u kunt altijd uw wachtwoord wijzigen.</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{ method_field('PATCH') }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-primary submit-btn" id="reservation-toewijs-button">Instellingen opslaan</button>
                    </div>
                </div>
            
            <div class="panel">
                <div class="panel-body">
                    <form class="user-panel" method="post">
                        <div class="reservation-details-buttons">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            {{ method_field('PATCH') }}
                            <button type="submit" class="btn btn-warning top-15 bottom-10"><i class="fa fa-trash" aria-hidden="true"></i> Account Verwijderen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
