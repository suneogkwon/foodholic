<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/jquery.shop.list.js"></script>', 10);
?>

<!-- 상품진열 30 시작 { -->
<?php
for ($i=1; $row=sql_fetch_array($result); $i++) {
    if ($this->list_mod >= 2) { // 1줄 이미지 : 2개 이상
        if ($i%$this->list_mod == 0) $sct_last = 'sct_last'; // 줄 마지막
        else if ($i%$this->list_mod == 1) $sct_last = 'sct_clear'; // 줄 첫번째
        else $sct_last = '';
    } else { // 1줄 이미지 : 1개
        $sct_last = 'sct_clear';
    }

    if ($i == 1) {
        if ($this->css) {
            echo "<ul class=\"{$this->css}\">\n";
        } else {
            echo "<ul class=\"sct sct_30\">\n";
        }
    }

    echo "<li class=\"sct_li {$sct_last}\">\n";
	echo "<div class=\"sct_li_innr\">\n";
    echo "<div class=\"sct_img\">\n";

    if ($this->href) {
        echo "<a href=\"{$this->href}{$row['it_id']}\">\n";
    }

    if ($this->view_it_img) {
        echo get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."\n";
    }
    if ($this->href) {
        echo "</a>\n";
    }


    echo "<div class=\"sct_btn\">
    <button type=\"button\" class=\"btn_wish\" data-it_id=\"{$row['it_id']}\"><span class=\"sound_only\">위시리스트</span></button>
    </div>\n";

	if ($this->href) {
        echo "<a href=\"{$this->href}{$row['it_id']}\" class=\"li_hover\">\n";
    }
	echo "<span class=\"sound_only\">상품페이지로 이동하기</span>\n";
	if ($this->href) {
        echo "</a>\n";
    }
	
    if ($this->view_it_id) {
        echo "<div class=\"sct_id\">&lt;".stripslashes($row['it_id'])."&gt;</div>\n";
    }
        echo "</div>\n";

    if ($this->href) {
        echo "<div class=\"sct_txt\">\n";
    }

    $s_core  =  (int)$row['it_use_avg']; 
    if ($s_core > 0 ) { 
        echo "<span class=\"sct_star\"><img src=".G5_SHOP_URL."/img/s_star".$s_core.".png></span>"; 
    } 

    if ($this->href) {
        echo "<a href=\"{$this->href}{$row['it_id']}\" class=\"sct_tit\">\n";
    }

    if ($this->view_it_name) {
        echo stripslashes($row['it_name'])."\n";
    }

    if ($this->href) {
        echo "</a>\n";
    }


    if ($this->view_it_basic && $row['it_basic']) {
        echo "<div class=\"sct_basic\">".stripslashes($row['it_basic'])."</div>\n";
    }

    if ($this->view_it_cust_price || $this->view_it_price) {

        echo "<div class=\"sct_cost\">\n";

        if ($this->view_it_price) {
            echo display_price(get_price($row), $row['it_tel_inq'])."\n";
        }

        if ($this->view_it_cust_price && $row['it_cust_price']) {
            echo "<span class=\"sct_discount\">".display_price($row['it_cust_price'])."</span>\n";
        }

        echo "</div>\n";

    }

    if ($this->view_it_icon) {
        echo item_icon2($row);
    }

    echo "</div>\n";
	echo "</div>\n";
    
    echo "</li>\n";
}

if ($i > 1) echo "</ul>\n";

if($i == 1) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>


<script>

$('.btn_share').click(function(){
    $(this).parent().next('.sct_sns').show();
});

$('.sct_sns_wr .btn_close').click(function(){
    $('.sct_sns').hide();
});

$('.sct_sns .bg').click(function(){
    $('.sct_sns').hide();
});
</script>
<!-- } 상품진열 30 끝 -->