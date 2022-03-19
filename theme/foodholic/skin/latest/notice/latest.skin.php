<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $latest_skin_url . '/style.css">', 0);
?>
<div class="floatwrap">
    <div class="notice">
        <?php for ($i = 0; $i < count($list); $i++) {  ?>
            <div>
                <?php
                echo "<a href=\"" . $list[$i]['href'] . "\">";
                if ($list[$i]['is_notice'])
                    echo "<strong>" . $list[$i]['subject'] . "</strong>";
                else
                    echo $list[$i]['subject'];
                echo "</a>";
                // if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
                // if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }

                //if ($list[$i]['icon_file']) echo " <i class=\"fa fa-download\" aria-hidden=\"true\"></i>" ;
                //if ($list[$i]['icon_link']) echo " <i class=\"fa fa-link\" aria-hidden=\"true\"></i>" ;
                //if ($list[$i]['icon_hot']) echo " <i class=\"fa fa-heart\" aria-hidden=\"true\"></i>";
                ?>
            </div>
        <?php }  ?>
        <?php if (count($list) == 0) { //게시물이 없을 때  
        ?>
            <li class="empty_li">게시물이 없습니다.</li>
        <?php }  ?>
    </div>
    <div class="ctrl">
        <button class="prev"><i class="xi-angle-up-min"></i></button>
        <button class="next"><i class="xi-angle-down-min"></i></button>
    </div>
</div>
<?php if (count($list)) { //게시물이 있다면 
?>
    <script>
        $(function() {
            $("#m_notice_latest .notice").slick({
                infinite: true,
                /* 맨끝이미지에서 끝나지 않고 다시 맨앞으로 이동 */
                cssEase: 'linear',
                slidesToShow: 3,
                /* 화면에 보여질 이미지 갯수*/
                slidesToScroll: 1,
                /* 스크롤시 이동할 이미지 갯수 */
                autoplay: true,
                /* 자동으로 다음이미지 보여주기 */
                arrows: false,
                /* 화살표 */
                dots: false,
                /* 아래점 */
                autoplaySpeed: 0,
                /* 다음이미지로 넘어갈 시간 */
                speed: 3000,
                /* 다음이미지로 넘겨질때 걸리는 시간 */
                vertical: true,
                pauseOnHover: true,
                /* 마우스 호버시 슬라이드 이동 멈춤 */
                prevArrow: $("#m_notice_latest .ctrl .prev"),
                nextArrow: $("#m_notice_latest .ctrl .next")
            });
        });
    </script>
<?php } ?>