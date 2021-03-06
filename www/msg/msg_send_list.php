<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/msg/msg_send_list.php
 * date   : 2008.10.26
 * desc   : 메시지 송신함
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

auth_chk($RURL);

$page = $_REQUEST['page'];
if ( $page == "" ) $page = 1;

$mainconn->open();

$mem_id = $_SESSION['mem_id'];
$cond = " and send_mem_id = '$mem_id' and msg_send_status = 'Y' and msg_send_forever = 'T' and (unix_timestamp(now()) - unix_timestamp(msg_send_dt) < $MSG_USAGE_DAY * 86400) ";

$sql = "select count(*) from tblMsg where 1 $cond ";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $PAGE_SIZE*($page-1);
	$last = $PAGE_SIZE*$page;
}

$orderby = " order by msg_idx desc ";

$sql = "select *,(select mem_name from tblMember where mem_id=tblMsg.recv_mem_id) as recv_mem_name from tblMsg where 1 $cond $orderby limit $first, $PAGE_SIZE ";
//echo $sql;
$res = $mainconn->query($sql);
$LIST = "";
while ( $row = $mainconn->fetch($res) ) {
	$msg_idx		= trim($row['msg_idx']);
	$send_mem_id	= trim($row['send_mem_id']);
	$recv_mem_name	= trim($row['recv_mem_name']);
	$recv_mem_id	= trim($row['recv_mem_id']);
	$msg_comment	= trim($row['msg_comment']);
	$msg_send_dt	= trim($row['msg_send_dt']);
	$msg_recv_dt	= trim($row['msg_recv_dt']);
	$msg_recv_ok	= trim($row['msg_recv_ok']);

	$prt_recv_time = substr($msg_recv_dt,0,10)." (".substr($msg_recv_dt,11,5).")";
	$prt_recv_info = $recv_mem_id."(".$recv_mem_name.")";

	$msg_comment	= strip_str($msg_comment);
	$msg_comment	= cutStringHan($msg_comment,55);

	
	if ( $msg_recv_ok == "N" ) {
		$prt_recv_time = "<font color='DD2457'>확인전</font>";
	}

	$LIST .= "
	<tr>
		<td width='35' height='30' align='center'><input type='checkbox' name='itemchk' name='itemchk' value='$msg_idx' /></td>
		<td width='120' align='center'  ><a href='#' onclick=\"pop_msg_read($msg_idx);\">$prt_recv_info</a></td>
		<td style='padding-left:8'><a href='#' onclick=\"pop_msg_read($msg_idx);\">$msg_comment</a> </td>
		<td width='123' align='center' class='date'>$prt_recv_time</td>
	</tr>
	<tr>
		<td height='1' colspan='4' bgcolor='E9E9E9'></td>
	</tr>
	";

}

$total_block = ceil($total_page/$PAGE_BLOCK);
$block = ceil($page/$PAGE_BLOCK);
$first_page = ($block-1)*$PAGE_BLOCK;
$last_page = $block*$PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}

?>

<? include "../include/_head.php"; ?>

<table border="0" cellspacing="0" cellpadding="0">
<form id="frm" name="frm" method="post">
<input type="hidden" id="msg_idx" name="msg_idx" value="" />
<input type="hidden" id="msg_type" name="msg_type" value="S" />
<input type="hidden" id="mode" name="mode" value="" />
<input type="hidden" id="tgt" name="tgt" value="self" />

  <tr>
    <td width="200" valign="top"><!-- 주간 코디 top10 //-->
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- 마이페이지 시작 //-->
			
			<? include "../include/left_my.php" ?>
			
			 <!-- 마이페이지 시작 //-->
			</td>
          </tr>
        </table>
    <!-- 좌측 가이드 5개 롤링 끝 //--> </td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">[쪽지함] 보낸 쪽지함 :</font></b> <font color="#FFFFFF">전체 <?=$total_record?>개의 보낸 쪽지가 있습니다.</font> </td>
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
          <td width="62"><a href="#" onClick="checkAll();"><img src="/img/btn_all.gif" width="60" height="20" border="0" /></a></td>
          <td width="62"><a href="#" onClick="msg_all_del();"><img src="/img/btn_delete.gif" width="60" height="20" border="0" /></a></td>
          <td><a href="#" onClick="msg_all_forever();"><img src="/img/btn_save03.gif" width="60" height="20" border="0" /></a></td>
        </tr>
      </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
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
                      <td width="35" align="center">&nbsp;</td>
                      <td width="120" align="center"><img src="/img/title19.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td align="center"><img src="/img/title20.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="120" align="center"><img src="/img/title22.gif" width="70" height="20" /></td>
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
                  <td height="6" colspan="4" align="center" bgcolor="FF5B5C"></td>
                </tr>
              </table>
           
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
                <td height="1" bgcolor="DADADA"></td>
              </tr>
              <tr>
                <td height="25" bgcolor="F6F5F5" style="padding-top:3"  class="intext">&nbsp;※ 보관하지 않은 쪽지는 <?=$MSG_USAGE_DAY?>일 후에 삭제됩니다. 중요한 쪽지는 쪽지보관함에 보관해주세요.</td>
              </tr>
              <tr>
                <td height="1" bgcolor="DADADA"></td>
              </tr>
            </table>
            <table width="100" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
            </table>
            <table width="645" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="62"><a href="#" onClick="checkAll();"><img src="/img/btn_all.gif" width="60" height="20" border="0" /></a></td>
                <td width="62"><a href="#" onClick="msg_all_del();"><img src="/img/btn_delete.gif" width="60" height="20" border="0" /></a></td>
                <td><a href="#" onClick="msg_all_forever();"><img src="/img/btn_save03.gif" width="60" height="20" border="0" /></a></td>
              </tr>
            </table>
            <table width="100%" height="45" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center">
				  
				  <?php
					echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$_SERVER['PHP_SELF'],$qry_str); ?>
				  
				  </td>
                </tr>
            </table>
            </td>
        </tr>
      </table></td>
  </tr>

</form>
</table>
<? include "../include/_foot.php"; ?>