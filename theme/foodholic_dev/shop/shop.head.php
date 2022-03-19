<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

set_cart_id(0);
$tmp_cart_id = get_session('ss_cart_id');

$sql = " select au_menu from {$g5['auth_table']} where mb_id = '{$member['mb_id']}' ";
$result = sql_query($sql);
$mem_au = array();
for($i=0; $row=sql_fetch_array($result); $i++)
    {
        $mem_au[$i] = $row['au_menu'];
    }

?>
<?php if(defined('_INDEX_')) { // index에서만 실행
    ?>
    <div id="popup_wr">
        <?php
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
        } ?>
    </div>

<div id="top_banner">
	<?php echo display_banner('상단', 'mainbanner.30.skin.php'); // 상단 배너 ?>
</div>
<!-- 상단 시작 { -->
<header id="hd">
    <h1 id="hd_h1" class="visually-hidden"><?php echo $g5['title'] ?></h1>
    <div id="top_nav">
        <div class="container">
            <nav class="d-none d-lg-flex nav justify-content-end">
                <?php if ($is_member) { ?>
                    <?php if ($is_admin) {  ?>
                        <a class="nav-link" href="<?php echo G5_ADMIN_URL; ?>/shop_admin?w=c">관리자</a>
                    <?php }
                    if($member['mb_level'] == 5){ ?>
                        <a class="nav-link" href="<?php echo G5_ADMIN_URL; ?>/shop_admin">직원용</a>
                    <?php } ?>
                    <a class="nav-link" href="<?php echo G5_THEME_SHOP_URL ?>/roulette_ev.php">포인트룰렛</a>
                    <a class="nav-link" href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a>
                    <a class="nav-link" href="<?php echo G5_SHOP_URL; ?>/mypage.php">마이페이지</a>
                    <a class="nav-link" href="<?php echo G5_BBS_URL; ?>/member_online_coupon.php" target="_blank" id="login_password_lost">쿠폰등록</a>
                <?php } else { ?>
                    <a class="nav-link" href="<?php echo G5_THEME_SHOP_URL ?>/roulette_ev.php">포인트룰렛</a>
                    <a class="nav-link" class="login_btn" href="<?php echo G5_BBS_URL ?>/login.php">로그인</a>
                    <a class="nav-link" href="<?php echo G5_BBS_URL ?>/register.php" class="position-relative">회원가입<div id="animated-example" class="animated tada infinite text-center">2000</div></a>

                <?php } ?>
                <a class="nav-link" href="<?php echo G5_SHOP_URL; ?>/cart.php">장바구니</a>
                <a class="nav-link" href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">주문조회</a>
            </nav>
            <ul class="show-for-small-only menu simple align-center align-middle text-center expanded" style="height:35px">
                <?php if ($is_member) { ?>
                    <?php if ($is_admin) {  ?>
                        <li><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin?w=c">관리자</a></li>
                    <?php }
                    if($member['mb_level'] == 5){ ?>
                        <li><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin">직원용</a></li>
                    <?php } ?>
                    <li><a href="<?php echo G5_THEME_SHOP_URL ?>/roulette_ev.php">포인트룰렛</a></li>
                    <li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
                    <li><a href="<?php echo G5_SHOP_URL; ?>/mypage.php">마이페이지</a></li>
                    <li><a href="<?php echo G5_BBS_URL; ?>/member_online_coupon.php" target="_blank" id="login_password_lost">쿠폰등록</a></li>
                <?php } else { ?>
                    <li><a href="<?php echo G5_THEME_SHOP_URL ?>/roulette_ev.php">포인트룰렛</a></li>
                    <li><a class="login_btn" href="<?php echo G5_BBS_URL ?>/login.php">로그인</a></li>
                    <li><a href="<?php echo G5_BBS_URL ?>/register.php" class="position-relative">회원가입</a></li>
                <?php } ?>
                <li><a href="<?php echo G5_SHOP_URL; ?>/cart.php">장바구니</a></li>
                <li><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">주문조회</a></li>
            </ul>
        </div>
    </div>
    <div id="hd" >
        <div class="grid-container">
            <div class="grid-x padding-vertical-2 align-middle">
                <div class="cell small-4 medium-3">
                    <button class="show-for-small-only padding-left-1 menuOpen" type="button" data-toggle="offCanvas" style="cursor: pointer"><i class="h1 xi-bars"></i><span class="display-block">전체메뉴</span></button>
                    <div class="show-for-medium"><img src="<?php echo G5_THEME_IMG_URL ?>/delivery.png"></div>
                </div>
                <div id="header_logo" class="cell small-4 medium-4 medium-offset-1 text-center">
                    <div class="show-for-small-only padding-horizontal-3"><a href="<?php echo G5_SHOP_URL; ?>/"><img src="<?php echo G5_THEME_IMG_URL; ?>/logo_img.svg" alt="<?php echo $config['cf_title']; ?>"></a></div>
                    <div class="show-for-medium-only"><a href="<?php echo G5_SHOP_URL; ?>/"><img class="width-75" src="<?php echo G5_THEME_IMG_URL; ?>/logo_img.svg" alt="<?php echo $config['cf_title']; ?>"></a></div>
                    <div class="show-for-large"><a href="<?php echo G5_SHOP_URL; ?>/"><img class="width-50" src="<?php echo G5_THEME_IMG_URL; ?>/logo_img.svg" alt="<?php echo $config['cf_title']; ?>"></a></div>
                </div>
                <div class="cell small-4 medium-3 large-2 medium-offset-1 large-offset-2">
                    <ul class="menu simple expanded text-center padding-right-2">
                        <li>
                            <a href="<?php echo G5_THEME_SHOP_URL;?>/lunch_menu.php"><img src="<?php echo G5_THEME_IMG_URL ?>/lunch_box.png">
                                <span class="show-for-small-only color-black">도시락 식단</span>
                                <h6 class="show-for-medium margin-0 color-black">도시락 식단</h6>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo G5_THEME_SHOP_URL;?>/side_menu.php"><img src="<?php echo G5_THEME_IMG_URL ?>/side_dish.png">
                                <span class="show-for-small-only color-black">반찬 식단</span>
                                <h6 class="show-for-medium margin-0 color-black">반찬 식단</h6>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <div id="gnb">
        <div id="small_gnb" class="hide-for-large grid-container full">
            <ul class="no-bullet grid-x small-up-4 text-center margin-0">
                <?php
                $menu_datas = get_menu_db(1, true);
                $i = 0;
                foreach( $menu_datas as $row ){
                    if( empty($row) ) continue;
                    $highlight_menu = Array('직장인도시락','식단제반찬','스페셜도시락','회원전용특판');
                    $add_a_class = (array_search($row['me_name'],$highlight_menu) !== false)? 'color-primary':'';
                    ?>
                    <li class="cell padding-vertical-2">
                        <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="h6 <?php echo $add_a_class; ?>"><?php echo $row['me_name'] ?></a>
                    </li>
                    <?php
                    $i++;
                }	//end foreach $row
                ?>
            </ul>
        </div>
		    <div id="large_gnb" class="show-for-large grid-container">
            <ul class="dropdown menu simple expanded text-center" data-dropdown-menu>
                <button id="menuOpen" type="button" class="color-white text-center margin-right-2"><i class="h3 xi-bars margin-0"></i><span class="show-for-sr">전체메뉴</span></button>
                <?php
                $menu_datas = get_menu_db(0, true);
                $i = 0;
                foreach( $menu_datas as $row ){
                    if( empty($row) ) continue;
                    //$add_class = (isset($row['sub']) && $row['sub']) ? 'gnb_al_li_plus' : '';
                    $highlight_menu = Array('직장인도시락','식단제반찬','스페셜도시락','회원전용특판');
                    $add_a_class = (array_search($row['me_name'],$highlight_menu) !== false)? 'color-primary':'';
                    ?>
                <li class="padding-vertical-3 <?php //echo $add_class; ?>">
                    <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="h6 font-bold <?php echo $add_a_class; ?>"><?php echo $row['me_name'] ?></a>
                    <?php
                    $k = 0;
                    foreach( (array) $row['sub'] as $row2 ){

                        if( empty($row2) ) continue;

                        if($k == 0)
                            echo '<ul class="vertical menu text-left padding-2">'.PHP_EOL;
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
      <div id="category" class="position-relative">
        <div id="pc_all_menu" class="show-for-medium category grid-container full padding-bottom-3">
          <div class="grid-container">
            <ul class="menu expanded text-center">
              <?php

              $i = 0;
              foreach( $menu_datas as $row ){
                ?>
                <li>
                <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="h6 color-black padding-vertical-3"><?php echo $row['me_name'] ?></a>
                <?php
                $k = 0;
                foreach( (array) $row['sub'] as $row2 ){
                  if($k == 0)
                    echo '<ul class="vertical menu">'.PHP_EOL;
                  ?>
                  <li><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"><?php echo $row2['me_name'] ?></a></li>
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
        </div>
        <div class="clear-both"></div>
        <i class="blind"></i>
      </div>
      <?php // include_once(G5_THEME_SHOP_PATH.'/category.php'); // 분류 ?>

      <div class="clear-both"></div>
    </div>
  <script>
    $(function() {
      $("#menuOpen").on("click", function() {
        $('.category').toggleClass("sel");
        $(this).children('i').toggleClass('xi-bars').toggleClass('xi-close');
        $('.blind').toggleClass("sel");
      });
      $(".blind").click(function() {
        $('.category').removeClass("sel");
        $(this).children('i').removeClass('xi-close').addClass('xi-bars');
        $('.allmenu').removeClass("sel");
      });
    });
  </script>
</header>

<!-- 콘텐츠 시작 { -->
<div id="container">
    <?php if (!defined("_INDEX_")) { ?>
        <div id="wrapper_title" class="position-relative text-center">
            <div class="show-for-small-only grid-container" style="padding:2.5rem 0">
                <div class="position-relative display-inline-block">
                    <a href="javascript:history.back()" class="position-absolute margin-0 color-black h3" style="left:-30px;"><i class="xi-angle-left"></i><span class="show-for-sr">뒤로</span></a>
                    <h3 class="margin-0 font-bold color-primary" style="letter-spacing: 3px;"><?php echo $g5['title'] ?></h3>
                </div>
            </div>
            <div class="show-for-medium grid-container" style="padding:5rem 0">
                <h3 class="margin-0 font-bold color-primary" style="letter-spacing: 3px;"><?php echo $g5['title'] ?></h3>
            </div>
        </div>
    <?php } ?>
