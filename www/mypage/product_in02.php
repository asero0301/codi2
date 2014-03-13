<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/product_in02.php
 * date   : 2008.10.10
 * desc   : 마이페이지 코디상품 등록 2단계
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

auth_chk($RURL);

$mainconn->open();

$mem_id		= $_SESSION['mem_id'];
$mem_name	= $_SESSION['mem_name'];
$mem_date	= date("Ymd", time());

$mode			= trim($_POST['mode']);
$tbl			= trim($_POST['tbl']);
$p_idx			= trim($_POST['p_idx']);

$shop_idx		= trim($_POST['shop_idx']);
$p_categ		= trim($_POST['p_categ']);
$p_style_kwd	= trim($_POST['p_style_kwd']);
$p_style_kwd2	= trim($_POST['p_style_kwd2']);
$p_item_kwd		= trim($_POST['p_item_kwd']);
$p_item_kwd2	= trim($_POST['p_item_kwd2']);
$p_theme_kwd	= trim($_POST['p_theme_kwd']);
$p_theme_kwd2	= trim($_POST['p_theme_kwd2']);
$p_etc_kwd		= trim($_POST['p_etc_kwd']);
$p_gift_kind	= trim($_POST['p_gift_kind']);
$p_gift			= trim($_POST['p_gift']);
$p_gift_cond	= trim($_POST['p_gift_cond']);
$p_gift_cnt		= trim($_POST['p_gift_cnt']);
$p_current_cash = trim($_POST['p_current_cash']);
$p_key			= trim($_POST['p_key']);

/*
// p_key md5 체크
$this_p_key = md5($mem_id.$mem_name.$mem_date);
if ( $this_p_key != $p_key ) {
	echo "<script>alert('잘못된 경로로 접근하였습니다.'); history.back();</script>";
	exit;
}
*/

// 코드/캐시 값을 구한다.
$inc_sql = "select * from tblCashConfig ";
$inc_res = $mainconn->query($inc_sql);
$CASHCODE = array();
while ( $inc_row = $mainconn->fetch($inc_res) ) {
	$inc_cc_cid = trim($inc_row['cc_cid']);
	$inc_cc_cval = trim($inc_row['cc_cval']);
	$inc_etc_conf = trim($inc_row['etc_conf']);
	$inc_cash = trim($inc_row['cash']);

	//$CASHCODE[$inc_cc_cid] = $inc_cash;
	$CASHCODE[$inc_cc_cid] = array($inc_cc_cval, $inc_cash, $inc_etc_conf);
}

// 코디상품 추가 이미지 레이어 갯수 초기화
echo "<script language='javascript'>var g_layer_cnt = 0;</script>";

if ( $mode == "E" ) {
	$tbl_name = ( $tbl == "R" ) ? "tblProduct" : "tblProductTmp";
	$sql = "select * from $tbl_name where p_idx = $p_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$old_p_main_img = trim($row['p_main_img']);
	$old_p_base_img = trim($row['p_base_img']);
	$old_p_etc_img = trim($row['p_etc_img']);
	$old_p_desc_img = trim($row['p_desc_img']);
	$p_title = trim($row['p_title']);
	$p_info = trim($row['p_info']);
	$p_desc = trim($row['p_desc']);
	$p_price = trim($row['p_price']);
	$p_url = trim($row['p_url']);
	$p_judgment = trim($row['p_judgment']);
	$p_auto_extend = trim($row['p_auto_extend']);

	$p_title	= strip_str($p_title);
	$p_info	= strip_str($p_info);
	$p_desc	= strip_str($p_desc);

	$arr_base_img = explode(";", $old_p_base_img);
	$arr_etc_img = explode(";", $old_p_etc_img);
	$arr_desc_img = explode(";", $old_p_desc_img);

	// 추가이미지(동적)를 자바스크립트 변수에 할당
	if ( $arr_etc_img ) {
		$layer_cnt = 0;
		for ( $x=0; $x<sizeof($arr_etc_img); $x++ ) {
			if ( $arr_etc_img[$x] == "" ) continue;
			echo "<script>var js_etc_img_$x = '$arr_etc_img[$x]';</script>";
			$layer_cnt++;
		}
		// 코디상품 추가 이미지 레이어 갯수 수정
		echo "<script language='javascript'>g_layer_cnt = $layer_cnt;</script>";
	}


	// 설명 이미지중 url입력/파일입력을 구분
	$txt_desc_arr = array();
	$img_desc_arr = array();
	
	for ( $i=0; $i<sizeof($arr_desc_img); $i++ ) {
		if ( $arr_desc_img[$i] == "" ) continue;
		if ( substr($arr_desc_img[$i],0,7) == "http://" ) {
			array_push($txt_desc_arr, $arr_desc_img[$i]);
		} else {
			array_push($img_desc_arr, $arr_desc_img[$i]);
		}
	}	

	// 설명이미지를 자바스크립트 변수에 할당
	if ( $img_desc_arr ) {
		for ( $x=0; $x<sizeof($img_desc_arr); $x++ ) {
			if ( $img_desc_arr[$x] == "" ) continue;
			echo "<script>var js_desc_img_$x = '$img_desc_arr[$x]';</script>";
		}
	}

	$info_reg_str = "수정";
} else {
	$txt_desc_arr = array("http://","http://","http://");
	$info_reg_str = "등록";
}

if ( $p_url == "" ) $p_url = "http://";
foreach ( $txt_desc_arr as $k => $v ) {
	
}

$info_reg_cash = $CASHCODE['CC59'][1];

