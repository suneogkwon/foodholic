<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
?>

<!-- 로그인 전 아웃로그인 시작 { -->
<div id="s_ol_before" class="padding-2">
    <h5 class="font-bold text-center">로그인</h5>
    <form name="foutlogin" action="<?php echo $outlogin_action_url ?>" onsubmit="return fhead_submit(this);" method="post" autocomplete="off">
    <fieldset>
        <input type="hidden" name="url" value="<?php echo $outlogin_url ?>">
        <label for="ol_id" id="ol_idlabel" class="show-for-sr">회원아이디</label>
        <input type="text" id="ol_id" name="mb_id" required class="required margin-bottom-1" maxlength="20" placeholder="아이디">
        <label for="ol_pw" id="ol_pwlabel" class="show-for-sr">비밀번호</label>
        <input type="password" name="mb_password" id="ol_pw" required class="required margin-bottom-1" maxlength="20" placeholder="비밀번호">
        <div id="ol_auto" class="switch tiny">
            <input class="switch-input" type="checkbox" name="auto_login" value="1" id="auto_login" style="vertical-align: middle;">
            <label for="auto_login" id="auto_login_label" class="switch-paddle"></label>
            <small class="color-black">자동로그인</small>
        </div>
        <button type="submit" id="ol_submit" class="width-100 button">로그인</button>
        <div id="ol_svc" class="float-right">
            <a href="<?php echo G5_BBS_URL ?>/password_lost.php" id="ol_password_lost" class="bordered" style="padding:2px">아이디 / 비밀번호 찾기</a>
        </div>
    </fieldset>
    </form>
</div>

<script>
$omi = $('#ol_id');
$omp = $('#ol_pw');
$omi_label = $('#ol_idlabel');
$omi_label.addClass('ol_idlabel');
$omp_label = $('#ol_pwlabel');
$omp_label.addClass('ol_pwlabel');

$(function() {
    $("#auto_login").click(function(){
        if ($(this).is(":checked")) {
            if(!confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?"))
                return false;
        }
    });
});

function fhead_submit(f)
{
    return true;
}
</script>
<!-- } 로그인 전 아웃로그인 끝 -->
