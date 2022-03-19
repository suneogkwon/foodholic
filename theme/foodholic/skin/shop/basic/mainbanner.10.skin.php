<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<?php
$max_width = 0;
$max_height = 700;
$bn_first_class = ' class="bn_first"';
$bn_slide_btn = '';
$bn_sl = ' class="bn_sl"';

$main_banners = array();

for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $main_banners[] = $row;

    if ($i==0) echo '<div id="main_bn">'.PHP_EOL.'<div class="main_bn">'.PHP_EOL;
    //print_r2($row);
    // 테두리 있는지
    $bn_border  = ($row['bn_border']) ? ' class="sbn_border"' : '';;
    // 새창 띄우기인지
    $bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';

    $bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
    if (file_exists($bimg))
    {
        $banner = '';
        $size = getimagesize($bimg);

        if($size[2] < 1 || $size[2] > 16)
            continue;

        if($max_width < $size[0])
            $max_width = $size[0];

        // if($max_height < $size[1])
        //     $max_height = $size[1];

        echo '<div class="desc">'.PHP_EOL.'<div class="img">'.PHP_EOL;
        if ($row['bn_url'][0] == '#')
            $banner .= '<a href="'.$row['bn_url'].'">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner .= '<a href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'"'.$bn_new_win.'>';
        }
        echo $banner.'<img src="'.G5_DATA_URL.'/banner/'.$row['bn_id'].'" width="'.$size[0].'" alt="'.get_text($row['bn_alt']).'"'.$bn_border.'>';
        if($banner)
            echo '</a>'.PHP_EOL;
        echo '</div>'.PHP_EOL.'</div>'.PHP_EOL;

       
    }
}

if ($i > 0) {
    echo '</div>'.PHP_EOL; ?>
    <div class="control">
        <button class="prev arrow slick-arrow" style="display: block;"></button>
        <button class="next arrow slick-arrow" style="display: block;"></button>
    </div>
    <?php 
    echo '<div class="tool"></div>';
?>
</div>

<div>
<?php // echo latest ("false9_notice",'findod', 2, 30); ?> 
</div> 


<script>
$(function(){
	$(".main_bn").slick({
		fade:true,
		infinite: true , /* 맨끝이미지에서 끝나지 않고 다시 맨앞으로 이동 */
		slidesToShow: 1, /* 화면에 보여질 이미지 갯수*/
		slidesToScroll: 1,  /* 스크롤시 이동할 이미지 갯수 */
		autoplay: true, /* 자동으로 다음이미지 보여주기 */
		arrows: true, /* 화살표 */
		dots:true, /* 아래점 */
		autoplaySpeed:6000,/* 다음이미지로 넘어갈 시간 */
		speed:2000 , /* 다음이미지로 넘겨질때 걸리는 시간 */
		horizontal: true,
		prevArrow: $('#main_bn .prev'),
		nextArrow: $('#main_bn .next'),
		appendDots: $('#main_bn .tool'),
		touchMove : true,
		swipe : true,
		pauseOnFocus: true,
		pauseOnHover: true,
		pauseOnDotsHover: false,
	});
	$('#main_bn .tool').append('<button type="button" class="pause ctrl">재생</button>');
	$('#main_bn .tool .ctrl').click(function(e){
		if($(this).hasClass('pause')){
			$('.main_bn').slick('slickPause');
			$(this).removeClass('pause').addClass('play').text('재생');
		}else{
			$('.main_bn').slick('slickPlay');
			$(this).removeClass('play').addClass('pause').text('정지');
		}
	});
});
</script>

<?php
}
?>