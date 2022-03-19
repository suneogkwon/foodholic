<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

for ($i=$chk_count-1; $i>=0; $i--)
{
    $write = sql_fetch(" select * from $write_table where wr_id = '$tmp_array[$i]' ");

    // 본문글 삭제시 댓글에 첨부된 파일도 삭제
    $sql = " select wr_id from $write_table where wr_parent = '{$write['wr_id']}' and wr_is_comment = 1 ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result))
    {
        $sql2 = " select * from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '{$row['wr_id']}' ";
        $result2 = sql_query($sql2);
        while ($row2 = sql_fetch_array($result2)) {
            @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/'.$row2['bf_file']);
            // 썸네일삭제
            if(preg_match("/\.({$config['cf_image_extension']})$/i", $row2['bf_file'])) {
                delete_board_thumbnail($bo_table, $row2['bf_file']);
            }
        }

        // 파일테이블 행 삭제
        sql_query(" delete from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '{$row['wr_id']}' ");
    }
}
?>