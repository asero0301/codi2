<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/common/ajax_tail_board.php
 * date   : 2009.01.20
 * desc   : 상세보기에서 게시판 하단부분
 *******************************************************/
session_start();

ini_set("default_charset", "euc-kr");

require_once "../inc/common.inc.php";

// 리퍼러 체크
referer_chk();

$mainconn->open();

$tkind	= trim($_REQUEST['tkind']);
$ttkind	= trim($_REQUEST['ttkind']);
$tpage	= trim($_REQUEST['tpage']);
$tkey	= trim($_REQUEST['tkey']);
$tkwd	= trim($_REQUEST['tkwd']);

$tkwd = iconv("utf-8", "euc-kr", $tkwd);

$str = "";

if ( $tkind == "U" ) {
	if ( $ttkind == "A" ) {
		$A_bg = "#FFDADA"; $B_bg = $C_bg = $_bg = "#FFFFFF";
		$A_h = "<b><font color='CC0000'>"; $A_f = "</font></b>";
		$B_h = $B_f = $C_h = $C_f = $_h = $_f = "";
	} else if ( $ttkind == "B" ) {
		$B_bg = "#FFDADA"; $A_bg = $C_bg = $_bg = "#FFFFFF";
		$B_h = "<b><font color='CC0000'>"; $B_f = "</font></b>";
		$A_h = $A_f = $C_h = $C_f = $_h = $_f = "";
	}  else if ( $ttkind == "C" ) {
		$C_bg = "#FFDADA"; $A_bg = $B_bg = $_bg = "#FFFFFF";
		$C_h = "<b><font color='CC0000'>"; $C_f = "</font></b>";
		$A_h = $A_f = $B_h = $B_f = $_h = $_f = "";
	} else {
		$_bg = "#FFDADA"; $B_bg = $C_bg = $A_bg = "#FFFFFF";
		$_h = "<b><font color='CC0000'>"; $_f = "</font></b>";
		$B_h = $B_f = $C_h = $C_f = $A_h = $A_f = "";
	}

	$col_categ = " A.ucc_categ, ";
	$col_score = " (select ifnull(sum(ucc_s_score),0) from tblUccScore where ucc_idx=A.ucc_idx) as score, ";
	$str .= "
	  <table width='645' border='0' cellpadding='0' cellspacing='1' bgcolor='FF5B5C'>
        <tr>
          <td width='152' align='center' bgcolor='$_bg' style='padding:7 5 5 5'><a href='#' onClick=\"go_ucc('');\">$_h 전체보기 $_h</a></td>
          <td align='center' bgcolor='$A_bg' style='padding:7 5 5 5' class='guide'><a href='#' onClick=\"go_ucc('A');\">$A_h ".$UCC_CATEG[A][1]." $A_f</a></td>
          <td align='center' bgcolor='#FFFFFF' style='padding:7 5 5 5' class='guide'><a href='#' onClick=\"go_ucc('B');\">$B_h ".$UCC_CATEG[B][1]." $B_f</a></td>
          <td align='center' bgcolor='#FFFFFF' style='padding:7 5 5 5' class='guide'><a href='#' onClick=\"go_ucc('C');\">$C_h ".$UCC_CATEG[C][1]." $C_f</a></td>
        </tr>
      </table>

	  <table width='645' border='0' cellspacing='0' cellpadding='0'>
        <tr>
          <td>
		  <table width='645' border='0' cellspacing='0' cellpadding='0'>
              <tr>
                <td height='5' bgcolor='FF5B5C'></td>
              </tr>
              <tr>
                <td height='27'>
				<table width='645' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='70' align='center'><img src='/img/title36.gif' width='70' height='20' /></td>
                      <td width='3'><img src='/img/title_line.gif' width='3' height='9' /></td>
                      <td width='70' align='center'><img src='/img/title37.gif' width='70' height='20' /></td>
                      <td width='3'><img src='/img/title_line.gif' width='3' height='9' /></td>
                      <td align='center'><img src='/img/title38.gif' width='70' height='20' /></td>
                      <td width='3'><img src='/img/title_line.gif' width='3' height='9' /></td>
                      <td width='70' align='center'><img src='/img/title39.gif' width='70' height='20' /></td>
                      <td width='3' align='center'><img src='/img/title_line.gif' width='3' height='9' /></td>
                      <td width='80' align='center'><img src='/img/title06.gif' width='70' height='20' /></td>
                      <td width='3' align='center'><img src='/img/title_line.gif' width='3' height='9' /></td>
                      <td width='70' align='center'><img src='/img/title40.gif' width='70' height='20' /></td>
                      <td width='3' align='center'><img src='/img/title_line.gif' width='3' height='9' /></td>
                      <td width='70' align='center'><img src='/img/title41.gif' width='70' height='20' /></td>
                    </tr>
                </table>
				</td>
              </tr>
              <tr>
                <td height='1' bgcolor='FF5B5C'></td>
              </tr>
            </table>
              <table width='100' height='10' border='0' cellpadding='0' cellspacing='0'>
                <tr>
                  <td></td>
                </tr>
              </table>
	";

} else {
	$col_categ = "";
	$col_score = "";

	$str .= "
	  <table width='645' border='0' cellspacing='0' cellpadding='0'>
        <tr>
          <td>
		  <table width='645' border='0' cellspacing='0' cellpadding='0'>
              <tr>
                <td height='5' bgcolor='FF5B5C'></td>
              </tr>
              <tr>
                <td height='27'>
				<table width='645' border='0' cellspacing='0' cellpadding='0'>
                    <tr>
                      <td width='70' align='center'><img src='/img/title36.gif' width='70' height='20' /></td>
                      <td width='3'><img src='/img/title_line.gif' width='3' height='9' /></td>
                      <!--
					  <td width='70' align='center'><img src='/img/title37.gif' width='70' height='20' /></td>
                      <td width='3'><img src='/img/title_line.gif' width='3' height='9' /></td>
					  -->
                      <td align='center'><img src='/img/title38.gif' width='70' height='20' /></td>
                      <td width='3'><img src='/img/title_line.gif' width='3' height='9' /></td>
                      <td width='70' align='center'><img src='/img/title39.gif' width='70' height='20' /></td>
                      <td width='3' align='center'><img src='/img/title_line.gif' width='3' height='9' /></td>
                      <td width='80' align='center'><img src='/img/title06.gif' width='70' height='20' /></td>
                      <td width='3' align='center'><img src='/img/title_line.gif' width='3' height='9' /></td>
                      <td width='70' align='center'><img src='/img/title40.gif' width='70' height='20' /></td>
					  <!--
                      <td width='3' align='center'><img src='/img/title_line.gif' width='3' height='9' /></td>
                      <td width='70' align='center'><img src='/img/title41.gif' width='70' height='20' /></td>
					  -->
                    </tr>
                </table>
				</td>
              </tr>
              <tr>
                <td height='1' bgcolor='FF5B5C'></td>
              </tr>
            </table>
              <table width='100' height='10' border='0' cellpadding='0' cellspacing='0'>
                <tr>
                  <td></td>
                </tr>
              </table>
	";
}


