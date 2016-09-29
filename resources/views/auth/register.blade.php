{{-- resources/views/auth/register.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('header')
@parent
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="panel-heading">ユーザー登録</div>
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

    <form class="bs-component" role="form" method="POST" action="{{ url('/auth/register') }}">
        {!! csrf_field() !!}
        <div class="form-group label-floating">
            <label class="control-label" for="name">ユーザー名</label>
            <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" />
        </div>
        <div class="form-group label-floating">
            <label class="control-label" for="email">メールアドレス</label>
            <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" />
        </div>
        <div class="form-group label-floating">
            <label class="control-label" for="password">パスワード</label>
            <input class="form-control" id="password" type="password" name="password" value="{{ old('password') }}" />
        </div>
        <div class="form-group label-floating">
            <label class="control-label" for="password_confirmation">パスワード（確認用）</label>
            <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-raised btn-primary"><i class="fa fa-user"></i> 登録する</button>
            <a class="btn btn-raised btn-default" href="{{ url('/auth/resend') }}"><i class="fa fa-send"></i> 登録確認メールを再送する</a>
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
            name: {
                validators: {
                    notEmpty: {
                    },
                    stringLength: {
                        min: 2,
                        max: 30
                    }
                }
            },
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
            },
            password_confirmation: {
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
