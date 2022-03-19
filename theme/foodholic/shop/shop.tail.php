<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH . '/shop.tail.php');
    return;
}

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>

</div>
<!-- 하단 시작 { -->

<div id="sidemenu" class="tab_wr">
    <div class="quickmenu"><button class="animated"><i class="xi-angle-left" aria-hidden="true"></i></button></div>

    <div class="fix_btn">
        <div class="ka_img">
            <a href="" target='_blank'><img src="<?php echo G5_THEME_IMG_URL ?>/kakao.png"></a>
            <a href="" target='_blank'><img src="<?php echo G5_THEME_IMG_URL ?>/kakao_ch.png"></a>
        </div>
        <button type="button" class="top_btn"><i class="fa fa-arrow-up"></i><span class="sound_only">상단으로</span></button>
    </div>

    <div class="tabs_con">
        <div class="item">
            <div class="inner">
                <?php echo outlogin('theme/shop_basic'); // 아웃로그인 
                ?>

                <div class="s_cart s_ol">
                    <?php include_once(G5_THEME_SHOP_PATH . '/ajax.cart.php'); ?>
                </div>
                <?php echo poll('theme/basic');?>

                <div class="s_CSinfo">
                    <div class="list center">
                        <div class="tit">Customer Center</div>
                        <div class="ka_img">
                            <a href="" target='_blank'><img src="<?php echo G5_THEME_IMG_URL ?>/kakao.png"></a>
                            <a href="" target='_blank'><img src="<?php echo G5_THEME_IMG_URL ?>/kakao_ch.png"></a>
                        </div>
                        <div class="txt">
                            <div class="tel"><p>1566-3615</p><?php echo $default['de_admin_company_tel']; ?></div>
                            <div class="openclose"><strong>상담시간</strong>00:00AM - 00.00PM</div>
                            <div class="email"><strong>EMAIL</strong><?php echo $default['de_admin_info_email']; ?></div>
                        </div>
                    </div>
                    <div class="list bank">
                        <div class="tit">Bank Info</div>
                        <div class="txt">
                            <span class="bank">
                                농협은행 010-3685-3615-08 <br>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $(".quickmenu").on("click", function() {
                $("#sidemenu").toggleClass("sel");
                $(".quickmenu button").toggleClass("btn_on");
            });
        });
    </script>
</div>

<div id="ft">
    <div class="ft_wr">
        <div class="fnb">
            <div class="floatwrap">
                <ul class="link">
                    <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company">회사소개</a></li>
                    <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=provision">서비스이용약관</a></li>
                    <li><a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=privacy">개인정보처리방침</a></li>
                </ul>
            </div>
        </div>
        <div class="footer">
            <div class="floatwrap">
                <a href="<?php echo G5_SHOP_URL; ?>/" id="ft_logo"><img src="<?php echo G5_THEME_IMG_URL; ?>/logo_img.svg" alt="<?php echo $config['cf_title']; ?>"></a></a>

                <address>
                    <span><b>회사명</b> <?php echo $default['de_admin_company_name']; ?></span>
                    <span><b>주소</b> <?php echo $default['de_admin_company_addr']; ?></span>
                    <span><b>사업자 등록번호</b> <?php echo $default['de_admin_company_saupja_no']; ?></span>
                    <span><b>대표</b> <?php echo $default['de_admin_company_owner']; ?></span><br>
                    <span><b>전화</b> <?php echo $default['de_admin_company_tel']; ?></span>
                    <span><b>휴대폰</b> <?php echo $default['de_admin_company_fax']; ?></span>
                    <!-- <span><b>운영자</b> <?php echo $admin['mb_name']; ?></span><br> -->
                    <span><b>통신판매업신고번호</b> <?php echo $default['de_admin_tongsin_no']; ?></span>
                    <span><b>개인정보 보호책임자</b> <?php echo $default['de_admin_info_name']; ?></span><br>

                    <?php if ($default['de_admin_buga_no']) echo '<span><b>관리자 제휴&문의</b> ' . $default['de_admin_buga_no'] . '</span>'; ?><br>
                    <cite>Copyright &copy; 20020-2020 <?php echo $default['de_admin_company_name']; ?>. All Rights Reserved.</cite>
                </address>
            </div>
        </div>
    </div>
    <div class="fix_btn">
        <button type="button" class="fix_cart_btn"><a href="<?php echo G5_SHOP_URL; ?>/cart.php"><i class="xi-basket"></i><span class="sound_only">장바구니</span></a></button>
        <button type="button" class="top_btn"><i class="fa fa-arrow-up"></i><span class="sound_only">상단으로</span></button>
    </div>
</div>

<script>
    $(function() {
        $(".top_btn").on("click", function() {
            $("html, body").animate({
                scrollTop: 0
            }, '500');
            return false;
        });
    });
</script>
<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
</div>
<!-- } 하단 끝 -->

<?php
include_once(G5_THEME_PATH . '/tail.sub.php');
?>