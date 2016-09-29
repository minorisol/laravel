{{-- resources/views/chat/index.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('content')
<ul class="nav nav-tabs" style="margin-bottom: 15px;">
    <li class="active"><a href="#talk" data-toggle="tab">トーク</a></li>
    <li><a href="#friend" data-toggle="tab">フレンド</a></li>
    <li><a href="#group" data-toggle="tab">グループ</a></li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" data-target="#">招待する <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="#dropdown1" data-toggle="tab">メールで招待</a></li>
            <li><a href="#dropdown2" data-toggle="tab">招待用URL表示</a></li>
            <li><a href="#dropdown3" data-toggle="tab">QRコード</a></li>
        </ul>
    </li>
</ul>
<div id="myTabContent" class="panel-body tab-content">
    <div class="tab-pane fade active in" id="talk">
        <div class="list-group">
            @forelse($groups as $data)
            <div class="list-group-item">
                <div class="row-picture">
                    @if(isset($data->user->profile->avatar) && strlen($data->user->profile->avatar) > 0)
                    <img src="{{ $data->user->profile->avatar }}" alt="{{ $data->user->name }}" class="circle" width="56" height="56" /></a>
                    @else
                    <i class="material-icons"><i class="fa fa-user"></i></i>
                    @endif
                </div>
                <div class="row-content">
                    <div class="least-content">
                        <button type="button" data-href="/friend/destroy/{{ $data->id }}" id="delete" class="btn btn-raised btn-xs btn-danger"><i class="fa fa-remove"></i> 削除</a></button>
                    </div>
                    <h4 class="list-group-item-heading">{{ $data->user->name }}</h4>
                    <p class="list-group-item-text">{{ $data->user->profile->message }}</p>
                </div>
            </div>
            <div class="list-group-separator"></div>
            @empty
            トーク履歴がありません。
            @endforelse
            {{ $groups->render() }}
        </div>
    </div>
    <div class="tab-pane fade active in" id="friend">
        <div class="list-group">
            @forelse($friends as $data)
            <div class="list-group-item">
                <div class="row-picture">
                    <a href="/chat/create/{{ $data->user->id }}">
                        @if(isset($data->user->profile->avatar) && strlen($data->user->profile->avatar) > 0)
                        <img src="{{ $data->user->profile->avatar }}" alt="{{ $data->user->name }}" class="circle" width="56" height="56" /></a>
                        @else
                        <i class="material-icons"><i class="fa fa-user"></i></i>
                        @endif
                    </a>
                </div>
                <div class="row-content">
                    <div class="least-content">
                        <button type="button" data-href="/friend/destroy/{{ $data->id }}" id="delete" class="btn btn-raised btn-xs btn-danger"><i class="fa fa-remove"></i> 削除</a></button>
                    </div>
                    <h4 class="list-group-item-heading">{{ $data->user->name }}</h4>
                    <p class="list-group-item-text">{{ $data->user->profile->message }}</p>
                </div>
            </div>
            <div class="list-group-separator"></div>
            @empty
            現在フレンドがいません。
            @endforelse
            {{ $friends->render() }}
        </div>
    </div>
    <div class="tab-pane fade" id="group">
        <form class="bs-component" role="form" method="POST" action="{{ secure_url('/chat/create') }}">
            {!! csrf_field() !!}
            <div class="list-group">
                @forelse($friends as $data)
                <div class="list-group-item">
                    <div class="row-action-primary checkbox">
                        <label><input type="checkbox" name="user_id[]" value="{{ $data->user->id }}" /></label>
                    </div>
                    <div class="row-content">
                        <div class="least-content">
                            <button type="button" data-href="/friend/destroy/{{ $data->id }}" id="delete" class="btn btn-raised btn-xs btn-danger"><i class="fa fa-remove"></i> 削除</a></button>
                        </div>
                        <h4 class="list-group-item-heading">{{ $data->user->name }}</h4>
                        <p class="list-group-item-text">{{ $data->user->profile->message }}</p>
                    </div>
                </div>
                <div class="list-group-separator"></div>
                @empty
                現在フレンドがいません。
                @endforelse
                {{ $friends->render() }}
            </div>
            <button type="submit" class="btn btn-raised btn-primary"><i class="fa fa-check"></i> トーク開始</button>
        </form>
    </div>
    <div class="tab-pane fade" id="dropdown1">
        <form class="bs-component" role="form" method="POST" action="{{ url('/friend/invite') }}">
            {!! csrf_field() !!}
            <div class="form-group label-floating">
                <label class="control-label" for="email">メールアドレス</label>
                <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" />
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-fab btn-fab-mini"><i class="material-icons">send</i></button>
                </span>
            </div>
        </form>
    </div>
    <div class="tab-pane fade" id="dropdown2">
        <div class="form-group">
            <label class="col-md-4 control-label">招待用URL</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="url" class="form-control" id="url" value="{{ url('/friend/confirm/' . auth()->user()->profile->token) }}" readonly="" />
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-fab btn-fab-mini" data-clipboard-target="#url"><i class="material-icons">attach_file</i></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="dropdown3">
        <div class="form-group">
            <label class="col-md-4 control-label">QRコード</label>
            <div class="col-md-6">
                <div id="qrcode"></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <a href="[BACK]" class="btn btn-raised btn-default"><i class="fa fa-reply"></i> 戻る</a>
        </div>
    </div>
</div>
@endsection

@section('after')
@parent
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
<script>
$(function () {
    // QRコード表示
    $('#qrcode').qrcode("{{ url('/friend/confirm/' . auth()->user()->profile->token) }}");
    
    // URLをクリップボードにコピー
    var clipboard = new Clipboard('.btn');
    clipboard.on('success', function(e) {
        e.clearSelection();
        alert('クリップボードにコピーしました。');
    });
});

$('#delete').click(function(){
    if (!confirm("フレンドを削除します。\n本当によろしいですか？")) {
        return false;
    } else {
        location.href = $('#delete').attr("data-href");
    }
});
</script>
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')
