{{-- resources/views/auth/login.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('before')
@parent
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="panel-heading">ログイン</div>
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
    <form class="bs-component" role="form" method="POST" action="{{ url('/auth/login') }}">
        {!! csrf_field() !!}
        <div class="form-group label-floating">
            <label class="control-label" for="email">メールアドレス</label>
            <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" />
        </div>
        <div class="form-group label-floating">
            <label class="control-label" for="password">パスワード</label>
            <input class="form-control" id="password" type="password" name="password" value="{{ old('password') }}" />
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label><input type="checkbox" name="remember" /> パスワードを記憶する</label>
            </div>
            <button type="submit" class="btn btn-raised btn-primary"><i class="fa fa-sign-in"></i> ログイン</button>
            <a class="btn btn-raised btn-default" href="{{ url('/password/email') }}"><i class="fa fa-key"></i> パスワードを忘れた方はこちら</a>
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
        locale: 'ja_JP',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
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
