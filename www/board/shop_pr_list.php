<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/shop_pr_list.php
 * date   : 2009.01.21
 * desc   : �� PR ����Ʈ
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

$mainconn->open();

$key = trim($_REQUEST['key']);
$kwd = trim($_REQUEST['kwd']);
$page = trim($_REQUEST['page']);
$shop_idx = trim($_REQUEST['shop_idx']);

if ( $page == "" ) $page = 1;

$cond = " where 1 and A.mem_id = B.mem_id and A.shop_idx = C.shop_idx ";

// �˻�: �ۼ���(M),����(T),����(C),����+����(TC)
if ( $key != "" && $kwd != "" ) {
	if ( $key == "M" ) {
		$cond .= " and B.mem_name like '%$kwd%' ";
	} else if ( $key == "T" ) {
		$cond .= " and A.pr_title like '%$kwd%' ";
	} else if ( $key == "C" ) {
		$cond .= " and A.pr_content like '%$kwd%' ";
	} else {	// ����+����
		$cond .= " and ( A.pr_title like '%$kwd%' or A.pr_content like '%$kwd%' ) ";
	}
}

// record count
$sql = "select count(*) from tblPr A, tblMember B, tblShop C $cond ";
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
$orderby = " order by A.pr_reg_dt desc ";

$sql = "
select A.pr_idx, A.shop_idx, A.mem_id, A.pr_title, A.pr_view, A.pr_reg_dt, unix_timestamp(A.pr_reg_dt) as stamp,
B.mem_name, C.shop_name, C.shop_url,
ifnull((select rs_total_rank from tblRankShop where shop_idx=A.shop_idx order by rs_idx desc limit 1),0) as rs_total_rank,
(select count(*) from tblPrComment where pr_idx=A.pr_idx) as comment_cnt
from tblPr A, tblMember B, tblShop C
$cond $orderby limit $first, $PAGE_SIZE
";
//echo "row : $sql <br>";
$res = $mainconn->query($sql);

$LIST = "";
$article_num = $total_record - $PAGE_SIZE*($page-1);
$cnt = 0;
while ( $row = $mainconn->fetch($res) ) {
	$cnt++;

	$pr_idx		= trim($row['pr_idx']);
	$shop_idx	= trim($row['shop_idx']);
	$s_shop_name	= trim($row['shop_name']);
	$shop_url	= trim($row['shop_url']);
	$s_mem_id	= trim($row['mem_id']);
	$s_mem_name	= trim($row['mem_name']);
	$pr_title	= trim($row['pr_title']);
	$pr_view	= trim($row['pr_view']);
	$pr_reg_dt	= trim($row['pr_reg_dt']);
	$stamp		= trim($row['stamp']);
	$rs_total_rank	= trim($row['rs_total_rank']);
	$comment_cnt= trim($row['comment_cnt']);

	if ( $comment_cnt > 0 ) {
		$comment_cnt_str = "<font color='#FF7F02'>[$comment_cnt]</font>";
	} else {
		$comment_cnt_str = "";
	}

	$prt_shop_name = "<b class='date'><font color='#FF3366'>[$s_shop_name]</font></b>";

	if ( (time() - $stamp) < $PR_NEW_STAMP ) {
		$icon = "<img src='/img/icon_new.gif' width='27' height='15' align='absmiddle'>";
		$pr_title = cutStringHan($pr_title, 94);
	} else {
		$icon = "";
		$pr_title = cutStringHan($pr_title, 100);
	}

	$param_show = $param_hide = "";
	for ( $j=1; $j<=$PAGE_SIZE; $j++ ) {
		$sh = ( $cnt == $j ) ? "show" : "hide";
		$param_show .= "'shopview_list_$j','','$sh',";
		$param_hide .= "'shopview_list_$j','','hide',";
	}
	$param_show = substr($param_show, 0, strlen($param_show)-1);
	$param_hide = substr($param_hide, 0, strlen($param_hide)-1);	

	//$pr_title	= cutStringHan(strip_str($pr_title),100);
	$pr_reg_dt = str_replace("-",".",substr($pr_reg_dt,0,10));
	$LIST .= "
            
                <tr>
                  <td width='70' height='30' align='center'>$article_num</td>
                  <td align='left' style='padding:5 5 5 5'><a href='#' onClick=\"go_shop_pr_view('$pr_idx');\">$pr_title $comment_cnt_str</a>$icon</td>
                  <td width='73' align='center' >
					<a onClick=\"MM_showHideLayers($param_show);\" style='cursor:hand;'>$prt_shop_name</a>
	";

	// �� ���� ���̾�
	$LIST .= getLayerShopInfo("shopview_list", $cnt, 2, 1, 20, -85, $rs_total_rank, $shop_url, $s_shop_name, $s_mem_id, $param_hide);

	$LIST .= "
				  </td>
                  <td width='83' align='center'>$pr_reg_dt</td>
                  <td width='72' align='center'>$pr_view</td>
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


if ( $cnt < $PAGE_SIZE ) {
	for ( $i=$cnt+1; $i<=$PAGE_SIZE; $i++ ) {
		$LIST .= "<div id='shopview_list_{$i}'  style='position:relative; z-index:2; left:445px; top: -122px;visibility: hidden;'></div>";
	}
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
		 <!-- �Խ��� �޴� ���� //-->
			
			<? include "../include/left_board.php" ?>
			
			 <!-- �Խ��� �޴� �� //-->
			</td>
          </tr>
        </table>
       
             </td>
    <td width="15"></td>
    <td valign="top">
	<table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">��PR �Խ��� :</font></b> <font color="#FFFFFF">�ڽ��� ���θ��� ȫ���� �� �ֽ��ϴ�.</font> </td>
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
                      <td width="70" align="center"><img src="/img/title44.gif" width="70" height="20" /></td>
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
                  <td height="24" align="right" valign="bottom"><a href="#" onClick="go_shop_pr_write('','');"><img src="/img/btn_write.gif" width="60" height="20" border="0" /></a></td>
                </tr>
            </table>
            <table width="100%" height="45" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center">
<?
if ( $total_record > 0 ) 
echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"/board/shop_pr_list.php",$qry_str);
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
            <input name="key" type="radio" value="M" <?if ($key=="M") echo " checked";?> /> �ۼ���
            <input name="key" type="radio" value="T" <?if ($key=="T") echo " checked";?> /> ����
            <input name="key" type="radio" value="C" <?if ($key=="C") echo " checked";?> /> ����
            <input name="key" type="radio" value="TC" <?if ($key=="TC" || $key=="") echo " checked";?> /> ����+����          
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