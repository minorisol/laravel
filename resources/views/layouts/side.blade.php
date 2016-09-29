{{-- resources/views/layout/side.blade.php --}}

@section('side')
<div class="sidebar left">
    <div class="list-group">
        <div class="list-group-item">
            <div class="row-picture">
                @if(auth()->guest())
                <i class="material-icons">grade</i>
                @else
                    @if(auth()->user()->profile->avatar)
                    <a href="/profile" class="btn btn-fab"><img src="{{ auth()->user()->profile->avatar }}" alt="{{ auth()->user()->name }}" width="56" height="56" /></a>
                    @else
                    <i class="material-icons">grade</i>
                    @endif
                @endif
            </div>
            <div class="row-content">
                ようこそ！<br />
                @if(auth()->guest())
                    ゲスト
                @else
                    {{ auth()->user()->name }}
                @endif
                さん
            </div>
        </div>
        <i class="fa fa-chevron-circle-left toggle visible-xs visible-sm" data-action="toggle" data-side="left"></i>
    </div>
    <nav class="menu">
        <ul>
            {{--
            <li class="withripple" data-target="#mail"><a><i class="fa fa-envelope-o"></i> メール</a></li>
            <li class="withripple" data-target="#timeline"><a><i class="fa fa-clock-o"></i> タイムライン</a></li>
            <li class="withripple" data-target="#blog"><a><i class="fa fa-pencil-square-o"></i> ブログ</a></li>
            --}}
            <li class="withripple @if (strstr(Request::url(), 'chat')) active @endif"><a href="/chat"><i class="fa fa-comments-o"></i> チャット</a></li>
            <li class="withripple @if (strstr(Request::url(), 'friend')) active @endif"><a href="/friend"><i class="fa fa-users"></i> フレンド</a></li>
            <li class="withripple @if (strstr(Request::url(), 'weather')) active @endif"><a href="/weather"><i class="fa fa-sun-o"></i> 天気</a></li>
            <li class="withripple @if (strstr(Request::url(), 'map')) active @endif"><a href="/map"><i class="fa fa-map-marker"></i> 地図</a></li>
            <li class="withripple @if (strstr(Request::url(), 'fm')) active @endif"><a href="/fm"><i class="fa fa-hdd-o"></i> ファイル共有</a></li>
            <li class="withripple @if (strstr(Request::url(), 'pm')) active @endif"><a href="/pm"><i class="fa fa-key"></i> パスワード管理</a></li>
            <li class="withripple @if (strstr(Request::url(), 'profile')) active @endif"><a href="/profile"><i class="fa fa-user"></i> プロフィール</a></li>
            <li class="withripple @if (strstr(Request::url(), 'settings')) active @endif"><a href="/settings"><i class="fa fa-cog"></i> 設定</a></li>
        </ul>
    </nav>
</div>
@endsection
