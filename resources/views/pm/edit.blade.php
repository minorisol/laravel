{{-- resources/views/password/edit.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('header')
@parent
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="panel-heading">登録｜パスワード管理</div>
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

    @if(strlen($data->id) > 0)
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/pm/update') }}">
        <input type="hidden" name="id" value="{{ $data->id }}" />
    @else
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/pm/store') }}">
    @endif
        {!! csrf_field() !!}
        <div class="form-group">
            <label class="col-md-4 control-label">タイトル</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="title" value="{{ old('title', $data->title) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">アカウントID</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="account_id" value="{{ old('account_id', $data->account_id) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">パスワード</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="password" value="{{ old('password', $data->password) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">URL</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="url" value="{{ old('url', $data->url) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">メモ</label>
            <div class="col-md-6">
                <textarea class="form-control" name="remark">{{ old('remark', $data->remark) }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-raised btn-primary">登録</button>
                <a href="[BACK]" class="btn btn-raised btn-default"><i class="fa fa-reply"></i> 戻る</a>
            </div>
        </div>
    </form>
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
            title: {
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
