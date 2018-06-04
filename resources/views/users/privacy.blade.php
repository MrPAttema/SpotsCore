@extends('layouts.app')

@section('content')
<div class="container centered columns">
    <div class="column">
        <div class="col-6 col-xs-12 centered">

          <div class="margin-15">
              <h3>
                  Uw log-in historie
              </h3>
          </div>
    
            <div class="panel">
                <div class="margin-15">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Apparaat OS / Browser</th>
                                <th>Locatie</th>
                                <th>Laaste Activiteit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>
                                        @if ($log->platform == "Windows 10")
                                            <i class="fa fa-desktop" aria-hidden="true"></i>
                                        @elseif ($log->platform == "Android")
                                            <i class="fa fa-mobile" aria-hidden="true"></i>
                                        @endif
                                        <span class="log-his-span">{{$log->platform}} / {{$log->browser}}</span>
                                    </td>
                                    <td>
                                        <span class="log-his-span">--</span>
                                    </td>
                                    <td>
                                        <span class="log-his-span">{{ Carbon\Carbon::parse($log->created_at)->format('d F Y - H:i') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $logs->links() }}
                    Als je iets vreemds ziet, wijzig je wachtwoord.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