$info_kwd_sum = 0;
if ( $p_style_kwd2 ) $info_kwd_sum++;
if ( $p_item_kwd2 ) $info_kwd_sum++;
if ( $p_theme_kwd2 ) $info_kwd_sum++;
$info_kwd_cash = $CASHCODE['CC57'][1] * $info_kwd_sum;

// 사용가능한 캐시값을 구한다.
//$sql = "select mem_cash from tblMember where mem_id = '$mem_id'";
//$mem_cash = $mainconn->count($sql);
$mem_cash = $_SESSION['mem_cash'];

$mainconn->close();

?>

<? include "../include/_head.php"; ?>


<script type="text/JavaScript">
<!--
var g_auto_extend_count = 0;	// 자동연장값 저장
var g_etc_img_count = g_desc_img_count = 0;	// (추가/설명)이미지 갯수를 알기위해서
var g_p_desc_img_1 = g_p_desc_img_2 = g_p_desc_img_3 = 0;	// 설명이미지 갯수

// 이미지 업로드 인덱스를 기억하기 위한 변수
g_base_index = "";
g_etc_index = "";
g_desc_index = "";

// 설명이미지 값이 변할때 호출
function chkCashDescImg(num) {
	if ( document.getElementById("p_desc_img_"+num).value != "" ) {
		if ( num == 1 ) {
			g_p_desc_img_1 += 1;
		} else if ( num == 2 ) {
			g_p_desc_img_2 += 1;
		} else if ( num == 3 ) {
			g_p_desc_img_3 += 1;
		}
	} else {
		if ( num == 1 ) {
			g_p_desc_img_1 -= 1;
		} else if ( num == 2 ) {
			g_p_desc_img_2 -= 1;
		} else if ( num == 3 ) {
			g_p_desc_img_3 -= 1;
		}
	}

	if ( num == 1 ) {
		if ( g_p_desc_img_1 == 1 ) {
			cash_change("<?=$CASHCODE[CC57][1]?>",1);
			g_desc_img_count++;
		} else if ( g_p_desc_img_1 == 0 ) {
			cash_change("<?=$CASHCODE[CC57][1]?>",0);
			g_desc_img_count--;
		}
	} else if ( num == 2 ) {
		if ( g_p_desc_img_2 == 1 ) {
			cash_change("<?=$CASHCODE[CC57][1]?>",1);
			g_desc_img_count++;
		} else if ( g_p_desc_img_2 == 0 ) {
			cash_change("<?=$CASHCODE[CC57][1]?>",0);
			g_desc_img_count--;
		}
	} else if ( num == 3 ) {
		if ( g_p_desc_img_3 == 1 ) {
			cash_change("<?=$CASHCODE[CC57][1]?>",1);
			g_desc_img_count++;
		} else if ( g_p_desc_img_3 == 0 ) {
			cash_change("<?=$CASHCODE[CC57][1]?>",0);
			g_desc_img_count--;
		}
	}
	info_change("info_img");
}

// 자동연장 값이 변할때 호출
function chkCashAutoExtend() {
	var f = document.frm;

	var this_val = parseInt(f.p_auto_extend.options[f.p_auto_extend.selectedIndex].value);
	var diff = this_val - parseInt(g_auto_extend_count);
	document.getElementById("p_auto_extend_cash").innerHTML = parseInt("<?=$CASHCODE[CC55][1]?>") * this_val;
	cash_change("<?=$CASHCODE[CC55][1]?>", diff);
	info_change("info_auto_extend", this_val);
	g_auto_extend_count = this_val;
}

// 추천코디 심사신청 값이 변할때 호출
function chkCashJudgment() {
	var f = document.frm;
	if ( f.p_judgment.checked == true ) {
		cash_change("<?=$CASHCODE[CC56][1]?>",1);
		info_change("info_judgment",1);
	} else {
		cash_change("<?=$CASHCODE[CC56][1]?>",0);
		info_change("info_judgment",0);
	}
}

// 임시저장 submit
function goOk(flag) {
	var f = document.frm;
	f.savemode.value = flag;

	if ( f.mode.value == "E" ) {
		f.img_base_index.value = g_base_index;
		f.img_etc_index.value = g_etc_index;
		f.img_desc_index.value = g_desc_index;
	}

	if ( f.p_main_img.value == "" && f.old_p_main_img.value == "" ) {
		alert("코디상품 대표이미지를 입력하세요.");
		f.p_main_img.focus();
		return;
	}

	if ( f.p_title.value == "" ) {
		alert("코디제목을 입력하세요.");
		f.p_title.focus();
		return;
	}

	if ( f.p_info.value == "" ) {
		alert("코디 간략소개를 입력하세요.");
		f.p_info.focus();
		return;
	}

	if ( f.p_desc.value == "" ) {
		alert("코디 설명을 입력하세요.");
		f.p_desc.focus();
		return;
	}

	if ( f.p_price.value == "" ) {
		alert("코디구매 가격을 입력하세요.");
		f.p_price.focus();
		return;
	}

	if ( f.p_info.value ) {
		if ( han_length(f.p_info.value) > 300 ) {
			alert("간략소개는 300자 이내여야 합니다.");
			f.p_info.select();
			return;
		}
	}

	if ( trim(f.p_url.value) == "" || trim(f.p_url.value) == "http://" ) {
		alert("코디구매 URL을 입력하세요.");
		f.p_url.focus();
		return;
	}

	if ( isNumber(f.p_price) == false ) {
		alert("코디구매 가격은 숫자여야 합니다.");
		f.p_price.focus();
		return;
	}

	my_cash = parseInt('<?=$mem_cash?>');	// 현재캐쉬
	curr_cash = f.p_current_cash.value;		// 지불할캐쉬
	limit_cash = parseInt('<?=$CASHCODE[CC54][2]?>')	// 지불한도 외상캐쉬

	if ( my_cash - curr_cash < -limit_cash ) {
		alert("캐쉬가 부족합니다.\n캐시충전후 등록가능합니다.");
		return;
	}

	if ( my_cash - curr_cash <= 0 && my_cash - curr_cash > -limit_cash ) {
		if ( !confirm("현재 캐쉬가 "+(limit_cash-my_cash+curr_cash)+ "원 부족합니다.\n외상으로 등록하시겠습니까?") ) return;
	}

	f.encoding = "multipart/form-data";
	f.target = "_self";
	f.action = "product_in02_ok.php";
	f.submit();
}

