<?php
include_once('./_common.php');

if ($is_guest)
    alert('회원이시라면 로그인 후 이용해 보십시오.', '../../../bbs/login.php?url=' . urlencode(G5_THEME_SHOP_URL . '/roulette_ev.php'));


define("_INDEX_", TRUE);

include_once(G5_THEME_SHOP_PATH . '/shop.head.php');

?>

<!-- 룰렛 이벤트 -->
<div class="floatwrap">
    <div id="roulette">
        <img id="title_bn">
        <div id="count"></div>
        <div class="roulette">
            <img class="rlt_ring" src="<?php echo G5_THEME_IMG_URL ?>/roulette_ring.png">
            <img class="rlt_board" src="<?php echo G5_THEME_IMG_URL ?>/roulette_board.png">
            <button class="rlt_btn"></button>
        </div>
        <div id="description">
            <div>이벤트 안내</div>
            <li>▨ 회원 누구나 하루에 한번 참여 가능합니다.</li>
            <li>▨ 당첨 여부와 포인트 적립은 즉시 확인하실 수 있습니다.</li>
            <li>▨ 부정한 방법으로 획득한 마일리지는 취소될 수 있습니다.</li>
        </div>
    </div>
</div>

<script>
    var mb_id = "<?php echo $member['mb_id'] ?>";
    var btn_status = false;
    var roulette_data;
    var roulette_error = new Array(
    "에러 리스트",
    "회원만 이용가능한 서비스입니다.",
    "이벤트 기간이 아닙니다. \n00월 00일 ~ 00월 00일",
    "남은 응모기회가 없습니다.",
    "포인트 적립 실패. 응모횟수는 차감되지 않습니다."
    );

    $('#roulette .rlt_btn').click(function(){
            roll_roulette(mb_id);
            $(this).attr('disabled','disabled');
    })
    
    $(window).load(function(){
        update_chance(mb_id).then(function(result){
            $('#count').text(result);
        });
    })

    function update_chance($mb_id) {
        return new Promise(function(resolve,reject){
            $.ajax({
            type: 'post',
            url: './roulette.php',
            data: {
                'mb_id': $mb_id,
                'state': 1
            },
            datatype: 'json',
            success: function (data) {
                roulette_data = JSON.parse(data);
                if (data.error) {
                    alert(error[data.error]);
                }
                else {
                    //$(window).reload;
                    // $('#roulette #count').text(data.mb_1);
                    resolve(roulette_data.mb_1);
                }
            },
            error: function (request, status, error) { console.log(request, status, error); }
            });
        })
    }

    function roll_roulette($mb_id){
    $.ajax({
            type: 'post',
            url: './roulette.php',
            data: {
                'mb_id': $mb_id,
                'state': 2
            },
            datatype: 'json',
            success: function (data) {
                roulette_data = JSON.parse(data);
                if (roulette_data.error) { alert(roulette_error[roulette_data.error]); }
                else {
                    $('#roulette #count').text(roulette_data.mb_1 - 1);
                    $('#roulette .roulette .rlt_board').css({
                        'transition': '7s cubic-bezier(0,0,0,1)',
                        'transform': 'rotate(' + (1800 + roulette_data.rotate) + 'deg)'
                    });
                    $('#roulette .roulette .rlt_board').one('transitionend webkitTransitionEnd oTransitionEnd otransitionend', function () {
                        if(roulette_data.mileage == 0){
                            alert('꽝입니다. 다시 도전해보세요!');
                        } else{
                            alert(roulette_data.mileage + ' 포인트 당첨을 축하드립니다!');
                        }
                        location.reload();
                    });
                }
            },
            error: function (request, status, error) { console.log(request, status, error); }
    });
    $('#roulette .roulette .rlt_board').css({ 'transition': '', 'transform': '' });
    }
</script>
<?php
include_once(G5_THEME_SHOP_PATH . '/shop.tail.php');
?>