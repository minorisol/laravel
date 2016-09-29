{{-- resources/views/friend/index.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('content')
<div class="panel-heading">フレンドリスト</div>
<div class="panel-body">
    <div class="list-group">
        @forelse($datas as $data)
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
        現在フレンドがいません。
        @endforelse
        {{ $datas->render() }}
    </div>
</div>

<div class="panel-heading">フレンドを招待する</div>
<div class="panel-body">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/friend/invite') }}">
        {!! csrf_field() !!}
        <div class="form-group">
            <label class="col-md-4 control-label">メールで招待</label>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="email" name="email" class="form-control" value="" placeholder="example@sampledomain.com" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-fab btn-fab-mini"><i class="material-icons">send</i></button>
                    </span>
                </div>
            </div>
        </div>
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
        <div class="form-group">
            <label class="col-md-4 control-label">招待用QRコード</label>
            <div class="col-md-6">
                <div id="qrcode"></div>
            </div>
        </div>
    </form>
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