function itemShow() {
	if ( document.getElementById("etc_img_area_"+g_etc_img_count).style.display == "none" ) {
		cash_change("<?=$CASHCODE[CC57][1]?>",1);
		document.getElementById("p_etc_img_"+g_etc_img_count).disabled = false;
		document.getElementById("etc_img_area_"+g_etc_img_count).style.display = "block";
		g_etc_img_count++;
		info_change("info_img");
	}
}

function itemHide() {
	if ( g_etc_img_count < 1 ) return;
	g_etc_img_count--;
	if ( document.getElementById("etc_img_area_"+g_etc_img_count).style.display == "block" ) {
		cash_change("<?=$CASHCODE[CC57][1]?>",0);
		document.getElementById("p_etc_img_"+g_etc_img_count).disabled = true;
		document.getElementById("etc_img_area_"+g_etc_img_count).style.display = "none";

		//del_file = document.getElementByName("p_etc_img\[\]");
		//del_file[g_etc_img_count].select();
		//document.selection.clear();
		info_change("info_img");
	}
}

// 하단 cash 정보, 모든 캐시의 변화가 생길때 호출된다.
function info_change(kind,flag) {
	if ( kind == "info_img" ) {
		document.getElementById("info_img_count").innerHTML = parseInt(g_etc_img_count) + parseInt(g_desc_img_count);
		document.getElementById("info_img_cash").innerHTML = ( parseInt(g_etc_img_count) + parseInt(g_desc_img_count) ) * parseInt("<?=$CASHCODE[CC58][1]?>");
	} else if ( kind == "info_judgment" ) {
		if ( flag == 1 ) {
			document.getElementById("info_judgment_ox").innerHTML = "O";
			document.getElementById("info_judgment_cash").innerHTML = parseInt("<?=$CASHCODE[CC56][1]?>");
		} else {
			document.getElementById("info_judgment_ox").innerHTML = "X";
			document.getElementById("info_judgment_cash").innerHTML = 0;
		}
	} else if ( kind == "info_auto_extend" ) {
		if ( flag == 0 ) {
			document.getElementById("info_auto_extend_count").innerHTML = 0;
			document.getElementById("info_auto_extend_cash").innerHTML = 0;
		} else {
			document.getElementById("info_auto_extend_count").innerHTML = flag;
			document.getElementById("info_auto_extend_cash").innerHTML = parseInt(flag) * parseInt("<?=$CASHCODE[CC55][1]?>");
		}
	}
	document.getElementById("info_total_cash").innerHTML = parseInt(document.getElementById("info_reg_cash").innerHTML) + parseInt(document.getElementById("info_kwd_cash").innerHTML) + parseInt(document.getElementById("info_img_cash").innerHTML) + parseInt(document.getElementById("info_judgment_cash").innerHTML) + parseInt(document.getElementById("info_auto_extend_cash").innerHTML); 
}

// 이미지 보이기
function img_filetype_view(obj) {
	if(obj.value.match(/(.jpg|.jpeg|.gif|.png|.bmp|.pdf)$/i)) {
		document.getElementById('view_p_img').src = obj.value;
		document.getElementById('view_p_img').style.display = "block";
	} else {
		document.getElementById('view_p_img').style.display = "none";
	}	
}

function img_view(id,val) {
	if(!val.match(/(.jpg|.jpeg|.gif|.png)$/i)) {
		alert("jpg, gif, png 파일만 업로드 가능합니다");
		return;
	}
	document.getElementById(id).src = val;
}

function add_index(type,idx) {
	flag = 1;
	if ( type == "base" ) {
		tmp_arr = g_base_index.split(",");
		for ( var i=0; i<tmp_arr.length; i++ ) {
			if ( ""+idx == tmp_arr[i] ) {
				flag = 0;
				break;
			}
		}
		if ( flag == 1 ) g_base_index += idx+",";
	} else if ( type == "etc" ) {
		tmp_arr = g_etc_index.split(",");
		for ( var i=0; i<tmp_arr.length; i++ ) {
			if ( ""+idx == tmp_arr[i] ) {
				flag = 0;
				break;
			}
		}
		if ( flag == 1 ) g_etc_index += idx+",";
	} else if ( type == "desc" ) {
		tmp_arr = g_desc_index.split(",");
		for ( var i=0; i<tmp_arr.length; i++ ) {
			if ( ""+idx == tmp_arr[i] ) {
				flag = 0;
				break;
			}
		}
		if ( flag == 1 ) g_desc_index += idx+",";
	}
}
//-->
</script>


