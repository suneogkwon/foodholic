<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//----------------------------------------------------------
// 회원가입알림-고객용
// gnuwiz 카카오 알림톡 연동 시작
//----------------------------------------------------------
if ($w == '' && $mb_hp && !$config['cf_use_email_certify']) { // 메일인증을 사용할경우 알림톡 보내지 않음.
	$gw_msg = new NCP_SENS();
	$gw_msg->templateCode	= 'register01'; // 템플릿 코드
	$gw_msg->to				= $mb_hp; // 수신자 휴대폰번호
	$gw_msg->user_field1	= $mb_name; // 필드1 (이름)
	$gw_msg->user_field2	= $mb_id; // 필드2 (아이디)
	$gw_msg->user_field3	= $config['cf_title']; // 필드3 (홈페이지 명)
	$gw_msg->send();
}
//----------------------------------------------------------
// gnuwiz 카카오 알림톡 연동 끝
//----------------------------------------------------------

//----------------------------------------------------------
// 회원가입알림-관리자용
// gnuwiz 카카오 알림톡 연동 시작
//----------------------------------------------------------
if ($w == '' && $mb_hp && $nc_config['nc_biz_msg_admin_hp']) {
	$gw_msg = new NCP_SENS();
	$gw_msg->templateCode	= 'register02'; // 템플릿 코드
	$gw_msg->to				= $nc_config['nc_biz_msg_admin_hp']; // 수신자 휴대폰번호
	$gw_msg->user_field1	= $mb_name; // 필드1 (이름)
	$gw_msg->user_field2	= $mb_id; // 필드2 (아이디)
	$gw_msg->user_field3	= G5_TIME_YMDHIS; // 필드3 (가입일시)
	$gw_msg->send();
}
//----------------------------------------------------------
// gnuwiz 카카오 알림톡 연동 끝
//----------------------------------------------------------




// //----------------------------------------------------------
// // SMS 문자전송 시작
// //----------------------------------------------------------

// $sms_contents = $default['de_sms_cont1'];
// $sms_contents = str_replace("{이름}", $mb_name, $sms_contents);
// $sms_contents = str_replace("{회원아이디}", $mb_id, $sms_contents);
// $sms_contents = str_replace("{회사명}", $default['de_admin_company_name'], $sms_contents);

// // 핸드폰번호에서 숫자만 취한다
// $receive_number = preg_replace("/[^0-9]/", "", $mb_hp);  // 수신자번호 (회원님의 핸드폰번호)
// $send_number = preg_replace("/[^0-9]/", "", $default['de_admin_company_tel']); // 발신자번호

// if ($w == "" && $default['de_sms_use1'] && $receive_number)
// {
// 	if ($config['cf_sms_use'] == 'icode')
// 	{
// 		if($config['cf_sms_type'] == 'LMS') {
//             include_once(G5_LIB_PATH.'/icode.lms.lib.php');

//             $port_setting = get_icode_port_type($config['cf_icode_id'], $config['cf_icode_pw']);

//             // SMS 모듈 클래스 생성
//             if($port_setting !== false) {
//                 $SMS = new LMS;
//                 $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $port_setting);

//                 $strDest     = array();
//                 $strDest[]   = $receive_number;
//                 $strCallBack = $send_number;
//                 $strCaller   = iconv_euckr(trim($default['de_admin_company_name']));
//                 $strSubject  = '';
//                 $strURL      = '';
//                 $strData     = iconv_euckr($sms_contents);
//                 $strDate     = '';
//                 $nCount      = count($strDest);

//                 $res = $SMS->Add($strDest, $strCallBack, $strCaller, $strSubject, $strURL, $strData, $strDate, $nCount);

//                 $SMS->Send();
//                 $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
//             }
//         } else {
//             include_once(G5_LIB_PATH.'/icode.sms.lib.php');

//             $SMS = new SMS; // SMS 연결
//             $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']);
//             $SMS->Add($receive_number, $send_number, $config['cf_icode_id'], iconv_euckr(stripslashes($sms_contents)), "");
//             $SMS->Send();
//             $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
//         }
// 	}
// }
// //----------------------------------------------------------
// // SMS 문자전송 끝
// //----------------------------------------------------------
?>
