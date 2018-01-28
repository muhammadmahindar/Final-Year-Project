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
        <div class="col-sm-2 invoice-col">
          <address>
            Product:<strong> {{$productionData->name}}</strong><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col">
          <address>
            Unit:<strong> {{$productionData->unit->uom}}</strong><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 invoice-col">
          Quantity:<b> {{$quantityData}}</b><br>
        </div>
        <div class="col-sm-2 invoice-col">
          Rate:<b> {{number_format((float)($semiData+$factoryData+$costData)/$quantityData, 4, '.', '')}}</b><br>
        </div>
        <div class="col-sm-2 invoice-col">
          Cost:<b> {{number_format((float)$costData, 4, '.', '')}}</b><br>          
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
              <th>Semi Fixed</th>
              <th>Amount</th>
            </tr>
            </thead>
            <tbody>
              <?php $i=sizeof($semiAll)?>
              <?php $j=0 ?>
            @foreach($semiAll as $key)
            <tr>
              <td>{{$key->name}}</td>
              @if($j<=$i)
              <td><strong>{{$semireturn[$j]}}</strong></td>
              <?php $j++ ?>
              @endif
            </tr>
            @endforeach
            <thead>
              <tr>
                <th>Factory Overhead</th>
                <th>Amount</th>
              </tr>
            </thead>

              <?php $k=sizeof($factoryAll)?>
              <?php $l=0 ?>
            @foreach($factoryAll as $key)
            <tr>
              <td>{{$key->name}}</td>
              @if($l<=$k)
              <td><strong>{{$factoryreturn[$l]}}</strong></td>
              <?php $j++ ?>
              @endif
            </tr>
            @endforeach
            <thead>
              <tr>
                <th>Material Name</th>
                <th>Unit</th>
                <th>Quantity</th>
              </tr>
              
            </thead>
            @foreach($productionData->materials as $key)
            <tr>
              <td>{{$key->name}}</td>
              <td>{{$key->unit->uom}}</td>
              <td>{{$key->sumQuantity($key,$productionData)}}</td>
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
              <td>{{$semiData}} PKR </td>
            </tr>
            <tr>
              <th>Factory Overhead</th>
              <td> {{$factoryData}} PKR </td>
            </tr> 
            <tr>
              <th>Material Total:</th>
              <td>{{$costData}} PKR </td>
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