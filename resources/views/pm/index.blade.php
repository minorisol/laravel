{{-- resources/views/pm/index.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('content')
<div class="panel-heading">パスワード管理</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>アカウントID</th>
                <th>パスワード</th>
                <th>URL</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $data)
            <tr>
                <td>{{ $data->title }}</td>
                <td>{{ $data->account_id }}</td>
                <td>{{ $data->password }}</td>
                <td>{{ $data->url }}</td>
                <td>
                    <a href="/pm/show/{{ $data->id }}" class="btn btn-default btn-raised btn-xs"><i class="fa fa-file-text"></i> 詳細</a>
                    <a href="/pm/edit/{{ $data->id }}" class="btn btn-success btn-raised btn-xs"><i class="fa fa-edit"></i> 編集</a>
                    <a href="/pm/delete/{{ $data->id }}" class="btn btn-danger btn-raised btn-xs"><i class="fa fa-trash"></i> 削除</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $datas->render() }}
</div>
<div class="panel-body">
    <div class="col-md-6 col-md-offset-4">
        <a href="/pm/create" class="btn btn-primary btn-raised"><i class="fa fa-edit"></i> 新規作成</a>
    </div>
</div>
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')