if ( !$tpage ) $tpage = 1;

if ( $tkind == "N" ) {
	$col = "notice";
	$tbl_1 = "tblNotice"; $tbl_2 = "tblNoticeComment";
} else if ( $tkind == "U" ) {
	$col = "ucc";
	$tbl_1 = "tblUcc"; $tbl_2 = "tblUccComment";
} else if ( $tkind == "P" ) {
	$col = "pr";
	$tbl_1 = "tblPr"; $tbl_2 = "tblPrComment";
} else if ( $tkind == "B" ) {
	$col = "bad";
	$tbl_1 = "tblBadShop"; $tbl_2 = "tblBadShopComment";
}

$cond = " where 1 and A.mem_id = B.mem_id ";

// 불량샵이면 자기것만 보인다.
if ( $tkind == "B" ) {
	$cond .= " and A.mem_id = '".$_SESSION['mem_id']."' ";
}

if ( $ttkind != "" ) {
	$cond .= " and A.ucc_categ = '$ttkind' ";
}

// 검색: 작성자(M),제목(T),내용(C),제목+내용(TC)
if ( $tkey != "" && $tkwd != "" ) {
	if ( $tkey == "M" ) {
		$chk_M = " checked "; $chk_T = $chk_C = $chk_TC = "";
		$cond .= " and B.mem_name like '%$tkwd%' ";	
	} else if ( $tkey == "C" ) {
		$chk_C = " checked "; $chk_T = $chk_M = $chk_TC = "";
		$cond .= " and A.{$col}_content like '%$tkwd%' ";
	} else if ( $tkey == "TC" ) {
		$chk_TC = " checked "; $chk_T = $chk_C = $chk_M = "";
		$cond .= " and ( A.{$col}_title like '%$tkwd%' or A.{$col}_content like '%$tkwd%' ) ";
	} else {
		$chk_T = " checked "; $chk_M = $chk_C = $chk_TC = "";
		$cond .= " and A.{$col}_title like '%$tkwd%' ";
	}
}

