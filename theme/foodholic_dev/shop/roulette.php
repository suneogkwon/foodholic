<?php
include_once('./_common.php');

$roulette = (object)array();
$roulette->id = $_POST['mb_id'];
$sql = "select mb_1, mb_2 from {$g5['member_table']} where mb_id = '{$roulette->id}'";
$query_result_roulette = sql_fetch($sql);
$roulette->mb_1 = $query_result_roulette['mb_1'];

$sstime_start = mktime(0, 0, 0, 3, 21, 2020);
$sstime_end = mktime(23, 59, 59, 3, 25, 3022);
$sstime_now = time();

if($roulette->id) {
    if( (int)date('Ymd',(int)$query_result_roulette['mb_2'])<(int)date('Ymd',$sstime_now) && $sstime_start < $sstime_now && $sstime_end > $sstime_now) {
        $sql = " update {$g5['member_table']} set mb_1=1, mb_2=unix_timestamp() where mb_id = '$roulette->id'";
        sql_query($sql);
        $roulette->mb_1++;
    }
}

if ($_POST['state'] == 1) {
    if (!$roulette->id) {
        $roulette->error = 1;
    } else if (!($sstime_start < $sstime_now && $sstime_end > $sstime_now)) {
        $roulette->error = 2;
    }

} else if ($_POST['state'] == 2) {
    if (!$roulette->mb_1) {
        $roulette->error = 3;
    } else {
        $sql = "update {$g5['member_table']} set mb_1=mb_1 - 1 where mb_id = '$roulette->id'";
        $result = sql_query($sql);
        $lucky_number = mt_rand(0, 99);
        if ($lucky_number < 5) {
            $roulette->rotate = 330 + mt_rand(1,29);
            $roulette->mileage = 1000;
        } else if ($lucky_number < 10) {
            $roulette->rotate = 210 + mt_rand(1,29);
            $roulette->mileage = 500;
        } else if ($lucky_number < 20) {
            $roulette->rotate = 150 + mt_rand(0, 1) * 120 + mt_rand(1,29);
            $roulette->mileage = 300;
        } else if ($lucky_number < 40) {
            $roulette->rotate = 30 + mt_rand(0, 1) * 60 + mt_rand(1,29);
            $roulette->mileage = 100;
        } else {
            $roulette->rotate = mt_rand(0, 5) * 60 + mt_rand(1,29);
            $roulette->mileage = 0;
        }
        //마일리지 넣기
        if (!$result) {
            $roulette->error = 4;
            $sql = " update {$g5['member_table']} set mb_1=mb_1 + 1 where mb_id = '$roulette->id'";
            sql_query($sql);
        }
        if($roulette->mileage != 0)
            insert_point($roulette->id, $roulette->mileage, '룰렛 이벤트 적립', '@event', $roulette->id, G5_TIME_YMDHIS,365);
    }
}
echo json_encode($roulette);

?>