<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 상품리스트에서 옵션항목
function get_list_options($it_id, $subject, $no)
{
    global $g5;

    if(!$it_id || !$subject)
        return '';

    $sql = " select * from {$g5['g5_shop_item_option_table']} where io_type = '0' and it_id = '$it_id' and io_use = '1' order by io_no asc ";
    $result = sql_query($sql);
    if(!sql_num_rows($result))
        return '';

    $str = '';
    $subj = explode(',', $subject);
    $subj_count = count($subj);

    if($subj_count > 1) {
        $options = array();

        // 옵션항목 배열에 저장
        for($i=0; $row=sql_fetch_array($result); $i++) {
            $opt_id = explode(chr(30), $row['io_id']);

            for($k=0; $k<$subj_count; $k++) {
                if(!is_array($options[$k]))
                    $options[$k] = array();

                if($opt_id[$k] && !in_array($opt_id[$k], $options[$k]))
                    $options[$k][] = $opt_id[$k];
            }
        }

        // 옵션선택목록 만들기
        for($i=0; $i<$subj_count; $i++) {
            $opt = $options[$i];
            $opt_count = count($opt);
            $disabled = '';
            if($opt_count) {
                $seq = $no.'_'.($i + 1);
                if($i > 0)
                    $disabled = ' disabled="disabled"';

                $str .= '<label for="it_option_'.$seq.'">'.$subj[$i].'</label>'.PHP_EOL;

                $select = '<select id="it_option_'.$seq.'" class="it_option"'.$disabled.'>'.PHP_EOL;
                $select .= '<option value="">선택</option>'.PHP_EOL;
                for($k=0; $k<$opt_count; $k++) {
                    $opt_val = $opt[$k];
                    if(strlen($opt_val)) {
                        $select .= '<option value="'.$opt_val.'">'.$opt_val.'</option>'.PHP_EOL;
                    }
                }
                $select .= '</select>'.PHP_EOL;

                $str .= $select.PHP_EOL;
            }
        }
    } else {
        $str .= '<label for="it_option_1">'.$subj[0].'</label>'.PHP_EOL;

        $select = '<select id="it_option_1" class="it_option">'.PHP_EOL;
        $select .= '<option value="">선택</option>'.PHP_EOL;
        for($i=0; $row=sql_fetch_array($result); $i++) {
            if($row['io_price'] >= 0)
                $price = '&nbsp;&nbsp;+ '.number_format($row['io_price']).'원';
            else
                $price = '&nbsp;&nbsp; '.number_format($row['io_price']).'원';

            if(!$row['io_stock_qty'])
                $soldout = '&nbsp;&nbsp;[품절]';
            else
                $soldout = '';

            $select .= '<option value="'.$row['io_id'].','.$row['io_price'].','.$row['io_stock_qty'].'">'.$row['io_id'].$price.$soldout.'</option>'.PHP_EOL;
        }
        $select .= '</select>'.PHP_EOL;

        $str .= $select.PHP_EOL;
    }

    return $str;
}


function item_icon2($it)
{
    global $g5;

    $icon = '<span class="sct_icon">';

    if ($it['it_type2'])
        $icon .= '<span class="icon icon_rec">RECOMMEND</span>';

    if ($it['it_type4'])
        $icon .= '<span class="icon icon_best">BEST</span>';

    if ($it['it_type5'])
        $icon .= '<span class="icon icon_sale">SALE</span>';

    if ($it['it_type3'])
        $icon .= '<span class="icon icon_new">NEW</span>';

    if ($it['it_type1'])
        $icon .= '<span class="icon icon_hit">HIT</span>';

    // 쿠폰상품
    $sql = " select count(*) as cnt
                from {$g5['g5_shop_coupon_table']}
                where cp_start <= '".G5_TIME_YMD."'
                  and cp_end >= '".G5_TIME_YMD."'
                  and (
                        ( cp_method = '0' and cp_target = '{$it['it_id']}' )
                        OR
                        ( cp_method = '1' and ( cp_target IN ( '{$it['ca_id']}', '{$it['ca_id2']}', '{$it['ca_id3']}' ) ) )
                      ) ";
    $row = sql_fetch($sql);
    if($row['cnt'])
        $icon .= '<span class="icon icon_cp">CUPON</span>';

    $icon .= '</span>';
    // 품절
    if (is_soldout($it['it_id']))
        $icon .= '<span class="icon_soldout"><span class="soldout_txt">SOLD OUT</span></span>';

    return $icon;
}

function memo_recv_count($mb_id)
{
    global $g5;

    if(!$mb_id)
        return 0;

    $sql = " select count(*) as cnt from {$g5['memo_table']} where me_recv_mb_id = '$mb_id' and me_read_datetime = '0000-00-00 00:00:00' ";
    $row = sql_fetch($sql);
    return $row['cnt'];
}



