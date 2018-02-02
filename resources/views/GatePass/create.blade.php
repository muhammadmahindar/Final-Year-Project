@extends('layouts.app')
@section('title','GatePass')
@section('dynamiccontent')
<div class="col-sm-6">
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
        <textarea row="4" id="remarks" type="textarea" class="form-control" name="remarks" placeholder="Remarks"></textarea>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('remarks'))
            <span class="help-block">
                <strong>{{ $errors->first('remarks') }}</strong>
            </span>
        @endif
      </div>
      <button class="btn btn-primary add_form_field test btn" type="button">Add Material</button>
            @if ($errors->has('DuplicateMaterial'))
            <span class="help-block">
                <strong>{{ $errors->first('DuplicateMaterial') }}</strong>
            </span>
          @endif

      <div class="container1">

      </div>
      <button class="btn btn-primary add_form_field_product test btn" type="button">Add Product</button>
            @if ($errors->has('DuplicateProduct'))
            <span class="help-block">
                <strong>{{ $errors->first('DuplicateProduct') }}</strong>
            </span>
          @endif

      <div class="container2">

      </div>

      @if(!Auth::user()->hasRole('SuperAdmin'))

            <input type="hidden" name="" value="{{Auth::user()->company_id}}">
            <input type="hidden" name="" value="{{Auth::user()->branch_id}}">
            <input type="hidden" name="" value="{{Auth::user()->department_id}}">
            
            @else
            <div class="form-group has-feedback form-group{{ $errors->has('companyList') ? ' has-error' : '' }}">
                            <label class="col-md-4">Associate Companies</label>
                            <div class="col-md-8">
                             <select class="form-control select2"  data-placeholder="Companies" name="companyList" id="companyList" style="width: 100%;" required>
                                  <option value="">--- Select State ---</option>
                                 @foreach($CompanyData as $dpDT)
                                     <option value="{{$dpDT->id}}">{{$dpDT->name}}</option>
                                 @endforeach
                            </select>
                            @if ($errors->has('companyList'))
                            <span class="help-block">
                                <strong>{{ $errors->first('companyList') }}</strong>
                            </span>
                            @endif
                        </div>
                        </div>

                        <div class="form-group has-feedback form-group{{ $errors->has('branchList') ? ' has-error' : '' }}">
                            <label class="col-md-4">Associate Branches</label>
                            <div class="col-md-8">                            
                             <select class="form-control select2" style="width: 100%;" data-placeholder="Branches" id="branchList" name="branchList" required>
                                <option value="">--- Select Branch ---</option>
                            </select>
                            @if ($errors->has('branchList'))
                            <span class="help-block">
                                <strong>{{ $errors->first('branchList') }}</strong>
                            </span>
                            @endif
                        </div>
                        </div>


                        <div class="form-group has-feedback form-group{{ $errors->has('departmentList') ? ' has-error' : '' }}">
                            <label class="col-md-4">Associate Departments</label>
                             <div class="col-md-8">
                             <select class="form-control select2" data-placeholder="Departments" name="departmentList" style="width: 100%;" required>
                                <option value="">--- Select Department ---</option>
                            </select>
                            @if ($errors->has('departmentList'))
                            <span class="help-block">
                                <strong>{{ $errors->first('departmentList') }}</strong>
                            </span>
                            @endif
                        </div>
                        </div>
                        @endif
      <div class="form-group">
        <!-- /.col -->
        <div class="col-xs-4 pull-right">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
        </div>
        <!-- /.col -->
        </div>
        
</form>
</div>
@endsection
@section('scriptarea')
<!-- InputMask -->
<script src="{{ asset('css/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{asset('css/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('css/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script>
 $(document).ready(function() {
        var max_fields      = 100;
        var wrapper         = $(".container1");
        var add_button      = $(".add_form_field");

        var x = 1;
        $(add_button).click(function(e){
            e.preventDefault();
            if(true){
                x++;
                $(wrapper).append('<div class="row"><div class="col-sm-5"><select name="materialList[]" class="form-control"><option>Select Option</option>@foreach($material as $key) <option value="{{$key->id}}">{{$key->name}}</option> @endforeach </select></div><div class="col-sm-5 "><input type="number" class="form-control" id="quan"  name="QuantityList[]" placeholder="Quantity"  min="0" step="any" required=""></div><a href="#" class="delete">Delete</a></div>'); //add input box
            }        });

        $(wrapper).on("click",".delete", function(e){
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });

</script>
<script>
 $(document).ready(function() {
        var max_fields      = 100;
        var wrapper         = $(".container2");
        var add_button      = $(".add_form_field_product");

        var x = 1;
        $(add_button).click(function(e){
            e.preventDefault();
            if(true){
                x++;
                $(wrapper).append('<div class="row"><div class="col-sm-5"><select name="productList[]" class="form-control"><option>Select Option</option> @foreach($product as $key) <option value="{{$key->id}}">{{$key->name}}</option> @endforeach </select></div><div class="col-sm-5 "><input type="number" class="form-control" id="quan"  name="QuantityList1[]" placeholder="Quantity"  min="0" step="any" required=""></div><a href="#" class="delete">Delete</a></div>'); //add input box
            }        });

        $(wrapper).on("click",".delete", function(e){
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });

</script>
<script type="text/javascript">
  $(document).ready(function(){
  $(":input").inputmask();
});
</script>
<script type="text/javascript">
  $(document).ready(function(){
  $("#contact_phone").inputmask("99999999999",{ "onincomplete": function(){ $(':input[type="submit"]').prop('disabled', true); },"oncomplete": function(){ $(':input[type="submit"]').prop('disabled', false); } }); //default
});
  $(document).ready(function(){
  $("#phone1").inputmask("99999999999",{ "onincomplete": function(){ $(':input[type="submit"]').prop('disabled', true); },"oncomplete": function(){ $(':input[type="submit"]').prop('disabled', false); } }); //default
});
</script>
<script type="text/javascript">
  $("select[name='companyList']").change(function(){
      var companyList = $(this).val();
      var token = $("input[name='_token']").val();
      $.ajax({
          url: '/getbranch',
          method: 'POST',
          data: {companyList:companyList, _token:token},
          success: function(data) {
            $("select[name='branchList'").html('');
            $("select[name='branchList'").html(data.options);
          }
      });
  });
</script>
<script type="text/javascript">
  $("select[name='branchList']").change(function(){
      var branchList = $(this).val();
      var token = $("input[name='_token']").val();
      $.ajax({
          url: '/getdepartment',
          method: 'POST',
          data: {branchList:branchList, _token:token},
          success: function(data) {
            $("select[name='departmentList'").html('');
            $("select[name='departmentList'").html(data.options);
          }
      });
  });
</script>
@endsection
