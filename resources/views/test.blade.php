<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Meta Author-->
    <meta name="author" content="Muhammad Mahin Dar">
    <!-- App favicon -->
    <!-- App Title -->
    <title>@yield('title') | CPMS </title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CPMS') }}</title>


</head>
<body>
<script>
    var chatDiv = document.createElement('div');
    chatDiv.className = 'fb-customerchat';
    chatDiv.setAttribute('page_id', '204334060167088');
    document.body.appendChild(chatDiv);
    window.fbAsyncInit = function() {
        FB.init({
            appId            : '850652791742367',
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v3.2'
        });
    };
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
</body>
</html>