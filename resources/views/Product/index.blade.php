@extends('layouts.app')
@section('title','Product')
@section('BigHeading')
Products
@endsection
@section('SmallHeading')
details
@endsection
@section('pagetitle')
Products
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

<table id="producttable" class="display responsive table table-striped table-bordered nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th data-priority="3">Product Code</th>
                <th data-priority="1">Product Name</th>
                <th data-priority="4">Material List,Quantity</th>
                <th data-priority="5">Company/Branch/Department</th>
                <th data-priority="5">Description</th>
                <th data-priority="6">Created By</th>
                <th data-priority="7">Unit</th>
                <th data-priority="8">Updated At</th>
                <th data-priority="9">Created At</th>
                <th data-priority="2">Actions</th> 
            </tr>
        </thead>
        <tbody>
          @foreach($product as $cmp)
            @if($cmp->delete_status==1)
            <tr>
                <td>{{$cmp->product_code}}</td>
                <td>{{$cmp->name}}</td>
                <td><ul>@foreach($cmp->materials as $chekc) <li>{{$chekc->name}},{{$chekc->pivot->quantity}}</li>@endforeach</ul></td>
                 <td>{{$cmp->company->name}}/{{$cmp->branch->name}}/{{$cmp->department->name}}</td>
                <td>{{$cmp->description}}</td>
                <td>{{$cmp->user->name}}</td>
                <td>{{$cmp->unit->uom}}</td>
                <td>{{$cmp->updated_at->format('d-M-Y h:i a')}}</td>
                <td>{{$cmp->created_at->format('d-M-Y h:i a')}}</td>
                <td>@can('Edit-Product')<a href="{{route('Product.edit',$cmp->id)}}" class="btn btn-primary">Edit</a>@endcan
                  @can('Delete-Product')
                  <form action="{{route('Product.destroy',$cmp->id)}}" method="POST">
                    <input type="hidden" name="_method" value="delete">
                        {{csrf_field()}}
                        <input type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete his?');" value="Delete"></form>@endcan</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
