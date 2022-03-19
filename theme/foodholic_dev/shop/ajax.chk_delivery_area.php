<?php
include_once('./_common.php');

// 사용자 주소
$usr_addr = $_POST['address'];
$usr_sido = $_POST['sido'];
$usr_gungu = $_POST['gungu'];
$usr_dongri = $_POST['dongri'];

// 배달 가능 지역 리스트
$can_sido = explode(',',$default['de_3']);
$can_gungu = explode(',',$default['de_4']);
$can_dongri = explode(',',$default['de_5']);

// 배송 불가 메세지
$cant_message = $default['de_6'];
$cant_message = str_replace('{주소}',"'".$usr_addr."'",$cant_message);

// 전지역 리스트
$all = array();

// 시/도 전지역 판단
for($i=0;$i<count($can_sido);$i++){
    if(mb_strpos($can_sido[$i],'(전)')){
        $can_sido[$i] = str_replace('(전)','',$can_sido[$i]);
        $all[] = $can_sido[$i];
    }
}
// 군/구 전지역 판단
for($i=0;$i<count($can_gungu);$i++){
    if(mb_strpos($can_gungu[$i],'(전)')){
        $can_gungu[$i] = str_replace('(전)','',$can_gungu[$i]);
        $all[] = $can_gungu[$i];
    }
}
if(in_array($usr_sido,$can_sido)){ // 배송 가능 시/도 판단
    if(in_array($usr_sido,$all))
        die("'".$usr_addr."'는 배송 가능 지역입니다.");
    if(in_array($usr_gungu,$can_gungu)){ // 배송 가능 군/구 판단
        if(in_array($usr_gungu,$all))
            die("'".$usr_addr."'는 배송 가능 지역입니다.");
        if(in_array($usr_dongri,$can_dongri)){ // 배송 가능 동/리 판단
            die("'".$usr_addr."'는 배송 가능 지역입니다.");
        }
    }
}

die($cant_message);   // 배송 불가 알림