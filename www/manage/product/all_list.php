<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/product/all_list.php
 * date   : 2008.08.20
 * desc   : Admin 전체(평가진행중/평가완료된 모두) LIST

SELECT 
	A. * , B.shop_name, 
	ifnull( (SELECT sum( E.li_score ) FROM tblMemberScore D, tblLottoItem E WHERE D.li_cid = E.li_cid AND D.p_e_idx = C.p_e_idx),0 ) AS score_sum, C.start_dt, C.end_dt
FROM tblProduct A, tblShop B, tblProductEach C
WHERE 1
AND A.shop_idx = B.shop_idx
AND A.p_idx = C.p_idx
AND ( now() BETWEEN C.start_dt AND C.end_dt OR now() > C.end_dt )
ORDER BY A.p_reg_dt DESC
 *******************************************************/
session_start();
require_once "../../inc/common.inc.php";

// 관리자 인증여부 체크
admin_auth_chk();

// 리퍼러 체크
referer_chk();


$mainconn->open();

/*
$judge = trim($_REQUEST['judge']);

if ( $judge == "" ) {
	$judge = "R";
}
*/
$key = trim($_REQUEST['key']);
$kwd = trim($_REQUEST['kwd']);
$page = trim($_REQUEST['page']);

$arr_chk = trim($_POST['chk']);
if ( is_array($arr_chk) ) {
	foreach ( $arr_chk as $k => $v ) {
		echo "\$arr_chk[$k] : $v <br>";
	}
}

if ( $page == "" ) $page = 1;


/*
if ( $key == "p_title" ) {
	$cond .= " and A.p_title like '%$kwd%' ";
} else if ( $key == "shop_name" ) {
	$cond .= " and B.shop_name like '%$kwd%' ";
}
*/
// record count

$cond = " where 1 and A.p_idx = B.p_idx and (now() between B.start_dt and B.end_dt or now() > B.end_dt) ";
if ( $key != "" ) {
	$cond .= " and $key like '%$kwd%' ";
}
$sql = "select count(*) from tblProduct A,tblProductEach B $cond ";
$total_record = $mainconn->count($sql);
$total_page = ceil($total_record/$ADMIN_PAGE_SIZE);

if ( $total_record == 0 ) {
	$first = 1;
	$last = 0;
} else {
	$first = $ADMIN_PAGE_SIZE*($page-1);
	$last = $ADMIN_PAGE_SIZE*$page;
}

$qry_str = "&judge=$judge&key=$key&kwd=$kwd";
$orderby = " order by A.p_reg_dt desc ";



$cond = "";
$cond = " where 1 AND A.shop_idx = B.shop_idx AND A.p_idx = C.p_idx AND ( now() BETWEEN C.start_dt AND C.end_dt or now() > C.end_dt ) ";
$orderby = " ORDER BY A.p_reg_dt DESC ";
if ( $key != "" ) {
	$cond .= " and $key like '%$kwd%' ";
}
$sql = "select A.*, B.shop_name, (select ifnull(sum(X.score),0) from tblScoreConfig X, tblScore Y where X.sc_cid = Y.sc_cid and Y.p_e_idx = C.p_e_idx) as score_sum, C.start_dt, C.end_dt from tblProduct A,tblShop B,tblProductEach C $cond $orderby limit $first, $ADMIN_PAGE_SIZE ";

$res = $mainconn->query($sql);

$LIST = "";

