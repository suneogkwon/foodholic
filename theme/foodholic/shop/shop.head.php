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
<div id="responsive">
<?php if ($is_admin) {  ?>
<div class="hd-admin">
    <span><strong>관리자</strong>로 접속하셨습니다.</span>
    <a href="<?php echo G5_THEME_ADM_URL ?>" target="_blank">테마관리</a>
    <a href="<?php echo G5_ADMIN_URL ?>/shop_admin/" target="_blank">관리자</a>
</div>
<?php } ?>

<?php if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
     } ?>
   
<div id="top_banner">
	<?php echo display_banner('상단', 'mainbanner.30.skin.php'); // 상단 배너 ?>
</div>
<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1" class="sound_only"><?php echo $g5['title'] ?></h1>
    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>
    <div class="tnb">
		<div class="floatwrap">
    	<ul class="tnb_right">
    		<li>
				<?php if ($is_member) { ?>
					<?php if ($is_admin) {  ?>
						<a href="<?php echo G5_ADMIN_URL; ?>/shop_admin?w=c">관리자</a></li>
						<li>
					<?php }  
					if($member['mb_level'] == 5){ ?>
						<a href="<?php echo G5_ADMIN_URL; ?>/shop_admin">직원용</a></li>
						<li>
					<?php }
					?>
					<a href="<?php echo G5_THEME_SHOP_URL ?>/roulette_ev.php">포인트룰렛</a></li>
					<li><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
					<li><a href="<?php echo G5_SHOP_URL; ?>/mypage.php">마이페이지</a></li>
					<li><a href="<?php echo G5_BBS_URL; ?>/member_online_coupon.php" target="_blank" id="login_password_lost">쿠폰등록</a></li>
					<?php } else { ?>
					<a href="<?php echo G5_THEME_SHOP_URL ?>/roulette_ev.php">포인트룰렛</a></li>
	        		<li><a class="login_btn" href="<?php echo G5_BBS_URL ?>/login.php">로그인</a></li>
	        		<li><a href="<?php echo G5_BBS_URL ?>/register.php">회원가입
	        			<div id="animated-example" class="animated tada infinite">2000</div>
	        			</a></li>
					<?php } ?>
			</li>
			<li><a href="<?php echo G5_SHOP_URL; ?>/cart.php"><i class="xi-basket"></i>장바구니</a></li>
			<?php if ($is_member) { ?>
				<li><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">주문조회</a></li>
			<?php } else { ?>
				<li><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">비회원주문조회</a></li>
			<?php } ?>
		</ul>
		</div>
	</div>
    <div id="hd_wrapper">
        <div class="floatwrap">
        <div class="sub_img"><img src="<?php echo G5_THEME_IMG_URL ?>/delivery.jpg"></div>
        <div class="logo"><a href="<?php echo G5_SHOP_URL; ?>/"><img src="<?php echo G5_THEME_IMG_URL; ?>/logo_img.svg" alt="<?php echo $config['cf_title']; ?>"></a></div>
		<div class="food_menu">
			<ul>
				<li><a href="<?php echo G5_THEME_SHOP_URL;?>/lunch_menu.php"><img src="<?php echo G5_THEME_IMG_URL ?>/lunch_box.png"><span>도시락식단</span></a></li>
				<li><a href="<?php echo G5_THEME_SHOP_URL;?>/side_menu.php"><img src="<?php echo G5_THEME_IMG_URL ?>/side_dish.png"><span>반찬식단</span></a></li>
			</ul>
		</div>
		<div class="mob">
            <button type="button" class="menuOpen"><div class="bars"><span class="ba1"></span><span class="ba2"></span><span class="ba3"></span></div><span class="bar_txt">전체메뉴</span></button>
        </div>
        </div>
    </div>
    <div id="gnb">
		<div class="floatwrap">
    	<button type="button" class="menuOpen"><div class="bars"><span class="ba1"></span><span class="ba2"></span><span class="ba3"></span></div><span class="bar_txt">전체메뉴</span></button>
		<div class="inner">
		<ul class="gnb_shortcut">
    		<li class="dl1"><a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=10">점심도시락주문</a></li>
			<li class="dl1"><a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=20">반찬주문</a></li>
			<li class="dl1"><a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=30">단품반찬주문</a></li>
			<li class="dl1"><a href="<?php echo G5_SHOP_URL;?>/list.php?ca_id=40">회원전용특판</a></li>
			<li class="dl1"><a href="<?php echo G5_BBS_URL;?>/faq.php">자주하는질문</a> 
			<li class="dl1"><a href="<?php echo G5_BBS_URL; ?>/qalist.php">1:1문의게시판</a></li> 
			<li class="dl1"><a href="<?php echo G5_THEME_SHOP_URL;?>/delivery_area.php">배송가능지역</a></li> 
			<li class="dl1"><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=return">용기&가방수거요청</a></li> 
			<li class="dl1"><a href="<?php echo G5_THEME_SHOP_URL;?>/user_guide.php">이용안내</a>
				<ul class="depth2">
					<li><a href="<?php echo G5_BBS_URL;?>/content.php?co_id=company">회사소개</a></li>
					<li><a href="<?php echo G5_THEME_SHOP_URL;?>/user_guide.php">이용안내</a></li>
					<li><a href="<?php echo G5_THEME_SHOP_URL;?>/delivery_guide.php">배송안내</a></li>
					<li><a href="<?php echo G5_THEME_SHOP_URL;?>/delivery_area.php">배송가능지역</a></li> 
					<li><a href="<?php echo G5_BBS_URL;?>/faq.php">자주하는질문</a></li> 
				</ul>
			</li>
			<li class="dl1"><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=notice">공지&이벤트</a></li>
			<li class="dl1"><a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=40">회원전용특판</a> </li>
			<li class="dl1"><a href="<?php echo G5_BBS_URL;?>/faq.php">자주하는질문</a> 
			<li class="dl1"><a href="<?php echo G5_BBS_URL; ?>/qalist.php">1:1문의게시판</a></li>
			<li class="dl1"><a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=40">회원전용특판</a>
			 <?php
				echo get_mb_category('40', '4');
			?>
			</li> 
			<li class="dl1"><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=review">이용후기</a></li> 
			<li class="dl1"><a href="<?php echo G5_THEME_SHOP_URL;?>/delivery_area.php">배송가능지역</a></li>
			<li class="dl1"><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=return">용기&가방수거요청</a></li>
		</ul>
		</div>
		<?php // echo latest('theme/notice', 'notice', 5, 23); ?>
		<script>
			$(function() {
                $('.dl1').bind('mouseenter keyup', function() {
                    $(this).addClass('sel').siblings().removeClass('sel');
                }).bind("mouseleave",function(){
                    $(this).removeClass('sel');
                });
            });
		</script>
    </div>
    <div id="category">
			<div class="category floatwrap">
				<div class="title">
					<?php if($is_member) {?>
						<!-- 회원 -->
						<div class="logout">
						안녕하세요 <b><?php echo $member['mb_name']; ?></b>님,<br />
						<div class="button button2"><a href="<?php echo G5_SHOP_URL; ?>/mypage.php">마이페이지</a></div>
                        <div class="button"><a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></div>
                    	</div>
						<!-- 회원 -->
					<?php } else { ?>
					<!-- 비회원 -->
                    <div class="logout">
                        안녕하세요 고객님,<br />
                        회원이시라면 <a href="<?php echo G5_BBS_URL ?>/login.php">로그인</a>해주세요!
                        <div class="button"><a href="<?php echo G5_BBS_URL ?>/login.php">로그인</a></div>
                    </div>
					<!-- 비회원 -->
					<?php } ?>
				</div>
				<div class="member">
                	<ul>
                	    <li><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php"><img src="<?php echo G5_THEME_IMG_URL ?>/ico_ship.png" /><span>주문/배송</span></a></li>
                	    <li><a href="<?php echo G5_SHOP_URL; ?>/cart.php"><img src="<?php echo G5_THEME_IMG_URL ?>/ico_cart.png" /><span>장바구니</span></a></li>
						<li><a href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank"><span class="amount"><?php echo number_format($member['mb_point']); ?></span><span>보유 포인트</span></a></li>
						<li><a href="<?php echo G5_SHOP_URL; ?>/coupon.php" target="_blank"><span class="amount"><?php 
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
						echo ($is_member)?number_format($cp_count):0; ?></span><span>보유 쿠폰</span></a></li>
                	</ul>
				</div>
				<div class="m_notice_wrap">
					<div class="m_notice">
						<div><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=notice">공지사항</a></div>
						<div><a href="<?php echo G5_THEME_SHOP_URL;?>/user_guide.php">이용안내</a></div>
						<div><a href="<?php echo G5_THEME_SHOP_URL;?>/delivery_guide.php">배송안내</a></div>
						<div><a href="<?php echo G5_THEME_SHOP_URL;?>/delivery_area.php">배송가능지역</a></div>
					</div>
					<script>
					$(function () {
    					$(".m_notice").slick({
        					infinite: true , /* 맨끝이미지에서 끝나지 않고 다시 맨앞으로 이동 */
        					slidesToShow: 1, /* 화면에 보여질 이미지 갯수*/
        					slidesToScroll: 1,  /* 스크롤시 이동할 이미지 갯수 */
        					autoplay: true, /* 자동으로 다음이미지 보여주기 */
        					arrows: false, /* 화살표 */
        					dots:false, /* 아래점 */
        					autoplaySpeed:3000,/* 다음이미지로 넘어갈 시간 */
        					speed:1000 , /* 다음이미지로 넘겨질때 걸리는 시간 */
        					vertical: true,
        					pauseOnHover:true, /* 마우스 호버시 슬라이드 이동 멈춤 */
    					});
					});
				</script>
				</div>
				<div class="list">
					<ul class="cate">
    					<li class="cate_li_1"><a class="cate_li_1_a" href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=10">점심도시락주문</a></li>
						<li class="cate_li_1"><a class="cate_li_1_a" href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=20">반찬주문</a></li>
						<li class="cate_li_1"><a class="cate_li_1_a" href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=30">단품반찬주문</a></li>
						<li class="cate_li_1"><a class="cate_li_1_a" href="<?php echo G5_THEME_SHOP_URL;?>/user_guide.php">이용안내</a>
							<ul class="sub_cate sub_cate1">
								<li class="cate_li_2"><a href="<?php echo G5_BBS_URL;?>/content.php?co_id=company">회사소개</a></li>
								<li class="cate_li_2"><a href="<?php echo G5_THEME_SHOP_URL;?>/user_guide.php">이용안내</a></li>
								<li class="cate_li_2"><a href="<?php echo G5_THEME_SHOP_URL;?>/delivery_guide.php">배송안내</a></li>
								<li class="cate_li_2"><a href="<?php echo G5_THEME_SHOP_URL;?>/delivery_area.php">배송가능지역</a></li>
								<li class="cate_li_2"><a href="<?php echo G5_BBS_URL;?>/faq.php">자주하는질문</a></li>
							</ul>
						</li>
						<li class="cate_li_1"><a class="cate_li_1_a" href="<?php echo G5_BBS_URL;?>/board.php?bo_table=notice">공지&이벤트</a></li>
						<li class="cate_li_1"><a class="cate_li_1_a" href="<?php echo G5_BBS_URL; ?>/qalist.php">1:1문의게시판</a></li>
						<li class="cate_li_1"><a class="cate_li_1_a" href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=40">회원전용특판</a>
						<?php
							echo get_mb_category1('40', '4');
						?>
						</li>
						<li class="cate_li_1"><a class="cate_li_1_a" href="<?php echo G5_BBS_URL;?>/board.php?bo_table=review">이용후기</a></li>
						<li class="cate_li_1"><a class="cate_li_1_a" href="<?php echo G5_BBS_URL;?>/board.php?bo_table=return">용기&가방수거요청</a></li>
					</ul>
				</div>
				<div class="vote_wrap">
					<?php echo poll('theme/basic');?>
				</div>
				
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
			<i class="blind"></i>
		</div>
		<?php // include_once(G5_THEME_SHOP_PATH.'/category.php'); // 분류 ?>
		
		<script>
		$(function() {
			$(".menuOpen").on("click", function() {
				$(this).toggleClass("sel");
				$('#category').toggleClass("sel");
				$('.blind').toggleClass("sel");
			})
			$(".blind").click(function() {
				$('.blind').removeClass("sel");
				$('#category').removeClass("sel");
				$('.allmenu').removeClass("sel");
			})
		});
		</script>
    </div>
</div>

<!-- 콘텐츠 시작 { -->
<div id="container">
    <?php if (!defined("_INDEX_")) { ?><div id="wrapper_title"><div class="floatwrap"><a href="javascript:history.back()" class="mob"><i class="xi-angle-left-min"></i><span class="sound_only">뒤로</span></a><h3><?php echo $g5['title'] ?></h3></div></div><?php } ?>
      