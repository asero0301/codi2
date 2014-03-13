<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/Mcodi.php
 * date   : 2008.10.13
 * desc   : 마이페이지 코디상품 리스트
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

auth_chk($RURL);

$mainconn->open();

$mem_id = $_SESSION['mem_id'];

$key = trim($_REQUEST['key']);
$kwd = trim($_REQUEST['kwd']);
$page = trim($_REQUEST['page']);

if ( $page == "" ) $page = 1;

$cond = " where 1 and mem_id = '$mem_id' ";

if ( $key != "" ) {
	$cond .= " and $key like '%$kwd%' ";
}

// record count
$sql = "select count(*) from tblProduct $cond ";
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
$orderby = " order by p_idx desc ";

$sql = "
	select *,
	(select start_dt from tblProductEach where p_idx = tblProduct.p_idx order by p_e_idx asc limit 1) as start_dt,
	(select end_dt from tblProductEach where p_idx = tblProduct.p_idx order by p_e_idx desc limit 1) as end_dt,
	(select count(*) from tblProductUpDown where p_idx = tblProduct.p_idx and p_u_val = 1) as up,
	(select count(*) from tblProductUpDown where p_idx = tblProduct.p_idx and p_u_val = -1) as down,
	(select count(*) from tblProductComment where p_idx = tblProduct.p_idx) as comment_cnt,
	(select count(*) from tblProductVisit where p_idx = tblProduct.p_idx) as visit
	from tblProduct
	$cond $orderby limit $first, $PAGE_SIZE
	";
//echo $sql;
$res = $mainconn->query($sql);

$LIST = "";
//$article_num = $total_record - $PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {
	$t_p_idx = trim($row['p_idx']);
	$t_shop_idx = trim($row['shop_idx']);
	$t_p_title = strip_str(trim($row['p_title']));
	$t_p_gift = trim($row['p_gift']);
	$t_p_main_img = trim($row['p_main_img']);
	$t_p_auto_extend = trim($row['p_auto_extend']);
	$t_p_judgment = trim($row['p_judgment']);
	$t_up = trim($row['up']);
	$t_down = trim($row['down']);
	$t_comment_cnt = trim($row['comment_cnt']);
	$t_visit = trim($row['visit']);
	$t_start_dt = trim($row['start_dt']);
	$t_end_dt = trim($row['end_dt']);

	$tmp_main_img = $UP_URL."/thumb/".$t_p_main_img;

	if ( date("Y-m-d H:i:s", time()) > $t_start_dt && date("Y-m-d H:i:s", time()) < $t_end_dt ) {
		if ( $t_p_judgment == "R" ) {
			$status_str = "심사중";
			$btn_str = "<img src='/img/btn_delete02.gif' width='44' height='19' border='0' onClick=\"del_codi('$t_p_idx');\" style='cursor:hand;' />";	// 삭제
		} else {
			$t_start_dt = substr(str_replace("-",".",$t_start_dt),0,10);
			$t_end_dt = substr(str_replace("-",".",$t_end_dt),0,10);
			$status_str = "진행중<br>$t_start_dt<br>~<br>$t_end_dt";
			$btn_str = "<img src='/img/btn_modify.gif' width='44' height='19' border='0' onClick=\"edit_codi('$t_p_idx','R');\" style='cursor:hand;' />";	// 수정
		}
	} else {
		$t_start_dt = substr(str_replace("-",".",$t_start_dt),0,10);
		$t_end_dt = substr(str_replace("-",".",$t_end_dt),0,10);
		$status_str = "평가완료<br>$t_start_dt<br>~<br>$t_end_dt";
		$btn_str = "<img src='/img/btn_day.gif' width='44' height='19' border='0' onClick=\"extend_codi('$t_p_idx','$t_p_judgment');\" style='cursor:hand;' />";	// 연장
	}

	$LIST .= "
		<table width='645' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td width='100'>
				<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
					<tr>
						<td bgcolor='#3D3D3D'><img src='$tmp_main_img' width='95' height='95' border='0' onClick=\"codi_view('$t_p_idx');\" style='cursor:hand;' /></td>
					</tr>
				</table>
				</td>
				<td  style='padding-left:5;padding-right:8'><a href='#' onclick=\"codi_view('$t_p_idx');\">$t_p_title</a><img src='/img/btn_best.gif' width='32' height='15' align='absmiddle' /></td>
				<td width='123' align='center'>$t_p_gift </td>
				<td width='102' align='center' class='date'>$status_str</td>
				<td width='103' align='center' >
				<table width='75%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
						<td width='50' class='evgray'><a href=\"javascript:pop_codi_view('$t_p_idx');\">코디업</a></td>
						<td align='right' ><a href=\"javascript:pop_codi_view('$t_p_idx');\"><span class='evfont'> <b><font color='#CC3300'>$t_up</font></b></span></a></td>
					</tr>
					<tr>
						<td class='evgray'><a href=\"javascript:pop_codi_view('$t_p_idx');\">코디다운</a></td>
						<td align='right' ><a href=\"javascript:pop_codi_view('$t_p_idx');\"><span class='evfont'> <font color='FF5B5C'>$t_down</font></span></a></td>
					</tr>
					<tr>
						<td class='evgray'><a href=\"javascript:pop_codi_view('$t_p_idx');\">평가댓글</a></td>
						<td align='right' class='date'><a href=\"javascript:pop_codi_view('$t_p_idx');\">$t_comment_cnt</a></td>
					</tr>
					<tr>
						<td class='evgray'><a href=\"javascript:pop_codi_view('$t_p_idx');\">샵방문</a></td>
						<td align='right' class='date'><a href=\"javascript:pop_codi_view('$t_p_idx');\">$t_visit</a></td>
					</tr>
				</table>
				</td>
				<td width='80' align='center'>$btn_str</td>
			</tr>
		</table>
		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td height='1' bgcolor='E9E9E9'></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
		";
}


