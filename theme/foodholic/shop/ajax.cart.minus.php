<?php
include_once('./_common.php');

$it_id = $_POST['it_id'];

// 보관기간이 지난 상품 삭제
cart_item_clean();

$s_cart_id = get_session('ss_cart_id');

if($_POST['del']){
    $sql = "delete from {$g5['g5_shop_cart_table']} where od_id ='$s_cart_id' and it_id = '$it_id'";
    sql_query($sql);

    return 'del';
}


$sql = " select ct_qty as qty from {$g5['g5_shop_cart_table']} where od_id ='$s_cart_id' and it_id = '$it_id'";
$qty = sql_fetch($sql);

if($qty['qty'] - 1 == 0){
    $sql = "delete from {$g5['g5_shop_cart_table']} where od_id ='$s_cart_id' and it_id = '$it_id'";
    sql_query($sql);

    die();
}

$sql ="update {$g5['g5_shop_cart_table']} set ct_qty = ct_qty - 1 where od_id ='$s_cart_id' and it_id = '$it_id' and io_type = 0";
sql_query($sql);

die();
?>