@extends('layouts.app')

@section('content')
<div class="container centered columns">
    <div class="column">
        <div class="col-7 col-xs-12 centered">
            <div class="margin-15">
                <h3>
                    Uw berichten inbox
                </h3>
            </div> 

            @if (count($notifications) > 0)
                <div class="panel">
                    <div class="margin-15">
                        <table class="table table-striped table-hover">
                            <tbody>
                                @foreach ($notifications as $notification)
                                    <tr>
                                        <td class="col-6">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            <span class="log-his-span">Reserveringnummer #{{$notification['data']['reservation_id']}} aangemaakt.</span>
                                        </td>
                                        <td class="col-3">
                                            <span class="log-his-span">Aangemaakt op: <b>{{ Carbon\Carbon::parse($notification['created_at'])->format('d-m-Y') }}</b></span>
                                        </td>
                                        <td class="col-3">
                                            @if ($notification['read_at'] == NUll)
                                                <form action="/users/inbox" method="POST">
                                                    <button type="submit" class="btn btn-primary submit-btn top-5">Markeer als gelezen</button>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="notification_id" value="{{ $notification['id'] }}">
                                                </form>
                                            @else 
                                                <span class="log-his-span">Gelezen op: <b>{{ Carbon\Carbon::parse($notification['read_at'])->format('d-m-Y') }}</b></span>
                                            @endif
                                        </td>
                                    </tr>                      
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pagination">
                    {{-- {{ $notifications->links() }}			 --}}
                </div>
            @else
                <div class="panel">
                    <div class="panel-heading bottom-10 top-10">
                        <i class="fas fa-envelope-open fa-5x centered"></i>
                        <span class="empty-state-text">Deze berichtenbox is leeg.</span>
                        <span class="empty-state-text-under">Er staan helemaal geen berichten klaar.</span>
                        <span class="empty-state-text-under">Dat leest makkelijk weg!</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
