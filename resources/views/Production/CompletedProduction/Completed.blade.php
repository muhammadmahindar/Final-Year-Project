@extends('layouts.app')
@section('title','Costing')
@section('BigHeading')
Costing
@endsection
@section('SmallHeading')
details
@endsection
@section('pagetitle')
Costing
@endsection
@section('cssarea')
<!-- DataTable Bootstrap  -->
    <link href="{{ asset('css/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<!-- Responsive Bootstrap  -->
    <link href="{{ asset('css/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet"> 
<!-- Select2 -->
  <link rel="stylesheet" href="{{asset('css/bower_components/select2/dist/css/select2.min.css')}}">    
     
@endsection
@section('dynamiccontent')
<form role="form" action="{{route('Production-Approval.update',$productionData->id)}}" method="POST">
	<input type="hidden" name="_method" value="PATCH">
                      {{ csrf_field() }}
  <table id="productiontable" class="display responsive table table-striped table-bordered nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th data-priority="1">Semi Fixed</th>
                <th data-priority="2">Quantity</th>
            </tr>
        </thead>
        <tbody>
          @foreach($semi as $key)
            <tr>
                <td><input type="hidden" name="semiId[]" value="{{$key->id}}">{{$key->name}}</td>
                <td><input type="number" class="form-control" id="quan"  name="SemiQuantityList[]" placeholder="Enter Quanity" min="0" step="any" required="" value="0"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row">
    	<h3>Factory Overhead</h1>
    </div>
    <table id="factorytable" class="display responsive table table-striped table-bordered nowrap" cellspacing="0" width="100%">
    	<input type="hidden" name="approval" value="4">
        <thead>
            <tr>
                <th data-priority="1">Factory OverHead</th>
                <th data-priority="2">Quantity</th>
            </tr>
        </thead>
        <tbody>
          @foreach($factory as $key)
            <tr>
                <td><input type="hidden" name="factoryId[]" value="{{$key->id}}">{{$key->name}}</td>
                <td><input type="number" class="form-control" id="quan"  name="FactoryQuantityList[]" placeholder="Enter Quanity" min="0" step="any" required="" value="0"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="form-group modal-footer">
          <button type="submit" class="btn btn-primary pull-right">Update</button>
          </div>
</form>
@endsection
@section('scriptarea')

<!-- DataTable -->
 <script src="{{ asset('css/bower_components/datatables.net-bs/js/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('css/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
 <script src="{{ asset('css/bower_components/datatables.net-bs/js/dataTables.responsive.min.js') }}"></script>
 <script src="{{ asset('css/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js') }}"></script>
 <!-- InputMask -->
<script src="{{ asset('css/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{asset('css/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{asset('css/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('css/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){
  $(":input").inputmask();
});
</script>
<script type="text/javascript">
  $(document).ready(function(){
  $("#phone").inputmask("99999999999",{ "onincomplete": function(){ $(':input[type="submit"]').prop('disabled', true); },"oncomplete": function(){ $(':input[type="submit"]').prop('disabled', false); } }); //default
});
  $(document).ready(function(){
  $("#phone1").inputmask("99999999999",{ "onincomplete": function(){ $(':input[type="submit"]').prop('disabled', true); },"oncomplete": function(){ $(':input[type="submit"]').prop('disabled', false); } }); //default
});
</script>

<script type="text/javascript">
  //Initialize Select2 Elements
    $('.select2').select2()
  $(document).ready(function(){
    $("#productCreate").click(function(){

      var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 11; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));


        $("#mat_code").val(text);
        $("#myModal").modal();
    });
});
</script>



@endsection