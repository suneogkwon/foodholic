<?php
include_once('./_common.php');
include_once(G5_SHOP_PATH . '/settle_naverpay.inc.php');
add_javascript('<script src="' . G5_THEME_JS_URL . '/fixto.min.js"></script>', 10);
add_javascript('<script src="'.G5_JS_URL.'/shop.js"></script>', 10);
add_javascript('<script src="'.G5_JS_URL.'/shop.override.js"></script>', 10);

// 보관기간이 지난 상품 삭제
cart_item_clean();

// cart id 설정
set_cart_id($sw_direct);

$s_cart_id = get_session('ss_cart_id');
// 선택필드 초기화
$sql = " update {$g5['g5_shop_cart_table']} set ct_select = '0' where od_id = '$s_cart_id' ";
sql_query($sql);

$cart_action_url = G5_SHOP_URL . '/cartupdate.php';

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH . '/cart.php');
    return;
}

$g5['title'] = '장바구니';
include_once('./_head.php');
?>
    <div id="content">
        <div class="grid-container">
            <div id="sod_bsk">
                <form name="frmcartlist" id="sod_bsk_list" class="2017_renewal_itemform position-relative" method="post" action="<?php echo $cart_action_url; ?>">
                    <div id="cart_table_wrapper">
                        <table class="unstriped">
                            <thead class="bordered">
                            <tr>
                                <th class="show-for-small-only width-100 padding-horizontal-1 padding-vertical-2 position-relative" scope="col">
                                    <span class="float-left select_all" style="width:100px;">전체 선택</span>
                                    <div class="switch tiny margin-0 float-left">
                                        <input class="switch-input" type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked">
                                        <label for="ct_all" class="switch-paddle"><span class="show-for-sr">상품 전체</span></label>
                                    </div>
                                    <div class="btn_cart_del float-right">
                                        <button type="button" class="button padding-1 margin-0" onclick="return form_check('seldelete');">선택삭제</button>
                                        <button type="button" class="button padding-1 margin-0" onclick="return form_check('alldelete');">비우기</button>
                                    </div>
                                </th>
                                <th class="show-for-medium text-center" scope="col">
                                    <div class="switch tiny margin-0">
                                        <input class="switch-input" type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked">
                                        <label for="ct_all" class="switch-paddle"><span class="show-for-sr">상품 전체</span></label>
                                    </div>
                                </th>
                                <th class="hide-for-small-only text-center" scope="col">상품명</th>
                                <th class="hide-for-small-only text-center" scope="col" style="min-width:100px;">수량</th>
                                <th class="hide-for-small-only text-center" scope="col">판매가</th>
                                <th class="hide-for-small-only text-center" scope="col">적립포인트</th>
                                <th class="hide-for-small-only text-center" scope="col">배송비</th>
                                <th class="hide-for-small-only text-center" scope="col">소계</th>
                            </tr>
                            </thead>
                            <tbody class="border-none">
                            <?php
                            $tot_point = 0;
                            $tot_sell_price = 0;
                            $tot_qty = 0;
                            
                            // $s_cart_id 로 현재 장바구니 자료 쿼리
                            $sql = " select a.ct_id,
                        a.it_id,
                        a.od_id,
                        a.it_name,
                        a.ct_price,
                        a.ct_point,
                        a.ct_qty,
                        a.ct_status,
                        a.ct_send_cost,
                        a.it_sc_type,
                        a.ct_binding,
                        b.ca_id,
                        b.ca_id2,
                        b.ca_id3,
                        b.it_explan
                   from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
                  where a.od_id = '$s_cart_id' ";
                            $sql .= " group by a.it_id ";
                            $sql .= " order by a.ct_id ";
                            $result = sql_query($sql);
                            
                            $it_send_cost = 0;
                            
                            $minimum_day = explode(',', $default['de_1']);
                            $day_point = explode(',', $default['de_2']);
                            
                            for ($i = 0; $row = sql_fetch_array($result); $i++) {
                                // 합계금액 계산
                                $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                                                SUM(ct_point * ct_qty) as point,
                                                SUM(ct_qty) as qty
                                        from {$g5['g5_shop_cart_table']}
                                        where it_id = '{$row['it_id']}'
                                        and od_id = '$s_cart_id' ";
                                $sum = sql_fetch($sql);

                                if ($row['ca_id'] == 10 && $row['ct_binding'] == 1) {
                                    $sql = " update {$g5['g5_shop_cart_table']} set ct_point = ct_point - '{$day_point[0]}', ct_binding = 0
                                        where od_id = '$s_cart_id'
                                        and it_id  = {$row['it_id']}";
                                    sql_fetch($sql);
                                    $sum['point'] -= $day_point[0];
                                }

                                if ($row['ca_id'] == 20 && $row['ct_binding'] == 1) {
                                    $sql = " update {$g5['g5_shop_cart_table']} set ct_point = ct_point - '{$day_point[1]}', ct_binding = 0
                                        where od_id = '$s_cart_id'
                                        and it_id  = {$row['it_id']}";
                                    sql_fetch($sql);
                                    $sum['point'] -= $day_point[1];
                                }

                                if ($i == 0) { // 계속쇼핑
                                    $continue_ca_id = $row['ca_id'];
                                }

                                $a1 = '<a href="./item.php?it_id=' . $row['it_id'] . '" class="prd_name"><b>';
                                $a2 = '</b></a>';

                                //$image = get_it_image($row['it_id'], 200, 200);
//                                if (mb_substr($row['it_id'], 6, 2) == 10) {
//                                    $image = get_it_image(1, 200, 200);
//                                } else if (mb_substr($row['it_id'], 6, 2) == 20) {
//                                    $image = get_it_image2(1, 200, 200);
//                                } else {
//                                    $image = get_it_image($row['it_id'], 200, 200);
//                                }
                                $image = '<img src="http://localhost/data/item/1/1608548703_88_default_box.jpg">';

                                // $it_name = $a1 . stripslashes($row['it_name']) . $a2;
                                $it_options = print_item_options($row['it_id'], $s_cart_id);
                                if ($it_options) {
                                    $mod_options = '<div class="margin-top-2 sod_option_btn"><button type="button" class="button hollow padding-1 margin-0 mod_options">메뉴추가</button></div>';
                                    // $it_name .= '<div class="sod_opt">' . $it_options . '</div>';
                                    $it_name = '<div class="margin-top-2 padding-top-2 sod_opt">' . $it_options . '</div>';
                                }

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

                                $point = $sum['point'];
                                $sell_price = $sum['price'];
                                ?>

                                <tr class="margin-bottom-2 bordered">
                                    <td class="td_chk" data-th="상품 선택">
                                        <p class="cart_table_h padding-left-1 show-for-small-only">상품 선택</p>
                                        <div class="cart_table_c padding-1 text-left">
                                            <div class="switch tiny margin-0">
                                                <input class="switch-input" type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked">
                                                <label for="ct_chk_<?php echo $i; ?>" class="switch-paddle"><span class="show-for-sr">상품</span></label>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="td_prd" data-th="상품명">
                                        <p class="cart_table_h padding-left-1 show-for-small-only">상품명</p>
                                        <div class="cart_table_c padding-1 text-left" style="text-align: left !important;">
                                            <?php if ($row['ca_id'] == 10 || $row['ca_id'] == 20) { ?>
                                                <div class="margin-bottom-2">
                                                    <div class="sod_prd_img display-inline-block margin-right-2" style="width:100px;"><?php echo $image; ?></div>
                                                    <div class="sod_explan display-inline-block" style="vertical-align: top; width: calc(100% - 120px);">
                                                        <?php echo stripslashes($row['it_explan']) ?>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="display-inline-block margin-right-2">
                                                    <a href="./item.php?it_id=<?php echo $row['it_id']; ?>"><?php echo $image; ?></a>
                                                </div>
                                            <?php } ?>
                                            <div class="position-relative">
                                                <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
                                                <input type="hidden" name="it_name[<?php echo $i; ?>]" value="<?php echo get_text($row['it_name']); ?>">
                                                <?php echo '<span class="h5 font-bold color-primary prd_name">' . stripslashes($row['it_name']) ." ". calcDay($row['it_id']). '</span>';
                                                echo $it_name. $mod_options; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="td_num" data-th="수량">
                                        <p class="cart_table_h padding-left-1 show-for-small-only">수량</p>
                                        <div class="cart_table_c padding-1 text-left">
                                            <button type="button" onclick="cart_qty_down(<?php echo '1,'.$row['it_id'].','.$row['od_id']?>)" class="show-for-small-only padding-1" style="cursor: pointer"><i class="xi-minus"></i></button>
                                            <span class="cart_qty padding-horizontal-3"><?php echo number_format($row['ct_qty']); ?></span>
                                            <button type="button" onclick="cart_qty_up(<?php echo '1,'.$row['it_id'].','.$row['od_id']?>)" class="show-for-small-only padding-1" style="cursor: pointer"><i class="xi-plus"></i></button>
                                            <div class="margin-top-1">
                                                <button type="button" onclick="cart_qty_down(<?php echo '1,'.$row['it_id'].','.$row['od_id']?>)" class="show-for-medium padding-1" style="cursor: pointer"><i class="xi-minus"></i></button>
                                                <button type="button" onclick="cart_qty_up(<?php echo '1,'.$row['it_id'].','.$row['od_id']?>)" class="show-for-medium padding-1" style="cursor: pointer"><i class="xi-plus"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="td_numbig text_right" data-th="판매가">
                                        <p class="cart_table_h padding-left-1 show-for-small-only">판매가</p>
                                        <div class="cart_table_c padding-1 text-left">
                                            <span class="">
                                                <?php echo number_format($row['ct_price']); ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="td_numbig text_right" data-th="포인트">
                                        <p class="cart_table_h padding-left-1 show-for-small-only">포인트</p>
                                        <div class="cart_table_c padding-1 text-left">
                                            <?php echo number_format($point); ?>
                                        </div>
                                    </td>
                                    <td class="td_dvr" data-th="배송비">
                                        <p class="cart_table_h padding-left-1 show-for-small-only">배송비</p>
                                        <div class="cart_table_c padding-1 text-left">
                                            <?php echo $ct_send_cost; ?>
                                        </div>
                                    </td>
                                    <td class="td_numbig text_right" data-th="소계">
                                        <p class="cart_table_h padding-left-1 show-for-small-only">소계</p>
                                        <div class="cart_table_c padding-1 text-left">
                                            <span id="sell_price_<?php echo $i; ?>" class="h6 font-bold color-warning"><?php echo number_format($sell_price); ?></span>
                                        </div>
                                    </td>

                                </tr>
                                
                                <?php
                                $tot_point += $point;
                                $tot_sell_price += $sell_price;
                                $tot_qty += $row['ct_qty'];
                            } // for 끝
                            
                            if ($i == 0) {
                                echo '<tr><td colspan="8" class="empty_table">장바구니에 담긴 상품이 없습니다.</td></tr>';
                            } else {
                                // 배송비 계산
                                $send_cost = get_sendcost($s_cart_id, 0);
                            }
                            ?>
                            </tbody>
                        </table>
                        <div class="btn_cart_del show-for-medium padding-vertical-2">
                            <button type="button" class="button" onclick="return form_check('seldelete');">선택삭제</button>
                            <button type="button" class="button" onclick="return form_check('alldelete');">비우기</button>
                        </div>
                    </div>

                    <input type="hidden" name="url" value="./orderform.php">
                    <input type="hidden" name="records" value="<?php echo $i; ?>">
                    <input type="hidden" name="act" value="">

                    <div class="sod_tot_wr">
                        <?php
                        $tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비
                        if ($tot_price > 0 || $send_cost > 0) {
                            ?>
                            <div id="sod_bsk_tot" class="show-for-medium">
                                <ul class="grid-x no-bullet">
                                    <li class="cell small-4 padding-3 color-white sod_bsk_dvr">
                                        <span class="h6">배송비</span>
                                        <strong class="h6 float-right margin-0"><?php echo number_format($send_cost); ?> 원</strong>
                                    </li>

                                    <li class="cell small-4 padding-3 color-white sod_bsk_pt">
                                        <span class="h6">포인트</span>
                                        <strong class="h6 float-right margin-0"><?php echo number_format($tot_point); ?> 점</strong>
                                    </li>

                                    <li class="cell small-4 padding-3 color-white sod_bsk_cnt">
                                        <span class="h6">총계 가격</span>
                                        <strong class="h6 float-right margin-0"><?php echo number_format($tot_price); ?> 원</strong>
                                    </li>

                                </ul>
                            </div>
                        <?php } ?>

                        <div id="sod_bsk_act" class="show-for-medium padding-vertical-2 text-center">
                            <button type="button" onclick="return form_check('buy');" class="button large _btn_submit" style="width: 300px;">주문하기</button>
                            <?php if (false && $naverpay_button_js) { ?>
                                <div class="cart-naverpay"><?php echo $naverpay_request_js . $naverpay_button_js; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div id="fake_cart_div" class="show-for-small-only" style="height:55px"></div>
                    <div id="m_sod_bsk_act" class="show-for-small-only width-100 position-fixed-bottom padding-horizontal-2 margin-bottom-1">
                        <button type="button" onclick="return form_check('buy');" class="_btn_submit button large expanded margin-0" style="letter-spacing: 1px;border-radius: 10rem">
                            <span class="h6">총 <?php echo $tot_qty."개 <b>".$tot_price."</b>원 주문하기"?></span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>
    <script>
        $(function () {
            var close_btn_idx;

            // 선택사항수정
            $(".mod_options").click(function () {
                var it_id = $(this).closest("tr").find("input[name^=it_id]").val();
                var $this = $(this);
                close_btn_idx = $(".mod_options").index($(this));

                $.post(
                    "<?php echo G5_THEME_SHOP_URL?>/cartoption.php", {
                        it_id: it_id
                    },
                    function (data) {
                        $("#mod_option_frm").remove();
                        $this.after("<div id=\"mod_option_frm\"></div><div class=\"mod_option_bg\"></div>");
                        $("#mod_option_frm").html(data);
                        price_calculate();
                    }
                );
            });

            // 모두선택
            $("input[name=ct_all]").click(function () {
                if ($(this).is(":checked"))
                    $("input[name^=ct_chk], input[name=ct_all]").attr("checked", true);
                else
                    $("input[name^=ct_chk], input[name=ct_all]").attr("checked", false);
            });

            // 옵션수정 닫기
            $(document).on("click", "#mod_option_close", function () {
                $("#mod_option_frm").remove();
                $(".mod_option_bg").remove();
                $(".mod_options").eq(close_btn_idx).focus();
            });
            $("#win_mask").click(function () {
                $("#mod_option_frm").remove();
                $(".mod_option_bg").remove();
                $(".mod_options").eq(close_btn_idx).focus();
            });

            // 모바일 장바구니 플로팅 버튼
            let scrollHeight = $(window).scrollTop() + $(window).height();
            let ftHeight = $(document).height() - $('#ft').height() - 50;
            
            if(scrollHeight > ftHeight) {
                $('#m_sod_bsk_act').removeClass('position-fixed-bottom');
                $('#fake_cart_div').addClass('hide');
            } else {
                $('#m_sod_bsk_act').addClass('position-fixed-bottom');
                $('#fake_cart_div').removeClass('hide');
            }
            $(window).scroll( function() {
                scrollHeight = $(window).scrollTop() + $(window).height();
                ftHeight = $(document).height() - $('#ft').height() - 50;
                
                if(scrollHeight > ftHeight) {
                    $('#m_sod_bsk_act').removeClass('position-fixed-bottom');
                    $('#fake_cart_div').addClass('hide');
                } else {
                    $('#m_sod_bsk_act').addClass('position-fixed-bottom');
                    $('#fake_cart_div').removeClass('hide');
                }
            });

            $('.sod_option_btn').css('left',($('.prd_name').width() + 20));
        });

        function fsubmit_check(f) {
            if ($("input[name^=ct_chk]:checked").length < 1) {
                alert("구매하실 상품을 하나이상 선택해 주십시오.");
                return false;
            }

            return true;
        }

        function form_check(act) {
            var f = document.frmcartlist;
            var cnt = f.records.value;

            if (act == "buy") {
                if ($("input[name^=ct_chk]:checked").length < 1) {
                    alert("주문하실 상품을 하나이상 선택해 주십시오.");
                    return false;
                }

                f.act.value = act;
                f.submit();
            } else if (act == "alldelete") {
                f.act.value = act;
                f.submit();
            } else if (act == "seldelete") {
                if ($("input[name^=ct_chk]:checked").length < 1) {
                    alert("삭제하실 상품을 하나이상 선택해 주십시오.");
                    return false;
                }

                f.act.value = act;
                f.submit();
            }

            return true;
        }
    </script>
    <!-- } 장바구니 끝 -->

<?php
include_once('./_tail.php');
?>