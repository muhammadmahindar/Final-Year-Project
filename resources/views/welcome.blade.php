@extends('layouts.app')


@section('cssarea')
<!-- Morris chart -->
  <link rel="stylesheet" href="{{asset('css/bower_components/morris.js/morris.css')}}">
@endsection
@section('dynamiccontent')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
            </div>
        </div>
    </div>
</div>
@endsection