// record count
$sql = "select count(*) from $tbl_1 A, tblMember B $cond ";
//echo "cnt : $sql <br>";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $PAGE_SIZE*($tpage-1);
	$last = $PAGE_SIZE*$tpage;
}

$orderby = " order by A.{$col}_reg_dt desc ";

$sql = "
select A.{$col}_idx, $col_categ A.mem_id, A.{$col}_title, A.{$col}_view, A.{$col}_reg_dt, unix_timestamp(A.{$col}_reg_dt) as stamp,
B.mem_name, $col_score
(select count(*) from $tbl_2 where {$col}_idx=A.{$col}_idx) as comment_cnt
from $tbl_1 A, tblMember B
$cond $orderby limit $first, $PAGE_SIZE
";

//echo $sql."<br>";

$res = $mainconn->query($sql);
$article_num = $total_record - $PAGE_SIZE*($tpage-1);
while ( $row = $mainconn->fetch($res) ) {
	$c_idx		= trim($row[${col}.'_idx']);
	$s_mem_id		= trim($row['mem_id']);
	$s_mem_name	= trim($row['mem_name']);
	$c_title	= strip_str(trim($row[${col}.'_title']));
	$c_view		= trim($row[${col}.'_view']);
	$c_reg_dt	= str_replace("-",".",substr(trim($row[${col}.'_reg_dt']),0,10));
	$stamp		= trim($row['stamp']);
	$comment_cnt= trim($row['comment_cnt']);

	if ( $comment_cnt > 0 ) {
		$comment_cnt_str = "<font color='#FF7F02'>[$comment_cnt]</font>";
	} else {
		$comment_cnt_str = "";
	}

	if ( $tkind == "U" ) {
		if ( (time() - $stamp) < $UCC_NEW_STAMP ) {
			$icon = "<img src='/img/icon_new.gif' width='27' height='15' align='absmiddle'>";
			$c_title = cutStringHan($c_title, 94);
		} else {
			$icon = "";
			$c_title = cutStringHan($c_title, 100);
		}
	} else if ( $tkind == "P" ) {
		if ( (time() - $stamp) < $PR_NEW_STAMP ) {
			$icon = "<img src='/img/icon_new.gif' width='27' height='15' align='absmiddle'>";
			$c_title = cutStringHan($c_title, 94);
		} else {
			$icon = "";
			$c_title = cutStringHan($c_title, 100);
		}
		//$mem_name = "<b class='date'><font color='#FF3366'>[$shop_name]</font></b>";
	} else if ( $tkind == "N" ) {
		if ( (time() - $stamp) < $NOTICE_NEW_STAMP ) {
			$icon = "<img src='/img/icon_new.gif' width='27' height='15' align='absmiddle'>";
			$c_title = cutStringHan($c_title, 46);
		} else {
			$icon = "";
			$c_title = cutStringHan($c_title, 52);
		}
		$comment_cnt_str = "&nbsp;";
	} else if ( $tkind == "B" ) {
		if ( (time() - $stamp) < $BAD_NEW_STAMP ) {
			$icon = "<img src='/img/icon_new.gif' width='27' height='15' align='absmiddle'>";
			$c_title = cutStringHan($c_title, 100);
		} else {
			$icon = "";
			$c_title = cutStringHan($c_title, 106);
		}
	}
	
	if ( $tkind == "U" ) {
		$score		= trim($row['score']);
		$c_categ	= trim($row[${col}.'_categ']);
		$js_func = "go_ucc_view";

		if ( $c_categ == "A" ) { $c_categ_bg = "#FA3A00"; }
		else if ( $c_categ == "B" ) { $c_categ_bg = "#6B3AD8"; }
		else if ( $c_categ == "C" ) { $c_categ_bg = "#FF0078"; }

		$ucc_str_1 = "<td width='72' align='center'><font color='$c_categ_bg'>".$UCC_CATEG[$c_categ][0]."</font></td>";
		$ucc_str_2 = "<td width='72' align='center' class='evfont'><font color='#009933'>$score</font></td>";
	} else {
		$ucc_str_1 = $ucc_str_2 = "";

		if ( $tkind == "N" ) {
			$js_func = "go_notice_view";
		} else if ( $tkind == "P" ) {
			$js_func = "go_shop_pr_view";
		} else if ( $tkind == "B" ) {
			$js_func = "go_bad_shop_view";
		}
	}

	$str .= "
            <table width='645' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td width='70' align='center'>$article_num</td>
                  $ucc_str_1
                  <td align='left' style='padding:5 5 5 5'><a href='#' onClick=\"$js_func('$c_idx');\">$c_title $comment_cnt_str</a>$icon</td>
                  <td width='73' align='center' >$s_mem_name</td>
                  <td width='83' align='center'>$c_reg_dt</td>
                  <td width='73' align='center'>$c_view</td>
                  $ucc_str_2
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
}	// while


