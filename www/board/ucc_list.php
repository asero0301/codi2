<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/ucc_list.php
 * date   : 2009.01.16
 * desc   : 코디 ucc 리스트 (전체 카테고리)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

$mainconn->open();

$key = trim($_REQUEST['key']);
$kwd = trim($_REQUEST['kwd']);
$page = trim($_REQUEST['page']);
$ucc_categ = trim($_REQUEST['ucc_categ']);

if ( $page == "" ) $page = 1;

$cond = " where 1 and A.mem_id = B.mem_id ";

if ( $ucc_categ != "" ) {
	$cond .= " and A.ucc_categ = '$ucc_categ' ";
}

if ( $ucc_categ == "A" ) {
	$A_bg = "#FFDADA"; $B_bg = $C_bg = $_bg = "#FFFFFF";
	$A_h = "<b><font color='CC0000'>"; $A_f = "</font></b>";
	$B_h = $B_f = $C_h = $C_f = $_h = $_f = "";
} else if ( $ucc_categ == "B" ) {
	$B_bg = "#FFDADA"; $A_bg = $C_bg = $_bg = "#FFFFFF";
	$B_h = "<b><font color='CC0000'>"; $B_f = "</font></b>";
	$A_h = $A_f = $C_h = $C_f = $_h = $_f = "";
}  else if ( $ucc_categ == "C" ) {
	$C_bg = "#FFDADA"; $A_bg = $B_bg = $_bg = "#FFFFFF";
	$C_h = "<b><font color='CC0000'>"; $C_f = "</font></b>";
	$A_h = $A_f = $B_h = $B_f = $_h = $_f = "";
} else {
	$_bg = "#FFDADA"; $B_bg = $C_bg = $A_bg = "#FFFFFF";
	$_h = "<b><font color='CC0000'>"; $_f = "</font></b>";
	$B_h = $B_f = $C_h = $C_f = $A_h = $A_f = "";
}

// 검색: 작성자(M),제목(T),내용(C),제목+내용(TC)
if ( $key != "" && $kwd != "" ) {
	if ( $key == "M" ) {
		$cond .= " and B.mem_name like '%$kwd%' ";
	} else if ( $key == "T" ) {
		$cond .= " and A.ucc_title like '%$kwd%' ";
	} else if ( $key == "C" ) {
		$cond .= " and A.ucc_content like '%$kwd%' ";
	} else {	// 제목+내용
		$cond .= " and ( A.ucc_title like '%$kwd%' or A.ucc_content like '%$kwd%' ) ";
	}
}

// record count
$sql = "select count(*) from tblUcc A, tblMember B $cond ";
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
$orderby = " order by A.ucc_reg_dt desc ";

$sql = "
select A.ucc_idx, A.ucc_categ, A.mem_id, A.ucc_title, A.ucc_view, A.ucc_reg_dt, unix_timestamp(A.ucc_reg_dt) as stamp, 
B.mem_name,
(select ifnull(sum(ucc_s_score),0) from tblUccScore where ucc_idx=A.ucc_idx) as score,
(select count(*) from tblUccComment where ucc_idx=A.ucc_idx) as comment_cnt
from tblUcc A, tblMember B
$cond $orderby limit $first, $PAGE_SIZE
";
//echo "row : $sql <br>";
$res = $mainconn->query($sql);

$LIST = "";
$article_num = $total_record - $PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {
	$ucc_idx	= trim($row['ucc_idx']);
	$ucc_categ	= trim($row['ucc_categ']);
	$s_mem_id		= trim($row['mem_id']);
	$s_mem_name	= trim($row['mem_name']);
	$ucc_title	= trim($row['ucc_title']);
	$ucc_view	= trim($row['ucc_view']);
	$ucc_reg_dt	= trim($row['ucc_reg_dt']);
	$stamp		= trim($row['stamp']);
	$score		= trim($row['score']);
	$comment_cnt= trim($row['comment_cnt']);

	if ( $comment_cnt > 0 ) {
		$comment_cnt_str = "<font color='#FF7F02'>[$comment_cnt]</font>";
	} else {
		$comment_cnt_str = "";
	}

	if ( (time() - $stamp) < $UCC_NEW_STAMP ) {
		$icon = "<img src='/img/icon_new.gif' width='27' height='15' align='absmiddle'>";
		$ucc_title = cutStringHan(strip_str($ucc_title), 94);
	} else {
		$icon = "";
		$ucc_title = cutStringHan(strip_str($ucc_title), 100);
	}

	//$ucc_title	= cutStringHan(strip_str($ucc_title),100);
	$ucc_reg_dt = str_replace("-",".",substr($ucc_reg_dt,0,10));
	$LIST .= "
            <table width='645' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td width='70' align='center'>$article_num</td>
                  <td width='72' align='center'><font color='FF0078'>".$UCC_CATEG[$ucc_categ][0]."</font></td>
                  <td align='left' style='padding:5 5 5 5'><a href='#' onClick=\"go_ucc_view('$ucc_idx');\">$ucc_title $comment_cnt_str</a>$icon</td>
                  <td width='73' align='center' >$s_mem_name</td>
                  <td width='83' align='center'>$ucc_reg_dt</td>
                  <td width='73' align='center'>$ucc_view</td>
                  <td width='72' align='center'  class='evfont'><font color='#009933'>$score</font></td>
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
	$article_num--;
}