function get_wish_count($it_id)
{
    global $g5;

    $sql = " select count(*) as cnt
                from {$g5['g5_shop_wish_table']}
                where it_id = '$it_id' ";
    $row = sql_fetch($sql);

    return $row['cnt'];
}

function get_use_count($it_id)
{
    global $g5;

    $sql = " select count(*) as cnt
                from {$g5['g5_shop_item_use_table']}
                where it_id = '$it_id' ";
    $row = sql_fetch($sql);

    return $row['cnt'];
}


function get_it_image2($it_id, $width, $height=0, $anchor=false, $img_id='', $img_alt='', $is_crop=false)
{
    global $g5;

    if(!$it_id || !$width)
        return '';

    $sql = " select it_id, it_img1, it_img2, it_img3, it_img4, it_img5, it_img6, it_img7, it_img8, it_img9, it_img10 from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $row = sql_fetch($sql);

    if(!$row['it_id'])
        return '';

    for($i=1;$i<=10; $i++) {
        $file = G5_DATA_PATH.'/item/'.$row['it_img'.$i];
        if(is_file($file) && $row['it_img'.$i]) {
            $size = @getimagesize($file);
            if($size[2] < 1 || $size[2] > 3)
                continue;

            $filename = basename($file);
            $filepath = dirname($file);
            $img_width = $size[0];
            $img_height = $size[1];

            if($i == 2) break;
        }
    }

    if($img_width && !$height) {
        $height = round(($width * $img_height) / $img_width);
    }

    if($filename) {
        //thumbnail($filename, $source_path, $target_path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3')
        $thumb = thumbnail($filename, $filepath, $filepath, $width, $height, false, $is_crop, 'center', false, $um_value='80/0.5/3');
    }

    if($thumb) {
        $file_url = str_replace(G5_PATH, G5_URL, $filepath.'/'.$thumb);
        $img = '<img src="'.$file_url.'" width="'.$width.'" height="'.$height.'" alt="'.$img_alt.'"';
    } else {
        $img = '<img src="'.G5_SHOP_URL.'/img/no_image.gif" width="'.$width.'"';
        if($height)
            $img .= ' height="'.$height.'"';
        $img .= ' alt="'.$img_alt.'"';
    }

    if($img_id)
        $img .= ' id="'.$img_id.'"';
    $img .= '>';

    if($anchor)
        $img = '<a href="'.G5_SHOP_URL.'/item.php?it_id='.$it_id.'">'.$img.'</a>';

    return $img;
}

function get_it_main_img($it_id, $width, $height=0, $anchor=false, $img_id='', $img_alt='', $is_crop=true)
{
    global $g5;

    if(!$it_id || !$width)
        return '';

    $row = get_shop_item($it_id, true);

    if(!$row['it_id'])
        return '';

    $filename = $thumb = $img = '';

    for($i=1;$i<=10; $i++) {
        $file = G5_DATA_PATH.'/item/'.$row['it_img'.$i];
        if(is_file($file) && $row['it_img'.$i]) {
            $size = @getimagesize($file);
            if($size[2] < 1 || $size[2] > 3)
                continue;

            $filename = basename($file);
            $filepath = dirname($file);
            $img_width = $size[0];
            $img_height = $size[1];

            break;
        }
    }

    if($img_width && !$height) {
        $height = round(($width * $img_height) / $img_width);
    }

    if($filename) {
        //thumbnail($filename, $source_path, $target_path, $thumb_width, $thumb_height, $is_create, $is_crop=false, $crop_mode='center', $is_sharpen=true, $um_value='80/0.5/3')
        $thumb = thumbnail($filename, $filepath, $filepath, $width, $height, false, $is_crop, 'center', false, $um_value='80/0.5/3');
    }

    if($thumb) {
        $file_url = str_replace(G5_PATH, G5_URL, $filepath.'/'.$thumb);
        $img = '<img src="'.$file_url.'" width="'.$width.'" height="'.$height.'" alt="'.$img_alt.'"';
    } else {
        $img = '<img src="'.G5_SHOP_URL.'/img/no_image.gif" width="'.$width.'"';
        if($height)
            $img .= ' height="'.$height.'"';
        $img .= ' alt="'.$img_alt.'"';
    }

    if($img_id)
        $img .= ' id="'.$img_id.'"';
    $img .= '>';

    if($anchor)
        $img = $img = '<a href="'.shop_item_url($it_id).'">'.$img.'</a>';

    return run_replace('get_it_image_tag', $img, $thumb, $it_id, $width, $height, $anchor, $img_id, $img_alt, $is_crop);
}


