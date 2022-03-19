<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $latest_skin_url . '/style.css">', 0);
$thumb_width = 236;
$thumb_height = 180;
?>

<div id="review">
    <div class="floatwrap">
        <div class="title">
            <h3><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject ?></a></h3>
        </div>
        <div class="cont">
            <ul>
                <?php
                for ($i = 0; $i < count($list); $i++) {
                    $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

                    if ($thumb['src']) {
                        $img = $thumb['src'];
                        $img_content = '<img src="' . $img . '" alt="' . $thumb['alt'] . '" >';
                ?>
                        <li>
                            <div class="inner">
                                <div class="img">
                                    <a href="<?php echo $list[$i]['href'] ?>"><?php echo $img_content; ?></a>
                                </div>
                                <div class="con">
                                    <div class="tit">
                                        <a href="<?php echo $list[$i]['href'] ?>"><?php echo $list[$i]['subject']; ?></a>
                                    </div>
                                    <div class="txt_wrap">
                                        <div class="txt">
                                            <?php echo $list[$i]['wr_content']; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="info">
                                    <span class="nick"><?php echo $list[$i]['name'] ?></span>
                                    <span class="date"><?php echo $list[$i]['datetime2'] ?></span>
                                </div>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                <?php }  ?>
                <?php if (count($list) == 0) { //게시물이 없을 때  
                ?>
                    <li class="empty_li">게시물이 없습니다.</li>
                <?php }  ?>
            </ul>
            <script>
                var slide = $("#review .cont ul").slick({
                            infinite: true,
                            /* 맨끝이미지에서 끝나지 않고 다시 맨앞으로 이동 */
                            slidesToShow: 5,
                            /* 화면에 보여질 이미지 갯수*/
                            slidesToScroll: 1,
                            /* 스크롤시 이동할 이미지 갯수 */
                            autoplay: true,
                            /* 자동으로 다음이미지 보여주기 */
                            autoplaySpeed:1000,
                            arrows: true,
                            /* 화살표 */
                            speed: 2000,
                            /* 다음이미지로 넘겨질때 걸리는 시간 */
                            horizontal: true,
                            prevArrow: $('#review .cont .prev'),
                            nextArrow: $('#review .cont .next'),
                            dot: false,
                            touchMove: true,
                            swipe: true,
                            responsive: [{
                                    breakpoint: 1259,
                                    settings: {
                                        slidesToShow: 4,
                                    }
                                },
                                {
                                    breakpoint: 747,
                                    settings: {
                                        slidesToShow: 2,
                                    }
                                }
                            ]
                        });
            </script>
        </div>
    </div>
</div>