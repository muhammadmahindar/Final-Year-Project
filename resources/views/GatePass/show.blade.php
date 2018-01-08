@extends('layouts.app')
@section('title',$gatePassData->name)
@section('BigHeading')
Production
@endsection
@section('SmallHeading')
details
@endsection
@section('dynamiccontent')
<?php $total=0; ?>
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Petro Chemical International GatePass  
            <small class="pull-right">{{date('d-M-Y h:i a')}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            Person Name: <strong>{{$gatePassData->person_name}}</strong><br>
            Phone: <strong>{{$gatePassData->contact_phone}}</strong> <br>
            Destination: <strong>{{$gatePassData->destination}}</strong>
          </address>
        </div>
      
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table id="gate" class="table table-striped">
            <thead>
            <tr>
              <th>Product</th>
              <th>Description</th>
              <th>Quantity</th>
            </tr>
            </thead>
            <tbody>
              @foreach($gatePassData->products as $val)
            <tr>
              <td>{{$val->name}}</td>
              <td>{{$val->description}}</td>
              <td><strong>{{$val->pivot->quantity}}</strong><?php $total+=$val->pivot->quantity; ?></td>
            </tr>
            @endforeach
             @foreach($gatePassData->materials as $val)
            <tr>
              <td>{{$val->name}}</td>
              <td>{{$val->description}}</td>
              <td><strong>{{$val->pivot->quantity}}</strong><?php $total+=$val->pivot->quantity; ?></td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <!-- /.col -->
        <div class="col-xs-6 pull-right">

          <div class="table-responsive">
          <table class="table">
            <tr>
              <th>Total:</th>
              <td><STRONG>{{$total}}</STRONG></td>
            </tr>
          </table>
        </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print pull-right">
        <div class="col-xs-12 pull-right">
          <a onclick="window.print();" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>
    </section>
    @endsection