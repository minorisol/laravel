{{-- resources/views/layout/footer.blade.php --}}

@section('footer')
<footer class="footer col-sm-12">
    <div class="container">
        <p class="text-muted text-center">Copyright &copy; 2016 Brand inc. All Rights Reserved.</p>
    </div>
</footer>
<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-sidebar/3.3.2/jquery.sidebar.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/ripples.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
// トークン
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(function(){
    // デザイン＆アニメーション設定
    $.material.init();
    new WOW().init();
    // リンクをクリックした場
    $('a[href]').each(function(){
        var url = $(this).attr('href');
        if (url.indexOf('#') == -1) {
            $(this).removeAttr('href');
            $(this).click(function(){
                $("#wrap").addClass("blur");
                $("#loading").addClass("progress");
                $(".col-md-12.content").removeClass("fadeInLeft");
                $(".col-md-12.content").addClass("fadeOutLeft");
                if(url == '[BACK]'){
                    setTimeout(function(){window.history.back();}, 1000);
                } else {
                    location.href = url;
                }
            });
        }
    });
    // ボタンをクリックした場合
    $('[type="submit"]').each(function() {
        $(this).click(function(){
            if (!$('form').has('.has-error')) {
                $("#wrap").addClass("blur");
                $("#loading").addClass("progress");
                $(".col-md-12.content").removeClass("fadeInLeft");
                $(".col-md-12.content").addClass("fadeOutLeft");
            }
        });
    });
    // サイドバーの設定
    setTimeout(function() {
        $("#wrap").removeClass("blur");
        $("#loading").removeClass("progress");
    }, 1000);
    $(".sidebar.left").sidebar({side: "left"});
    $(".toggle[data-action]").on("click", function () {
        var $this = $(this);
        var action = $this.attr("data-action");
        var side = $this.attr("data-side");
        $(".sidebar." + side).trigger("sidebar:" + action);
        return false;
    });
});
</script>
@yield('after')
@endsection