//$article_num = $total_record - $ADMIN_PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {

	$p_idx			= $row['p_idx'];
	$mem_id			= $row['mem_id'];
	$shop_idx		= $row['shop_idx'];
	$shop_name		= $row['shop_name'];
	$p_categ		= $row['p_categ'];
	$p_title		= $row['p_title'];
	$p_info			= $row['p_info'];
	$p_desc			= $row['p_desc'];
	$p_price		= $row['p_price'];
	$p_url			= $row['p_url'];
	$p_style_kwd	= $row['p_style_kwd'];
	$p_item_kwd		= $row['p_item_kwd'];
	$p_theme_kwd	= $row['p_theme_kwd'];
	$p_etc_kwd		= $row['p_etc_kwd'];
	$p_gift			= $row['p_gift'];
	$p_gift_cond	= $row['p_gift_cond'];
	$p_gift_cnt		= $row['p_gift_cnt'];
	$p_main_img		= $row['p_main_img'];
	$p_base_img		= $row['p_base_img'];
	$p_etc_img		= $row['p_etc_img'];
	$p_desc_img		= $row['p_desc_img'];
	$p_auto_extend	= $row['p_auto_extend'];
	$p_judgment		= $row['p_judgment'];
	$p_reg_dt		= $row['p_reg_dt'];
	$score_sum		= $row['score_sum'];
	$start_dt		= $row['start_dt'];
	$end_dt			= $row['end_dt'];

	$p_main_img_disp	= $UP_URL."/thumb/".$p_main_img;

	$act_flag = ( $p_judgment == "Y" ) ? " disabled " : "";

	if ( date("Y-m-d H:i:s") > $end_dt ) {	// 평가완료
		$case_str = "<input type='button' value='수정' onClick='delProduct(\"$p_idx\");'>";
	} else {	// 평가진행
		$case_str = "<input type='button' value='추천등록' $act_flag onClick='chgJudge(\"Y\",\"$p_idx\");'>";
	}

	$LIST .= "
		<tr>
		  <td height='28' align='center' bgcolor='#FFFFFF' class='join'>
			<input type='checkbox' id='itemchk' name='itemchk' value='$p_idx'>
		  </td>
		  <td align='center' bgcolor='#FFFFFF' width='100'>
			<img src='$p_main_img_disp' boarder='0' height='100' width='100'>
		  </td>
		  <td align='center' bgcolor='#FFFFFF'>
			<span class='stext'>
				<a href='product_view.php?p_idx=$p_idx'><font color='#006699'>$p_title</font></a>
			</span>
		  </td>
		  <td align='center'  bgcolor='#FFFFFF'>$p_gift</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'><a href='#'>$shop_name</a></td>
		  <td align='center'  bgcolor='#FFFFFF'class='stext'>$start_dt <br>~<br> $end_dt</td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'><a href='#'>$score_sum</a></td>
		  <td align='center' bgcolor='#FFFFFF'class='stext'>
			<input type='button' value='수정' onClick='alert(\"작업중\");'>
			$case_str
		  </td>
		</tr>
		<tr>
		  <td height='1' colspan='8' ></td>
		</tr>
		";
	$article_num--;
}

if ( $LIST == "" ) {
	$LIST = "<tr height='50' bgcolor='#ffffff' align='center'><td colspan='8' align='center' bgcolor='#FFFFFF'>결과가 없습니다.</td></tr>";
}

$total_block = ceil($total_page/$ADMIN_PAGE_BLOCK);
$block = ceil($page/$ADMIN_PAGE_BLOCK);
$first_page = ($block-1)*$ADMIN_PAGE_BLOCK;
$last_page = $block*$ADMIN_PAGE_BLOCK;

if ( $total_block <= $block ) {
	$last_page = $total_page;
}

$mainconn->close();

if ( $judge == "R" ) {
	// 등록신청
	$b_title = "오늘의 추천코디 등록심사";
	$b2_title = "심사신청 코디가 있습니다.";
	$b3_title = "현재 등록중 추천코디";
} else if ( $judge == "Y" ) {
	// 추천으로 등록됨
	$b_title = "현재 등록중인 추천코디";
	$b2_title = "추천코디가 있습니다.";
	$b3_title = "현재 신청중 심사코디";
}


require_once "../_top.php";
?> 

<script language="javascript">
function chgJudge(kind,idx) {
	var str = ( kind == "Y" ) ? "추천" : "일반";
	if ( confirm(str + "등록 하시겠습니까?") ) {
		var f = document.frm;
		f.mode.value = "R";
		f.kind.value = kind;

		if ( idx == "" ) {
			for (i = 0; document.getElementById('frm').elements[i]; i++) {
				if (document.getElementById('frm').elements[i].name == "itemchk") {
					if (document.getElementById('frm').elements[i].checked == true) {
						idx += document.getElementById('frm').elements[i].value+";";
					}
				}
			}

		}
		f.sel_idx.value = idx;

		f.action = "wait_write_ok.php";
		f.submit();
	}
}

function chgSearchItem() {
	var f = document.frm;
	if ( f.key.options[f.key.selectedIndex].value == "mem_jumin" ) {
		f.kwd.value = "- 제외하고 입력";
	} else if ( f.key.options[f.key.selectedIndex].value == "mem_status" ) {
		f.kwd.value = "활동:Y, 탈퇴:N, 블록:D (대소문자 구분) ";
	} else if ( f.key.options[f.key.selectedIndex].value == "mem_grade" ) {
		f.kwd.value = "1 에서 10 까지 숫자만 입력";
	} else {
		f.kwd.value = "";
	}
}

function goSearch() {
	var f = document.frm;
	f.action = "<?=$_SERVER['PHP_SELF']?>";
	f.submit();
}

function pop_msg(idlist) {
	var f = document.frm;

	var pop=window.open("","pop_msg_form_target","top=10,left=10,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=200,height=200");

	f.sel_idx.value = idlist;
	f.action = "/msg/pop_msg_form.php";
	f.target = "pop_msg_form_target";
	f.submit();
	pop.focus();
	//alert(idlist + "에게 메시지를 보냅니다. 작업중 ~~");
}

function sendAll() {
	var str = "";
	for (i = 0; document.getElementById('frm').elements[i]; i++) {
		if (document.getElementById('frm').elements[i].name == "itemchk") {
			if (document.getElementById('frm').elements[i].checked == true) {
				str += document.getElementById('frm').elements[i].value+";";
			}
		}
	}
	if ( str == "" ) {
		alert("선택된 항목이 없습니다.");
		return;
	} else {
		pop_msg(str);
	}
}

