<?php
include_once('./_common.php');

$g5['title'] = '배송가능지역';

include_once(G5_THEME_SHOP_PATH . '/shop.head.php');

add_javascript('<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>', 0);
?>

<div class='content'>
    <div class="floatwrap">
        <div class="search_area_wrap">
            <div id="search_area">
            </div>
        </div>
    </div>
</div>

<?php
include_once(G5_THEME_SHOP_PATH . '/shop.tail.php');
?>

<script>
    $(function() {
        var element_wrap = document.getElementById('search_area');
        new daum.Postcode({
            oncomplete: function(data) {
                var params = {
                    address: data.address,
                    sido: data.sido,
                    gungu: data.sigungu,
                    dongri: data.bname
                };
                console.log(params);
                $.ajax({
                    url: "./ajax.chk_delivery_area.php",
                    type: "post",
                    dataType: "html",
                    data: params,
                    success: function(d) {
                        alert(d);
                    },
                    error: function(res) {
                        console.log(res);
                    }
                });
            },
            width:'100%',
            height:'100%'
        }).embed(element_wrap,{
            autoClose: false //기본값 true
        });

    });
</script>