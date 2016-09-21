{{-- resources/views/password/index.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('content')
<div class="panel-heading">アップロードファイル一覧</div>
@if(is_array($datas) && count($datas) > 0)
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>ダウンロードURL</th>
                <th>ダウンロード期限</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $data)
            <tr>
                <td>{{ $data->title }}</td>
                <td><a href="{{ url('/fm/download/' . $data->token) }}">{{ url('/fm/download/' . $data->token) }}</a></td>
                <td>{{ date("Y年m月d日 H時n分",strtotime("+1 week" ,strtotime($data->created_at))) }}</td>
                <td>
                    <a href="/fm/show/{{ $data->id }}" class="btn btn-default btn-raised btn-xs"><i class="fa fa-file-text"></i> 詳細</a>
                    <a href="/fm/delete/{{ $data->id }}" class="btn btn-danger btn-raised btn-xs"><i class="fa fa-trash"></i> 削除</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="panel-body">
    現在、共有中のファイルはありません。
</div>
@endif
<div class="panel panel-footer">
    {{ $datas->render() }}
    <a href="/fm/create" class="btn btn-primary btn-raised"><i class="fa fa-cloud-upload"></i> 新規アップロード</a>
    <a href="[BACK]" class="btn btn-raised btn-default"><i class="fa fa-reply"></i> 戻る</a>
</div>
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')