function get_item_event_info($it_id)
{
    global $g5;

    $data = array();

    $sql = " select distinct ev_id from {$g5['g5_shop_event_item_table']} where it_id = '$it_id' ";
    $result = sql_query($sql);

    for($i=0; $row=sql_fetch_array($result); $i++) {
        // 이벤트정보
        $sql = " select ev_id, ev_subject from {$g5['g5_shop_event_table']} where ev_id = '{$row['ev_id']}' and ev_use = '1' ";
        $ev  = sql_fetch($sql);
        if(!$ev['ev_id'])
            continue;

        // 배너이미지
        $file = G5_DATA_PATH.'/event/'.$ev['ev_id'].'_m';
        if(!is_file($file))
            continue;

        $subject = $ev['ev_subject'];
        $img     = str_replace(G5_DATA_PATH, G5_DATA_URL, $file);

        $data[] = array('ev_id' => $row['ev_id'], 'subject' => $subject, 'img' => $img);
    }

    return $data;
}

function display_faq()
{
    global $g5;

    $sql = " select * from {$g5['faq_table']} order by fa_id";

    $result = sql_query($sql);

    for ($i=0;$row=sql_fetch_array($result);$i++){
        $faq_list[] = $row;
    }

    if(!count($faq_list))
        return;

    echo '<div id="faq">'.
            '<div class="floatwrap">'.
            '<div class="list">';
    foreach($faq_list as $key=>$v){
        if(empty($v))
            continue;
    ?>
        <div class="desc">
            <a href="<?php echo G5_BBS_URL ?>/faq.php">
                <div class="sub">Question.<?php echo $v['fa_id'] ?></div>
                <div class="tit"><?php echo conv_content($v['fa_subject'], 1); ?></div>
                <div class="txt"><?php echo conv_content($v['fa_content'], 1); ?></div>
            </a>
        </div>
    <?php } ?>
        </div>
    </div>

    <div class="control">
        <button class="prev arrow slick-arrow" style="display: block;"></button>
        <button class="next arrow slick-arrow" style="display: block;"></button>
    </div>
    <div class="tool"></div>

    <script>
    $(function () {
        $("#faq .list").slick({
            infinite: true , /* 맨끝이미지에서 끝나지 않고 다시 맨앞으로 이동 */
            slidesToShow: 1, /* 화면에 보여질 이미지 갯수*/
            slidesToScroll: 1,  /* 스크롤시 이동할 이미지 갯수 */
            autoplay: true, /* 자동으로 다음이미지 보여주기 */
            arrows: true, /* 화살표 */
            dots:true, /* 아래점 */
            autoplaySpeed:5000,/* 다음이미지로 넘어갈 시간 */
            speed:600 , /* 다음이미지로 넘겨질때 걸리는 시간 */
            horizontal: true,
            pauseOnHover:false, /* 마우스 호버시 슬라이드 이동 멈춤 */
            prevArrow: $('#faq .control .prev'),
            nextArrow: $('#faq .control .next'),
			appendDots: $('#faq .tool')
        });
		$('#faq .tool').append('<button type="button" class="pause ctrl">재생</button>');
		$('#faq .tool .ctrl').click(function(e){
			if($(this).hasClass('pause')){
				$('#faq .list').slick('slickPause');
				$(this).removeClass('pause').addClass('play').text('재생');
			}else{
				$('#faq .list').slick('slickPlay');
				$(this).removeClass('play').addClass('pause').text('정지');
			}
		});
    });
    </script>
    </div>
<?php
}

function get_mb_category($ca_id, $len){
    global $g5;

	$sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']}
		where ca_use = '1' ";
	$sql .= " and ca_id like '$ca_id%' ";
	$sql .= " and length(ca_id) = '$len' order by ca_order, ca_id ";
	$ca_res1 = sql_query($sql);
    ?>
    <ul class="depth2">
	<?php
	for($i=0; $ca_row1=sql_fetch_array($ca_res1); $i++){
	?>
		<li>
			<a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=<?php echo $ca_row1['ca_id']; ?>"><?php echo get_text($ca_row1['ca_name']); ?></a>
		</li>
	<?php
	}
	?>
    </ul>
<?php
}

function get_mb_category1($ca_id, $len){
    global $g5;

	$sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']}
		where ca_use = '1' ";
	$sql .= " and ca_id like '$ca_id%' ";
	$sql .= " and length(ca_id) = '$len' order by ca_order, ca_id ";
	$ca_res1 = sql_query($sql);
    ?>
    <ul class="sub_cate sub_cate1">
	<?php
	for($i=0; $ca_row1=sql_fetch_array($ca_res1); $i++){
	?>
		<li class="cate_li_2">
			<a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=<?php echo $ca_row1['ca_id']; ?>"><?php echo get_text($ca_row1['ca_name']); ?></a>
		</li class="cate_li_2">
	<?php
	}
	?>
    </ul>
<?php
}
?>