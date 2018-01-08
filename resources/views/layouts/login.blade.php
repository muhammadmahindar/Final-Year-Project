<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Meta Author-->
    <meta name="author" content="Muhammad Mahin Dar">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- App Title -->
    <title>@yield('title') | CPMS </title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CPMS') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <!-- Bootstrap 3.3.7 -->
    <link href="{{ asset('css/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('css/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Ionicons -->
    <link href="{{ asset('css/bower_components/Ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <!-- Theme style -->
    <link href="{{ asset('css/dist/css/AdminLTE.min.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('css/plugins/iCheck/square/blue.css') }}" rel="stylesheet">
     @yield('cssarea')  
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Petro</b>Chemical</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    
    @yield('content')

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->    

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>

<!-- jQuery 3 -->
 <script src="{{ asset('css/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('css/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('css/plugins/iCheck/icheck.min.js') }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
@yield('scriptarea')
</body>
</html>
