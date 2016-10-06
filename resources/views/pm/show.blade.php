{{-- resources/views/pm/show.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('content')
<div class="panel-heading">詳細｜パスワード管理</div>
<div class="panel-body">
    <div class="form-horizontal">
        <div class="form-group">
            <label class="col-md-4 control-label">タイトル</label>
            <div class="col-md-6 control-div">
                {{ $data->title }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">アカウントID</label>
            <div class="col-md-6 control-div">
                {{ $data->account_id }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">パスワード</label>
            <div class="col-md-6 control-div">
                {{ $data->password }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">URL</label>
            <div class="col-md-6 control-div">
                <a href="{{ $data->url }}" target="_blank">{{ $data->url }}</a>
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
                <a href="/pm/edit/{{ $data->id }}" class="btn btn-raised btn-success"><i class="fa fa-pencil"></i> 編集</a>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')
