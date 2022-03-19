<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

//----------------------------------------------------------
// 게시글알림-관리자용
// gnuwiz 카카오 알림톡 연동 시작
//----------------------------------------------------------
if ($w == '' && $nc_config['nc_biz_msg_admin_hp']) { // 최고관리자를 조회하고 휴대폰번호가 있다면 발송
	$gw_msg = new NCP_SENS();
	$gw_msg->templateCode	= 'board'; // 템플릿 코드
	$gw_msg->to				= $nc_config['nc_biz_msg_admin_hp']; // 수신자 휴대폰번호
	$gw_msg->user_field1	= $board['bo_subject']; // 필드1 (게시판 이름)
	$gw_msg->user_field2	= $member['mb_id']; // 필드2 (게시글 작성자 아이디)
	$gw_msg->user_field3	= $wr_subject; // 필드3 (게시글 제목)
	$gw_msg->send();
}
//----------------------------------------------------------
// gnuwiz 카카오 알림톡 연동 끝
//----------------------------------------------------------
?>