<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="<?=$mode?>" />
<input type="hidden" id="p_idx" name="p_idx" value="<?=$p_idx?>" />
<input type="hidden" id="savemode" name="savemode" value="" />
<input type="hidden" id="tbl" name="tbl" value="<?=$tbl?>" />
<input type="hidden" id="shop_idx" name="shop_idx" value="<?=$shop_idx?>" />
<input type="hidden" id="p_categ" name="p_categ" value="<?=$p_categ?>" />
<input type="hidden" id="p_style_kwd" name="p_style_kwd" value="<?=$p_style_kwd?>" />
<input type="hidden" id="p_style_kwd2" name="p_style_kwd2" value="<?=$p_style_kwd2?>" />
<input type="hidden" id="p_item_kwd" name="p_item_kwd" value="<?=$p_item_kwd?>" />
<input type="hidden" id="p_item_kwd2" name="p_item_kwd2" value="<?=$p_item_kwd2?>" />
<input type="hidden" id="p_theme_kwd" name="p_theme_kwd" value="<?=$p_theme_kwd?>" />
<input type="hidden" id="p_theme_kwd2" name="p_theme_kwd2" value="<?=$p_theme_kwd2?>" />
<input type="hidden" id="p_etc_kwd" name="p_etc_kwd" value="<?=$p_etc_kwd?>" />
<input type="hidden" id="p_gift_kind" name="p_gift_kind" value="<?=$p_gift_kind?>" />
<input type="hidden" id="p_gift" name="p_gift" value="<?=$p_gift?>" />
<input type="hidden" id="p_gift_cond" name="p_gift_cond" value="<?=$p_gift_cond?>" />
<input type="hidden" id="p_gift_cnt" name="p_gift_cnt" value="<?=$p_gift_cnt?>" />
<input type="hidden" id="p_current_cash" name="p_current_cash" value="<?=$p_current_cash?>" />
<input type="hidden" id="p_key" name="p_key" value="<?=$p_key?>" />

<input type="hidden" id="old_p_main_img" name="old_p_main_img" value="<?=$old_p_main_img?>" />
<input type="hidden" id="old_p_base_img" name="old_p_base_img" value="<?=$old_p_base_img?>" />
<input type="hidden" id="old_p_etc_img" name="old_p_etc_img" value="<?=$old_p_etc_img?>" />
<input type="hidden" id="old_p_desc_img" name="old_p_desc_img" value="<?=$old_p_desc_img?>" />

<input type="hidden" id="img_base_index" name="img_base_index" value="" />
<input type="hidden" id="img_etc_index" name="img_etc_index" value="" />
<input type="hidden" id="img_desc_index" name="img_desc_index" value="" />

<table width="860" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="332" background="/img/pro_in04.gif" style="padding-top:3" >&nbsp;&nbsp;&nbsp;<b><font color="FFF600">코디등록</font></b> <font color="#FFFFFF">: 코디를 등록하여 평가를 신청합니다.</font></td>
    <td ><img src="/img/pro_in02.gif" width="528" height="29" /></td>
  </tr>
</table>

  <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="860" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><font color="#333333"><b><img src="/img/in_title02.gif"  align="absmiddle"/></b></font> 등록할 코디 상품의 상세정보를 등록합니다. </td>
      <td align="right" class="evfont"><img src="/img/icon_aa.gif"  align="absmiddle">현재등록 전체캐쉬 <img src="/img/icon_cash.gif"  align="absmiddle"/><b><font color="FF0078"><span id="p_current_cash_area"><?=$p_current_cash?></span> / <?=$_SESSION['mem_cash']?></font></b></td>
    </tr>
    <tr>
      <td height="4" colspan="2"></td>
    </tr>
    <tr>
      <td colspan="2"><table width="860" border="0" cellpadding="0" cellspacing="3" bgcolor="8D2D45">
        <tr>
          <td bgcolor="580C1F" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
              <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                <tr>
                  <td style="padding:15 15 15 15"  class="intext"><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA">코디상품 이미지 등록안내 :</font></b> 추가 이미지는 기본 3개까지 등록 가능하며 최대 3O개까지 추가등록이 가능합니다. 
                    <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;기본추가 이미지 외에 이미지를 추가할 때마다 <font color="#333333"><b><u><?=$CASHCODE['CC58'][1]?>캐쉬</u></b></font>가 부가됩니다. (jpg,gif,png 파일만 업로드 가능) </td>
                </tr>
              </table>
                <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="250" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle"> 코디상품 대표 이미지<span class="evfont">(300*300size 권장) </span></td>
                  <td>
                     <img src="/img/icon00.gif" align=absmiddle> 이미지 업로드                      
                      <input type="file" name="p_main_img" id="p_main_img" class="logbox"  style="width:370" onChange="img_view('p_main_img_area',this.value);" /></td>
					  <td>
						<img id='p_main_img_area' src="/img/photo_no.gif" width="40" height="40"  style="display:block;">
					  </td>
                </tr>
                <tr>
                  <td height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> 코디상품 추가 이미지<span class="evfont">(300*300size 권장)</span></td>
                  <td><img src="/img/icon00.gif" align=absmiddle> 이미지 업로드
                    <input type="file" name="p_base_img[]" id="p_base_img_0" class="logbox"  style="width:370" onChange="img_view('p_base_img_area_0',this.value); add_index('base',1);" /></td>
				  <td>
						<img id='p_base_img_area_0' src="/img/photo_no.gif" width="40" height="40"  style="display:block;">
					  </td>
                  </tr>
				  <tr>
                  <td height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> 코디상품 추가 이미지<span class="evfont">(300*300size 권장)</span></td>
                  <td><img src="/img/icon00.gif" align=absmiddle> 이미지 업로드
                    <input type="file" name="p_base_img[]" id="p_base_img_1" class="logbox"  style="width:370" onChange="img_view('p_base_img_area_1',this.value); add_index('base',2);" /></td>
					<td>
						<img id='p_base_img_area_1' src="/img/photo_no.gif" width="40" height="40"  style="display:block;">
					  </td>
                  </tr>
				  <tr>
                  <td height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> 코디상품 추가 이미지<span class="evfont">(300*300size 권장)</span></td>
                  <td><img src="/img/icon00.gif" align=absmiddle> 이미지 업로드
                    <input type="file" name="p_base_img[]" id="p_base_img_2" class="logbox"  style="width:370" onChange="img_view('p_base_img_area_2',this.value); add_index('base',3);" /></td>
					<td>
						<img id='p_base_img_area_2' src="/img/photo_no.gif" width="40" height="40"  style="display:block;">
					  </td>
                  </tr>
              </table>
			  
                <table border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
                    <td colspan="3">&nbsp;</td>
                    </tr>
                  <tr>
                    <td><img src="/img/btn_photo02.gif" width="80" height="19" border="0" onClick="itemShow();" style="cursor:hand;" /></td>
                    <td width="3"></td>
                    <td><img src="/img/btn_photo01.gif" width="80" height="19" border="0" onClick="itemHide();" style="cursor:hand;" /></td>
                  </tr>
                
                </table>
				
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="1" background="/img/dot00.gif"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>

