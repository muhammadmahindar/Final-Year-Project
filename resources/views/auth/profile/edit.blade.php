@extends('layouts.login')
@section('title','Change Password')
@section('content')
<p class="login-box-msg">Confirm your password</p>
<form role="form" method="POST" action="{{ route('Profile.update',$userinfo->id) }}">
       
       <input type="hidden" name="_method" value="PATCH">
                      {{ csrf_field() }}
      <div class="form-group has-feedback form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <input id="password" type="password" class="form-control" placeholder="Old Password" name="password" value="{{ old('password') }}" required autofocus>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>
      <input id="email" type="hidden" class="form-control" placeholder="Email" name="email" value="{{$userinfo->email}}">

      <div class="form-group has-feedback form-group{{ $errors->has('newpass') ? ' has-error' : '' }}">
        <input id="newpass" type="password" class="form-control" name="newpass" placeholder="New Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('newpass'))
            <span class="help-block">
                <strong>{{ $errors->first('newpass') }}</strong>
            </span>
        @endif
      </div>
      <div class="row">

        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary">Change Password</button>
        </div>
        <!-- /.col -->
      </div>
</form>
@endsection