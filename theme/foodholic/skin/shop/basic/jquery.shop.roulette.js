
var roulette_data;
var roulette_error = new Array(
    "에러 리스트",
    "회원만 이용가능한 서비스입니다.",
    "이벤트 기간이 아닙니다. \n00월 00일 ~ 00월 00일",
    "남은 응모기회가 없습니다.",
    "포인트 적립 실패. 응모횟수는 차감되지 않습니다."
);
function update_chance($mb_id) {
    $.ajax({
        type: 'post',
        url: '../shop/roulette.php',
        data: {
            'mb_id': $mb_id,
            'state': 1
        },
        datatype: 'json',
        success: function (data) {
            roulette_data = JSON.parse(data);
            if (roulette_data.error) {
                alert(roulette_error[roulette_data.error]);
            }
            else {
                $('#roulette #count').text(roulette_data.mb_1);
            }
        },
        error: function (request, status, error) { console.log(request, status, error); }
    });
}
function roll_roulette($mb_id){
    $.ajax({
            type: 'post',
            url: '../shop/roulette.php',
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

// php chr() 대응
if (typeof chr == "undefined") {
    function chr(code) {
        return String.fromCharCode(code);
    }
}