function delProduct(idx) {
	if ( !confirm("선택된 항목을 삭제하시겠습니까?\n삭제하면 제품정보,경품정보,사용자등록글,점수 항목이 삭제됩니다.\n샵캐시 항목은 삭제되지 않습니다.") ) { return; }

	if ( idx == "" ) {	// 전체 삭제
		var str = "";
		for (i = 0; document.getElementById('frm').elements[i]; i++) {
			if (document.getElementById('frm').elements[i].name == "itemchk") {
				if (document.getElementById('frm').elements[i].checked == true) {
					str += document.getElementById('frm').elements[i].value+";";
				}
			}
		}
		
	} else {	// 개별 삭제
		str = idx;
	}

	if ( str == "" || str == undefined ) {
		alert("선택된 항목이 없습니다.");
		return;
	} else {
		var f = document.frm;
		f.sel_idx.value = str;
		f.mode.value = "D";
		f.action = "product_write_ok.php";
		f.submit();
	}
}

function goR() {
	location.href = "wait_list.php?judge=R";
}

function goY() {
	location.href = "wait_list.php?judge=Y";
}

</script>

<table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="50%" height="23"><b><font color="#333333">■ 평가진행중 코디</font></b>  </td>
		<td width="50%" align="right" class="tienom">총 <?=$total_record?>개의 코디가 있습니다.</td>
	</tr>
</table>


<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="">
<input type="hidden" id="kind" name="kind" value="">
<input type="hidden" id="sel_idx" name="sel_idx" value="">
<input type="hidden" id="judge" name="judge" value="<?=$judge?>">

      <table width="980" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="D4D4D4">
              <tr>
                <td align="center" bgcolor="EFEFEF" style="padding:12 25 12 25"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="50" height="28" align="center" class="join"><font color="#000000"><b>전체</b></font></td>
					  <td width="100">&nbsp;</td>
                      <td width="200" align="center" class="stextbold"><font color="#000000"><b>코디상품명</b></font></td>
                      <td width="150" align="center" class="stextbold"><font color="#000000"><b>경품</b></font></td>
                      <td width="100" align="center" class="stextbold"><font color="#000000"><b>등록샵</b></font></td>
                      <td width="150" align="center" class="stextbold"><font color="#000000"><b>기간</b></font></td>
					  <td width="150" align="center" class="stextbold"><font color="#000000"><b>평가점수</b></font></td>
                      <td width="80" align="center" class="stextbold2008-06-03"><b><font color="#000000">처리</font></b></td>
                    </tr>
                    <tr>
                      <td height="1" colspan="7" align="center" bgcolor="#D4D4D4" ></td>
                    </tr>
					
					<?php
						echo $LIST;
					?>
          
                </table></td>
              </tr>
          </table></td>
        </tr>
      </table>
      

	  <table width="980" height="30" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="790" valign="bottom">
			<input type="button" value="전체선택" onClick="checkAll();">
			<input type="button" value="전체해제" onClick="checkFree();">
			<input type="button" value="선택 삭제" onClick="delProduct();">
		  </td>
        </tr>
      </table>

	

      <br>

<? if ( $total_record != 0 ) { ?>
      <table width="980" border="0" cellspacing="0" cellpadding="0" align=center>
        <tr>
          <td width="100"><img src="../board_img/text_page.gif" width="35" height="13" align="absmiddle"><span class="date"><?=$page?>/<?=$total_page?></span></td>
          <td align="center">

		  <?php
			echo admin_page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,$_SERVER['PHP_SELF'],$qry_str); ?>
		  
		  </td>
          <td width="100" align="right"> </td>
        </tr>
      </table>
<? } ?>

      <table width="100" height="18" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="980" border="0" cellpadding="0" cellspacing="1" bgcolor="E5E5E5" align=center>
        <tr>
          <td height="27" bgcolor="F7F7F7" style="padding-left:4;padding-right:4">
		  
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                
				<td width="120" style="padding-top:1">
					<select id="key" name="key" class="goodcss">
						<option value="">선택</option>
						<option value="A.p_title" <? if ( $key == "A.p_title" ) echo " selected"; ?>>제목</option>
						<option value="B.shop_name" <? if ( $key == "B.shop_name" ) echo " selected"; ?>>샵이름</option>
					</select>
				</td>
                <td><input type="text" id="kwd" name="kwd" value="<?=$kwd?>" class="goodcss" onFocus="document.frm.kwd.value='';" onKeyPress="javascript:if(event.keyCode==13) goSearch();">
                </td>
                <td width="70" align="right"><a href="javascript:goSearch();"><img src="../board_img/btn_search.gif" width="66" height="19" border="0"></a></td>
              </tr>
          </table></td>
        </tr>
      </table>
      <br>

</form>





<?php 

require_once "../_bottom.php";

?> 