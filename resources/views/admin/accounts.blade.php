@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="search_bar">

  </div>
    <div class="column">
    
        <div class="centered col-6 col-xs-12 margin-15">

        <div class="margin-15">
            <h3>
                Alle gebruikers
            </h3>
        </div>
          @foreach ($users as $User)
            <div class="panel panel-default">
              <div class="panel-heading-adminreserveringen" style="cursor:pointer">
                  {{$User->lastname}}, {{$User->firstname}} #{{$User->id}}
              </div>
              <div class="panel-body-adminreserveringen" style="display:none;">
                      <div class="form-group">
                          <label for="email">Voornaam:</label>
                          <input required disabled type="text" name="firstname" value="{{$User->firstname}}">
                      </div>
                      <div class="form-group">
                          <label for="email">Achternaam:</label>
                          <input required disabled type="text" name="lastname" value="{{$User->lastname}}">
                      </div>
                      <div class="form-group">
                          <label for="email">E-mailadres:</label>
                          <input required disabled type="text" name="email" value="{{$User->email}}">
                      </div>
                      <div class="form-group">
                          <label for="email">Telefoon:</label>
                          <input required disabled type="text" name="phone" maxlength="10" value="{{$User->phone}}" onkeypress="return isNumberKey(event)"/>
                      </div>
                      <div class="form-group">
                          <label for="email">Adres:</label>
                          <input required disabled type="text" name="adress" value="{{$User->adress}}">
                      </div>
                      <div class="form-group">
                          <label for="email">Postcode:</label>
                          <input required disabled type="text" name="postcode" value="{{$User->postcode}}">
                      </div>
                      <div class="form-group">
                          <label for="email">Woonplaats:</label>
                          <input required disabled type="text" name="city" value="{{$User->city}}">
                      </div>
                      <div class="form-group">
                          <label for="email">Werkomgeving:</label>
                            <select class="select work" name="work">
                              <option disabled value="{{$User->work}}">{{$User->work_location}}</option>
                            </select>
                      </div>
                      <div class="form-group">
                          <label for="email">Afdeling:</label>
                          <input required disabled type="text" name="department" value="{{$User->work_department}}">
                      </div>
                </div>
            </div>
            @endforeach
            {{ $users->links() }}
        </div>
    </div>
</div>

@endsection
