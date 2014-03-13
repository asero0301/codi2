<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/notice_list.php
 * date   : 2009.01.22
 * desc   : 공지사항 리스트
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

$mainconn->open();

$key = trim($_REQUEST['key']);
$kwd = trim($_REQUEST['kwd']);
$page = trim($_REQUEST['page']);

if ( $page == "" ) $page = 1;

$cond = " where 1 and A.mem_id = B.mem_id ";

// 검색: 작성자(M),제목(T),내용(C),제목+내용(TC)
if ( $key != "" && $kwd != "" ) {
	if ( $key == "M" ) {
		$cond .= " and B.mem_name like '%$kwd%' ";
	} else if ( $key == "T" ) {
		$cond .= " and A.notice_title like '%$kwd%' ";
	} else if ( $key == "C" ) {
		$cond .= " and A.notice_content like '%$kwd%' ";
	} else {	// 제목+내용
		$cond .= " and ( A.notice_title like '%$kwd%' or A.notice_content like '%$kwd%' ) ";
	}
}

// record count
$sql = "select count(*) from tblNotice A, tblMember B $cond ";
//echo "cnt : $sql <br>";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $PAGE_SIZE*($page-1);
	$last = $PAGE_SIZE*$page;
}

$qry_str = "&key=$key&kwd=$kwd";
$orderby = " order by A.notice_reg_dt desc ";

$sql = "
select A.notice_idx, A.mem_id, A.notice_title, A.notice_view, A.notice_reg_dt, unix_timestamp(A.notice_reg_dt) as stamp,
B.mem_name
from tblNotice A, tblMember B
$cond $orderby limit $first, $PAGE_SIZE
";
//echo "row : $sql <br>";
$res = $mainconn->query($sql);

$LIST = "";
$article_num = $total_record - $PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {
	$notice_idx		= trim($row['notice_idx']);
	//$s_shop_name		= trim($row['shop_name']);
	$s_mem_id			= trim($row['mem_id']);
	$s_mem_name		= trim($row['mem_name']);
	$notice_title	= trim($row['notice_title']);
	$notice_view	= trim($row['notice_view']);
	$notice_reg_dt	= trim($row['notice_reg_dt']);
	$stamp			= trim($row['stamp']);

	if ( (time() - $stamp) < $NOTICE_NEW_STAMP ) {
		$icon = "<img src='/img/icon_new.gif' width='27' height='15' align='absmiddle'>";
		$notice_title = cutStringHan(strip_str($notice_title), 48);
	} else {
		$icon = "";
		$notice_title = cutStringHan(strip_str($notice_title), 54);
	}

	$notice_reg_dt = str_replace("-",".",substr($notice_reg_dt,0,10));
	$LIST .= "
            
                <tr>
                  <td width='70' height='30' align='center'>$article_num</td>
                  <td align='left' style='padding:5 5 5 5'><a href='#' onClick=\"go_notice_view('$notice_idx');\">$notice_title</a>$icon</td>
                  <td width='73' align='center' >$s_mem_name</td>
                  <td width='83' align='center'>$notice_reg_dt</td>
                  <td width='72' align='center'>$notice_view</td>
                </tr>
            
				 <tr>
                  <td height='1' colspan='5' align='center' bgcolor='#E9E9E9'></td>
                </tr>
           
	";
	$article_num--;
}

$total_block = ceil($total_page/$PAGE_BLOCK);
$block = ceil($page/$PAGE_BLOCK);
$first_page = ($block-1)*$PAGE_BLOCK;
$last_page = $block*$PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}

$mainconn->close();
?>

<? require_once "../include/_head.php"; ?>


<table border="0" cellspacing="0" cellpadding="0">
<form id="board_frm" name="board_frm" method="post">
  <tr>
    <td width="200" valign="top">
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			  <!-- 게시판 메뉴 시작 //-->
			
			<? include "../include/left_board.php" ?>
			
			 <!-- 게시판 메뉴 끝 //-->
			</td>
          </tr>
        </table>
       
            </td>
    <td width="15"></td>
    <td valign="top">
	
	<table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">공지사항 :</font></b> <font color="#FFFFFF">코디탑텐 공지사항입니다.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>

      <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="645" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="6" bgcolor="FF5B5C"></td>
              </tr>
              <tr>
                <td height="27"><table width="645" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="70" align="center"><img src="/img/title36.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td align="center"><img src="/img/title38.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="70" align="center"><img src="/img/title39.gif" width="70" height="20" /></td>
                      <td width="3" align="center"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="80" align="center"><img src="/img/title06.gif" width="70" height="20" /></td>
                      <td width="3" align="center"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="70" align="center"><img src="/img/title40.gif" width="70" height="20" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height="1" bgcolor="FF5B5C"></td>
              </tr>
            </table>
              <table width="645" border="0" cellspacing="0" cellpadding="0">

<?=$LIST?>

                <tr>
                  <td height="6" colspan="5" align="center" bgcolor="FF5B5C"></td>
                </tr>
            </table>

            <table width="100%" height="45" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center">
<?
if ( $total_record > 0 ) 
echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"/board/notice_list.php",$qry_str);
?>
				  </td>
                </tr>
            </table></td>
        </tr>
      </table>
      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="1" colspan="2" bgcolor="DADADA"></td>
        </tr>
        <tr>
          <td height="30" bgcolor="F6F5F5" style="padding-top:3">&nbsp;
            <input name="key" type="radio" value="M" <?if ($key=="M") echo " checked";?> /> 작성자
            <input name="key" type="radio" value="T" <?if ($key=="T") echo " checked";?> /> 제목
            <input name="key" type="radio" value="C" <?if ($key=="C") echo " checked";?> /> 내용
            <input name="key" type="radio" value="TC" <?if ($key=="TC" || $key=="") echo " checked";?> /> 제목+내용           
			</td>
          <td align="right" bgcolor="F6F5F5" style="padding-right:5">
            <input type="text" name="kwd" class="logbox"  style="width:300" value="<?=$kwd?>" />
          <a href="#" onClick="go_board_search();"><img src="/img/btn_search.gif" align="absmiddle" border="0" /></a></td>
        </tr>
        <tr>
          <td height="1" colspan="2" bgcolor="DADADA"></td>
        </tr>
      </table></td>
  </tr>
</form>
</table>


<? include "../include/_foot.php"; ?>