if ( $LIST == "" ) {
	$LIST = "<table width='645' border='0' cellspacing='0' cellpadding='0'><tr><td align='center'>결과가 없습니다</td></tr></table>";
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
        <td background="/img/bar03.gif"><b><font color="FFFC11">코디UCC :</font></b> <font color="#FFFFFF">코디가 어울릴까? 코디평가! 코디가 고민되면 코디의뢰! 좋은 코디 정보를 나누는 코디제안!!</font> </td>
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
                      <td style="padding:10 10 10 10" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">코디 UCC 게시판의 글 등록은 <font color="FF0078">일반회원만 가능</font>합니다. (샵회원은 댓글만 가능). </font>
					 <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>
					  <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> 도배, 음란, 직접적인 홍보/광고, 기타 게시판 운영기준에 어긋나는 게시물은 별다른 통보없이 삭제 또는 수정될 수 있습니다. </td>
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
      <table width="645" border="0" cellpadding="0" cellspacing="1" bgcolor="FF5B5C">
        <tr>
          <td width="152" align="center" bgcolor="<?=$_bg?>" style="padding:7 5 5 5"><a href="#" onClick="go_ucc('');"><?=$_h?> 전체보기 <?=$_f?></a></td>
          <td align="center" bgcolor="<?=$A_bg?>" style="padding:7 5 5 5" class="guide"><a href="#" onClick="go_ucc('A');"><?=$A_h?> <?=$UCC_CATEG['A'][1]?> <?=$A_f?></a></td>
          <td align="center" bgcolor="<?=$B_bg?>" style="padding:7 5 5 5" class="guide"><a href="#" onClick="go_ucc('B');"><?=$B_h?> <?=$UCC_CATEG['B'][1]?> <?=$B_f?></a></td>
          <td align="center" bgcolor="<?=$C_bg?>" style="padding:7 5 5 5" class="guide"><a href="#" onClick="go_ucc('C');"><?=$C_h?> <?=$UCC_CATEG['C'][1]?> <?=$C_f?></a></td>
        </tr>
      </table>
      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="645" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="5" bgcolor="FF5B5C"></td>
              </tr>
              <tr>
                <td height="27">
				<table width="645" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="70" align="center"><img src="/img/title36.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="70" align="center"><img src="/img/title37.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td align="center"><img src="/img/title38.gif" width="70" height="20" /></td>
                      <td width="3"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="70" align="center"><img src="/img/title39.gif" width="70" height="20" /></td>
                      <td width="3" align="center"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="80" align="center"><img src="/img/title06.gif" width="70" height="20" /></td>
                      <td width="3" align="center"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="70" align="center"><img src="/img/title40.gif" width="70" height="20" /></td>
                      <td width="3" align="center"><img src="/img/title_line.gif" width="3" height="9" /></td>
                      <td width="70" align="center"><img src="/img/title41.gif" width="70" height="20" /></td>
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


<?=$LIST?>


            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height="6" bgcolor="FF5B5C"></td>
                </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="24" align="right" valign="bottom"><a href="#" onClick="go_ucc_write('','','');"><img src="/img/btn_write.gif" width="60" height="20" border="0" /></a></td>
                </tr>
            </table>
            <table width="100%" height="45" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center">

<?
if ( $total_record > 0 ) 
echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"/board/ucc_list.php",$qry_str);
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
            <input type="text" name="kwd" class="logbox" style="width:300" value="<?=$kwd?>" />
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
