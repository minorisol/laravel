{{-- resources/views/home.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('content')
<div class="panel-heading">ホーム</div>
<div class="panel-body">
    ようこそ！<br />
    ここはホームページです。<br />
</div>
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')