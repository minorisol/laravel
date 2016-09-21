<!DOCTYPE html>
<html lang="ja">
<head>
    @yield('header')
</head>
<body>
<div id="loading" class="progress">
    <div class="indeterminate"></div>
</div>
<div id="wrap" class="blur">
    @yield('nav')
    <main>
        <div class="container">
            <div class="row">
                @yield('side')
                @if (Session::has('message'))
                <div class="col-md-12 content fadeInLeft animated">
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                </div>
                @endif
                <div class="col-md-12 content fadeInLeft animated">
                    <div class="panel panel-info">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>
    @yield('footer')
</div>
</body>
</html>
