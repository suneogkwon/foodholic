<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/jquery.shop.list.js"></script>', 10);
?>

<!-- 장바구니 간략 보기 시작 { -->
<h5 class="text-center font-bold">장바구니</h5>
<aside id="sbsk">
    
    <form name="skin_frmcartlist" id="skin_sod_bsk_list" method="post" action="<?php echo G5_SHOP_URL.'/cartupdate.php'; ?>">
    <ul class="no-bullet">
    <?php
    $cart_datas = get_boxcart_datas(true);
    $total=0;
    $i = 0;
    foreach($cart_datas as $row)
    {
        if( !$row['it_id'] ) continue;

        echo '<li class="padding-horizontal-3 padding-vertical-1" style="border-top: 1px solid #f6f6f6;">';
        $it_name = get_text($row['it_name']);
        $it_price = $row['ct_price'] * $row['ct_qty'];
        $total += $it_price;
        // 이미지로 할 경우
        $it_img = get_it_image($row['it_id'], 60, 60, true);
        if(false){
            echo '<div class="prd_img">'.$it_img.'</div>';
        }
        echo '<div class="float-left padding-top-1">';
        echo '<p class="font-bold h6">'.$it_name.'</p>';
        echo '<p class="margin-0">';
        echo number_format($it_price).'원</p>';
        echo '</div>';
        echo '<div class="text-right">';
        echo '<a href="#none" onclick="cart_qty_up('.$row['it_id'].')" class="qty_up color-black h6"><i class="xi-angle-up"></i></a>';
        echo '<p class="qty_cnt margin-0">'.$row['ct_qty'].' <span>개</span></p>';
        echo '<a href="#none" onclick="cart_qty_down('.$row['it_id'].')" class="qty_down color-black h6"><i class="xi-angle-down"></i></a>';
        echo '</div>';
        echo '</li>';

        echo '<input type="hidden" name="act" value="buy" >';
        echo '<input type="hidden" name="ct_chk['.$i.']" value="1" >';
        echo '<input type="hidden" name="it_id['.$i.']" value="'.$row['it_id'].'">';
        echo '<input type="hidden" name="it_name['.$i.']"  value="'.$it_name.'">';

        $i++;
    }   //end foreach

    if ($i==0)
        echo '<li class="li_empty">장바구니 상품 없음</li>'.PHP_EOL;
    ?>
    </ul>
    <?php if($i){ ?>
        <p class="scart_total text-center">총 금액 <span class="h6 color-primary font-bold"><?php echo number_format($total)?></span></p>
        <p class="btn_buy"><button type="submit" class="button expanded btn_submit">바로구매</button></p>
        <?php 
    } 
    ?>
    <a href="<?php echo G5_SHOP_URL; ?>/cart.php" class="button expanded hollow go_cart">장바구니</a>
    </form>
</aside>
<!-- } 장바구니 간략 보기 끝 -->

