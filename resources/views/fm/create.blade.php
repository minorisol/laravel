{{-- resources/views/password/index.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('content')
<div class="panel-heading">ファイルをアップロード</div>
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
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/fm/store') }}" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group is-empty is-fileinput">
            <label class="col-md-4 control-label">ファイル</label>
            <div class="col-md-6">
                <input type="file" id="file" name="file" multiple="">
                <div class="input-group">
                    <input type="text" readonly="" class="form-control" placeholder="100MB以内のパスワード付きZIPファイル">
                    <span class="input-group-btn input-group-sm">
                        <button type="button" class="btn btn-fab btn-fab-mini">
                            <i class="fa fa-file-archive-o"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">パスワード</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password" value="{{ old('password', $data->password) }}" placeholder="********">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">タイトル</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="title" value="{{ old('title', $data->title) }}" placeholder="ここにタイトルが入ります">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">備考</label>
            <div class="col-md-6">
                <textarea class="form-control" name="remark" placeholder="ここに備考が入ります">{{ old('remark', $data->remark) }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-raised btn-primary"><i class="fa fa-cloud-upload"></i> アップロード</button>
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
            file: {
                validators: {
                    notEmpty: {
                    },
                    file: {
                        extension: 'zip',
                        type: 'application/zip',
                        maxSize: 100000000,
                    }
                }
            },
            title: {
                validators: {
                    notEmpty: {
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
