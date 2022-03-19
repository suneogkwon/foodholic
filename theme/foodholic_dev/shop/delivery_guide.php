<?php
include_once('./_common.php');
define("_INDEX_", TRUE);
add_javascript('<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>', 10);
include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
?>

<a class="zip_a" href=""></a>
<div>


<script>
    var zipcode;
    var address;
    
    var town = {'1동', '2동'}

    new daum.Postcode({
        oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분입니다.
                // 예제를 참고하여 다양한 활용법을 확인해 보세요.
        if(data.city == "인천"){
            // 인천이면 이코드실행

            if(town.dsaddwa(data.town)){
                // 목록안에 포함
            } else {
                // 목록안에 비포함
            }
        } else {
            // 인천이 아니면 이코드 실행
        }
            $('.zip_a').html(data.zonecode);
        }
    }).open();

</script>

</>
<?php
include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
?>