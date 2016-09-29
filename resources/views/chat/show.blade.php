{{-- resources/views/chat/show.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('content')
<div class="talk">
    <p class="right">長くないですか</p>
    <p class="left">次に、吹きだしを置きたいところに下のようなマークアップを書きます</p>
</div>
<form class="form-horizontal" role="form" method="POST" action="{{ url('/chat/store') }}">
    {!! csrf_field() !!}
    <div class="input-group">
        <span class="input-group-btn input-group-sm">
            <button type="button" class="btn btn-fab btn-fab-mini">
                <i class="fa fa-plus"></i>
            </button>
        </span>
        <textarea name="message" class="form-control"></textarea>
        <span class="input-group-btn">
            <button id="send" type="submit" class="btn btn-raised btn-default">送信</button>
        </span>
    </div>
</form>
@endsection

@section('after')
@parent
<script src="//js.pusher.com/3.2/pusher.min.js"></script>
<script>
Pusher.logToConsole = false;
var pusher = new Pusher('{{ env('PUSHER_KEY') }}', {
    encrypted: true
});
var channel = pusher.subscribe('test_channel');
channel.bind('my_event', function(data) {
    var message = data.message;
    $(".talk").append('<p class="right">' + message + '</p>');
});

$('#send').click(function() {
    var fd = new FormData($('#form')[0]);
    $.ajax('/chat/store', {
        type: 'post',
        data: fd,
        success: function(data) {
            alert("");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("");
        }
    });
});

$.get("/chat/update/{{ $id }}", function (data) {
    console.log(data);
});

/* 
$.get("/chat/messages", function (messages) {
    refreshMessages(messages)
});
 */
</script>
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')
