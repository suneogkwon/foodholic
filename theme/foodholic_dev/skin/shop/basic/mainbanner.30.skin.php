<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="' . G5_SHOP_SKIN_URL . '/style.css">', 0);
?>

<?php
$max_height = 100;
$main_banners = array();

for ($i = 0; $row = sql_fetch_array($result); $i++) {
    $main_banners[] = $row;

    if ($i == 0) {
        echo '<div class="container-fluid swiper-container">' . PHP_EOL;
        echo '<div class="text-center swiper-wrapper">' . PHP_EOL;
    }
    // 테두리 있는지
    $bn_border  = ($row['bn_border']) ? ' class="sbn_border"' : '';;
    // 새창 띄우기인지
    $bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';

    $bimg = G5_DATA_PATH . '/banner/' . $row['bn_id'];
    $item_html = '';

    if (file_exists($bimg)) {
        $banner = '';
        $size = getimagesize($bimg);

        if ($size[2] < 1 || $size[2] > 16)
            continue;

        $item_html .= '<div class="swiper-slide nth_'.$i.'">';
        if ($row['bn_url'][0] == '#')
            $banner .= '<a href="' . $row['bn_url'] . '">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner .= '<a href="' . G5_SHOP_URL . '/bannerhit.php?bn_id=' . $row['bn_id'] . '"' . $bn_new_win . '>';
        }
        $item_html .= $banner . '<img class="img-fluid" src="' . G5_DATA_URL . '/banner/' . $row['bn_id'] . '" alt="' . get_text($row['bn_alt']) . '"' . $bn_border . '>';
        // echo $banner . '<span style="background-image:url(' . G5_DATA_URL . '/banner/' . $row['bn_id'] . ');" class="bn-img"></span>';
        if ($banner)
            $item_html .= '</a>';
        $item_html .= '</div>';
    }
    echo $item_html;
}

if ($i > 0) {
    echo '</div></div>' . PHP_EOL;
?>

<script>
$(function(){
    $('#top_banner .swiper-container').height($('#top_banner img').height());
    $(window).resize(function(){
        $('#top_banner .swiper-container').height($('#top_banner img').height());
    });

    new Swiper('#top_banner .swiper-container', {
        direction: 'vertical',
        speed: 1300,
        loop: true,
        autoplay:true,
        delay: 5000,
        waitForTransition: true
    });
})
</script>
<?php
}
?>
