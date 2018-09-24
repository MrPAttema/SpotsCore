@extends('layouts.admin')

@section('content')
<div class="container columns">
    <div class="column">
        <div class="col-5 col-sm-12 centered">

            <div class="margin-15"></div>

            <div class="panel panel-default">
                <div class="panel-heading-meldingen">Nieuw Boekingsjaar:</div>
                <div class="panel-body-adminreserveringen">
                    Huidig boekingsjaar:<b> {{$boekingsjaar}}</b><hr>
                    <form action="{{ action('OptionsCore@newyear') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label for="year">Nieuw jaartal:</label>
                        <input name="year" type="text-small" size="4" maxlength="4"></input>
                        <br>
                        <hr>
                        <a href="#"><button class="btn btn-primary submit-btn">Nieuw boekingsjaar aanmaken</button></a>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading-meldingen">Automatisch Toewijzen:</div>
                <div class="panel-body-adminreserveringen">
                    <form action="{{ action('AdminReservationsController@autoAssign') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="#"><button name="round" value="1" class="btn btn-primary submit-btn">Ronde 1</button></a>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="#"><button name="round" value="2" class="btn btn-primary submit-btn">Ronde 2</button></a>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="#"><button name="round" value="3" class="btn btn-primary submit-btn">Ronde 3</button></a>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading-meldingen">Reservering Opties:</div>

                    <div class="panel-body-adminreserveringen">
                    <form class="form-opties-opslaan" action="{{ action('OptionsCore@updateSettings') }}" method="post">

                        @if($ronde1 == 1)
                            <div class="form-group">
                                <label class="form-switch">
                                    <input checked type="checkbox" name="ronde1">
                                    <i class="form-icon"></i> Reserveringen Ronde 1
                                </label>
                            </div>
                        @else
                            <div class="form-group">
                                <label class="form-switch">
                                    <input type="checkbox" name="ronde1">
                                    <i class="form-icon"></i> Reserveringen Ronde 1
                                </label>
                            </div>
                        @endif 

                         <div class="form-group">
                            <label for="year">Openings datum:</label>
                            <input name="year" type="datetime-local"></input>                        
                        </div>    

                        @if($ronde2 == 1)
                            <div class="form-group">
                                <label class="form-switch">
                                    <input checked type="checkbox" name="ronde2">
                                    <i class="form-icon"></i> Reserveringen Ronde 2
                                </label>
                            </div>
                        @else
                            <div class="form-group">
                                <label class="form-switch">
                                    <input type="checkbox" name="ronde2">
                                    <i class="form-icon"></i> Reserveringen Ronde 2
                                </label>
                            </div>
                        @endif 

                        <hr>

                        @if($autotoewijzen == 1)
                            <div class="form-group">
                                <label class="form-switch">
                                    <input checked type="checkbox" name="autotoewijzen">
                                    <i class="form-icon"></i> Automatisch Toewijzen
                                </label>
                            </div>
                        @else
                            <div class="form-group">
                                <label class="form-switch">
                                    <input type="checkbox" name="autotoewijzen">
                                    <i class="form-icon"></i> Automatisch Toewijzen
                                </label>
                            </div>
                        @endif
                        <i>Alleen voor ronde 3.</i>

                        <hr>

                        @if($dubbeleboekingen == 1)
                            <div class="form-group">
                                <label class="form-switch">
                                    <input checked type="checkbox" name="dubbeleboekingen">
                                    <i class="form-icon"></i> Dubbele Boekingen
                                </label>
                            </div>
                        @else
                            <div class="form-group">
                                <label class="form-switch">
                                    <input type="checkbox" name="dubbeleboekingen">
                                    <i class="form-icon"></i> Dubbele Boekingen
                                </label>
                            </div>
                        @endif
                        
                        <i>Het toestaan van dubbele boeking in het huidige boekingsjaar.</i>
                        
                        <hr>

                        {{ method_field('PATCH') }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-primary submit-btn" id="reservation-toewijs-button">Instellingen opslaan</button>
                    </form>
                    
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading-meldingen">Systeem Opties:</div>

                    <div class="panel-body-adminreserveringen">
                    <form class="form-opties-opslaan" action="{{ action('OptionsCore@updateSettings') }}" method="post">

                        @if($autoarchive == 1)
                            <div class="form-group">
                                <label class="form-switch">
                                    <input checked type="checkbox" name="autoarchive">
                                    <i class="form-icon"></i> Automatisch Archiveren
                                </label>
                                <div class="popover popover-top">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <div class="popover-container">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title h5">
                                                    Automatisch Archiveren
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                Wij raden aan automatisch archiveren altijd aan te laten. Automatisch archiveren zorgt er voor dat uw database met huidige reserveringen snel en geoptimaliseerd blijft en reserveringen ouder dan twee jaar in het archief komen te staan.
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        @else
                            <div class="form-group">
                                <label class="form-switch">
                                    <input type="checkbox" name="autoarchive">
                                    <i class="form-icon"></i> Automatisch Archiveren
                                </label>
                                <div class="popover popover-top">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <div class="popover-container">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title h5">
                                                    Automatisch Archiveren
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                Wij raden aan automatisch archiveren altijd aan te laten. Automatisch archiveren zorgt er voor dat uw database met huidige reserveringen snel en geoptimaliseerd blijft en reserveringen ouder dan twee jaar in het archief komen te staan.
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        @endif

                        @if($facebookauth == 1)
                            <div class="form-group">
                                <label class="form-switch">
                                    <input checked type="checkbox" name="facebookauth">
                                    <i class="form-icon"></i> Facebook Authenticatie
                                </label>
                                <div class="popover popover-top">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <div class="popover-container">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title h5">
                                                    Facebook Authenticatie
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                Als u deze optie aan zet maakt u het voor gebruikers mogelijk in te loggen door het gebruik van hun Facebook account.
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        @else
                            <div class="form-group">
                                <label class="form-switch">
                                    <input type="checkbox" name="facebookauth">
                                    <i class="form-icon"></i> Facebook Authenticatie
                                </label>
                                <div class="popover popover-top">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <div class="popover-container">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title h5">
                                                    Facebook Authenticatie
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                Als u deze optie aan zet maakt u het voor gebruikers mogelijk in te loggen door het gebruik van hun Facebook account.
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        @endif

                        @if($incltouristtax == 1)
                            <div class="form-group">
                                <label class="form-switch">
                                    <input checked type="checkbox" name="incltouristtax">
                                    <i class="form-icon"></i> Toeristenbelasting Excl
                                </label>
                                <div class="popover popover-top">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <div class="popover-container">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title h5">
                                                    Toeristenbelasting Exclusief
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                Als u deze optie aan zet dan zullende totaalprijzen exclusief toeristenbelasting zijn. De toeristenbelasting kan per locatie verschillend zijn.
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        @else
                            <div class="form-group">
                                <label class="form-switch">
                                    <input type="checkbox" name="incltouristtax">
                                    <i class="form-icon"></i> Toeristenbelasting Excl
                                </label>
                                <div class="popover popover-top">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <div class="popover-container">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title h5">
                                                    Toeristenbelasting Exclusief
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                Als u deze optie aan zet dan zullende totaalprijzen exclusief toeristenbelasting zijn. De toeristenbelasting kan per locatie verschillend zijn.
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        @endif
                        <select required="" class="" name="taxtype">
                            @if ($taxtype == null)
                                <option selected hidden value="">Maak een keuze</option>
                            @else
                                <option selected hidden value="{{$taxtype}}">{{$taxtype}}</option>
                            @endif
                            <option value='per week'>Per Week</option>
                            <option value='p.p.p.n'>Per Persoon Per Nacht</option>
                        </select>

                        <hr>

                        {{ method_field('PATCH') }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-primary submit-btn" id="reservation-toewijs-button">Instellingen opslaan</button>
                    </form>
                    
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading-meldingen">Encrypt alle gebruikers</div>

                 <div class="panel-body-adminreserveringen">
                    <form class="form-horizontal" method="POST" action="{{ route('user_encrypt') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Uitvoeren
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>        

        </div>
    </div>
</div>

@endsection
