@extends('layouts.app')
@section('title','Production Reports')
@section('BigHeading')
Production Reports
@endsection
@section('SmallHeading')

@endsection
@section('pagetitle')
Monthly Production
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
  <form method="POST" action="{{route('Reports.Month')}}">
    {{ csrf_field() }}
    <h3>Select a Product</h3>
    <select name="productID">
      @foreach($product as $key)
      <option value="{{$key->id}}">{{$key->name}}</option>
      @endforeach
    </select>
    <button type="Submit">Submit</button>
  </form>
@endsection