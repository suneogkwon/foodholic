<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 댓글에 첨부된 파일 삭제
$row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' ");
@unlink(G5_DATA_PATH.'/file/'.$bo_table.'/'.$row['bf_file']);

// 썸네일삭제
if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
    delete_board_thumbnail($bo_table, $row['bf_file']);
}

// 파일테이블 행 삭제
sql_query(" delete from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '{$comment_id}' ");
?>