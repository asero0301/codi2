<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/product_in02.php
 * date   : 2008.10.10
 * desc   : ���������� �ڵ��ǰ ��� 2�ܰ�
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
// p_key md5 üũ
$this_p_key = md5($mem_id.$mem_name.$mem_date);
if ( $this_p_key != $p_key ) {
	echo "<script>alert('�߸��� ��η� �����Ͽ����ϴ�.'); history.back();</script>";
	exit;
}
*/

// �ڵ�/ĳ�� ���� ���Ѵ�.
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

// �ڵ��ǰ �߰� �̹��� ���̾� ���� �ʱ�ȭ
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

	// �߰��̹���(����)�� �ڹٽ�ũ��Ʈ ������ �Ҵ�
	if ( $arr_etc_img ) {
		$layer_cnt = 0;
		for ( $x=0; $x<sizeof($arr_etc_img); $x++ ) {
			if ( $arr_etc_img[$x] == "" ) continue;
			echo "<script>var js_etc_img_$x = '$arr_etc_img[$x]';</script>";
			$layer_cnt++;
		}
		// �ڵ��ǰ �߰� �̹��� ���̾� ���� ����
		echo "<script language='javascript'>g_layer_cnt = $layer_cnt;</script>";
	}


	// ���� �̹����� url�Է�/�����Է��� ����
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

	// �����̹����� �ڹٽ�ũ��Ʈ ������ �Ҵ�
	if ( $img_desc_arr ) {
		for ( $x=0; $x<sizeof($img_desc_arr); $x++ ) {
			if ( $img_desc_arr[$x] == "" ) continue;
			echo "<script>var js_desc_img_$x = '$img_desc_arr[$x]';</script>";
		}
	}

	$info_reg_str = "����";
} else {
	$txt_desc_arr = array("http://","http://","http://");
	$info_reg_str = "���";
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

// ��밡���� ĳ�ð��� ���Ѵ�.
//$sql = "select mem_cash from tblMember where mem_id = '$mem_id'";
//$mem_cash = $mainconn->count($sql);
$mem_cash = $_SESSION['mem_cash'];

$mainconn->close();

?>

<? include "../include/_head.php"; ?>


<script type="text/JavaScript">
<!--
var g_auto_extend_count = 0;	// �ڵ����尪 ����
var g_etc_img_count = g_desc_img_count = 0;	// (�߰�/����)�̹��� ������ �˱����ؼ�
var g_p_desc_img_1 = g_p_desc_img_2 = g_p_desc_img_3 = 0;	// �����̹��� ����

// �̹��� ���ε� �ε����� ����ϱ� ���� ����
g_base_index = "";
g_etc_index = "";
g_desc_index = "";

// �����̹��� ���� ���Ҷ� ȣ��
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

// �ڵ����� ���� ���Ҷ� ȣ��
function chkCashAutoExtend() {
	var f = document.frm;

	var this_val = parseInt(f.p_auto_extend.options[f.p_auto_extend.selectedIndex].value);
	var diff = this_val - parseInt(g_auto_extend_count);
	document.getElementById("p_auto_extend_cash").innerHTML = parseInt("<?=$CASHCODE[CC55][1]?>") * this_val;
	cash_change("<?=$CASHCODE[CC55][1]?>", diff);
	info_change("info_auto_extend", this_val);
	g_auto_extend_count = this_val;
}

// ��õ�ڵ� �ɻ��û ���� ���Ҷ� ȣ��
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

// �ӽ����� submit
function goOk(flag) {
	var f = document.frm;
	f.savemode.value = flag;

	if ( f.mode.value == "E" ) {
		f.img_base_index.value = g_base_index;
		f.img_etc_index.value = g_etc_index;
		f.img_desc_index.value = g_desc_index;
	}

	if ( f.p_main_img.value == "" && f.old_p_main_img.value == "" ) {
		alert("�ڵ��ǰ ��ǥ�̹����� �Է��ϼ���.");
		f.p_main_img.focus();
		return;
	}

	if ( f.p_title.value == "" ) {
		alert("�ڵ������� �Է��ϼ���.");
		f.p_title.focus();
		return;
	}

	if ( f.p_info.value == "" ) {
		alert("�ڵ� �����Ұ��� �Է��ϼ���.");
		f.p_info.focus();
		return;
	}

	if ( f.p_desc.value == "" ) {
		alert("�ڵ� ������ �Է��ϼ���.");
		f.p_desc.focus();
		return;
	}

	if ( f.p_price.value == "" ) {
		alert("�ڵ𱸸� ������ �Է��ϼ���.");
		f.p_price.focus();
		return;
	}

	if ( f.p_info.value ) {
		if ( han_length(f.p_info.value) > 300 ) {
			alert("�����Ұ��� 300�� �̳����� �մϴ�.");
			f.p_info.select();
			return;
		}
	}

	if ( trim(f.p_url.value) == "" || trim(f.p_url.value) == "http://" ) {
		alert("�ڵ𱸸� URL�� �Է��ϼ���.");
		f.p_url.focus();
		return;
	}

	if ( isNumber(f.p_price) == false ) {
		alert("�ڵ𱸸� ������ ���ڿ��� �մϴ�.");
		f.p_price.focus();
		return;
	}

	my_cash = parseInt('<?=$mem_cash?>');	// ����ĳ��
	curr_cash = f.p_current_cash.value;		// ������ĳ��
	limit_cash = parseInt('<?=$CASHCODE[CC54][2]?>')	// �����ѵ� �ܻ�ĳ��

	if ( my_cash - curr_cash < -limit_cash ) {
		alert("ĳ���� �����մϴ�.\nĳ�������� ��ϰ����մϴ�.");
		return;
	}

	if ( my_cash - curr_cash <= 0 && my_cash - curr_cash > -limit_cash ) {
		if ( !confirm("���� ĳ���� "+(limit_cash-my_cash+curr_cash)+ "�� �����մϴ�.\n�ܻ����� ����Ͻðڽ��ϱ�?") ) return;
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

// �ϴ� cash ����, ��� ĳ���� ��ȭ�� ���涧 ȣ��ȴ�.
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

// �̹��� ���̱�
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
		alert("jpg, gif, png ���ϸ� ���ε� �����մϴ�");
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
    <td width="332" background="/img/pro_in04.gif" style="padding-top:3" >&nbsp;&nbsp;&nbsp;<b><font color="FFF600">�ڵ���</font></b> <font color="#FFFFFF">: �ڵ� ����Ͽ� �򰡸� ��û�մϴ�.</font></td>
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
      <td><font color="#333333"><b><img src="/img/in_title02.gif"  align="absmiddle"/></b></font> ����� �ڵ� ��ǰ�� �������� ����մϴ�. </td>
      <td align="right" class="evfont"><img src="/img/icon_aa.gif"  align="absmiddle">������ ��üĳ�� <img src="/img/icon_cash.gif"  align="absmiddle"/><b><font color="FF0078"><span id="p_current_cash_area"><?=$p_current_cash?></span> / <?=$_SESSION['mem_cash']?></font></b></td>
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
                  <td style="padding:15 15 15 15"  class="intext"><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA">�ڵ��ǰ �̹��� ��Ͼȳ� :</font></b> �߰� �̹����� �⺻ 3������ ��� �����ϸ� �ִ� 3O������ �߰������ �����մϴ�. 
                    <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�⺻�߰� �̹��� �ܿ� �̹����� �߰��� ������ <font color="#333333"><b><u><?=$CASHCODE['CC58'][1]?>ĳ��</u></b></font>�� �ΰ��˴ϴ�. (jpg,gif,png ���ϸ� ���ε� ����) </td>
                </tr>
              </table>
                <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="250" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle"> �ڵ��ǰ ��ǥ �̹���<span class="evfont">(300*300size ����) </span></td>
                  <td>
                     <img src="/img/icon00.gif" align=absmiddle> �̹��� ���ε�                      
                      <input type="file" name="p_main_img" id="p_main_img" class="logbox"  style="width:370" onChange="img_view('p_main_img_area',this.value);" /></td>
					  <td>
						<img id='p_main_img_area' src="/img/photo_no.gif" width="40" height="40"  style="display:block;">
					  </td>
                </tr>
                <tr>
                  <td height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> �ڵ��ǰ �߰� �̹���<span class="evfont">(300*300size ����)</span></td>
                  <td><img src="/img/icon00.gif" align=absmiddle> �̹��� ���ε�
                    <input type="file" name="p_base_img[]" id="p_base_img_0" class="logbox"  style="width:370" onChange="img_view('p_base_img_area_0',this.value); add_index('base',1);" /></td>
				  <td>
						<img id='p_base_img_area_0' src="/img/photo_no.gif" width="40" height="40"  style="display:block;">
					  </td>
                  </tr>
				  <tr>
                  <td height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> �ڵ��ǰ �߰� �̹���<span class="evfont">(300*300size ����)</span></td>
                  <td><img src="/img/icon00.gif" align=absmiddle> �̹��� ���ε�
                    <input type="file" name="p_base_img[]" id="p_base_img_1" class="logbox"  style="width:370" onChange="img_view('p_base_img_area_1',this.value); add_index('base',2);" /></td>
					<td>
						<img id='p_base_img_area_1' src="/img/photo_no.gif" width="40" height="40"  style="display:block;">
					  </td>
                  </tr>
				  <tr>
                  <td height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> �ڵ��ǰ �߰� �̹���<span class="evfont">(300*300size ����)</span></td>
                  <td><img src="/img/icon00.gif" align=absmiddle> �̹��� ���ε�
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
// 30���� ���̾ƿ��� �ִ�.
for ($i=0; $i<30; $i++ ) {
?>
				<div id="etc_img_area_<?=$i?>" style="display:none;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
						<td width="250" height="20" class="intitle">
							<img src="/img/pop_icon.gif"  align="absmiddle" /> �ڵ��ǰ �߰�  �̹���<span class="evfont">(300*300size ����) </span>
						</td>
						<td>
							<img src="/img/icon00.gif" align=absmiddle> �̹��� ���ε�<span class="evfont"><font color=FF5B5C >(100ĳ��)</font></span>
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
                    <td style="padding:15 15 15 15"  class="intext"><img src="/img/icon_oh.gif" align="absmiddle"/> <b><font color="724ECA">���� �̹��� ����� ����ϴ� ��� :</font></b> ���� �̹����� ��� �� �� �ִ� ���θ� Ȩ������, ī��, ��α� � �̹��� ������ ���ε��� ��, �̹����� URL �ּҸ�
					 �����ؼ�
					 <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>

					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�Է��ϸ� <b><font color="#333333"><u>����� �̹��� ���</u></font></b>�� �����մϴ�. </td>
                  </tr>
                </table>
                <table width="100" height="18" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                </table>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="250" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> �ڵ��ǰ ���� �̹���1 <span class="evfont">(����830�ȼ� ����) </span></td>
                    <td><img src="/img/icon00.gif" align=absmiddle> URL ��ũ(����)                      
                      <input name="p_desc_img_txt_1" id="p_desc_img_txt_1" type="text" class="logbox"  style="width:361" value="<?if ( $txt_desc_arr[0] ) echo $txt_desc_arr[0]; else echo"http://"; ?>" /></td>
					  <td rowspan="2"><img id='p_desc_img_area_1' src="/img/photo_no.gif" width="40" height="40"  style="display:block;"></td>
                    </tr>
                  <tr>
                    <td height="24" class="intitle" >&nbsp;</td>
                    <td><img src="/img/icon00.gif" align=absmiddle> �̹��� ���ε�(100ĳ��)
                      <input type="file" name="p_desc_img[]" id="p_desc_img_1" class="logbox"  style="width:318" onChange="chkCashDescImg(1); img_view('p_desc_img_area_1',this.value); add_index('desc',1);" /></td>
                  </tr>
				  
				  <tr>
                    <td width="250" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> �ڵ��ǰ ���� �̹���2 <span class="evfont">(����830�ȼ� ����) </span></td>
                    <td><img src="/img/icon00.gif" align=absmiddle> URL ��ũ(����)                      
                      <input name="p_desc_img_txt_2" id="p_desc_img_txt_2" type="text" class="logbox"  style="width:361" value="<?if ( $txt_desc_arr[1] ) echo $txt_desc_arr[1]; else echo"http://"; ?>" /></td>
					  <td rowspan="2"><img id='p_desc_img_area_2' src="/img/photo_no.gif" width="40" height="40" style="display:block;"></td>
                    </tr>
                  <tr>
                    <td height="24" class="intitle" >&nbsp;</td>
                    <td><img src="/img/icon00.gif" align=absmiddle> �̹��� ���ε�(100ĳ��)
                      <input type="file" name="p_desc_img[]" id="p_desc_img_2" class="logbox"  style="width:318" onChange="chkCashDescImg(2); img_view('p_desc_img_area_2',this.value); add_index('desc',2);" /></td>
                  </tr>
				  <tr>
                    <td width="250" height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> �ڵ��ǰ ���� �̹���3 <span class="evfont">(����830�ȼ� ����) </span></td>
                    <td><img src="/img/icon00.gif" align=absmiddle> URL ��ũ(����)                      
                      <input name="p_desc_img_txt_3" id="p_desc_img_txt_3" type="text" class="logbox"  style="width:361" value="<?if ( $txt_desc_arr[2] ) echo $txt_desc_arr[2]; else echo"http://"; ?>" /></td>
					  <td rowspan="2"><img id='p_desc_img_area_3' src="/img/photo_no.gif" width="40" height="40"  style="display:block;"></td>
                    </tr>
                  <tr>
                    <td height="24" class="intitle" >&nbsp;</td>
                    <td> <img src="/img/icon00.gif" align=absmiddle> �̹��� ���ε�(100ĳ��)
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
                    <td width="100" height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� �� </td>
                    <td width="311">
					
					<input type="text" name="p_title" id="p_title" class="logbox" value="<?=$p_title?>" style="width:584;" maxlength="100" /></td>
                    </tr>

                  <tr>
                    <td height="6" colspan="2" ></td>
                  </tr>
                 <tr>
                    <td height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� �� </td>
                    <td width="311">
                        <textarea name="p_info" id="p_info" class="memobox" style="width:584; height:50;"><?=$p_info?></textarea>
                     
                   </td>
                    </tr>
					 <tr>
                    <td height="6" colspan="2" ></td>
                  </tr>
                 <tr>
                    <td height="24" class="intitle" style="LETTER-SPACING: 1px"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� �� </td>
                    <td width="311">
                        <textarea name="p_desc" id="p_desc" class="memobox"  style="width:584; height:80;"><?=$p_desc?></textarea>
                     
                   </td>
                    </tr>
					<tr>
                    <td height="6" colspan="2" ></td>
                  </tr>
                 <tr>
                    <td width="100" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /><b><font color="724ECA"> �����ڵ𰡰� </b></font></td>
                    <td><input type="text" name="p_price" id="p_price" value="<?=$p_price?>" class="logbox"  style="width:100" />
                      ��   &nbsp;&nbsp;&nbsp; * ���θ� �Ǵ� �̴ϼ� ��� ���� �Ǹŵǰ� �ִ� �ݾ��� �Է����ּ���.</td>
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
                    <td width="119" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> �ڵ𱸸� URL </td>
                    <td><input name="p_url" id="p_url" type="text" class="logbox"  style="width:361" value="<?=$p_url?>" />
                      <span class="infont">�ڵ�緯���� ��ưŬ�� <?=$CASHCODE['CC53'][2]?>ȸ ���ĺ��� <font color="FF0078"><?=$CASHCODE['CC53'][1]?>ĳ��</font> ����(1IP��, CPC���� <img src="/img/btn_cpc.gif" alt="CPC�����̶�?" border="0"  align="absmiddle" onclick="MM_openBrWindow('pop_cpc.php','','width=300,height=230')" style="cursor:hand;" />) </span></td>
                  </tr>
				  <tr>
                    <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td colspan="3" >�� �� ��ǰ�� ���� ������ �� �ִ� URL�� �Է��� �ּ��� </td>
                  </tr>
                  <tr>
                    <td height="18" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td colspan="3" >�� <b><font color="#333333">[�߿����] </font></b>ĳ���� ������ ���� <b>10,000ĳ������ �ܻ�!!</b> (��, �ڵ��ǰ�� �߰������ �� �� �����ϴ�.)</td>
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
                    <td height="24" ><span class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> ������ ��õ�ڵ� �ɻ��û (���� <?=$CASHCODE['CC56'][1]?>ĳ��) :  
                     
                          <input type="checkbox" name="p_judgment" id="p_judgment" value="R" onClick="chkCashJudgment();" <?if ($p_judgment=="R") echo " checked";?> />
                          </span>�ɻ縦 ��û�մϴ�.                      </td>
                    <td align="right" ><img src="/img/btn_today.gif" width="157" height="20" border="0" onclick="MM_openBrWindow('pop_cpc.php','','width=300,height=230')" style="cursor:hand;" /></td>
                  </tr>
                  <tr>
                    <td height="24" colspan="4"  >�� �ɻ縦 ����� ���, �� �����ϱ��� <font color="FF0078">7�ϵ��� �򰡴�� ����Ʈ�Ӹ� �ƴ϶� ������ ��õ�ڵ�(��������)</font>�� �˴ϴ�. </td>
                    </tr>
                  <tr>
                    <td height="20" colspan="4" >�� �ɻ�Ⱓ������ �򰡴�� ����Ʈ�� ����� ���� �ʽ��ϴ�.(�ɻ��û�� ���� ������, ��� ��ϵ˴ϴ�.) </td>
                    </tr>
					 <tr>
                    <td height="20" colspan="4" >�� �ɻ�Ⱓ : ��û �� 24�ð� �̳� <u><font color="#333333">(�ɻ縦 ������� ���ϴ��� ��û�� ĳ���� ȯ�ҵ��� �ʽ��ϴ�.) </font></u></td>
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
                    <td width="119" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� �� </td>
                    <td>
					<select name="p_auto_extend" id="p_auto_extend" class="logbox"  style="width:150" onChange="chkCashAutoExtend();">
                      <option value="0" <?if ($p_auto_extend=="0") echo " selected";?>>�������</option>
                      <option value="1" <?if ($p_auto_extend=="1") echo " selected";?>>1�ֿ���(2�ְ� ����)</option>
                      <option value="2" <?if ($p_auto_extend=="2") echo " selected";?>>2�ֿ���(3�ְ� ����)</option>
                      <option value="3" <?if ($p_auto_extend=="3") echo " selected";?>>3�ֿ���(4�ְ� ����)</option>
                    </select>
                      �ҿ�Ǵ� ĳ�� : <font color="FF0078"><span id="p_auto_extend_cash">0</span> ĳ��</font></td>
                  </tr>
                  <tr>
                    <td height="24" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td colspan="3" >�� �⺻�򰡱Ⱓ(1����)�� ������ ��÷�� ��ǥ�� �Ϸ�Ǿ, ������ �Ⱓ���� ������ ��� �������� �ڵ� �űԵ���� �˴ϴ�. </td>
                  </tr>
                  <tr>
                    <td height="18" class="intitle"  style="LETTER-SPACING: 1px">&nbsp;</td>
                    <td colspan="3" ><font color="#FFFFFF">��</font> (1���ϰ� ���� �������� �ٽ� �ʱ�ȭ �Ǿ� ��ϵ˴ϴ�.) </td>
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
                          <td height="26" align="center" class="intitle">�׸�</td>
                          <td width="80" align="center" class="intitle">����</td>
                          <td width="80" align="center" class="intitle">�ܰ�</td>
                          <td width="80" align="center" class="intitle">���ĳ��</td>
                        </tr>
                        <tr>
                          <td height="1" colspan="4" bgcolor="E0295A"></td>
                        </tr>
                      </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="27" align="center" bgcolor="F9F9F9">�űԵ��</td>
                            <td width="80" align="center" bgcolor="F9F9F9"><?=$info_reg_str?></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont" ><?=$CASHCODE['CC59'][1]?></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont"><b><font color="#009933"><span id="info_reg_cash"><?=$info_reg_cash?></span></font></b></td>
                          </tr>
						   <tr>
                            <td height="1" colspan="4" bgcolor="#E0E0E0"></td>
                          </tr>
                          <tr>
                            <td height="27" align="center">�߰�Ű����</td>
                            <td align="center"><?=$info_kwd_sum?>��</td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont" ><?=$CASHCODE['CC57'][1]?></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont"><b><font color="#009933"><span id="info_kwd_cash"><?=$info_kwd_cash?></span></font></b></td>
                          </tr>
						   <tr>
                            <td height="1" colspan="4" bgcolor="#E0E0E0"></td>
                          </tr>
                          <tr>
                            <td height="27" align="center" bgcolor="F9F9F9">��ǰ�̹���</td>
                            <td align="center" bgcolor="F9F9F9"><span id="info_img_count">0</span>��</td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont" ><?=$CASHCODE['CC58'][1]?></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont"><b><font color="#009933"><span id="info_img_cash">0</span></font></b></td>
                          </tr>
						   <tr>
                            <td height="1" colspan="4" bgcolor="#E0E0E0"></td>
                          </tr>
                          <tr>
                            <td height="27" align="center">��õ�ڵ�</td>
                            <td align="center"><span id="info_judgment_ox">X</span></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont" ><?=$CASHCODE['CC56'][1]?></td>
                            <td width="80" align="center" bgcolor="F9F9F9" class="evfont"><b><font color="#009933"><span id="info_judgment_cash">0</span></font></b></td>
                          </tr>
						   <tr>
                            <td height="1" colspan="4" bgcolor="#E0E0E0"></td>
                          </tr>
                          <tr>
                            <td height="27" align="center" bgcolor="F9F9F9">�ڵ�����</td>
                            <td align="center" bgcolor="F9F9F9"><span id="info_auto_extend_count">0</span>��</td>
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
                            <td width="152" align="center" bgcolor="FEB7B7" style="padding:7 5 5 5"><b><font color="CC0000">�հ� : <span id="info_total_cash">0</span>ĳ�� </font></b></td>
                            <td align="center" bgcolor="#FFFFFF" style="padding:7 5 5 5">��밡���� ĳ�� <?=$mem_cash?>ĳ�� <img src="/img/btn_add.gif" border="0"  align="absmiddle" onClick="alert('������');" style="cursor:hand;" /></td>
                          </tr>
                        </table></td>
                      <td width="20">&nbsp;</td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style='border:1 dotted #BFBFBF;'>
                        <tr>
                          <td style="padding:15 15 15 15" class="intext"><img src="/img/icon_aa.gif"  align="absmiddle" />TOP10���� ������ �ڵ��ǰ�� ��ȸ���Ե��� ����� ����� �� �ֵ��� ���ֵ��� <font color="#000000"><u>�ڵ�ž�� ����Ʈ �������� ���������� ����</u></font>�� �˴ϴ�.
						    <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td></td>
                              </tr>
                            </table>
						    <img src="/img/icon_aa.gif"  align="absmiddle" />��ǰ���޿� ���� �ǹ��� å���� �������� �ش� ��ǰ�� ����� ������ �ֽ��ϴ�. �ڵ�ž���� ��ǰ��� �� ��÷ �ý��� ���� ������ ���Դϴ�. 
						    <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td></td>
                              </tr>
                            </table>
						    <img src="/img/icon_aa.gif"  align="absmiddle" />�����ϱ�� �� ��ǰ�� ��ǰ�������ǰ� ������ ����, ��÷�� ��ǥ �� ������ ��÷�ڿ��� <font color="#000000"><u>�ִ� 7�� �̳��� ����</u></font>�ϴ� ���� ��Ģ���� �մϴ�. 
						    <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td></td>
                              </tr>
                            </table>
						    <img src="/img/icon_aa.gif"  align="absmiddle" />
						  ��ǰ�� ���� ������������ �������, ��Ͻ� �ɸ��뿡 �̿Ͱ��� ����� ����ؾ� �մϴ�. 
						  <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td></td>
                            </tr>
                          </table>
						  <img src="/img/icon_aa.gif"  align="absmiddle" />�����ϱ�� �� ��ǰ�� ���ٸ� ������ ���ų� Ÿ������ ���� ���� ������ ������ ������ �ǰų�, �����ϱ�� �� ����� �ٸ� ��ǰ�� ���޵� ��쿡 �߻��� �� �ִ� <font color="#DD2457">��������� ��� å���� �����</font>���� �ֽ��ϴ�. </td>
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
				<img src="/img/btn_save.gif" alt="�ӽ�����" width="120" height="25" border="0" onClick="goOk('T');" style="cursor:hand;" />
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
// ���� �̹��� �Ҵ�
document.getElementById("p_main_img_area").src = img_dir + '<?=$old_p_main_img?>';

// �⺻ �̹��� �Ҵ�
if ( '<?=trim($arr_base_img[0])?>' ) {
	document.getElementById("p_base_img_area_0").src = img_dir + '<?=trim($arr_base_img[0])?>';
}
if ( '<?=trim($arr_base_img[1])?>' ) {
	document.getElementById("p_base_img_area_1").src = img_dir + '<?=trim($arr_base_img[1])?>';
}
if ( '<?=trim($arr_base_img[2])?>' ) {
	document.getElementById("p_base_img_area_2").src = img_dir + '<?=trim($arr_base_img[2])?>';
}

// �⺻,���� �̹��� ����
g_etc_img_count = parseInt("<?=sizeof($arr_etc_img)-1?>");
g_desc_img_count = parseInt("<?=sizeof($img_desc_arr)?>");

// �⺻ �̹��� �Ҵ�(����)
for ( var i=0; i<g_etc_img_count; i++ ) {
	js_var = eval("js_etc_img_"+i);
	if ( js_var ) {
		document.getElementById("p_etc_img_area_"+i).src = img_dir + js_var;
	}
}

//alert(g_desc_img_count);

// ���� �̹��� �Ҵ�
for ( var i=0; i<g_desc_img_count; i++ ) {
	js_var = eval("js_desc_img_"+i);
	if ( js_var ) {
		document.getElementById("p_desc_img_area_"+(i+1)).src = img_dir + js_var;
	}
}

// ���̾� ����
for ( j=0; j<g_etc_img_count; j++ ) {
	document.getElementById("etc_img_area_"+j).style.display = "block";
}

// �ڵ����尪
g_auto_extend_count = parseInt("<?=$p_auto_extend?>");

// ��ǰ�̹��� ���ĳ�ø� ���Ѵ�.
edit_img_cash = (g_etc_img_count + g_desc_img_count)*parseInt("<?=$CASHCODE['CC58'][1]?>");
document.getElementById("info_img_cash").innerHTML = edit_img_cash;

// ��õ�ڵ� �ɻ�ĳ�ø� ���Ѵ�.
edit_judgment_cash = <?if ($p_judgment=="R") echo "parseInt('1')";else echo "parseInt('0')";?>*parseInt("<?=$CASHCODE['CC56'][1]?>");
document.getElementById("info_judgment_cash").innerHTML = edit_judgment_cash;

// �ڵ����� ���ĳ�ø� ���Ѵ�.
edit_auto_extend_cash = parseInt("<?=$p_auto_extend?>")*parseInt("<?=$CASHCODE['CC55'][1]?>");
document.getElementById("p_auto_extend_cash").innerHTML = edit_auto_extend_cash;
document.getElementById("info_auto_extend_cash").innerHTML = edit_auto_extend_cash;

// �հ谪�� ���Ѵ�.
document.getElementById("info_total_cash").innerHTML = parseInt("<?=$info_reg_cash?>") + parseInt("<?=$info_kwd_cash?>") + edit_img_cash + edit_judgment_cash + edit_auto_extend_cash;



</script>
<? } ?>
<a href="javascript:alert(g_etc_img_count);">aaaa</a>
<? include "../include/_foot.php"; ?>

