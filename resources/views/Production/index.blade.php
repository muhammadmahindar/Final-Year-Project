@extends('layouts.app')
@section('title','Production')
@section('BigHeading')
Productions
@endsection
@section('SmallHeading')
details
@endsection
@section('pagetitle')
Productions
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

<table id="productiontable" class="display responsive table table-striped table-bordered nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th data-priority="3">Production Code</th>
                <th data-priority="1">Production Name</th>
                <th data-priority="4">Status</th>
                <th data-priority="6">Description</th>
                <th data-priority="5">Products,Quantity</th>
                <th data-priority="7">Company/Branch/Department</th>
                <th data-priority="8">Created By</th>
                <th data-priority="9">Updated At</th>
                <th data-priority="10">Created At</th>
                <th data-priority="2">Actions</th>  
            </tr>
        </thead>
        <tbody>
          @foreach($production as $cmp)
            @if($cmp->delete_status==1)
            <tr>
                <td>{{$cmp->production_code}}</td>
                <td>{{$cmp->name}}</td>
                <td>@if($cmp->status==1)<span class="label label-info">Pending Approval</span>@elseif($cmp->status==0)<span class="label label-danger">Disapproved</span>@elseif($cmp->status==3)<span class="label label-success">Approved</span>
                  @elseif($cmp->status==4)<span class="label label-success">Completed</span>@endif</td>
                <td>{{$cmp->description}}</td>
                <td><ul>@foreach($cmp->Products as $chekc) <li>{{$chekc->name}},{{$chekc->pivot->quantity}}</li>@endforeach</ul></td>
                <td>{{$cmp->company->name}}/{{$cmp->branch->name}}/{{$cmp->department->name}}</td>
                <td>{{$cmp->user->name}}</td>
                <td>{{$cmp->updated_at->format('d-M-Y h:i a')}}</td>
                <td>{{$cmp->created_at->format('d-M-Y h:i a')}}</td>
                <td>@can('Edit-Production') @if($cmp->status!=4)<a href="{{route('Production.edit',$cmp->id)}}" class="btn btn-primary">Edit</a>@endif @endcan
                  @if($cmp->status==4)
                  <a href="{{route('Production.show',$cmp->id)}}" class="btn btn-primary">Show</a>
                  @endif
                  @can('Delete-Production')
                  <form action="{{route('Production.destroy',$cmp->id)}}" method="POST">
                    <input type="hidden" name="_method" value="delete">
                        {{csrf_field()}}
                        <input type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete his?');" value="Delete"></form>@endcan 
                        @if($cmp->status==1)@can('Approve-Production') <form action="{{route('Production-Approval.update',$cmp->id)}}" method="POST">
                           <input type="hidden" name="_method" value="PATCH">
                      {{ csrf_field() }}
                          <button class="btn btn-primary" name="approval" value="3">Approve</button>
                          <button class="btn btn-primary" name="approval" value="0">Disapprove</button>
                        </form>@endcan @endif
                         @if($cmp->status==3)@can('Complete-Production') <a class="btn btn-primary" href="{{route('Production-Approval.show',$cmp->id)}}">Complete Production</a>@endcan @endif
                      </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
