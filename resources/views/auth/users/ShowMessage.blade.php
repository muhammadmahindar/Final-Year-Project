@extends('layouts.app')


@section('cssarea')

@endsection
@section('dynamiccontent')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mailbox
        
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Inbox</h3>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  <tr>
                    <td class="mailbox-name"><a href="#">{{$fromData->name}}</a></td>
                    <td class="mailbox-subject">{{json_decode($messagedata->data)->message}}
                    </td>
                    <td class="mailbox-attachment"></td>
                    <td class="mailbox-date">..</td>
                  </tr>
                  
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>

          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
@section('scriptarea')
<script type="text/javascript">
  $("input[name='usersearch']").change(function(){
      var usersearch = $(this).val();
      var token = $("input[name='_token']").val();
      $.ajax({
          url: '/searchuser',
          method: 'POST',
          data: {usersearch:usersearch, _token:token},
          success: function(data) {
            $("select[name='branchList'").html('');
            $("select[name='branchList'").html(data.options);
          }
      });
  });
</script>
@endsection