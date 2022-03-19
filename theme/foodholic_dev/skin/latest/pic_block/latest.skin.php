<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 210;
$thumb_height = 150;
$timenow = date("Y-m-d");
$str_now = strtotime($timenow);
?>

<div id="event">
    <div class="floatwrap">
        <div class="title"><h3><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject ?></a></h3></div>
        <div class="list">
    <?php
    for ($i=0; $i<count($list); $i++) {
    $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

    if($thumb['src']) {
        $img = $thumb['src'];
        $img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" >';
    } else {
        $img_content = '<i class="noimg"></i>';
    }
    

    if($list[$i]['ca_name'] == '진행예정'){
        $cate = '<div class="cate"><a href="'.$list[$i]['href'].'" class="bo_cate_link">진행예정</a></div>';
    } 
    if($list[$i]['ca_name'] == '진행중'){
        $cate = '<div class="cate"><a href="'.$list[$i]['href'].'" class="bo_cate_link">진행중</a></div>';
    }
    if($list[$i]['ca_name'] == '마감'){
        $cate = '<div class="cate"><a href="'.$list[$i]['href'].'" class="bo_cate_link">마감</a></div>';
    }
    ?>
            <div class="desc">
                <div class="inner">
                    <div class="img">
                        <?php echo $cate; ?>
                        <a href="<?php echo $list[$i]['href'] ?>"><?php echo $img_content; ?></a>
                    </div>
                    <div class="con">
                        <div class="tit">
                            <a href="<?php echo $list[$i]['href'] ?>"><?php echo $list[$i]['subject']; ?></a>
                        </div>
                        <div class="date">
                            <span><?php echo $list[$i]['wr_1']?> ~ <?php echo $list[$i]['wr_2']?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="control">
                <button class="prev arrow slick-arrow" style="display: block;"></button>
                <button class="next arrow slick-arrow" style="display: block;"></button>
            </div>
            <script>
                $("#event .list").slick({
		            infinite: true , /* 맨끝이미지에서 끝나지 않고 다시 맨앞으로 이동 */
		            slidesToShow: 3, /* 화면에 보여질 이미지 갯수*/
		            slidesToScroll: 3,  /* 스크롤시 이동할 이미지 갯수 */
		            autoplay: false, /* 자동으로 다음이미지 보여주기 */
		            arrows: true, /* 화살표 */
		            speed:2000 , /* 다음이미지로 넘겨질때 걸리는 시간 */
		            horizontal: true,
		            prevArrow: $('#event .list .prev'),
		            nextArrow: $('#event .list .next'),
                    dot:false,
		            touchMove : true,
		            swipe : true
	            });
            </script>
    <?php }  ?>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <li class="empty_li">게시물이 없습니다.</li>
    <?php }  ?>
        </div>
    </div>
</div>