if ( $page == 1 ) {
	// 임시저장된 코디
	$sql = "select * from tblProductTmp where mem_id = '$mem_id'";
	$res = $mainconn->query($sql);

	$TMP_LIST = "";
	$tmp_cnt = 0;
	while ( $row = $mainconn->fetch($res) ) {
		$tmp_cnt++;
		$t_p_idx = trim($row['p_idx']);
		$t_shop_idx = trim($row['shop_idx']);
		$t_p_title = trim($row['p_title']);
		$t_p_gift = trim($row['p_gift']);
		$t_p_main_img = trim($row['p_main_img']);

		$tmp_main_img = $UP_URL."/thumb/".$t_p_main_img;
		
		$TMP_LIST .= "
			<table width='645' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td width='100'>
					<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
						<tr>
							<td bgcolor='#3D3D3D'><img src='$tmp_main_img' width='95' height='95' border='0' onClick=\"edit_codi('$t_p_idx','T');\" style='cursor:hand;' /></td>
						</tr>
					</table>
					</td>
					<td  style='padding-left:5;padding-right:8'><a href='#' onclick=\"edit_codi('$t_p_idx','T');\">$t_p_title</a><img src='/img/btn_best.gif' width='32' height='15' align='absmiddle' /></td>
					<td width='123' align='center'>$t_p_gift </td>
					<td width='102' align='center' >임시저장</td>
					<td width='103' align='center' >-</td>
					<td width='80' align='center'><img src='/img/btn_modify.gif' width='44' height='19' border='0' onClick=\"edit_codi('$t_p_idx','T');\" style='cursor:hand;' /><img src='/img/btn_delete02.gif' width='44' height='19' border='0' onClick=\"del_codi('$t_p_idx');\" style='cursor:hand;' /></td>
				</tr>
			</table>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td height='1' bgcolor='E9E9E9'></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			";
	}
}

$total_block = ceil($total_page/$PAGE_BLOCK);
$block = ceil($page/$PAGE_BLOCK);
$first_page = ($block-1)*$PAGE_BLOCK;
$last_page = $block*$PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}

$title = "<font color='#333333'>등록한 코디상품이 <b><font color='FF0078'>총 {$total_record}개</font></b> 있습니다. 임시등록된 코디상품이 <b><font color='FF0078'>총 {$tmp_cnt}개</font></b> 있습니다. </font>";

$mainconn->close();

?>

<? include "../include/_head.php"; ?>

<script type="text/JavaScript">
<!--
function goCodi() {
	var f = document.frm;
	f.target = "_self";
	f.action = "product_in01.php";
	f.submit();
}

function edit_codi(idx,t) {
	var f = document.frm;
	f.mode.value = "E";
	f.p_idx.value = idx;
	f.tbl.value = t;
	f.target = "_self";
	f.action = "/mypage/product_edit.php";
	f.submit();
}

function extend_codi(idx,judgment) {
	var f = document.frm;

	var pop=window.open("","pop_extend_target","top=300,left=500,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=300,height=130");

	f.p_idx.value = idx;
	f.p_judgment.value = judgment;
	f.mode.value = "E";
	f.tbl.value = "R";
	f.action = "/mypage/pop_extend.php";
	f.target = "pop_extend_target";
	f.submit();
	pop.focus();
}

function del_codi() {
	alert('공사중');
}
//-->
</script>



<table border="0" cellspacing="0" cellpadding="0">

<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="" />
<input type="hidden" id="tbl" name="tbl" value="" />
<input type="hidden" id="p_idx" name="p_idx" value="" />
<input type="hidden" id="p_judgment" name="p_judgment" value="" />

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
       
            </td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">코디상품관리 :</font></b> <font color="#FFFFFF">등록한 코디상품을 관리할 수 있습니다.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
        <tr>
          <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                    <tr>
                      <td style="padding:10 10 10 10" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <?=$title?></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
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
                      <td align="center"><img src="/img/title13.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="120" align="center"><img src="/img/title14.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="100" align="center"><img src="/img/title27.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="100" align="center"><img src="/img/title28.gif" width="70" height="20" /></td>
                      <td width="80" align="center">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height="1" bgcolor="FF5B5C"></td>
              </tr>
            </table>
              <table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td></td>
                </tr>
              </table>

			  <?
				  echo $TMP_LIST;
				  echo $LIST;
			  ?>

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="6" bgcolor="FF5B5C"></td>
                </tr>
              </table>
			  
			<table width="100" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
                
                <tr>
                  <td align="right"><img src="/img/btn_add02.gif" border="0" onClick="goCodi();" style="cursor:hand;" /></td>
                </tr>
              </table>

            <table width="100" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table>
            <table width="100%" height="45" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center">
					<? 
					echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$_SERVER['PHP_SELF'],$qry_str);
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
            
            <input name="key" id="key" type="radio" value="p_title" />
            제목
            <input name="key" id="key" type="radio" value="kwds" />
            키워드</td>
          <td align="right" bgcolor="F6F5F5" style="padding-right:5">
            <input type="text" name="kwd" id="kwd" class="logbox"  style="width:300" />
          <img src="/img/btn_search.gif" align="absmiddle" border="0" onClick="" style="cursor:hand;" /></td>
        </tr>
        <tr>
          <td height="1" colspan="2" bgcolor="DADADA"></td>
        </tr>
      </table></td>
  </tr>

</form>

</table>


<? include "../include/_foot.php"; ?>