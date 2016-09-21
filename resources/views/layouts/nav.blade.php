{{-- resources/views/layout/nav.blade.php --}}

@section('nav')
<header>
    <div class="navbar navbar-fixed-top navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand toggle visible-xs visible-sm" data-action="toggle" data-side="left"><i class="fa fa-chevron-circle-right"></i></span>
                <a class="navbar-brand" href="/home">Brand</a>
            </div>
            <div class="navbar-collapse collapse navbar-inverse-collapse">
                <ul class="nav navbar-nav navbar-right">
                @if(auth()->guest())
                    @if(!Request::is('auth/login'))
                        <li><a href="{{ url('/auth/login') }}">ログイン</a></li>
                    @endif
                    @if(!Request::is('auth/register'))
                        <li><a href="{{ url('/auth/register') }}">登録</a></li>
                    @endif
                @else
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/auth/logout') }}">ログアウト</a></li>
                        </ul>
                    </li>
                @endif
                </ul>
            </div>
        </div>
    </div>
</header>
@endsection
