
<div id="hd_menu">
	<h2>바로가기 메뉴</h2>
    <ul>
        <li class="hd_menu_right"><a href="<?php echo G5_BBS_URL; ?>/faq.php"><i class="fa fa-question"></i>FAQ</a></li>
        <li class="hd_menu_right"><a href="<?php echo G5_BBS_URL; ?>/qalist.php"><i class="fa fa-comments-o"></i>1:1문의</a></li>
        <li class="hd_menu_right"><a href="<?php echo G5_SHOP_URL; ?>/personalpay.php"><i class="fa fa-credit-card"></i>개인결제</a></li>
        <li class="hd_menu_right"><a href="<?php echo G5_SHOP_URL; ?>/itemuselist.php"><i class="fa fa-camera"></i>사용후기</a></li>
        <li class="hd_menu_right"><a href="<?php echo G5_SHOP_URL; ?>/couponzone.php"><i class="fa fa-newspaper-o"></i>쿠폰존</a></li>
    </ul>
</div>

<div class="as_cs">
    <h2>고객센터</h2>
    <?php
    $save_file = G5_DATA_PATH.'/cache/theme/fashion/footerinfo.php';
    if(is_file($save_file))
        include($save_file);
    ?>
    <strong class="cs_tel"><?php echo get_text($footerinfo['tel']); ?></strong>
    <p class="cs_info"><?php echo get_text($footerinfo['etc'], 1); ?></p>   
</div>