$total_block = ceil($total_page/$PAGE_BLOCK);
$block = ceil($tpage/$PAGE_BLOCK);
$first_page = ($block-1)*$PAGE_BLOCK;
$last_page = $block*$PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}

$str .= "			
            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td height='6' bgcolor='FF5B5C'></td>
                </tr>
            </table>

";

if ( $total_record > 0 ) {
	$str .= "
				<table width='100%' height='45' border='0' cellpadding='0' cellspacing='0'>
					<tr>
					  <td align='center'>
	";

	$str .= ajax_general_page_navi($tpage,$first_page,$last_page,$total_page,$block,$total_block,"loadTailBoard",$tkind,$tkey,$tkwd,$ttkind);


	$str .= "
					  </td>
					</tr>
				</table>
	";
}

$keydown = "if (event.keyCode == 13) goSearchTail();";

$str .= "
			</td>
        </tr>
      </table>

      <table width='645' border='0' cellspacing='0' cellpadding='0'>
	  <form id='ajax_search_frm' name='ajax_search_frm' method='post'>
	  <input type='hidden' id='tkind' name='tkind' value='$tkind' />
	  <input type='hidden' id='ttkind' name='ttkind' value='$ttkind' />
	  <input type='hidden' id='tpage' name='tpage' value='1' />
        <tr>
          <td height='1' colspan='2' bgcolor='DADADA'></td>
        </tr>
        <tr>
          <td height='30' bgcolor='F6F5F5' style='padding-top:3'>&nbsp;
            <input id='tkey' name='tkey' type='radio' value='M' $chk_M /> 작성자
			<input id='tkey' name='tkey' type='radio' value='T' $chk_T /> 제목
            <input id='tkey' name='tkey' type='radio' value='C' $chk_C /> 내용
            <input id='tkey' name='tkey' type='radio' value='TC' $chk_TC /> 제목+내용 
		  </td>
          <td align='right' bgcolor='F6F5F5' style='padding-right:5'><input type='text' id='tkwd' name='tkwd' class='logbox'  style='width:300' value='$tkwd' OnKeyDown='$keydown' />
            <a onClick=\"goSearchTail();\" style='cursor:hand;'><img src='/img/btn_search.gif' align='absmiddle' border='0' /></a></td>
        </tr>
        <tr>
          <td height='1' colspan='2' bgcolor='DADADA'></td>
        </tr>
	  </form>
      </table>
";

$mainconn->close();
echo $str;

?>
