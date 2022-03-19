<?php
include_once('./_common.php');

// 보관기간이 지난 상품 삭제
cart_item_clean();

$s_cart_id = get_session('ss_cart_id');


include_once(G5_SHOP_SKIN_PATH.'/boxcart.skin.php'); // 장바구니
?>