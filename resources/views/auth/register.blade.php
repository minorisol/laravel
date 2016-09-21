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

    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
        {!! csrf_field() !!}

        <div class="form-group">
            <label class="col-md-4 control-label">ユーザー名</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="example">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">メールアドレス</label>
            <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="example@sampledomain.com">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">パスワード</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password" placeholder="********">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">パスワード（確認用）</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password_confirmation" placeholder="********">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-raised btn-primary">登録する</button>
                <a class="btn btn-raised btn-default" href="{{ url('/auth/resend') }}">登録確認メールを再送する</a>
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
            name: {
                validators: {
                    notEmpty: {
                    },
                    stringLength: {
                        min: 6,
                        max: 30
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]+$/
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
