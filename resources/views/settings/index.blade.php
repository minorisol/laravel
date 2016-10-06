{{-- resources/views/settings/index.blade.php --}}

@extends('layouts.master')

@section('title', 'Laravel')
@section('description', 'Laravel')
@section('keywords', 'Laravel')

@section('before')
@parent
<script type="text/javascript">
(function(p,u,s,h){
    p._pcq=p._pcq||[];
    p._pcq.push(['_currentTime',Date.now()]);
    s=u.createElement('script');
    s.type='text/javascript';
    s.async=true;
    s.src='https://cdn.pushcrew.com/js/921b5dd1f78714c3976c5e3d59afa225.js';
    h=u.getElementsByTagName('script')[0];
    h.parentNode.insertBefore(s,h);
})(window,document);
</script>
@endsection

@section('content')
<div class="panel-heading">設定</div>
<div class="panel-body">
    <div class="togglebutton">
        <label>
            プッシュ通知を受け取る　<input type="checkbox" id="push" name="push" />
        </label>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-6 col-md-offset-4">
        <a href="/settings" class="btn btn-raised btn-primary">設定を保存する</a>
    </div>
</div>
@endsection

@section('after')
@parent
<script type="text/javascript">
_pcq.push(['noTrigger',true]);
_pcq.push(['APIReady', callbackOnSuccessFunction]);
function callbackOnSuccessFunction() {
	// window._pcq.push(['triggerOptIn',{httpWindowOnly: true}]);
    var subscriber = pushcrew.subscriberId;
    // プッシュ状況チェック
    if (subscriber != false) {
        $.ajax({
            url: '/settings/check',
            type: "post",
            data: {'subscriber': subscriber},
            success: function(data){
                if(data.msg == 'checked' || data.msg == 'success'){
                    $('#push').attr('checked', 'checked');
                }
            }
        });
    }
    // トグルボタンクリック処理
    $("#push").click(function() {
        if ($("#push").attr('checked') == 'checked') {
            $('#push').removeAttr("checked");
            if (subscriber != false) {
                window._pcq.push(['triggerOptOut']);
                $.ajax({
                    url: '/settings/destroy',
                    type: "post",
                    data: {'subscriber': subscriber},
                    success: function(data){
                        $.removeCookie('wingify_push_do_status');
                        $.removeCookie('wingify_push_subscriber_id');
                        $.removeCookie('wingify_push_subscription_id');
                        $.cookie('wingify_push_subscription_status', 'unsubscribed');
                    }
                });
            }
        } else {
            $('#push').attr('checked', 'checked');
            if ($("#push").attr('checked') == 'checked') {
                window._pcq.push(['triggerOptIn']);
            }
        }
    });
}
</script>
@endsection

@include('layouts.header')
@include('layouts.nav')
@include('layouts.side')
@include('layouts.footer')
