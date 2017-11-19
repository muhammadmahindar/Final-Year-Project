@extends('layouts.app')
@section('title','Company')
@section('BigHeading')
Companies
@endsection
@section('SmallHeading')
details
@endsection
@section('pagetitle')
Companies
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
<table id="companytable" class="display responsive table table-striped table-bordered nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th data-priority="1">Name</th>
                <th data-priority="3">E-mail</th>
                <th data-priority="4">Phone</th>
                <th data-priority="5">Address</th>
                <th data-priority="6">Description</th>
                <th data-priority="7">Updated At</th>
                <th data-priority="8">Created At</th>
                <th data-priority="2">Actions</th> 
            </tr>
        </thead>
        <tbody>
        	@foreach($company as $cmp)
            <tr>
                <td>{{$cmp->name}}</td>
                <td>{{$cmp->email}}</td>
                <td>{{$cmp->phone}}</td>
                <td>{{$cmp->address}}</td>
                <td>{{$cmp->description}}</td>
                <td>{{$cmp->updated_at->format('d-M-Y h:i a')}}</td>
                <td>{{$cmp->created_at->format('d-M-Y h:i a')}}</td>
                <td><button class="btn btn-primary">Edit</button> <button class="btn btn-danger">Delete</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('footer')
<div class="container">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-primary" id="companyCreate">New Company</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>New Company Details</h4>
        </div>
        <div class="modal-body">
          <form role="form" action="{{route('Company.store')}}" method="POST">
            {{csrf_field()}}
            <div class="form-group has-feedback form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <input id="name" type="name" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}" required autofocus>
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
        	@if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        	@endif	
            </div>
            <div class="form-group has-feedback form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        	<input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
	        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        	@endif
      		</div>
      		<div class="form-group has-feedback form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
        	<input type="text" class="form-control" id="phone" required placeholder="032XXXXXXXX" name="phone" value="{{old('phone')}}">
	        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
	        @if ($errors->has('phone'))
            <span class="help-block">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        	@endif
      		</div>
      		<div class="form-group has-feedback form-group{{ $errors->has('Address') ? ' has-error' : '' }}">
        	<textarea class="form-control" rows="3" placeholder="Enter Company Address" id="Address" name="Address" value="{{old('Address')}}"></textarea>
	        <span class="glyphicon glyphicon-home form-control-feedback"></span>
	        @if ($errors->has('Address'))
            <span class="help-block">
                <strong>{{ $errors->first('Address') }}</strong>
            </span>
        	@endif
      		</div>
      		<div class="form-group has-feedback form-group{{ $errors->has('Description') ? ' has-error' : '' }}">
        	<textarea class="form-control" rows="4" placeholder="Enter Description" id="Address" name="Description" value="{{old('Description')}}"></textarea>
	        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
	        @if ($errors->has('Description'))
            <span class="help-block">
                <strong>{{ $errors->first('Description') }}</strong>
            </span>
        	@endif
      		</div>
      		<div class="form-group modal-footer">
      			<button type="submit" class="btn btn-default btn-default pull-left" data-dismiss="modal"><span class="" ="glyphicon glyphicon-remove"></span> Cancel</button>
          <button type="submit" class="btn btn-primary pull-right">Save it</button>
      		</div>
          </form> 
        </div>
      </div>
    </div>
  </div> 
</div>
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
<script type="text/javascript">
	$(document).ready(function(){
  $(":input").inputmask();
});
</script>
<script type="text/javascript">
	$(document).ready(function(){
  $("#phone").inputmask("99999999999",{ "onincomplete": function(){ $(':input[type="submit"]').prop('disabled', true); },"oncomplete": function(){ $(':input[type="submit"]').prop('disabled', false); } }); //default
});
</script>
 <script type="text/javascript">
	$(document).ready(function() {
    $('#companytable').DataTable( {
    
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for '+data[0];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        }
        

    } );
} );
</script>

<script type="text/javascript">
	$(document).ready(function(){
    $("#companyCreate").click(function(){
        $("#myModal").modal();
    });
});
</script>
<script type="text/javascript">
@if (count($errors) > 0)
    $("#myModal").modal('show');
@endif
</script>

@endsection