{{-- resources/views/auth/reset.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('header')
@parent
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="panel-heading">パスワード再設定</div>
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

    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label class="col-md-4 control-label">メールアドレス</label>
            <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">新しいパスワード</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">新しいパスワード（確認用）</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password_confirmation">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-raised btn-primary">パスワードを再設定する</button>
                <a href="[BACK]" class="btn btn-raised btn-default"><i class="fa fa-reply"></i> 戻る</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('footer')
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
            email: {
                validators: {
                    notEmpty: {
                    },
                    emailAddress: {
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                    },
                    stringLength: {
                        min: 6
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