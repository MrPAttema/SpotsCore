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
        @foreach ($users as $user)
            @php
                $user = (object) $user;
                $firstname = decrypt($user->firstname);
                $lastname = empty($user->lastname) ? '' : decrypt($user->lastname);
                $email = $user->email;
                $adress = empty($user->adress) ? '' : decrypt($user->adress);
                $phone =empty($user->phone) ? '' : decrypt($user->phone);
                $postcode = empty($user->postcode) ? '' : decrypt($user->postcode);
                $city = empty($user->city) ? '' : decrypt($user->city);
                $work_location = empty($user->work_location) ? '' : decrypt($user->work_location);
                $work_department = empty($user->work_location) ? '' : decrypt($user->work_location);
            @endphp
            <div class="panel panel-default">
              <div class="panel-heading-adminreserveringen" style="cursor:pointer">
                  {{$firstname}} #{{$user->id}}
              </div>
              <div class="panel-body-adminreserveringen" style="display:none;">
                      <div class="form-group">
                          <label for="email">Voornaam:</label>
                          <input required disabled type="text" name="firstname" value="{{$firstname}}">
                      </div>
                      <div class="form-group">
                          <label for="email">Achternaam:</label>
                          <input required disabled type="text" name="lastname" value="{{$lastname}}">
                      </div>
                      <div class="form-group">
                          <label for="email">E-mailadres:</label>
                          <input required disabled type="text" name="email" value="{{$email}}">
                      </div>
                      <div class="form-group">
                          <label for="email">Telefoon:</label>
                          <input required disabled type="text" name="phone" maxlength="10" value="{{$phone}}" onkeypress="return isNumberKey(event)"/>
                      </div>
                      <div class="form-group">
                          <label for="email">Adres:</label>
                          <input required disabled type="text" name="adress" value="{{$adress}}">
                      </div>
                      <div class="form-group">
                          <label for="email">Postcode:</label>
                          <input required disabled type="text" name="postcode" value="{{$postcode}}">
                      </div>
                      <div class="form-group">
                          <label for="email">Woonplaats:</label>
                          <input required disabled type="text" name="city" value="{{$city}}">
                      </div>
                      <div class="form-group">
                          <label for="email">Werkomgeving:</label>
                            <select class="select work" name="work">
                              <option disabled value="{{$user->work}}">{{$work_location}}</option>
                            </select>
                      </div>
                      <div class="form-group">
                          <label for="email">Afdeling:</label>
                          <input required disabled type="text" name="department" value="{{$work_department}}">
                      </div>
                </div>
            </div>
            @endforeach
            {{ $users->links() }}
        </div>
    </div>
</div>

@endsection
