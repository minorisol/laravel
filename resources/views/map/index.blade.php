{{-- resources/views/map/index.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('content')
<div class="panel-heading">地図</div>
<div id="map_canvas" style="width:100%;height:100%;min-height:480px;"></div>
@endsection

@section('after')
@parent
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyDxxIVtc7h11DKOET2O1nBLfTftFK0PnD4"></script>
<script type="text/javascript">
$(function($) {
    // gps に対応しているかチェック
    if (! navigator.geolocation) {
        $('#map_canvas').text('GPSに対応したブラウザでお試しください');
        return false;
    }

    $('#map_canvas').text('GPSデータを取得します...');

    // gps取得開始
    navigator.geolocation.getCurrentPosition(function(pos) {
        // gps 取得成功
        // google map 初期化
        var map_canvas = new google.maps.Map($('#map_canvas').get(0), {
            center: new google.maps.LatLng(35, 135),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 17
        });

        // 現在位置にピンをたてる
        var currentPos = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
        var currentMarker = new google.maps.Marker({
            position: currentPos
        });
        currentMarker.setMap(map_canvas);

        // 誤差を円で描く
        new google.maps.Circle({
            map: map_canvas,
            center: currentPos,
            radius: pos.coords.accuracy, // 単位はメートル
            strokeColor: '#0088ff',
            strokeOpacity: 0.8,
            strokeWeight: 1,
            fillColor: '#0088ff',
            fillOpacity: 0.2
        });

        // 現在地にスクロールさせる
        map_canvas.panTo(currentPos);

    }, function() {
        // gps 取得失敗
        $('#map_canvas').text('GPSデータを取得できませんでした');
        return false;
    });
});
</script>
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')