@endsection
@section('footer')
<!--Create Modal -->
<div class="container">
  @can('Create-Production')
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-primary" id="productionCreate">New Production</button>
@endcan
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>New Production Details</h4>
        </div>
        <div class="modal-body">
          <form role="form" action="{{route('Production.store')}}" method="POST">
            {{csrf_field()}}
            <div class="form-group has-feedback form-group{{ $errors->has('mat_code') ? ' has-error' : '' }}">
            <input id="mat_code" type="text" class="form-control" name="mat_code" readonly>
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          @if ($errors->has('mat_code'))
            <span class="help-block">
                <strong>{{ $errors->first('mat_code') }}</strong>
            </span>
          @endif  
            </div>

            <div class="form-group has-feedback form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <input id="name" type="name" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}" required autofocus>
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
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


            <label>Products</label>
            <br>
            <button class="add_form_field test" type="button">Add more</button>
            @if ($errors->has('Duplicate'))
            <span class="help-block">
                <strong>{{ $errors->first('Duplicate') }}</strong>
            </span>
          @endif
            <div class="container1">
                              <div class="row">
                               <div class="col-sm-offset-2 col-sm-4">
                                   <select class="test" name="FormulaList[]" required="">
                                    <option value="">--Please choose--</option>
                                     @foreach($productData as $mater)
                                     <option value="{{$mater->id}}">{{$mater->name}}</option>
                                     @endforeach
                                   </select>
                               </div>
                                <div class="col-sm-4 ">
                                    <input type="number" class="form-control" id="quan"  name="QuantityList[]" placeholder="Enter Quanity" min="0" step="any" required="">
                               </div>
                          </div>
                          </div>
                          <div class="form-group has-feedback form-group{{ $errors->has('user_code') ? ' has-error' : '' }}">
            <input id="user_code" type="text" class="form-control" readonly placeholder="{{ Auth::user()->name }}">
            <input id="user_code" type="hidden" class="form-control" name="user_code" value="{{ Auth::user()->id }}" readonly placeholder="{{ Auth::user()->name }}">
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          @if ($errors->has('user_code'))
            <span class="help-block">
                <strong>{{ $errors->first('user_code') }}</strong>
            </span>
          @endif  
            </div>
            <div class="form-group has-feedback form-group{{ $errors->has('user_code') ? ' has-error' : '' }}">
              <label>Company/Department/Branch</label>
            <input id="user_code" type="text" class="form-control" readonly placeholder="{{ Auth::user()->company->name }}/{{ Auth::user()->department->name }}/{{ Auth::user()->branch->name }}">
            <input id="user_code" type="hidden" class="form-control" name="company_code" value="{{ Auth::user()->company->id }}" readonly placeholder="{{ Auth::user()->company->name }}">

            <input id="user_code" type="hidden" class="form-control" name="department_code" value="{{ Auth::user()->department->id }}" readonly placeholder="{{ Auth::user()->department->name }}">

            <input id="user_code" type="hidden" class="form-control" name="branch_code" value="{{ Auth::user()->branch->id }}" readonly placeholder="{{ Auth::user()->branch->name }}">
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          @if ($errors->has('user_code'))
            <span class="help-block">
                <strong>{{ $errors->first('user_code') }}</strong>
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
@if(!$productionData==0)
  <!--Edit Modal -->
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" href="{{url('/Production')}}">&times;</a>
          <h4>Edit Production Details</h4>
        </div>
        <div class="modal-body">
          <form role="form" action="{{route('Production.update',$productionData->id)}}" method="POST">
            <input type="hidden" name="_method" value="PATCH">
                      {{ csrf_field() }}
          
            <div class="form-group has-feedback form-group{{ $errors->has('mat_code') ? ' has-error' : '' }}">
            <input id="mat_codeedit" type="text" class="form-control" name="mat_code" value="{{$productionData->production_code}}" readonly>
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          @if ($errors->has('mat_code'))
            <span class="help-block">
                <strong>{{ $errors->first('mat_code') }}</strong>
            </span>
          @endif  
            </div>

            <div class="form-group has-feedback form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <input id="name" type="name" class="form-control" placeholder="Name" name="name" value="{{ $productionData->name}}" required autofocus>
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
          @endif  
            </div>
            

          <div class="form-group has-feedback form-group{{ $errors->has('Description') ? ' has-error' : '' }}">
          <textarea class="form-control" rows="4" placeholder="Enter Description" id="Address" name="Description">{{$productionData->description}}</textarea>
          <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
          @if ($errors->has('Description'))
            <span class="help-block">
                <strong>{{ $errors->first('Description') }}</strong>
            </span>
          @endif
          </div>

          <div class="form-group has-feedback form-group{{ $errors->has('mat_code') ? ' has-error' : '' }}">
            <label>Status</label>
            <select name="statusproduct" required="">
              <option value="1" @if($productionData->status == 1)selected="selected"@endif>Pending Approval</option>
              <option value="3" @if($productionData->status == 3)selected="selected"@endif>Approved</option>
              <option value="0" @if($productionData->status == 0)selected="selected"@endif>Disapproved</option>
              <option value="4" @if($productionData->status == 4)selected="selected"@endif>Completed</option>
            </select>
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          @if ($errors->has('mat_code'))
            <span class="help-block">
                <strong>{{ $errors->first('mat_code') }}</strong>
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
              @foreach($productionData->products as $cmp)
              <div class="row">
                <div class="col-sm-offset-2 col-sm-4">
                  <select class="test" name="FormulaList[]" required="">
                    <option value="">--Please choose--</option>
                      @foreach($productData as $mater)
                        <option value="{{$mater->id}}" @if($mater->id == $cmp->id)selected="selected"@endif>{{$mater->name}}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-sm-4 ">
                  <input type="number" class="form-control" id="quan"  name="QuantityList[]" placeholder="Enter Quanity"  min="0" step="any" required="" value="{{$cmp->pivot->quantity}}">
                </div>
              </div>
              @endforeach
              </div>

          <div class="form-group has-feedback form-group{{ $errors->has('user_code') ? ' has-error' : '' }}">
            <input id="user_code" type="text" class="form-control" readonly placeholder="{{ Auth::user()->name }}">
            <input id="user_code" type="hidden" class="form-control" name="user_code" value="{{ Auth::user()->id }}" readonly placeholder="{{ $productionData->user->name }}">
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          @if ($errors->has('user_code'))
            <span class="help-block">
                <strong>{{ $errors->first('user_code') }}</strong>
            </span>
          @endif  
            </div>
            <input id="user_code" type="hidden" class="form-control" name="company_code" value="{{ Auth::user()->company->id }}" readonly placeholder="{{ Auth::user()->company->name }}">

            <input id="user_code" type="hidden" class="form-control" name="department_code" value="{{ Auth::user()->department->id }}" readonly placeholder="{{ Auth::user()->department->name }}">

            <input id="user_code" type="hidden" class="form-control" name="branch_code" value="{{ Auth::user()->branch->id }}" readonly placeholder="{{ Auth::user()->branch->name }}">
          <div class="form-group modal-footer">
            <a class="btn btn-default btn-default pull-left" href="{{url('/Production')}}">Back</a>
          <button type="submit" class="btn btn-primary pull-right">Update</button>
          </div>
          </form> 
        </div>
      </div>
    </div>
  </div> 
  @endif
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
  $(document).ready(function() {
    $('#productiontable').DataTable( {
    
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
  //Initialize Select2 Elements
    $('.select2').select2()
  $(document).ready(function(){
    $("#productionCreate").click(function(){

      var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 11; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));


        $("#mat_code").val(text);
        $("#myModal").modal();
    });
});
</script>
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
                $(wrapper).append('<div class="row"><div class="col-sm-offset-2 col-sm-4"><select name="FormulaList[]" class="test" required><option value="">--Please choose--</option>@foreach($productData as $mater)<option value="{{$mater->id}}">{{$mater->name}}</option>@endforeach</select></div><div class="col-sm-4 "><input type="number" class="form-control" id="quan"  name="QuantityList[]" placeholder="Enter Quanity"  min="0" step="any" required=""></div><a href="#" class="delete">Delete</a></div>'); //add input box
            }        });

        $(wrapper).on("click",".delete", function(e){
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });

</script>
<script type="text/javascript">
@if (count($errors) > 0 && $setModal!=true)
   var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 11; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));


        $("#mat_code").val(text);
    $("#myModal").modal();
@elseif(count($errors) > 0 && $setModal==true)
$("#editModal").modal('show');
@endif
@if($setModal==true)
$('#editModal').modal({backdrop: 'static', keyboard: false})
$("#editModal").modal('show');

@endif
</script>

@endsection