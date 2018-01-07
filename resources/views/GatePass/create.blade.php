@extends('layouts.login')
@section('title','GatePass')
@section('content')
<p class="login-box-msg">Generate Pass</p>
<form role="form" action="{{route('GatePass.store')}}" method="POST">
      {{csrf_field()}}
      <div class="form-group has-feedback form-group{{ $errors->has('person_name') ? ' has-error' : '' }}">
        <input id="person_name" type="text" class="form-control" placeholder="Person Name" name="person_name" value="{{ old('person_name') }}" required autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if ($errors->has('person_name'))
            <span class="help-block">
                <strong>{{ $errors->first('person_name') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group has-feedback form-group{{ $errors->has('contact_phone') ? ' has-error' : '' }}">
        <input id="contact_phone" type="text" class="form-control" name="contact_phone" placeholder="Contact Phone" required>
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        @if ($errors->has('contact_phone'))
            <span class="help-block">
                <strong>{{ $errors->first('contact_phone') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group has-feedback form-group{{ $errors->has('destination') ? ' has-error' : '' }}">
        <input id="destination" type="text" class="form-control" name="destination" placeholder="Destination" required>
        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
        @if ($errors->has('destination'))
            <span class="help-block">
                <strong>{{ $errors->first('destination') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group has-feedback form-group{{ $errors->has('remarks') ? ' has-error' : '' }}">
        <textarea row="4" id="remarks" type="textarea" class="form-control" name="remarks" placeholder="Remarks" required></textarea>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('remarks'))
            <span class="help-block">
                <strong>{{ $errors->first('remarks') }}</strong>
            </span>
        @endif
      </div>
      <button class="add_form_field test" type="button">Add more</button>
            @if ($errors->has('Duplicate'))
            <span class="help-block">
                <strong>{{ $errors->first('Duplicate') }}</strong>
            </span>
          @endif

      <div class="container1">
              <div class="row">
                <div class="col-sm-offset-2 col-sm-4">
                  <input type="text" class="form-control" id="quan"  name="itemList[]" placeholder="Enter Item Name"  min="0" step="any" required="" value="">
                </div>
                <div class="col-sm-4 ">
                  <input type="number" class="form-control" id="quan"  name="QuantityList[]" placeholder="Enter Quanity"  min="0" step="any" required="" value="">
                </div>
              </div>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
        </div>
        <!-- /.col -->
      </div>
</form>
@endsection
@section('scriptarea')
<script>
 $(document).ready(function() {
        var max_fields      = 10;
        var wrapper         = $(".container1");
        var add_button      = $(".add_form_field");

        var x = 1;
        $(add_button).click(function(e){
            e.preventDefault();
            if(true){
                x++;
                $(wrapper).append('<div class="row"><div class="col-sm-offset-2 col-sm-4"><input type="text" class="form-control" id="quan"  name="itemList[]" placeholder="Enter Quanity"  min="0" step="any" required=""></div><div class="col-sm-4 "><input type="number" class="form-control" id="quan"  name="QuantityList[]" placeholder="Enter Quanity"  min="0" step="any" required=""></div><a href="#" class="delete">Delete</a></div>'); //add input box
            }        });

        $(wrapper).on("click",".delete", function(e){
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });

</script>
@endsection
