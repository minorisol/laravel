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

    <form class="bs-component" role="form" method="POST" action="{{ url('/password/reset') }}">
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group label-floating">
            <label class="control-label" for="email">メールアドレス</label>
            <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" />
        </div>
        <div class="form-group label-floating">
            <label class="control-label" for="password">新しいパスワード</label>
            <input class="form-control" id="password" type="password" name="password" value="{{ old('password') }}" />
        </div>
        <div class="form-group label-floating">
            <label class="control-label" for="password_confirmation">パスワード（確認用）</label>
            <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-raised btn-primary"><i class="fa fa-key"></i> パスワードを再設定する</button>
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