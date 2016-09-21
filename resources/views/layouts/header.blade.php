{{-- resources/views/layout/head.blade.php --}}

@section('header')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title>@yield('title')</title>
<meta name="description" content="@yield('description')" />
<meta name="keywords" content="@yield('keywords')" />

<meta name="apple-touch-fullscreen" content="yes" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />

<meta name="csrf-token" content="{{ csrf_token() }}" />

<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/favicon.ico" />
<link rel="apple-touch-icon-precomposed apple-touch-icon" href="/apple-touch-icon.png" />

<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons" />
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
  
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/bootstrap-material-design.min.css" />
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/css/ripples.min.css" />
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" />
<link rel="stylesheet" type="text/css" href="/css/custom.css?{{ rand(10000000, 99999999) }}" />

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
@yield('before')
@endsection
