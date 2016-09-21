{{-- resources/views/weather/index.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('content')
{{-- dd($data) --}}
<div class="panel-heading">天気</div>
<div class="panel-body">
    <ul class="nav nav-pills nav-stacked">
        @if(auth()->user()->profile->lat && auth()->user()->profile->lng)
        <li><a href="/weather/show/{{ auth()->user()->profile->lat }}/{{ auth()->user()->profile->lng }}" class="btn btn-default btn-raised btn-block"><i class="fa fa-map-marker"></i> 登録した住所の天気を見る</a></li>
        @else
        <li><a href="/profile" class="btn btn-default btn-raised btn-block"><i class="fa fa-edit"></i> 住所を登録する</a></li>
        @endif
        <li><a onclick="getLocation()" class="btn btn-default btn-raised btn-block"><i class="fa fa-crosshairs"></i> 現在地の天気を見る</a></li>
    </ul>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-search"></i></span>
            <input type="text" id="address" name="address" class="form-control" value="">
            <span class="input-group-btn">
                <button class="btn btn-raised btn-default" type="button" onclick="codeAddress()">住所から検索する</button>
            </span>
        </div>
    </div>
</div>
@endsection

@section('after')
@parent
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyDxxIVtc7h11DKOET2O1nBLfTftFK0PnD4"></script>
<script type="text/javascript">
function getLocation() {
    // ユーザーの端末がGeoLocation APIに対応しているかの判定
    if (navigator.geolocation) {
    	// 現在地を取得
    	navigator.geolocation.getCurrentPosition(
    		// [第1引数] 取得に成功した場合の関数
    		function(position) {
    			// 取得したデータの整理
    			var data = position.coords ;
    			// データの整理
    			var lat = data.latitude ;
    			var lng = data.longitude ;
    			location.href = '/weather/show/' + lat + '/' + lng;
    		},
    
    		// [第2引数] 取得に失敗した場合の関数
    		function(error)
    		{
    			// エラーコード(error.code)の番号
    			// 0:UNKNOWN_ERROR				原因不明のエラー
    			// 1:PERMISSION_DENIED			利用者が位置情報の取得を許可しなかった
    			// 2:POSITION_UNAVAILABLE		電波状況などで位置情報が取得できなかった
    			// 3:TIMEOUT					位置情報の取得に時間がかかり過ぎた…
    
    			// エラー番号に対応したメッセージ
    			var errorInfo = [
    				"原因不明のエラーが発生しました。" ,
    				"位置情報の取得が許可されませんでした。" ,
    				"電波状況などで位置情報が取得できませんでした。" ,
    				"位置情報の取得に時間がかかり過ぎてタイムアウトしました。"
    			] ;
    			// アラート表示
    			alert("[エラー番号: " + error.code + "]\n" + errorInfo[ error.code ]);
    		} ,
    
    		// [第3引数] オプション
    		{
    			"enableHighAccuracy": false,
    			"timeout": 8000,
    			"maximumAge": 2000,
    		}
    	) ;
    // 対応していない場合
    } else {
    	// アラート表示
    	alert("お使いの端末には対応していません。") ;
    }
}
// 住所から座標を取得
function codeAddress() {
    var address = $('#address').val();
    if (address.trim() != "") {
        var geocoder = new google.maps.Geocoder();
    	geocoder.geocode( { 'address': address, 'language': 'ja'}, function(results, status) {
    		if (status==google.maps.GeocoderStatus.OK) {
    			var latLngArr = results[0].geometry.location.toUrlValue();
    			var Arrayltlg = latLngArr.split(",");
    			location.href = '/weather/show/' + Arrayltlg[0] + '/' + Arrayltlg[1];
    		} else {
    		    alert("住所から位置情報を取得できませんでした。");
    		}
	        return false;
    	});
    } else {
        alert("住所を正しく入力してください。");
        return false;
    }
}
</script>
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')
