<?php
include_once('./_common.php');

$g5['title'] = '마이페이지';

include_once(G5_THEME_SHOP_PATH . '/shop.head.php');

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

<!-- 마이페이지 시작 { -->
<div id="smb_my">
    <div class="floatwrap">
        <section id="smb_my_ov">
            <h2>회원정보 개요</h2>
            <div class="smb_my_ov_wr">
                <div class="my_name">
                    <p>안녕하세요.</p>
                    <strong><?php // echo get_member_profile_img($member['mb_id']); 
                            ?><?php echo $member['mb_id'] ? $member['mb_name'] : '비회원'; ?></strong>님
                </div>
                <br>
                <a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php" class="smb_info">정보수정</a>
                <a href="<?php echo G5_BBS_URL; ?>/logout.php">로그아웃</a>
            </div>
            <ul id="my_cou_wr">
                <li><a href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank" class="win_point"><img src="<?php echo G5_THEME_IMG_URL ?>/money-box-64.png">
                        <p>포인트</p><strong><?php echo number_format($member['mb_point']); ?></strong>
                    </a></li>
                <li><a href="<?php echo G5_SHOP_URL; ?>/coupon.php" target="_blank" class="win_coupon"><img src="<?php echo G5_THEME_IMG_URL ?>/ticket-64.png">
                        <p>쿠폰</p><strong><?php echo number_format($cp_count); ?></strong>
                    </a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" id="ol_after_memo" class="win_memo"><img src="<?php echo G5_THEME_IMG_URL ?>/envelope-64.png">
                        <p>쪽지</p> <?php echo $memo_not_read ?>
                    </a></li>
            </ul>
            <div>
                <dl class="my_info">
                    <dt>연락처</dt>
                    <dd><?php echo ($member['mb_tel'] ? $member['mb_tel'] : '미등록'); ?></dd>
                    <dt>E-Mail</dt>
                    <dd><?php echo ($member['mb_email'] ? $member['mb_email'] : '미등록'); ?></dd>
                    <dt class="add">주소</dt>
                    <dd class="add"><?php echo sprintf("(%s%s)", $member['mb_zip1'], $member['mb_zip2']) . ' ' . print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']); ?></dd>
                </dl>
                <a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();" class="withdrawal"><i class="fa fa-user-times"></i>회원탈퇴</a>
            </div>
        </section>

        <!-- } 회원정보 개요 끝 -->
        <div id="smb_my_list">
            <?php if(false){?>
            <img src="<?php echo G5_THEME_IMG_URL ?>/process.jpg">
            <?php } ?>
            <!-- 최근 주문내역 시작 { -->
            <div class="smb_my_od">
                <div class="tit">
                    <img src="<?php echo G5_THEME_IMG_URL ?>/shopping-bag-64.png">
                    <h2>주문내역</h2>
                </div>

                <?php
                // 최근 주문내역
                define("_ORDERINQUIRY_", true);

                $limit = " limit 0, 5 ";
                include G5_SHOP_PATH . '/orderinquiry.sub.php';
                ?>

                <div class="smb_my_more">
                    <a href="./orderinquiry.php">더보기</a>
                </div>
            </div>
            <!-- } 최근 주문내역 끝 -->

            <!-- 장바구니 시작 { -->
            <div class="smb_my_od">
                <div class="tit">
                    <img src="<?php echo G5_THEME_IMG_URL ?>/shopping-cart-64.png">
                    <h2>장바구니</h2>
                </div>
                <div id="smb_my_cart">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">상품명</th>
                                <th scope="col">수량</th>
                                <th scope="col">판매가</th>
                                <th scope="col">적립포인트</th>
                                <th scope="col">배송비</th>
                                <th scope="col">소계</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            cart_item_clean();
                            $s_cart_id = get_session('ss_cart_id');
                            $sql = " update {$g5['g5_shop_cart_table']} set ct_select = '0' where od_id = '$s_cart_id' ";
                            sql_query($sql);

                            $sql = " select *
                                from {$g5['g5_shop_cart_table']} a,
                                {$g5['g5_shop_item_table']} b
                                where a.mb_id = '{$member['mb_id']}'
                                and a.it_id  = b.it_id";
                            $sql .= " group by a.it_id
                                order by a.ct_id desc
                                limit 0, 10 ";
                            $result = sql_query($sql);
                            for ($i = 0; $row = sql_fetch_array($result); $i++) {

                                $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                                    SUM(ct_point * ct_qty) as point,
                                    SUM(ct_qty) as qty
                                    from {$g5['g5_shop_cart_table']}
                                    where it_id = '{$row['it_id']}'
                                    and od_id = '$s_cart_id' ";
                                $sum = sql_fetch($sql);

                                // 배송비
                                switch ($row['ct_send_cost']) {
                                    case 1:
                                        $ct_send_cost = '착불';
                                        break;
                                    case 2:
                                        $ct_send_cost = '무료';
                                        break;
                                    default:
                                        $ct_send_cost = '선불';
                                        break;
                                }

                                // 조건부무료
                                if ($row['it_sc_type'] == 2) {
                                    $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

                                    if ($sendcost == 0)
                                        $ct_send_cost = '무료';
                                }

                                $point      = $sum['point'];
                                $sell_price = $sum['price'];
                            ?>
                                <tr>
                                    <td><?php echo substr(date("Y"), 0, 2) . '년 ' . stripslashes($row['it_name']); ?></td>
                                    <td><?php echo number_format($sum['qty']); ?></td>
                                    <td><?php echo number_format($row['ct_price']); ?></td>
                                    <td><?php echo number_format($point); ?></td>
                                    <td><?php echo $ct_send_cost; ?></td>
                                    <td><?php echo number_format($sum['price']); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                    <?php
                    if ($i == 0)
                        echo '<p class="empty_li">보관 내역이 없습니다.</p>';
                    ?>
                <div class="smb_my_more">
                    <a href="./cart.php">더보기</a>
                </div>
            </div>
            <!-- } 장바구니 끝 -->
        </div>
    </div>
</div>

<script>
    $(function() {
        $(".win_coupon").click(function() {
            var new_win = window.open($(this).attr("href"), "win_coupon", "left=100,top=100,width=700, height=600, scrollbars=1");
            new_win.focus();
            return false;
        });
    });

    function member_leave() {
        return confirm('정말 회원에서 탈퇴 하시겠습니까?')
    }
</script>
<!-- } 마이페이지 끝 -->

<?php
include_once(G5_THEME_SHOP_PATH . '/shop.tail.php');
?>