<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
add_javascript('<script src="'.G5_THEME_JS_URL.'/slick.min.js"></script>', 10);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_JS_URL.'/slick-theme.css">', 10);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_JS_URL.'/slick.css">', 10);

// 이벤트 정보
$hsql = " select ev_id, ev_subject, ev_subject_strong from {$g5['g5_shop_event_table']} where ev_use = '1' order by ev_id desc limit 5";
$hresult = sql_query($hsql);

if(sql_num_rows($hresult)) {
    // add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
    add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<div id="sev">
    <h2>이벤트</h2>
    <div class="sev_slide">
    <?php
    
    for ($i=0; $row=sql_fetch_array($hresult); $i++)
    {
        $href = G5_SHOP_URL.'/event.php?ev_id='.$row['ev_id'];
		if( $i >= 5 ) continue;
        $event_img = G5_DATA_PATH.'/event/'.$row['ev_id'].'_m'; // 이벤트 이미지
		echo "<div class=\"sev_item sev_item_{$i}\">\n";
		echo '<a href="'.$href.'" class="sev_img"><img src="'.G5_DATA_URL.'/event/'.$row['ev_id'].'_m" alt="'.$row['ev_subject'].'"></a>'.PHP_EOL;
		echo '<a href="'.$href.'" class="sev_txt">'.$row['ev_subject'].'</a></div>'.PHP_EOL;
    }

    if ($i==0)
        echo '<div id="sev_empty">이벤트 없음</div>'.PHP_EOL;
    ?>
    </div>
</div>

<script>
$('.sev_slide').slick({
    centerPadding: '425px',
    centerMode: true,
    responsive: [
        {
            breakpoint: 1919,
            settings: {
                centerPadding: '345px'
            }
        },
        {
            breakpoint: 1599,
            settings: {
                centerPadding: '145px'
            }
        }
    ]
});
</script>

<?php
}
?>