<?
// 30개의 레이아웃이 있다.
for ($i=0; $i<30; $i++ ) {
?>
				<div id="etc_img_area_<?=$i?>" style="display:none;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
						<td width="250" height="20" class="intitle">
							<img src="/img/pop_icon.gif"  align="absmiddle" /> 코디상품 추가  이미지<span class="evfont">(300*300size 권장) </span>
						</td>
						<td>
							<img src="/img/icon00.gif" align=absmiddle> 이미지 업로드<span class="evfont"><font color=FF5B5C >(100캐쉬)</font></span>
							<input type="file" name="p_etc_img[]" id="p_etc_img_<?=$i?>" class="logbox"  style="width:320" onChange="img_view('p_etc_img_area_<?=$i?>',this.value); add_index('etc',<?=$i+1?>);" />
							
						</td>
						<td>
							<img id='p_etc_img_area_<?=$i?>' src="/img/photo_no.gif" width="40" height="40"  style="display:block;">
						</td>
					
					</tr>
				</table>
				</div>
<?
}	// for
?>

      

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="1" background="/img/dot00.gif"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                  <tr>
                    <td style="padding:15 15 15 15"  class="intext"><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA">설명 이미지 무료로 등록하는 방법 :</font></b> 직접 이미지를 등록 할 수 있는 쇼핑몰 홈페이지, 카페, 블로그 등에 이미지 파일을 업로드한 후, 이미지의 URL 주소만
					 복사해서
					 <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>

					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;입력하면 <b><font color="#333333"><u>무료로 이미지 등록</u></font></b>이 가능합니다. </td>
                  </tr>
                </table>
                <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="250" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> 코디상품 설명 이미지1 <span class="evfont">(가로830픽셀 권장) </span></td>
                    <td><img src="/img/icon00.gif" align=absmiddle> URL 링크(무료)                      
                      <input name="p_desc_img_txt_1" id="p_desc_img_txt_1" type="text" class="logbox"  style="width:361" value="<?if ( $txt_desc_arr[0] ) echo $txt_desc_arr[0]; else echo"http://"; ?>" /></td>
					  <td rowspan="2"><img id='p_desc_img_area_1' src="/img/photo_no.gif" width="40" height="40"  style="display:block;"></td>
                    </tr>
                  <tr>
                    <td height="24" class="intitle" >&nbsp;</td>
                    <td><img src="/img/icon00.gif" align=absmiddle> 이미지 업로드(100캐쉬)
                      <input type="file" name="p_desc_img[]" id="p_desc_img_1" class="logbox"  style="width:318" onChange="chkCashDescImg(1); img_view('p_desc_img_area_1',this.value); add_index('desc',1);" /></td>
                  </tr>
				  
				  <tr>
                    <td width="250" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> 코디상품 설명 이미지2 <span class="evfont">(가로830픽셀 권장) </span></td>
                    <td><img src="/img/icon00.gif" align=absmiddle> URL 링크(무료)                      
                      <input name="p_desc_img_txt_2" id="p_desc_img_txt_2" type="text" class="logbox"  style="width:361" value="<?if ( $txt_desc_arr[1] ) echo $txt_desc_arr[1]; else echo"http://"; ?>" /></td>
					  <td rowspan="2"><img id='p_desc_img_area_2' src="/img/photo_no.gif" width="40" height="40" style="display:block;"></td>
                    </tr>
                  <tr>
                    <td height="24" class="intitle" >&nbsp;</td>
                    <td><img src="/img/icon00.gif" align=absmiddle> 이미지 업로드(100캐쉬)
                      <input type="file" name="p_desc_img[]" id="p_desc_img_2" class="logbox"  style="width:318" onChange="chkCashDescImg(2); img_view('p_desc_img_area_2',this.value); add_index('desc',2);" /></td>
                  </tr>
				  <tr>
                    <td width="250" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> 코디상품 설명 이미지3 <span class="evfont">(가로830픽셀 권장) </span></td>
                    <td><img src="/img/icon00.gif" align=absmiddle> URL 링크(무료)                      
                      <input name="p_desc_img_txt_3" id="p_desc_img_txt_3" type="text" class="logbox"  style="width:361" value="<?if ( $txt_desc_arr[2] ) echo $txt_desc_arr[2]; else echo"http://"; ?>" /></td>
					  <td rowspan="2"><img id='p_desc_img_area_3' src="/img/photo_no.gif" width="40" height="40"  style="display:block;"></td>
                    </tr>
                  <tr>
                    <td height="24" class="intitle" >&nbsp;</td>
                    <td> <img src="/img/icon00.gif" align=absmiddle> 이미지 업로드(100캐쉬)
                      <input type="file" name="p_desc_img[]" id="p_desc_img_3" class="logbox"  style="width:318" onChange="chkCashDescImg(3); img_view('p_desc_img_area_3',this.value); add_index('desc',3);" /></td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="1" background="/img/dot00.gif"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="100" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 코 디 제 목 </td>
                    <td width="311">
					
					<input type="text" name="p_title" id="p_title" class="logbox" value="<?=$p_title?>" style="width:584;" maxlength="100" /></td>
                    </tr>

                  <tr>
                    <td height="6" colspan="2" ></td>
                  </tr>
                 <tr>
                    <td height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 간 략 소 개 </td>
                    <td width="311">
                        <textarea name="p_info" id="p_info" class="memobox" style="width:584; height:50;"><?=$p_info?></textarea>
                     
                   </td>
                    </tr>
					 <tr>
                    <td height="6" colspan="2" ></td>
                  </tr>
                 <tr>
                    <td height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> 코 디 설 명 </td>
                    <td width="311">
                        <textarea name="p_desc" id="p_desc" class="memobox"  style="width:584; height:80;"><?=$p_desc?></textarea>
                     
                   </td>
                    </tr>
					<tr>
                    <td height="6" colspan="2" ></td>
                  </tr>
                 <tr>
                    <td width="100" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /><b><font color="724ECA"> 구성코디가격 </b></font></td>
                    <td><input type="text" name="p_price" id="p_price" value="<?=$p_price?>" class="logbox"  style="width:100" />
                      원   &nbsp;&nbsp;&nbsp; * 쇼핑몰 또는 미니샵 등에서 실제 판매되고 있는 금액을 입력해주세요.</td>
                    </tr> 
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="1" background="/img/dot00.gif"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>
                    <td width="119" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> 코디구매 URL </td>
                    <td><input name="p_url" id="p_url" type="text" class="logbox"  style="width:361" value="<?=$p_url?>" />
                      <span class="infont">코디사러가기 버튼클릭 <?=$CASHCODE['CC53'][2]?>회 이후부터 <font color="FF0078"><?=$CASHCODE['CC53'][1]?>캐쉬</font> 차감(1IP당, CPC형식 <img src="/img/btn_cpc.gif" alt="CPC형식이란?" border="0"  align="absmiddle" onclick="MM_openBrWindow('pop_cpc.php','','width=300,height=230')" style="cursor:hand;" />) </span></td>
                  </tr>
				  <tr>
                    <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td colspan="3" >＊ 이 상품을 직접 구매할 수 있는 URL을 입력해 주세요 </td>
                  </tr>
                  <tr>
                    <td height="18" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td colspan="3" >＊ <b><font color="#333333">[중요사항] </font></b>캐쉬가 부족할 경우는 <b>10,000캐쉬까지 외상!!</b> (단, 코디상품의 추가등록은 할 수 없습니다.)</td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="1" background="/img/dot00.gif"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="24" ><span class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> 오늘의 추천코디 심사신청 (유료 <?=$CASHCODE['CC56'][1]?>캐쉬) :  
                     
                          <input type="checkbox" name="p_judgment" id="p_judgment" value="R" onClick="chkCashJudgment();" <?if ($p_judgment=="R") echo " checked";?> />
                          </span>심사를 신청합니다.                      </td>
                    <td align="right" ><img src="/img/btn_today.gif" width="157" height="20" border="0" onclick="MM_openBrWindow('pop_cpc.php','','width=300,height=230')" style="cursor:hand;" /></td>
                  </tr>
                  <tr>
                    <td height="24" colspan="4"  >＊ 심사를 통과할 경우, 평가 마감일까지 <font color="FF0078">7일동안 평가대기 리스트뿐만 아니라 오늘의 추천코디(랜덤노출)</font>이 됩니다. </td>
                    </tr>
                  <tr>
                    <td height="20" colspan="4" >＊ 심사기간동안은 평가대기 리스트에 등록이 되지 않습니다.(심사신청을 하지 않으면, 즉시 등록됩니다.) </td>
                    </tr>
					 <tr>
                    <td height="20" colspan="4" >＊ 심사기간 : 신청 후 24시간 이내 <u><font color="#333333">(심사를 통과하지 못하더라도 신청한 캐쉬는 환불되지 않습니다.) </font></u></td>
                    </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="1" background="/img/dot00.gif"></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="119" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> 자 동 연 장 </td>
                    <td>
					<select name="p_auto_extend" id="p_auto_extend" class="logbox"  style="width:150" onChange="chkCashAutoExtend();">
                      <option value="0" <?if ($p_auto_extend=="0") echo " selected";?>>연장없음</option>
                      <option value="1" <?if ($p_auto_extend=="1") echo " selected";?>>1주연장(2주간 노출)</option>
                      <option value="2" <?if ($p_auto_extend=="2") echo " selected";?>>2주연장(3주간 노출)</option>
                      <option value="3" <?if ($p_auto_extend=="3") echo " selected";?>>3주연장(4주간 노출)</option>
                    </select>
                      소요되는 캐쉬 : <font color="FF0078"><span id="p_auto_extend_cash">0</span> 캐쉬</font></td>
                  </tr>
                  <tr>
                    <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td colspan="3" >＊ 기본평가기간(1주일)이 지나서 당첨자 발표가 완료되어도, 설정한 기간동안 동일한 등록 기준으로 자동 신규등록이 됩니다. </td>
                  </tr>
                  <tr>
                    <td height="18" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td colspan="3" ><font color="#FFFFFF">＊</font> (1주일간 받은 평가점수는 다시 초기화 되어 등록됩니다.) </td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
        </tr>
      </table>
        <table width="100" height="20" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="860" border="0" cellpadding="0" cellspacing="3" bgcolor="EBEBEB">
          <tr>
            <td bgcolor="C8C8C8" style="padding:1 1 1 1"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                <tr>
                  <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="400"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td height="2" colspan="4" bgcolor="E0295A"></td>
                        </tr>
                        <tr>
                          <td height="26" align="center" class="intitle">항목</td>
                          <td width="80" align="center" class="intitle">내용</td>
                          <td width="80" align="center" class="intitle">단가</td>
                          <td width="80" align="center" class="intitle">등록캐쉬</td>
                        </tr>
                        <tr>
                          <td height="1" colspan="4" bgcolor="E0295A"></td>
                        </tr>
                      </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="27" align="center" bgcolor="F9F9F9">신규등록</td>
                            <td width="80" align="center" bgcolor="F9F9F9"><?=$info_reg_str?></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont" ><?=$CASHCODE['CC59'][1]?></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont"><b><font color="#009933"><span id="info_reg_cash"><?=$info_reg_cash?></span></font></b></td>
                          </tr>
						   <tr>
                            <td height="1" colspan="4" bgcolor="#E0E0E0"></td>
                          </tr>
                          <tr>
                            <td height="27" align="center">추가키워드</td>
                            <td align="center"><?=$info_kwd_sum?>개</td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont" ><?=$CASHCODE['CC57'][1]?></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont"><b><font color="#009933"><span id="info_kwd_cash"><?=$info_kwd_cash?></span></font></b></td>
                          </tr>
						   <tr>
                            <td height="1" colspan="4" bgcolor="#E0E0E0"></td>
                          </tr>
                          <tr>
                            <td height="27" align="center" bgcolor="F9F9F9">상품이미지</td>
                            <td align="center" bgcolor="F9F9F9"><span id="info_img_count">0</span>개</td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont" ><?=$CASHCODE['CC58'][1]?></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont"><b><font color="#009933"><span id="info_img_cash">0</span></font></b></td>
                          </tr>
						   <tr>
                            <td height="1" colspan="4" bgcolor="#E0E0E0"></td>
                          </tr>
                          <tr>
                            <td height="27" align="center">추천코디</td>
                            <td align="center"><span id="info_judgment_ox">X</span></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont" ><?=$CASHCODE['CC56'][1]?></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont"><b><font color="#009933"><span id="info_judgment_cash">0</span></font></b></td>
                          </tr>
						   <tr>
                            <td height="1" colspan="4" bgcolor="#E0E0E0"></td>
                          </tr>
                          <tr>
                            <td height="27" align="center" bgcolor="F9F9F9">자동연장</td>
                            <td align="center" bgcolor="F9F9F9"><span id="info_auto_extend_count">0</span>주</td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont" ><?=$CASHCODE['CC55'][1]?></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont"><b><font color="#009933"><span id="info_auto_extend_cash">0</span></font></b></td>
                          </tr>
                          <tr>
                            <td height="1" colspan="4" bgcolor="#E0E0E0"></td>
                          </tr>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="2"></td>
                          </tr>
                         
                        </table>
                        <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="DD2457">
                          <tr>
                            <td width="152" align="center" bgcolor="FEB7B7" style="padding:7 5 5 5"><b><font color="CC0000">합계 : <span id="info_total_cash">0</span>캐쉬 </font></b></td>
                            <td align="center" bgcolor="#FFFFFF" style="padding:7 5 5 5">사용가능한 캐쉬 <?=$mem_cash?>캐쉬 <img src="/img/btn_add.gif" border="0"  align="absmiddle" onClick="alert('공사중');" style="cursor:hand;" /></td>
                          </tr>
                        </table></td>
                      <td width="20">&nbsp;</td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                        <tr>
                          <td style="padding:15 15 15 15" class="intext"><img src="/img/icon_aa.gif"  align="absmiddle" />TOP10으로 선정된 코디상품은 샵회원님들의 매출로 연결될 수 있도록 한주동안 <font color="#000000"><u>코디탑텐 사이트 곳곳에서 지속적으로 노출</u></font>이 됩니다.
						    <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td></td>
                              </tr>
                            </table>
						    <img src="/img/icon_aa.gif"  align="absmiddle" />경품지급에 대한 의무와 책임은 전적으로 해당 상품을 등록한 샵에게 있습니다. 코디탑텐은 상품등록 및 추첨 시스템 등을 제공할 뿐입니다. 
						    <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td></td>
                              </tr>
                            </table>
						    <img src="/img/icon_aa.gif"  align="absmiddle" />지급하기로 한 경품은 경품지급조건과 설정에 따라, 당첨자 발표 후 선정된 당첨자에게 <font color="#000000"><u>최대 7일 이내에 지급</u></font>하는 것을 원칙으로 합니다. 
						    <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td></td>
                              </tr>
                            </table>
						    <img src="/img/icon_aa.gif"  align="absmiddle" />
						  경품에 대한 제세공과금이 있을경우, 등록시 걸명내용에 이와같은 사실을 명시해야 합니다. 
						  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td></td>
                            </tr>
                          </table>
						  <img src="/img/icon_aa.gif"  align="absmiddle" />지급하기로 한 경품이 별다른 이유가 없거나 타당하지 못한 이유 등으로 지급이 불이행 되거나, 지급하기로 한 내용과 다른 경품이 지급될 경우에 발생할 수 있는 <font color="#DD2457">민형사상의 모든 책임은 등록자</font>에게 있습니다. </td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
        </table>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              
              <tr>
                <td width="240"><table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="124"><img src="/img/btn_prev02.gif" width="120" height="25" border="0" onClick="history.back();" style="cursor:hand;" /></td>
                    <td><img src="/img/btn_cancle.gif" width="120" height="25" border="0" onClick="location.href='/mypage/Mcodi.php';" style="cursor:hand;" /></td>
                  </tr>
                </table>              
				</td>
                <td align="center"><img src="/img/btn_ok.gif" width="120" height="25" border="0" onClick="goOk('R');" style="cursor:hand;" /></td>
                <td width="240" align="right">
				<? if ( $tbl != "R" ) { ?>
				<img src="/img/btn_save.gif" alt="임시저장" width="120" height="25" border="0" onClick="goOk('T');" style="cursor:hand;" />
				<? } ?>
				</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
    </tr>
  </table>

