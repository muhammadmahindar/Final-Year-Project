@extends('layouts.app')
@section('title',$productionData->name)
@section('BigHeading')
Production
@endsection
@section('SmallHeading')
details
@endsection
@section('dynamiccontent')
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Petro Chemical International  
            <small class="pull-right">{{date('d-M-Y h:i a')}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            Company:<strong>{{$productionData->company->name}}</strong><br>
            {{$productionData->company->address}}<br>
            Phone: {{$productionData->company->phone}}<br>
            Email: {{$productionData->company->email}}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <address>
            Branch:<strong>{{$productionData->branch->name}}</strong><br>
            {{$productionData->branch->address}}<br>
            Phone: {{$productionData->branch->phone}}<br>
            Email: {{$productionData->branch->email}}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Production Code:<b>{{$productionData->production_code}}</b><br>
          Created By:<b>{{$productionData->user->name}}</b><br>
          
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Qty</th>
              <th>Product</th>
              <th>Product Code</th>
              <th>Description</th>
              <th>Raw Material Cost</th>
            </tr>
            </thead>
            <tbody>
              @foreach($productionData->products as $val)
            <tr>
              <td>{{$val->pivot->quantity}}</td>
              <td>{{$val->name}}</td>
              <td>{{$val->product_code}}</td>
              <td>{{$val->description}}</td>
              <td><strong>PKR 0</strong></td>
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
              <th>Semi Fixed:</th>
              <td>PKR {{$productionData->semiFixed()->sum('quantity')}}</td>
            </tr>
            <tr>
              <th>Factory Overhead</th>
              <td>PKR {{$productionData->factoryoverhead()->sum('quantity')}}</td>
            </tr> 
            <tr>
              <th>Total:</th>
              <td>PKR {{$productionData->factoryoverhead()->sum('quantity')+$productionData->semiFixed()->sum('quantity')}}</td>
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