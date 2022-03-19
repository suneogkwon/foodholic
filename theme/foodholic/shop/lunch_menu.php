<?php
include_once('./_common.php');

define("_INDEX_", TRUE);

include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
?>

<div class="content" style="text-align:center;">
	<div class="floatwrap">
	<?php 
//---- 오늘 날짜
$thisyear = date('Y'); // 4자리 연도
$thismonth = date('m'); // 0을 포함하지 않는 월

//------ $year, $month 값이 없으면 현재 날짜
$year = isset($_GET['year']) ? $_GET['year'] : $thisyear;
$month = isset($_GET['month']) ? $_GET['month'] : $thismonth;

$prev_month = $month - 1;
$next_month = $month + 1;
$prev_year = $next_year = $year;
if ($month == 1) {
    $prev_month = 12;
    $prev_year = $year - 1;
} else if ($month == 12) {
    $next_month = 1;
    $next_year = $year + 1;
}
$preyear = $year - 1;
$nextyear = $year + 1;

?>
<table class="table">
  <tr>
    <td class="day_changer">
        <a class="day_changer_button" href=<?php echo 'lunch_menu.php?'.'year='.$prev_year.'&month='.str_pad($prev_month,2,'0',STR_PAD_LEFT); ?>>◀</a>
        <?php echo "&nbsp;&nbsp;" . $year . '년 ' . $month . '월 ' . "&nbsp;&nbsp;"; ?>
        <a class="day_changer_button" href=<?php echo 'lunch_menu.php?'.'year='.$next_year.'&month='.str_pad($next_month,2,'0',STR_PAD_LEFT); ?>>▶</a>
    </td>
  </tr>
  <tr>
  <td>
  <img src="<?php echo G5_THEME_IMG_URL.'/'.$year.$month.'10.jpg'?>" style="max-width:100%; height:auto;" alt="<?php echo $year . '년 ' . $month . '월'?>">

  </td>
  </tr>
</table>
	</div>
</div>
    
<?php
include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
?>