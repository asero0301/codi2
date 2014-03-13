<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/bad_shop_list.php
 * date   : 2009.01.22
 * desc   : 불량샵 신고 리스트
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

$mainconn->open();

$key = trim($_REQUEST['key']);
$kwd = trim($_REQUEST['kwd']);
$page = trim($_REQUEST['page']);

if ( $page == "" ) $page = 1;

$cond = " where 1 and A.mem_id = B.mem_id and A.shop_idx = C.shop_idx and A.mem_id = '".$_SESSION['mem_id']."' ";

// 검색: 작성자(M),제목(T),내용(C),제목+내용(TC)
if ( $key != "" && $kwd != "" ) {
	if ( $key == "M" ) {
		$cond .= " and B.mem_name like '%$kwd%' ";
	} else if ( $key == "T" ) {
		$cond .= " and A.bad_title like '%$kwd%' ";
	} else if ( $key == "C" ) {
		$cond .= " and A.bad_content like '%$kwd%' ";
	} else {	// 제목+내용
		$cond .= " and ( A.bad_title like '%$kwd%' or A.bad_content like '%$kwd%' ) ";
	}
}

// record count
$sql = "select count(*) from tblBadShop A, tblMember B, tblShop C $cond ";
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
$orderby = " order by A.bad_reg_dt desc ";

$sql = "
select A.bad_idx, A.shop_idx, A.mem_id, A.bad_title, A.bad_view, A.bad_reg_dt, unix_timestamp(A.bad_reg_dt) as stamp,
B.mem_name, C.shop_name,(select count(*) from tblBadShopComment where bad_idx=A.bad_idx) as comment_cnt
from tblBadShop A, tblMember B, tblShop C
$cond $orderby limit $first, $PAGE_SIZE
";
//echo "row : $sql <br>";
$res = $mainconn->query($sql);

$LIST = "";
$article_num = $total_record - $PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {
	$bad_idx	= trim($row['bad_idx']);
	$shop_idx	= trim($row['shop_idx']);
	$s_shop_name	= trim($row['shop_name']);
	$s_mem_id		= trim($row['mem_id']);
	$s_mem_name	= trim($row['mem_name']);
	$bad_title	= trim($row['bad_title']);
	$bad_view	= trim($row['bad_view']);
	$bad_reg_dt	= trim($row['bad_reg_dt']);
	$stamp		= trim($row['stamp']);
	$comment_cnt= trim($row['comment_cnt']);

	if ( $comment_cnt > 0 ) {
		$comment_cnt_str = "<font color='#FF7F02'>[$comment_cnt]</font>";
	} else {
		$comment_cnt_str = "";
	}

	$bad_title = "<b class='date'><font color='#FF3366'>[$s_shop_name]</font></b> $bad_title";

	if ( (time() - $stamp) < $BAD_NEW_STAMP ) {
		$icon = "<img src='/img/icon_new.gif' width='27' height='15' align='absmiddle'>";
		$bad_title = cutStringHan($bad_title, 100);
	} else {
		$icon = "";
		$bad_title = cutStringHan($bad_title, 106);
	}

	$bad_reg_dt = str_replace("-",".",substr($bad_reg_dt,0,10));
	$LIST .= "
            
                <tr>
                  <td width='70' height='30' align='center'>$article_num</td>
                  <td align='left' style='padding:5 5 5 5'><a href='#' onClick=\"go_bad_shop_view('$bad_idx');\">$bad_title $comment_cnt_str</a>$icon</td>
                  <td width='73' align='center' >$s_mem_name</td>
                  <td width='83' align='center'>$bad_reg_dt</td>
                  <td width='72' align='center'>$bad_view</td>
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
        <td background="/img/bar03.gif"><b><font color="FFFC11">불량샵 신고 :</font></b> <font color="#FFFFFF">불량샵을 신고해 주세요. 해당샵의 책임사항이 확인되는 즉시 조치를 취하겠습니다.</font> </td>
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
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="24" align="right" valign="bottom"><a href="#" onClick="go_bad_shop_write('','');"><img src="/img/btn_write.gif" width="60" height="20" border="0" /></a></td>
                </tr>
            </table>
            <table width="100%" height="45" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center">
<?
if ( $total_record > 0 ) 
echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"/board/bad_shop_list.php",$qry_str);
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