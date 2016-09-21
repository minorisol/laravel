{{-- resources/views/profile/index.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('before')
@parent
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css" />
@endsection

@section('content')
<div class="panel-heading">プロフィール</div>
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
    <form id="form" class="form-horizontal" role="form" method="POST" action="/profile/update" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group">
            <label class="col-md-4 control-label">名前</label>
            <div class="col-md-6">
                <input type="text" name="name" class="form-control" value="{{ old('name', $data->name) }}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">メールアドレス</label>
            <div class="col-md-6">
                <input type="text" class="form-control" value="{{ old('email', $data->email) }}" disabled="disabled" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">パスワード</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="" value="********">
                <a href="/password/email" class="btn btn-raised btn-default">パスワードの再設定はこちら</a>
            </div>
        </div>
        <input type="hidden" name="avatar" id="avatar" value="{{ old('avatar', $data->Profile->avatar) }}">
        @if($data->Profile->avatar)
        <div id="show" class="form-group">
            <label class="col-md-4 control-label">写真</label>
            <div class="col-md-6">
                <img id="thumb" src="{{ old('avatar', $data->Profile->avatar) }}" alt="" /><br />
                <button type="button" id="remove" class="btn btn-raised btn-warning"><i class="fa fa-remove"></i> 削除する</button>
            </div>
        </div>
        @endif
        <div id="selector" class="form-group" @if($data->Profile->avatar) style="display:none;" @endif>
            <label class="col-md-4 control-label">写真</label>
            <div class="col-md-6">
                <input type="file" name="photo" id="photo" multiple="">
                <div class="input-group">
                    <input type="text" readonly="" class="form-control" placeholder="ファイルを選択、またはドラッグ＆ドロップしてください">
                    <span class="input-group-btn input-group-sm">
                        <button type="button" class="btn btn-fab btn-fab-mini"><i class="fa fa-file-o"></i></button>
                    </span>
                </div>
            </div>
        </div>
        <div id="editor" class="form-group" style="display:none;">
            <label class="col-md-4 control-label">写真</label>
            <div class="col-md-6">
                <div id="cropper">
                    <img id="thumb" class="img-responsive" src="" alt="">
                </div>
                <button type="button" id="getData" class="btn btn-raised btn-primary"><i class="fa fa-save"></i> 保存する</button>
            </div>
        </div>
        <div id="done" class="form-group" style="display:none;">
            <label class="col-md-4 control-label">写真</label>
            <div class="col-md-6">
                <div id="cropper">
                    <img id="image" src="" alt=""><br />
                    <button type="button" id="remove" class="btn btn-raised btn-warning"><i class="fa fa-remove"></i> やり直す</button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">一言メッセージ</label>
            <div class="col-md-6">
                <textarea name="message" class="form-control">{!! old('message', $data->Profile->message) !!}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">電話番号</label>
            <div class="col-md-6">
                <input type="tel" id="tel" name="tel" class="form-control" value="{{ old('tel', $data->Profile->tel) }}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">郵便番号</label>
            <div class="col-md-6">
                <input type="text" id="zip" name="zip" class="form-control" value="{{ old('zip', $data->Profile->zip) }}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">住所</label>
            <div class="col-md-6">
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $data->Profile->address) }}" />
            </div>
        </div>
        <input type="hidden" id="lat" name="lat" value="{{ old('lat', $data->Profile->lat) }}" />
        <input type="hidden" id="lng" name="lng" value="{{ old('lng', $data->Profile->lng) }}" />
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="button" class="btn btn-raised btn-primary" onclick="codeAddress()"><i class="fa fa-save"></i> 登録</button>
                <a href="[BACK]" class="btn btn-raised btn-default"><i class="fa fa-reply"></i> 戻る</a>
            </div>
            <div class="col-md-6 col-md-offset-4">
                <a id="delete" class="btn btn-raised btn-warning"><i class="fa fa-remove"></i> このアカウントを削除する</a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('after')
@parent
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyDxxIVtc7h11DKOET2O1nBLfTftFK0PnD4"></script>
<script type="text/javascript">
// 住所から座標を取得
function codeAddress() {
    var address = $('#zip').val() + ' ' + $('#address').val();
    if (address.trim() != "") {
        var geocoder = new google.maps.Geocoder();
    	geocoder.geocode( { 'address': address, 'language': 'ja'}, function(results, status) {
    		if (status==google.maps.GeocoderStatus.OK) {
    			var latLngArr = results[0].geometry.location.toUrlValue();
    			var Arrayltlg = latLngArr.split(",");
                $('#lat').val(Arrayltlg[0]);
                $('#lng').val(Arrayltlg[1]);
    		}
	        return $('form').submit();
    	});
    } else {
        return $('form').submit();
    }
}
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.js"></script>
<script type="text/javascript">
$("#photo").change(function () {
    var fd = new FormData($('#form')[0]);
    $.ajax('/profile/upload', {
        type: 'post',
        processData: false,
        contentType: false,
        data: fd,
        dataType: "json",
        success: function(data) {
            $('#thumb').attr('src', data.img);
            $('#selector').css('display', 'none');
            $('#editor').css('display', 'block');
            var $image = $('#cropper > img'), replaced;
            $('#thumb').cropper({
                aspectRatio: 4 / 4
            });
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("ファイルのアップロードに失敗しました");
        }
    });
});

$('#getData').click(function(){
    var data = $('#thumb').cropper('getData');
    var image = {
        thumb: $("#thumb").attr('src'),
        width: Math.round(data.width),
        height: Math.round(data.height),
        x: Math.round(data.x),
        y: Math.round(data.y),
    };
    $.ajax('/profile/trim', {
        type: 'post',
        data: image,
        dataType: "json",
        success: function(data) {
            if(data.response == false) {
                alert("画像の加工に失敗しました");
            } else {
                $('#avatar').val(data.img);
                $('#image').attr('src', data.img);
                $('#editor').css('display', 'none');
                $('#done').css('display', 'block');
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("画像の加工に失敗しました");
        }
    });
});

$('#remove').click(function(){
    var avatar = $('#avatar').val();
    $.ajax('/profile/remove', {
        type: 'get',
        data: {avatar: avatar},
        dataType: "json",
        success: function(data) {
            if(data.response == false) {
                alert("画像の削除に失敗しました");
            } else {
                $('#photo').val('');
                $('#avatar').val('');
                $('#show').css('display', 'none');
                $('#selector').css('display', 'block');
                $('#done').css('display', 'none');
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("画像の削除に失敗しました");
        }
    });
});

$('#delete').click(function(){
    if (!confirm("アカウントを削除します。\n一度アカウントを削除すると元に戻せません。\n本当によろしいですか？")) {
        return false;
    } else {
        location.href = '/profile/destroy';
    }
});
</script>
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')
