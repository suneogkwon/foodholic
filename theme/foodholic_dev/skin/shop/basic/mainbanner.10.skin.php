<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="' . G5_SHOP_SKIN_URL . '/style.css">', 0);
?>

<?php
$main_banners = array();

for ($i = 0; $row = sql_fetch_array($result); $i++) {
    $main_banners[] = $row;
    
    if ($i == 0) echo '<div id="main_bn">'
        . PHP_EOL
        . '<div class="swiper-container grid-container full margin-bottom-3" style="z-index: 0">'
        . PHP_EOL
        . '<div class="swiper-wrapper">'
        . PHP_EOL;
    // 테두리 있는지
    $bn_border = ($row['bn_border']) ? ' class="sbn_border"' : '';;
    // 새창 띄우기인지
    $bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';
    
    $bimg = G5_DATA_PATH . '/banner/' . $row['bn_id'];
    if (file_exists($bimg)) {
        $banner = '';
        $size = getimagesize($bimg);
        
        if ($size[2] < 1 || $size[2] > 16)
            continue;
        
        echo '<div class="swiper-slide">' . PHP_EOL;
        if ($row['bn_url'][0] == '#')
            $banner .= '<a href="' . $row['bn_url'] . '">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner .= '<a href="' . G5_SHOP_URL . '/bannerhit.php?bn_id=' . $row['bn_id'] . '"' . $bn_new_win . '>';
        }
        echo $banner . '<img src="' . G5_DATA_URL . '/banner/' . $row['bn_id'] . '" alt="' . get_text($row['bn_alt']) . '"' . $bn_border . '>';
        if ($banner)
            echo '</a>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
    }
}

if ($i > 0) {
    echo '</div>' . PHP_EOL; ?>
    <div class="control">
        <button class="display-block prev arrow"></button>
        <button class="display-block next arrow"></button>
    </div>
    <?php
    echo '<div class="tool text-center position-absolute" style="z-index: 10;"></div>';
    echo '</div></div>';
    ?>

    <script>
        $(function () {
            const mainSwiper = new Swiper('#main_bn .swiper-container', {
                loop: true,
                autoplay: true,
                speed: 2000,
                delay: 6000,
                pauseOnMouseEnter: true,

                pagination: {
                    el: '#main_bn .tool',
                    clickable: true
                },

                navigation: {
                    nextEl: '#main_bn .next',
                    prevEl: '#main_bn .prev',
                },
            });
            $('#main_bn .tool').append('<button type="button" class="pause ctrl">재생</button>');
            $('#main_bn .tool .ctrl').click(function (e) {
                if ($(this).hasClass('pause')) {
                    mainSwiper.autoplay.stop();
                    $(this).removeClass('pause').addClass('play').text('재생');
                } else {
                    mainSwiper.autoplay.start();
                    $(this).removeClass('play').addClass('pause').text('정지');
                }
            });
        });
    </script>
    
    <?php
}
?>