</form>

<script language="javascript">
document.getElementById("info_total_cash").innerHTML = parseInt(document.getElementById("info_reg_cash").innerHTML) + parseInt(document.getElementById("info_kwd_cash").innerHTML) + parseInt(document.getElementById("info_img_cash").innerHTML) + parseInt(document.getElementById("info_judgment_cash").innerHTML) + parseInt(document.getElementById("info_auto_extend_cash").innerHTML);
</script>

<? if ( $mode == "E" ) { ?>
<script language="javascript">
var img_dir = "<?=$UP_URL?>/thumb/";
// 메인 이미지 할당
document.getElementById("p_main_img_area").src = img_dir + '<?=$old_p_main_img?>';

// 기본 이미지 할당
if ( '<?=trim($arr_base_img[0])?>' ) {
	document.getElementById("p_base_img_area_0").src = img_dir + '<?=trim($arr_base_img[0])?>';
}
if ( '<?=trim($arr_base_img[1])?>' ) {
	document.getElementById("p_base_img_area_1").src = img_dir + '<?=trim($arr_base_img[1])?>';
}
if ( '<?=trim($arr_base_img[2])?>' ) {
	document.getElementById("p_base_img_area_2").src = img_dir + '<?=trim($arr_base_img[2])?>';
}

// 기본,설명 이미지 갯수
g_etc_img_count = parseInt("<?=sizeof($arr_etc_img)-1?>");
g_desc_img_count = parseInt("<?=sizeof($img_desc_arr)?>");

// 기본 이미지 할당(동적)
for ( var i=0; i<g_etc_img_count; i++ ) {
	js_var = eval("js_etc_img_"+i);
	if ( js_var ) {
		document.getElementById("p_etc_img_area_"+i).src = img_dir + js_var;
	}
}

//alert(g_desc_img_count);

// 설명 이미지 할당
for ( var i=0; i<g_desc_img_count; i++ ) {
	js_var = eval("js_desc_img_"+i);
	if ( js_var ) {
		document.getElementById("p_desc_img_area_"+(i+1)).src = img_dir + js_var;
	}
}

// 레이어 열기
for ( j=0; j<g_etc_img_count; j++ ) {
	document.getElementById("etc_img_area_"+j).style.display = "block";
}

// 자동연장값
g_auto_extend_count = parseInt("<?=$p_auto_extend?>");

// 상품이미지 등록캐시를 구한다.
edit_img_cash = (g_etc_img_count + g_desc_img_count)*parseInt("<?=$CASHCODE['CC58'][1]?>");
document.getElementById("info_img_cash").innerHTML = edit_img_cash;

// 추천코디 심사캐시를 구한다.
edit_judgment_cash = <?if ($p_judgment=="R") echo "parseInt('1')";else echo "parseInt('0')";?>*parseInt("<?=$CASHCODE['CC56'][1]?>");
document.getElementById("info_judgment_cash").innerHTML = edit_judgment_cash;

// 자동연장 등록캐시를 구한다.
edit_auto_extend_cash = parseInt("<?=$p_auto_extend?>")*parseInt("<?=$CASHCODE['CC55'][1]?>");
document.getElementById("p_auto_extend_cash").innerHTML = edit_auto_extend_cash;
document.getElementById("info_auto_extend_cash").innerHTML = edit_auto_extend_cash;

// 합계값을 구한다.
document.getElementById("info_total_cash").innerHTML = parseInt("<?=$info_reg_cash?>") + parseInt("<?=$info_kwd_cash?>") + edit_img_cash + edit_judgment_cash + edit_auto_extend_cash;



</script>
<? } ?>
<a href="javascript:alert(g_etc_img_count);">aaaa</a>
<? include "../include/_foot.php"; ?>

