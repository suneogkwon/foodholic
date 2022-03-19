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
<!-- 하단 시작 { -->
<div id="ft" class="margin-top-3">
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
<!-- } 하단 끝 -->
</div>
<div class="off-canvas position-left show-for-small-only" id="offCanvas" data-off-canvas data-transition="overlap">
  <a href="#" class="fake-a"></a>
  <div id="m_all_menu" class="category">
    <div class="title grid-x align-middle padding-vertical-3 padding-horizontal-2" style="background: #ef4136">
      <?php if($is_member) {?>
        <!-- 회원 -->
          <span class="cell auto color-white">안녕하세요 <b><?php echo $member['mb_name']; ?></b>님<br /></span>
          <div class="cell shrink member_btn text-center padding-horizontal-1 margin-right-1">
            <a href="<?php echo G5_SHOP_URL; ?>/mypage.php" class="color-white">마이페이지</a>
          </div>
          <div class="cell shrink member_btn text-center padding-horizontal-1">
            <a href="<?php echo G5_BBS_URL ?>/logout.php" class="color-white">로그아웃</a>
          </div>
      <?php } else { ?>
        <!-- 비회원 -->
        <div class="cell auto color-white">
          안녕하세요. 고객님<br>
          회원이시라면 <span class="font-bold">로그인</span>해주세요!
        </div>
        <div class="cell shrink member_btn text-center padding-horizontal-1"><a href="<?php echo G5_BBS_URL ?>/login.php" class="color-white">로그인</a></div>
      <?php } ?>
    </div>
    <div class="member">
      <ul class="grid-x no-bullet align-bottom text-center margin-0">
        <li class="cell auto padding-vertical-1">
          <a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">
            <img src="<?php echo G5_THEME_IMG_URL ?>/ico_ship.png" style="width: 50px"/><span class="display-block text-center color-darkgray">주문/배송</span>
          </a>
        </li>
        <li class="cell auto padding-vertical-1">
          <a href="<?php echo G5_SHOP_URL; ?>/cart.php">
            <img src="<?php echo G5_THEME_IMG_URL ?>/ico_cart.png" style="width: 50px"/><span class="display-block text-center color-darkgray">장바구니</span>
          </a>
        </li>
        <li class="cell auto padding-vertical-1">
          <a href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank">
            <span class="display-block margin-vertical-1 h5 color-primary font-bold"><?php echo number_format($member['mb_point']); ?></span><span class="display-block text-center color-darkgray">보유 포인트</span>
          </a>
        </li>
        <li class="cell auto padding-vertical-1">
          <a href="<?php echo G5_SHOP_URL; ?>/coupon.php" target="_blank">
            <span class="display-block margin-vertical-1 h5 color-primary font-bold"><?php
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
              echo ($is_member)?number_format($cp_count):0; ?></span><span class="display-block text-center color-darkgray">보유 쿠폰</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="padding-vertical-2" style="border-bottom:1px solid #e6e6e6">
        <ul class="vertical menu accordion-menu" data-accordion-menu>
            <?php
            $menu_datas = get_menu_db(0, true);
            $i = 0;
            foreach( $menu_datas as $row ){
                if( empty($row) ) continue;
                ?>
            <li class="padding-1">
                <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class=""><?php echo $row['me_name'] ?></a>
                <?php
                $k = 0;
                foreach( (array) $row['sub'] as $row2 ){

                    if( empty($row2) ) continue;

                    if($k == 0)
                        echo '<ul class="menu vertical nested">'.PHP_EOL;
                    ?>
                    <li class="margin-0"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="color-black"><?php echo $row2['me_name'] ?></a></li>
                    <?php
                    $k++;
                }   //end foreach $row2

                if($k > 0)
                    echo '</ul>'.PHP_EOL;
                ?>
                </li>
                <?php
                $i++;
            }   //end foreach $row
            ?>
        </ul>
    </div>
    <div class="vote_wrap">
      <?php echo poll('theme/basic');?>
    </div>

    <div class="s_CSinfo">
      <div class="grid-x padding-2">
          <div class="cell auto"><span class="h2 font-bold">Customer Center</span></div>
        <div class="cell shrink">
          <a href="" target='_blank'><img src="<?php echo G5_THEME_IMG_URL ?>/kakao.png" style="width:40px;"></a>
          <a href="" target='_blank'><img src="<?php echo G5_THEME_IMG_URL ?>/kakao_ch.png" style="width:40px;"></a>
        </div>
        <div class="cell">
          <div class="h1 font-bold color-primary margin-bottom-2">
              <p class="margin-0">1566-3615</p>
              <?php echo $default['de_admin_company_tel']; ?>
          </div>
          <div class="text-right"><strong class="float-left">상담시간</strong>00:00AM - 00.00PM</div>
          <div class="text-right"><strong class="float-left">EMAIL</strong><?php echo $default['de_admin_info_email']; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="sidemenu" class="tab_wr">
    <div class="quickmenu position-absolute"><button class="button rounded padding-1 margin-0 animated"><i class="h4 margin-0 xi-angle-left" aria-hidden="true"></i></button></div>
    <div class="fix_btn">
        <div class="ka_img">
            <a href="" target='_blank'><img src="<?php echo G5_THEME_IMG_URL ?>/kakao.png"></a>
            <a href="" target='_blank'><img src="<?php echo G5_THEME_IMG_URL ?>/kakao_ch.png"></a>
        </div>
        <button type="button" class="top_btn"><i class="fa fa-arrow-up"></i><span class="sound_only">상단으로</span></button>
    </div>
    <div class="tabs_con padding-vertical-3">
        <?php echo outlogin('theme/shop_basic'); // 아웃로그인 ?>

        <div class="padding-2">
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
    <script>
        $(function() {
            $(".quickmenu").on("click", function() {
                $("#sidemenu").toggleClass("sel");
                $(".quickmenu button").toggleClass("btn_on");
            });
        });
    </script>
</div>

<?php
include_once(G5_THEME_PATH . '/tail.sub.php');
?>
