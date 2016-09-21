{{-- resources/views/password/index.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('before')
@parent
@if (Session::has('download'))
<meta http-equiv="refresh" content="0;URL={{ Session::get('download') }}">
@endif

@endsection
            
@section('content')
<div class="panel-heading">ファイルをダウンロード</div>
<div class="panel-body">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>おっと!</strong> いくつかの入力に問題があります。<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (!$data)
    <div class="alert alert-warning">
        <h4>ファイルが存在しません</h4>
        <p>URLを間違えているか、ダウンロード期限が過ぎた可能性があります。</p>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-4">
            <a href="javascript:history.back();" class="btn btn-raised btn-default"><i class="fa fa-reply"></i> 戻る</a>
        </div>
    </div>
    @else
    <div class="alert alert-warning">
        <h4>注意!</h4>
        <p>このファイルは<strong>{{ date("Y年m月d日 H時n分",strtotime("+1 week" ,strtotime($data->created_at))) }}</strong>に削除されます。</p>
    </div>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/fm/download') }}">
        {!! csrf_field() !!}
        <input type="hidden" class="form-control" name="token" value="{{ old('token', $data->token) }}">
        <div class="form-group">
            <label class="col-md-4 control-label">パスワード</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password" value="">
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
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-raised btn-primary"><i class="fa fa-cloud-download"></i> ダウンロード</button>
                <a href="[BACK]" class="btn btn-raised btn-default"><i class="fa fa-reply"></i> 戻る</a>
            </div>
        </div>
    </form>
    @endif
</div>
@endsection

@section('after')
@parent
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/language/ja_JP.min.js"></script>
<script>
$(document).ready(function() {
    $('form').bootstrapValidator({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        locale: 'ja_JP',
        fields: {
            password: {
                validators: {
                    notEmpty: {
                    }
                }
            }
        }
    });
});
</script>
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')