@endsection
@section('footer')
<!--Create Modal -->
<div class="container">
  @can('Create-Product')
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-primary" id="productCreate">New Product</button>
  @endcan

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>New Product Details</h4>
        </div>
        <div class="modal-body">
          <form role="form" action="{{route('Product.store')}}" method="POST">
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
          <div class="form-group has-feedback form-group{{ $errors->has('unitID') ? ' has-error' : '' }}">
          <label>Associate Unit</label>
          <select class="form-control select2" style="width: 100%;" name="unitID" data-placeholder="Company">
            @foreach($unitData as $ud)
              <option value="{{$ud->id}}">{{$ud->uom}}</option>
            @endforeach
          </select>
          @if ($errors->has('unitID'))
            <span class="help-block">
                <strong>{{ $errors->first('unitID') }}</strong>
            </span>
          @endif
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
                                     @foreach($materialData as $mater)
                                     <option value="{{$mater->id}}">{{$mater->name}}</option>
                                     @endforeach
                                   </select>
                               </div>
                                <div class="col-sm-4 ">
                                    <input type="number" class="form-control" id="quan"  name="QuantityList[]" placeholder="Enter Quanity" min="0" step="any" required="">
                               </div>
                          </div>
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
@if(!$productData==0)
  <!--Edit Modal -->
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" href="{{url('/Product')}}">&times;</a>
          <h4>Edit Product Details</h4>
        </div>
        <div class="modal-body">
          <form role="form" action="{{route('Product.update',$productData->id)}}" method="POST">
            <input type="hidden" name="_method" value="PATCH">
                      {{ csrf_field() }}
            <div class="form-group has-feedback form-group{{ $errors->has('mat_code') ? ' has-error' : '' }}">
            <input id="mat_codeedit" type="text" class="form-control" name="mat_code" value="{{$productData->product_code}}" readonly>
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          @if ($errors->has('mat_code'))
            <span class="help-block">
                <strong>{{ $errors->first('mat_code') }}</strong>
            </span>
          @endif  
            </div>
            <div class="form-group has-feedback form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <input id="name" type="name" class="form-control" placeholder="Name" name="name" value="{{ $productData->name}}" required autofocus>
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
          @endif  
            </div>
            

          <div class="form-group has-feedback form-group{{ $errors->has('Description') ? ' has-error' : '' }}">
          <textarea class="form-control" rows="4" placeholder="Enter Description" id="Address" name="Description">{{$productData->description}}</textarea>
          <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
          @if ($errors->has('Description'))
            <span class="help-block">
                <strong>{{ $errors->first('Description') }}</strong>
            </span>
          @endif
          </div>

          <div class="form-group has-feedback form-group{{ $errors->has('unitID') ? ' has-error' : '' }}">
          <label>Associate Unit</label>
          <select class="form-control select2" style="width: 100%;" name="unitID" data-placeholder="Company">
            @foreach($unitData as $ud)
              <option value="{{$ud->id}}" @if($productData->unit_id==$ud->id) selected="selected"@endif>{{$ud->uom}}</option>
            @endforeach
          </select>
          @if ($errors->has('unitID'))
            <span class="help-block">
                <strong>{{ $errors->first('unitID') }}</strong>
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
              @foreach($productData->materials as $cmp)
              <div class="row">
                <div class="col-sm-offset-2 col-sm-4">
                  <select class="test" name="FormulaList[]" required="">
                    <option>--Please choose--</option>
                      @foreach($materialData as $mater)
                        <option value="{{$mater->id}}" @if($mater->id == $cmp->id)selected="selected" @endif >{{$mater->name}}</option>
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
            <input id="user_code" type="hidden" class="form-control" name="user_code" value="{{ Auth::user()->id }}" readonly placeholder="{{ $productData->user->name }}">
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          @if ($errors->has('user_code'))
            <span class="help-block">
                <strong>{{ $errors->first('user_code') }}</strong>
            </span>
          @endif  
            </div>

            @if(!Auth::user()->hasRole('SuperAdmin'))

            <input type="hidden" name="" value="{{Auth::user()->company_id}}">
            <input type="hidden" name="" value="{{Auth::user()->branch_id}}">
            <input type="hidden" name="" value="{{Auth::user()->department_id}}">
            
            @else
            <div class="form-group has-feedback form-group{{ $errors->has('companyList') ? ' has-error' : '' }}">
                            <label class="col-md-4">Associate Companies</label>
                            <div class="col-md-8">
                             <select class="form-control select2" style="width: 100%;" data-placeholder="Companies" name="companyList" id="companyList" required>
                                  <option value="">--- Select State ---</option>
                                 @foreach($CompanyData as $dpDT)
                                     <option value="{{$dpDT->id}}" @if($productData->company->name == $dpDT->name) 
                                      selected @endif>{{$dpDT->name}}</option>
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
                                     <option value="{{$branchData->id}}" selected>{{$branchData->name}}</option>
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
                             <select class="form-control select2" data-placeholder="Departments" style="width: 100%;" name="departmentList" required>
                                <option value="">--- Select Department ---</option>
                                     <option value="{{$departmentData->id}}"
                                      selected>{{$departmentData->name}}</option>
                            </select>
                            @if ($errors->has('departmentList'))
                            <span class="help-block">
                                <strong>{{ $errors->first('departmentList') }}</strong>
                            </span>
                            @endif
                        </div>
                        </div>
                        @endif


          <div class="form-group modal-footer">
            <a class="btn btn-default btn-default pull-left" href="{{url('/Product')}}">Back</a>
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
    $('#producttable').DataTable( {
    
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
                $(wrapper).append('<div class="row"><div class="col-sm-offset-2 col-sm-4"><select name="FormulaList[]" class="test" required><option value="">--Please choose--</option>@foreach($materialData as $mater)<option value="{{$mater->id}}">{{$mater->name}}</option>@endforeach</select></div><div class="col-sm-4 "><input type="number" class="form-control" id="quan"  name="QuantityList[]" placeholder="Enter Quanity"  min="0" step="any" required=""></div><a href="#" class="delete">Delete</a></div>'); //add input box
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