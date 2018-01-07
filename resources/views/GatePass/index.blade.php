@extends('layouts.app')
@section('title','Gate Pass')
@section('BigHeading')
GatePass
@endsection
@section('SmallHeading')
details
@endsection
@section('pagetitle')
GatePass
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
                <th data-priority="1">Person Name</th>
                <th data-priority="5">Phone</th>
                <th data-priority="4">Destination</th>
                <th data-priority="3">Item Name</th>
                <th data-priority="6">Quantity</th>
                <th data-priority="7">Remarks</th>
                <th data-priority="8">Updated At</th>
                <th data-priority="9">Created At</th>
                <th data-priority="2">Actions</th> 
            </tr>
        </thead>
        <tbody>
        	@foreach($gatepass as $cmp)
            <tr>
                <td>{{$cmp->person_name}}</td>
                <td>{{$cmp->contact_phone}}</td>
                <td>{{$cmp->destination}}</td>
                <td>{{$cmp->items}}</td>
                <td>{{$cmp->quantity}}</td>
                <td>{{$cmp->remarks}}</td>
                <td>{{$cmp->updated_at->format('d-M-Y h:i a')}}</td>
                <td>{{$cmp->created_at->format('d-M-Y h:i a')}}</td>
                <td><a href="{{route('GatePass.edit',$cmp->id)}}" class="btn btn-primary">Edit</a>
                  <form action="{{route('GatePass.destroy',$cmp->id)}}" method="POST">
                    <input type="hidden" name="_method" value="delete">
                        {{csrf_field()}}
                        <input type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete his?');" value="Delete"></form></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="container">
      <a class="btn btn-primary" href="{{route('GatePass.create')}}">Create New</a>
    </div>
@endsection
@section('footer')

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

@endsection