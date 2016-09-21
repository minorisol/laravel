{{-- resources/views/auth/password.blade.php --}}

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
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

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

    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
        {!! csrf_field() !!}

        <div class="form-group">
            <label class="col-md-4 control-label">メールアドレス</label>
            <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-raised btn-primary">パスワード再設定用のリンクを送信する</button>
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
