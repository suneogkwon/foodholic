<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/jquery.shop.list.js"></script>', 10);
?>
 <div class="floatwrap">
    <!-- 상품진열 10 시작 { -->
    <?php
    $s_cart_id = get_session('ss_cart_id');
    $tableDate;
    $tableYear;
    $tableMonth;
    $tableDay;
    $tableWeek;
    $tableMaxDay;
    $itemDate;
    $itemYear;
    $itemMonth;
    $itemDay;
    $presentYear = date('Y');
    $presentMonth = date('m');
    $presentDay = date('d');
    $week = array("일","월","화","수","목","금","토");

    echoDays($this->list_mod); // 요일 출력

    for($i=1;$i<=36;$i++){ // 2021042026
        if($i==1){
            $row=sql_fetch_array($result);
            
            while($row && mb_substr($row['it_id'],0,6) <= date('Ym')) {
                $tableYear = $itemYear = mb_substr($row['it_id'],0,4);
                $tableMonth = $itemMonth = mb_substr($row['it_id'],4,2);
                $tableDay = $itemDay = mb_substr($row['it_id'],8,2);
                $tableDate = $itemDate = $tableYear.'-'.$tableMonth.'-'.$tableDay;
                $tableWeek = date('W',strtotime($tableDate));

                if(date('W') == $tableWeek)
                    break;

                $row=sql_fetch_array($result);
            }
        }

        $itemYear = mb_substr($row['it_id'],0,4);
        $itemMonth = mb_substr($row['it_id'],4,2);
        $itemDay = mb_substr($row['it_id'],8,2);
        $itemDate = $itemYear.'-'.$itemMonth.'-'.$itemDay;
        $tableDate = $tableYear.'-'.$tableMonth.'-'.$tableDay;
        $tableMaxDay = date('t', strtotime($tableDate));

        echo "<li class=\"sct_li col-row-{$this->list_mod}\">\n";
        echo "<div class=\"sct_li_innr\">\n";

        if ($this->href)
            echo "<div class=\"sct_title\">\n";
        if($this->view_it_name){
            echo '<p class="day_title">';
            echo $tableMonth.'월 '.$tableDay.'일'.'<span class="dayweek"> ('.$week[date('w',strtotime($tableDate))].')</span>';
            echo '</p>'."\n";
        }
        if ($this->href)
            echo "</div>\n";

        if($row['it_basic'] && $tableDate == $itemDate){ ?>
            <div class="event_wrap">
                <img src="<?php echo G5_THEME_IMG_URL?>/event_gift.png">
            </div>
            <div class="ev_con_wrap">
                <p class="ev_content"><?php echo $row['it_basic']?></p>
            </div>
        <?php } else {
            echo "<div class=\"divider\"></div>\n";
        }

        echo "<div class=\"sct_explan\">";
        if($itemDate == $tableDate) {
            echo stripslashes($row['it_explan']);

            $tmp_row = $row;
            $row=sql_fetch_array($result);
        } else {
            if(date('w',strtotime($tableDate)) == 6 || $row){
                echo '휴무입니다.';
            } else {
                echo '준비중입니다.';
            }
        }
        echo "</div>\n";
        echo "</div>\n";

        if($itemDate == $tableDate && $tableDate > $presentYear.'-'.$presentMonth.'-'.sprintf("%02d", $presentDay + 1)){
            $isAdd = "";
            $csql = " select a.it_id,
                    a.od_id
                   from {$g5['g5_shop_cart_table']} a
                  where a.od_id = '$s_cart_id' ";
            $csql .= " group by a.it_id ";
            $csql .= " order by a.it_id ";
            $cresult = sql_query($csql);
            for($k = 0; $crow = sql_fetch_array($cresult); $k++){
                if($crow['it_id'] == $tmp_row['it_id']){
                    $isAdd = "added";
                    break; 
                }
            }
            echo "<div class=\"button_wrap\">"
                ."<button type=\"button\" class=\"sct_btn btn_cart {$isAdd}\" ";
            echo "data-it_id=\"{$tmp_row['it_id']}\"><i class=\"fas fa-shopping-cart\"></i><span class=\"btn_txt\">장바구니</span></button>";
            echo "</div>\n";
            echo "<div class=\"sct_cartop\"></div>\n";
        }
        echo "</li>\n";

        $tableDay = sprintf("%02d", $tableDay + 1);

        if(date('w',strtotime($tableDate)) == 6)
            $tableDay = sprintf("%02d", $tableDay + 1);

        if($tableDay > $tableMaxDay){
            $tableDay = sprintf("%02d", $tableDay - $tableMaxDay);
            $tableMonth = sprintf("%02d", $tableMonth + 1);

            if($tableMonth > 12){
                $tableMonth = sprintf("%02d", 1);
                $tableYear++;
            }
        }
    }

    if ($i > 1) echo "</ul>\n";

    if($i == 1) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
    ?>
    <!-- } 상품진열 10 끝 -->
</div>

<?php
function echoDays($row) {
    echo "<ul class=\"day sct sct_50 lists-row\">\n";
    echo "<li class=\"day sct_li col-row-{$row}\">월요일</li>";
    echo "<li class=\"day sct_li col-row-{$row}\">화요일</li>";
    echo "<li class=\"day sct_li col-row-{$row}\">수요일</li>";
    echo "<li class=\"day sct_li col-row-{$row}\">목요일</li>";
    echo "<li class=\"day sct_li col-row-{$row}\">금요일</li>";
    echo "<li class=\"day sct_li col-row-{$row}\">토요일</li>";
}
?>
<script>
$('.btn_cart').click(function(){
    $this = $(this);

    if(!$('#sidemenu').hasClass('sel')){
        $('#sidemenu').addClass('sel');
        $('#sidemenu button').addClass('btn_on');
    }
    if($(window).width() <= 748){
        if($this.hasClass('added')){
            alert('상품을 장바구니에서 삭제하였습니다.');
        } else {
            alert('상품을 장바구니에 담았습니다.');
        }
        
    }
});
</script>
<!-- } 상품진열 10 끝 -->