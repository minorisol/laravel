{{-- resources/views/fm/index.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('content')
<div class="panel-heading">ダウンロード情報を確認</div>
<div class="panel-body">
    <div class="alert alert-warning">
        <h4>注意!</h4>
        <p>
            このファイルの<strong>保存期間は1週間</strong>です。ファイルは<strong>{{ date("Y年m月d日 H時n分",strtotime("+1 week" ,strtotime($data->created_at))) }}</strong>に削除されます。
        </p>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-md-4 control-label">ダウンロードURL</label>
            <div class="col-md-6 control-div">
                <a href="{{ url('/fm/download/' . $data->token) }}" id="clipboard">{{ url('/fm/download/' . $data->token) }}</a>
                <button class="btn btn-raised btn-default" data-clipboard-target="#clipboard"><i class="fa fa-clipboard"></i> クリップボードにコピー</button>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">パスワード</label>
            <div class="col-md-6 control-div">
                ********
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">タイトル</label>
            <div class="col-md-6 control-div">
                {{ $data->title }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">メモ</label>
            <div class="col-md-6 control-div">
                {!! nl2br(e($data->remark)) !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('after')
@parent
<script src="https://cdn.jsdelivr.net/clipboard.js/1.5.12/clipboard.min.js"></script>
<script>
$(function () {
    var clipboard = new Clipboard('.btn');
    clipboard.on('success', function(e) {
        e.clearSelection();
        alert("クリップボードにコピーしました。");
    });
});
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')
