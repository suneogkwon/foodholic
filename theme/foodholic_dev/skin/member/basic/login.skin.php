<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_SHOP_PATH . '/shop.head.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $member_skin_url . '/style.css">', 0);
?>


<div class="content">
    <div class="floatwrap">
        <!-- 로그인 시작 { -->
        <div id="mb_login" class="khskin">
            <div class="floatwrap">
                <div id="mb_login_user" class="inner">
                    <h1><?php echo $g5['title'] ?></h1>
                    <div class="mb_log_cate">
                        <h2><span class="sound_only">회원</span>로그인</h2>
                        <a href="./register.php" class="join">회원가입</a>
                    </div>
                    <div class="tit">
                        <i class="xi_icon xi-info"></i>
                        <p>가입하신 아이디와 비밀번호를 입력해주세요<br>비밀번호는 대소문자를 구분합니다.</p>
                    </div>
                    <div class="form">
                        <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
                            <input type="hidden" name="url" value="<?php echo $login_url ?>">

                            <fieldset id="login_fs">
                                <legend>회원로그인</legend>
                                <div class="desc">
                                    <i class="xi-user-o"></i>
                                    <label for="login_id" class="sound_only">회원아이디<strong class="sound_only"> 필수</strong></label>
                                    <input type="text" name="mb_id" id="login_id" required class="frm_input required" size="20" maxLength="20" placeholder="아이디">
                                </div>
                                <div class="desc">
                                    <i class="xi-lock-o"></i>
                                    <label for="login_pw" class="sound_only">비밀번호<strong class="sound_only"> 필수</strong></label>
                                    <input type="password" name="mb_password" id="login_pw" required class="frm_input required" size="20" maxLength="20" placeholder="비밀번호">
                                </div>
                                <div class="info">
                                    <div class="login_if_auto chk_box fl">
                                        <input type="checkbox" name="auto_login" id="login_auto_login" class="tgl tgl-ios">
                                        <label class="tgl-btn" for="login_auto_login"></label>
                                        <span>자동로그인(어플 사용 시 반드시 체크)</span>
                                    </div>
                                    <div class="login_if_lpl fr">
                                        <a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost">정보찾기</a>
                                    </div>
                                </div>
                                <input type="submit" value="로그인" class="btn_submit">
                            </fieldset>

                            <?php
                            // 소셜로그인 사용시 소셜로그인 버튼
                            @include_once(get_social_skin_path() . '/social_login.skin.php');
                            ?>
                        </form>
                    </div>
                </div>
                <?php // 쇼핑몰 사용시 여기부터 
                ?>
                <?php if ($default['de_level_sell'] == 1) { // 상품구입 권한 
                ?>
                    <!-- 주문하기, 신청하기 -->
                    <?php if (preg_match("/orderform.php/", $url)) { ?>
                        <div id="mb_login_notmb" class="inner">
                            <h2>비회원 구매</h2>
                            <div class="tit">
                                <i class="xi_icon xi-info"></i>
                                <p>비회원으로 주문하시는 경우 포인트는 지급하지 않습니다.</p>
                            </div>
                            <div class="form">
                                <div id="guest_privacy" class="desc">
                                    <?php echo $default['de_guest_privacy']; ?>
                                </div>
                                <div class="info">
                                    <div class="chk_box">
                                        <input type="checkbox" id="agree" value="1" class="tgl tgl-ios">
                                        <label class="tgl-btn"for="agree"></label>
                                        <span>개인정보수집에 대한 내용을 읽었으며 이에 동의합니다.</span>
                                    </div>
                                </div>
                                
                                <div class="btn_confirm">
                                    <a href="javascript:guest_submit(document.flogin);" class="btn_submit">비회원으로 구매하기</a>
                                </div>
                            </div>
                            <script>
                                function guest_submit(f) {
                                    if (document.getElementById('agree')) {
                                        if (!document.getElementById('agree').checked) {
                                            alert("개인정보수집에 대한 내용을 읽고 이에 동의하셔야 합니다.");
                                            return;
                                        }
                                    }

                                    f.url.value = "<?php echo $url; ?>";
                                    f.action = "<?php echo $url; ?>";
                                    f.submit();
                                }
                            </script>
                        </div>
                    <?php } else if (preg_match("/orderinquiry.php$/", $url)) { ?>
                        <div id="mb_login_od_wr" class="inner">
                            <h2>비회원 주문조회 </h2>

                            <fieldset id="mb_login_od">
                                <legend>비회원 주문조회</legend>
                                <div class="tit">
                                    <i class="xi_icon xi-info"></i>
                                    <p>메일로 발송해드린 주문서의 <strong>주문번호</strong> 및 주문 시<br> 입력하신 <strong>비밀번호</strong>를 정확히 입력해주십시오.</p>
                                </div>
                                <div class="form">
                                <form name="forderinquiry" method="post" action="<?php echo urldecode($url); ?>" autocomplete="off">
                                    <div class="desc">
                                        <i class="xi-basket"></i>
                                        <label for="od_id" class="od_id sound_only">주문서번호<strong class="sound_only"> 필수</strong></label>
                                        <input type="text" name="od_id" value="<?php echo $od_id; ?>" id="od_id" required class="frm_input required" size="20" placeholder="주문서번호">
                                    </div>
                                    <div class="desc">
                                        <i class="xi-lock-o"></i>
                                        <label for="id_pwd" class="od_pwd sound_only">비밀번호<strong class="sound_only"> 필수</strong></label>
                                        <input type="password" name="od_pwd" size="20" id="od_pwd" required class="frm_input required" placeholder="비밀번호">
                                    </div>
                                    <input type="submit" value="확인" class="btn_submit">

                                </form>
                            </div>
                            </fieldset>

                        </div>
                    <?php } ?>
                <?php } ?>
                <?php // 쇼핑몰 사용시 여기까지 반드시 복사해 넣으세요 
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#login_auto_login").click(function() {
            if (this.checked) {
                this.checked = confirm("자동로그인을 사용하시겠습니까?");
            }
        });
    });

    function flogin_submit(f) {
        return true;
    }
</script>
<!-- } 로그인 끝 -->

<?php
include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
?>