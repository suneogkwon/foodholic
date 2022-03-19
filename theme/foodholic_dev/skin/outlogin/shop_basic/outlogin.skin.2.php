<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);

// 쿠폰
$cp_count = 0;
$sql = " select cp_id
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."' ";
$res = sql_query($sql);

for($k=0; $cp=sql_fetch_array($res); $k++) {
    if(!is_used_coupon($member['mb_id'], $cp['cp_id']))
        $cp_count++;
}
?>

<!-- 로그인 후 아웃로그인 시작 { -->
<div id="s_ol_after" class="padding-2">
    <h2 class="show-for-sr">나의 회원정보</h2>
    <div class="ol_wr">
        <div id="s_ol_after_hd">
            <?php echo get_member_profile_img($member['mb_id']); ?>
            <p class="font-bold margin-bottom-1 padding-top-1"><?php echo $nick ?>님 </p>
            <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" id="s_ol_after_info" title="정보수정" class="button tiny hollow">정보수정</a>
            <a href="<?php echo G5_BBS_URL ?>/logout.php" id="s_ol_after_logout" class="button tiny hollow black">로그아웃</a>
            <div class="clear-both"></div>
        </div>

        <ul id="s_ol_after_private" class="no-bullet margin-top-2">
            <li class="padding-1">
                <a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" id="ol_after_pt" class="grid-x align-middle">
                    <i class="fa fa-database cell small-2"></i> <span class="cell small-5">포인트</span><strong class="cell small-5 text-right"><?php echo $point ?> 점</strong>
                </a>
            </li>
            <li class="padding-1">
                <a href="<?php echo G5_SHOP_URL ?>/coupon.php" target="_blank" id="ol_after_coupon" class="grid-x align-middle">
                    <i class="fa fa-newspaper-o cell small-2"></i><span class="cell small-5">쿠폰</span><strong class="cell small-5 text-right"><?php echo number_format($cp_count); ?> 장</strong></a>
            </li>
            <li class="padding-1"><a href="<?php echo G5_SHOP_URL; ?>/mypage.php" class="grid-x align-middle">
                    <i class="fa fa-user cell small-2"></i><span class="cell small-5">마이페이지</span></a>
            </li>
        </ul>
    </div>
</div>

<script>
    $(function(){
        $('#s_ol_after_hd img').addClass("float-left padding-right-1");
    });
// 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
function member_leave()
{
    if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
        location.href = "<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php";
}
</script>
<!-- } 로그인 후 아웃로그인 끝 -->
