<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 댓글 첨부파일 저장 시작
include_once($board_skin_path.'/skin.lib.php');

if ($member['mb_level'] >= $cmt_file_level) {

    $upload_max_filesize = ini_get('upload_max_filesize');

    $file_upload_msg = '';
    $upload = array();

    // 삭제에 체크가 되어있다면 파일을 삭제합니다.
    if (isset($_POST['bf_file_del']) && $_POST['bf_file_del']) {
        $upload['del_check'] = true;

        $row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' and bf_no = 0 ");
        @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/'.$row['bf_file']);
        // 썸네일삭제
        if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
            delete_board_thumbnail($bo_table, $row['bf_file']);
        }
    }
    else
        $upload['del_check'] = false;

    $tmp_file  = $_FILES['bf_file']['tmp_name'];
    $filesize  = $_FILES['bf_file']['size'];
    $filename  = $_FILES['bf_file']['name'];
    $filename  = get_safe_filename($filename);

    // 서버에 설정된 값보다 큰파일을 업로드 한다면
    if ($filename) {
        if ($_FILES['bf_file']['error'] == 1) {
            alert("\'{$filename}\' 파일의 용량이 서버에 설정($upload_max_filesize)된 값보다 크므로 업로드 할 수 없습니다.\\n");
        }
        else if ($_FILES['bf_file']['error'] != 0) {
            alert("\'{$filename}\' 파일이 정상적으로 업로드 되지 않았습니다.\\n");
        }
    }

    if (is_uploaded_file($tmp_file)) {
        // 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
        if (!$is_admin && $filesize > $board['bo_upload_size']) {
            alert("\'{$filename}\' 파일의 용량(".number_format($filesize)." 바이트)이 게시판에 설정(".number_format($board['bo_upload_size'])." 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n");
        }

        // 이미지 파일만 사용을 선택했다면
        if ($cmt_image_use == 1) {
            if(!preg_match("/\.({$config['cf_image_extension']})$/i", $filename)) {
                alert("이미지 파일만 업로드 할수 있습니다.\\n (허용파일 : ".$config['cf_image_extension'].")");
            }
        }

        //=================================================================\
        // 090714
        // 이미지나 플래시 파일에 악성코드를 심어 업로드 하는 경우를 방지
        // 에러메세지는 출력하지 않는다.
        //-----------------------------------------------------------------
        $timg = @getimagesize($tmp_file);
        // image type
        if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
             preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
            if ($timg['2'] < 1 || $timg['2'] > 16) {
                alert("정상적인 파일이 아닙니다.");
            }
        }
        //=================================================================

        $upload['image'] = $timg;

        // 4.00.11 - 글답변에서 파일 업로드시 원글의 파일이 삭제되는 오류를 수정
        if ($w == 'cu') {
            // 존재하는 파일이 있다면 삭제합니다.
            $row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$comment_id' and bf_no = 0 ");
            @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/'.$row['bf_file']);
            // 이미지파일이면 썸네일삭제
            if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
                delete_board_thumbnail($bo_table, $row['bf_file']);
            }
        }

        // 프로그램 원래 파일명
        $upload['source'] = $filename;
        $upload['filesize'] = $filesize;

        // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
        $filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

        shuffle($chars_array);
        $shuffle = implode('', $chars_array);

        // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
        $upload['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

        $dest_file = G5_DATA_PATH.'/file/'.$bo_table.'/'.$upload['file'];

        // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
        $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file']['error']);

        // 올라간 파일의 퍼미션을 변경합니다.
        chmod($dest_file, G5_FILE_PERMISSION);
    }

    // 나중에 테이블에 저장하는 이유는 $wr_id 값을 저장해야 하기 때문입니다.

    if (!get_magic_quotes_gpc()) {
        $upload['source'] = addslashes($upload['source']);
    }

    $row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' and bf_no = 0 ");
    if ($row['cnt'])
    {
        // 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
        // 그렇지 않다면 내용만 업데이트 합니다.
        if ($upload['del_check'] || $upload['file'])
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_source = '{$upload['source']}',
                             bf_file = '{$upload['file']}',
                             bf_content = '{$bf_content}',
                             bf_filesize = '{$upload['filesize']}',
                             bf_width = '{$upload['image']['0']}',
                             bf_height = '{$upload['image']['1']}',
                             bf_type = '{$upload['image']['2']}',
                             bf_datetime = '".G5_TIME_YMDHIS."'
                      where bo_table = '{$bo_table}'
                                and wr_id = '{$comment_id}'
                                and bf_no = 0 ";
            sql_query($sql);
        } 
        else 
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_content = '{$bf_content}'
                        where bo_table = '{$bo_table}'
                                  and wr_id = '{$comment_id}'
                                  and bf_no = 0 ";
            sql_query($sql);
        }
    } 
    else 
    {
        $sql = " insert into {$g5['board_file_table']}
                    set bo_table = '{$bo_table}',
                         wr_id = '{$comment_id}',
                         bf_no = 0,
                         bf_source = '{$upload['source']}',
                         bf_file = '{$upload['file']}',
                         bf_content = '{$bf_content}',
                         bf_download = 0,
                         bf_filesize = '{$upload['filesize']}',
                         bf_width = '{$upload['image']['0']}',
                         bf_height = '{$upload['image']['1']}',
                         bf_type = '{$upload['image']['2']}',
                         bf_datetime = '".G5_TIME_YMDHIS."' ";
        sql_query($sql);
    }

    // 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
    // 파일 정보가 없다면 테이블의 내용을 삭제합니다.
    $row = sql_fetch(" select max(bf_no) as max_bf_no from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' ");
    for ($i=(int)$row['max_bf_no']; $i>=0; $i--)
    {
        $row2 = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' and bf_no = 0 ");

        // 정보가 있다면 빠집니다.
        if ($row2['bf_file']) break;

        // 그렇지 않다면 정보를 삭제합니다.
        sql_query(" delete from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' and bf_no = 0 ");
    }

    // 파일의 개수를 게시물에 업데이트 한다.
    $row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$comment_id}' ");
    sql_query(" update {$write_table} set wr_file = '{$row['cnt']}' where wr_id = '{$comment_id}' ");

}
// 댓글 첨부파일 저장 끝
?>