@extends('layouts.app')
@section('title','Daily Production')
@section('BigHeading')
Daily Production
@endsection
@section('SmallHeading')

@endsection
@section('pagetitle')
Daily Production
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
  <form method="POST" action="{{route('DailyProduction.store')}}">
    {{ csrf_field() }}
   <div class="container">
    <div class="form-group">
      <input type="hidden" name="product_id" value="{{$productData->id}}">
      <label>Product</label>
      <br>
      <input type="text" name="" value="{{$productData->name}}" disabled="">
    </div>
    <div class="form-group">
      <label>Produced</label>
      <br> 
      <input step="0.0000" min="0" type="number" name="produced" required="" autofocus="" value="0">
    </div>
    <div class="form-group">
      <label>Dispatches</label>
      <br>
      <input step="0.0000" min="0" type="number" name="dispatches" value="0">
    </div>
    <div class="form-group">
      <label>Sale Return</label>
      <br>
      <input step="0.0000" min="0" type="number" name="sale_return" value="0">
    </div>
    <div class="form-group">
      <label>Received</label>
      <br>
      <input step="0.0000" min="0" type="number" name="received" value="0">
    </div>
    <button class="btn btn-primary" type="Submit">Submit</button>
  </div>
  </form>
@endsection