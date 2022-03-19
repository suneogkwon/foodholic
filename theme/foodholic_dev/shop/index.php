<?php
include_once('./_common.php');

define("_INDEX_", TRUE);

include_once(G5_THEME_SHOP_PATH . '/shop.head.php');
?>

<?php echo display_banner('메인', 'mainbanner.10.skin.php'); ?>

<div id="m_notice_latest">
    <?php // echo latest('theme/notice', 'notice', 6, 23); ?>
</div>

<div id="main_review_banner">
    <div class="grid-container">
        <div class="padding-1" style="height: 15rem; background: url(<?php echo G5_THEME_IMG_URL?>/review_banner_bg.jpg) no-repeat center/cover;">
            <div class="padding-3 color-white height-100" style="border: 3px solid white;">
                <span class="h2 font-bold" style="letter-spacing: 5px">REVIEW</span><span class="h5">후기게시판</span>
                <h6>구매하신 상품의 후기를 남겨주시면 포인트, 사은품 등 푸짐한 선물을 드립니다!</h6>
                <a class="button white margin-top-1" href="<?php echo G5_BBS_URL ?>/board.php?bo_table=review"><span class="h6 font-bold font-family-body">후기 바로가기</span></a>
            </div>
        </div>
    </div>
</div>

<div id="direct_bn">
	<div class="grid-container margin-top-3">
        <div class="show-for-small-only grid-x small-up-1">
            <div class="cell" style="border-bottom:1px solid white;background:url(<?php echo G5_THEME_IMG_URL?>/mid_1.jpg) no-repeat center/cover;">
                <a href="#">
                    <div class="inner padding-3 height-100">
                        <h4 class="font-bold">도시락 & 반찬 주문</h4>
                        <hr class="width-25 margin-left-0 margin-vertical-1">
                        <span class="h6 font-family-body display-block">깨끗한 호텔주방에서 주방장이 직접 만든 프리미엄 도시락과 반찬을 무료로 받아보세요. <br>방문수령시 할인은 덤!</span>
                    </div>
                </a>
            </div>
            <div class="cell" style="border-bottom:1px solid white;background:url(<?php echo G5_THEME_IMG_URL?>/mid_2.jpg) no-repeat center/cover;">
                <a href="#">
                    <div class="inner padding-3 height-100">
                        <h4 class="font-bold">기간한정 예약주문</h4>
                        <hr class="width-25 margin-left-0 margin-vertical-1">
                        <span class="h6 font-family-body display-block">명절, 연말, 집들이,생일파티, 특별한 날을 위해 푸드홀릭이 준비했습니다. <br>다양한 반찬 구성!</span>
                    </div>
                </a>
            </div>
            <div class="cell" style="background:url(<?php echo G5_THEME_IMG_URL?>/mid_3.jpg) no-repeat center/cover;">
                <a href="#">
                    <div class="inner padding-3 height-100">
                        <h4 class="font-bold">회원 특가판매</h4>
                        <hr class="width-25 margin-left-0 margin-vertical-1">
                        <span class="h6 font-family-body display-block">회원분들께만 판매되는 특별한 상품! 명절선물 & 생필품 & 농축산물도 푸드홀릭에서 최저가로 구매하세요!</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="show-for-medium grid-x grid-margin-x medium-up-3">
            <div class="cell" style="background:url(<?php echo G5_THEME_IMG_URL?>/mid_1.jpg) no-repeat center/cover;">
                <a href="#">
                    <div class="inner padding-3 height-100">
                        <h4 class="font-bold">도시락 & 반찬 주문</h4>
                        <hr class="width-25 margin-left-0 margin-vertical-2">
                        <span class="h6 font-family-body display-block width-75">깨끗한 호텔주방에서 주방장이 직접 만든 프리미엄 도시락과 반찬을 무료로 받아보세요. <br>방문수령시 할인은 덤!</span>
                    </div>
                </a>
            </div>
            <div class="cell" style="background:url(<?php echo G5_THEME_IMG_URL?>/mid_2.jpg) no-repeat center/cover;">
                <a href="#">
                    <div class="inner padding-3 height-100">
                        <h4 class="font-bold">기간한정 예약주문</h4>
                        <hr class="width-25 margin-left-0 margin-vertical-2">
                        <span class="h6 font-family-body display-block width-75">명절, 연말, 집들이,생일파티, 특별한 날을 위해 푸드홀릭이 준비했습니다. <br>다양한 반찬 구성!</span>
                    </div>
                </a>
            </div>
            <div class="cell" style="background:url(<?php echo G5_THEME_IMG_URL?>/mid_3.jpg) no-repeat center/cover;">
                <a href="#">
                    <div class="inner padding-3 height-100">
                        <h4 class="font-bold">회원 특가판매</h4>
                        <hr class="width-25 margin-left-0 margin-vertical-2">
                        <span class="h6 font-family-body display-block width-75">회원분들께만 판매되는 특별한 상품! 명절선물 & 생필품 & 농축산물도 푸드홀릭에서 최저가로 구매하세요!</span>
                    </div>
                </a>
            </div>
        </div>
	</div>
</div>

<!-- survey view start { -->
	<?php echo display_banner('설문', 'mainbanner.40.skin.php'); ?>
<!-- } survey view end -->

<!-- review start { -->
<?php // echo latest('theme/review', 'review', 10, 23); ?>
<!-- review end { -->

<!-- side_dish start { -->
<div id="product">
	<div class="floatwrap">
		<div class="title">
			<h3><a href="<?php echo G5_SHOP_URL ?>/list.php?ca_id=30">반찬 단품</a></h3>
		</div>
		<div class="list">
			<?php
			$list = new item_list();
			$list->set_category('30', 1);
			$list->set_list_mod(5);
            $list->set_list_row(2);
            $list->set_img_size(800, 800);
            $list->set_list_skin(G5_SHOP_SKIN_PATH. '/main.10.skin.php');
            // $list->set_order_by ('it_order desc, it_hit desc');
            $list->set_view('it_img', true);
            $list->set_view('it_id', false);
            $list->set_view('it_name', true);
            $list->set_view('it_basic', true);
            // $list->set_view('it_cust_price', true);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', false);
            $list->set_view('sns', false);
            $list->set_view('star', false);
            echo $list->run();
			?>
		</div>
	</div>
</div>
<!-- side_dish end { -->

<!-- faq start { -->
<?php echo display_faq(); ?>
<!-- faq end { -->

<!-- CS info start { -->
<div id="CSinfo">
	<div class="floatwrap">
		<div class="list center">
			<div class="tit">Customer Center</div>
			<div class="ka_img">
				<a href="" target='_blank'><img src="<?php echo G5_THEME_IMG_URL ?>/kakao.png"></a>
				<a href="" target='_blank'><img src="<?php echo G5_THEME_IMG_URL ?>/kakao_ch.png"></a>
			</div>
			<div class="txt">
				<div class="tel">1566-3615<br><?php echo $default['de_admin_company_tel']; ?></div>
				<div class="openclose"><strong>상담시간</strong>00:00AM - 00.00PM</div>
				<div class="email"><strong>푸드홀릭 문의</strong><?php echo $default['de_admin_info_email']; ?></div>
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
<!-- CS info end { -->


<?php
include_once(G5_THEME_SHOP_PATH . '/shop.tail.php');
?>