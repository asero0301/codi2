<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/bad_shop_write.php
 * date   : 2009.01.22
 * desc   : �ҷ��� �ۼ�
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

// �������� üũ
auth_chk($RURL);

// �Ϲ�ȸ���� ����
/*
if ( $_SESSION['mem_kind'] != "S" ) {
	echo "<script>alert('��ȸ���� �ۼ������մϴ�'); location.href='/board/bad_shop_list.php';</script>";
	exit;
}
*/

$mode = trim($_REQUEST['mode']);
$bad_idx = trim($_REQUEST['bad_idx']);

if ( !$mode ) $mode = "I";

$mainconn->open();

if ( $mode == "E" ) {
	$sql = "select * from tblBadShop where bad_idx = $bad_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$shop_idx		= trim($row['shop_idx']);
	$mem_id			= trim($row['mem_id']);
	$bad_title		= trim($row['bad_title']);
	$bad_content	= trim($row['bad_content']);
	$bad_file		= trim($row['bad_file']);
	$bad_view		= trim($row['bad_view']);
	$bad_ip			= trim($row['bad_ip']);
	$bad_reg_dt		= trim($row['bad_reg_dt']);

	if ( $bad_file ) {
		$arr_file = explode(";", $bad_file);
		$cnt = 0;
		foreach ( $arr_file as $k => $v ) {
			if ( trim($v) == "" ) continue;
			$cnt++;
			$t_bad_file = trim($v);
			$t_bad_file = $UP_URL."/attach/".$t_bad_file;
			${'file_'.$cnt.'_view'} .= "<a href='$t_bad_file' rel='lightbox'><img src='$t_bad_file' border='0' width='20' height='20' align='absmiddle' style='cursor:hand;' /></a>";
		}
	}

	$bad_title	= strip_str($bad_title);
	$bad_content= strip_str($bad_content);

}

$sql = "select shop_idx, shop_name from tblShop order by shop_idx ";
$res = $mainconn->query($sql);
$sel_list = "";
while ( $row = $mainconn->fetch($res) ) {
	$t_shop_idx = $row['shop_idx'];
	$t_shop_name = $row['shop_name'];

	$sel = ( $shop_idx == $t_shop_idx ) ? " selected" : "";
	$sel_list .= "<option value='".$t_shop_idx."' $sel>".$t_shop_name."</option>";
}

$mainconn->close();
?>

<? require_once "../include/_head.php"; ?>

<script language="JavaScript" src="/wysiwyg/wysiwyg.js"></script>
<script language="JavaScript">
function goPrSubmit() {
	var f = document.board_frm;

	if ( f.shop_idx.value == "" ) {
		alert("���� �����ϼ���.");
		f.shop_idx.focus();
		return;
	}
	if ( f.bad_title.value == "" ) {
		alert("������ �Է��ϼ���");
		f.bad_title.focus();
		return;
	}
	if ( f.bad_content.value == "" ) {
		alert("������ �Է��ϼ���");
		f.bad_content.focus();
		return;
	}
	if ( document.getElementById("up_1").value ) {
		if ( checkExt(document.getElementById("up_1").value) == false ) return;
	}
	if ( document.getElementById("up_2").value ) {
		if ( checkExt(document.getElementById("up_2").value) == false ) return;
	}
	if ( document.getElementById("up_3").value ) {
		if ( checkExt(document.getElementById("up_3").value) == false ) return;
	}
	
	f.action = "/board/bad_shop_write_ok.php";
	f.encoding = "multipart/form-data";
	f.submit();
}
function checkExt(val) {
    var img_format = "\\.(gif|jpg|png)$";
    if((new RegExp(img_format, "i")).test(val)) return true;
    alert("jpg, gif, png ���ϸ� ���ε� �����մϴ�.");
    return false;
}
function file_offset_reset(num) {
	var f = document.board_frm;
	str = f.file_offset.value;
	obj = document.getElementById("up_"+num);
	
	if ( str.indexOf(num) == -1 && obj.value ) {
		f.file_offset.value = str + num + ";";
	}	
}
</script>
<table border="0" cellspacing="0" cellpadding="0">
<form id="board_frm" name="board_frm" method="post">
<input type="hidden" name="mode" id="mode" value="<?=$mode?>" />
<input type="hidden" name="bad_idx" id="bad_idx" value="<?=$bad_idx?>" />
<input type="hidden" name="old_file_list" id="old_file_list" value="<?=$bad_file?>" />
<input type="hidden" name="file_offset" id="file_offset" value="" />

  <tr>
    <td width="200" valign="top">
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- �Խ��� �޴� ���� //-->
			
			<? require_once "../include/left_board.php" ?>
			
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
        <td background="/img/bar03.gif"><b><font color="FFFC11">�ҷ��� �Ű� :</font></b> <font color="#FFFFFF">�ҷ����� �Ű��� �ּ���. �ش缥�� å�ӻ����� Ȯ�εǴ� ��� ��ġ�� ���ϰڽ��ϴ�.</font> </td>
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
                      <td style="padding:10 10 10 10" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">�ҷ��� �Ű� �Խ����� �� ����� <font color="FF0078">�Ϲ�ȸ���� ����</font>�մϴ�.</font> 

<table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td></td>
                      </tr>
                    </table>

                          <img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> ����, ����, �������� ȫ��/����, ��Ÿ �Խ��� ����ؿ� ��߳��� �Խù��� ���ٸ� �뺸���� ���� �Ǵ� ������ ��<br />
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�ֽ��ϴ�. </td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
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
                <td style="padding:15 15 15 15"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="80" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� �� </td>
                      <td>
						  <select name="shop_idx" id="shop_idx" class="logbox"  style="width:150">
							<option value="">::: �������ּ��� :::</option>
							<? echo $sel_list; ?>
						  </select>
					  </td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� </td>
                      <td><input type="text" name="bad_title" id="bad_title" class="logbox" value="<?=$bad_title?>" style="width:100%" /></td>
                    </tr>
                    <tr>
                       <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� </td>
                      <td>
					  <textarea name="bad_content" id="bad_content" class="memobox" type="editor" style="width:100%; height:300;"><?=$bad_content?>
					  </textarea>
					  </td>
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
                        <td width="80" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> �̹��� 1 </td>
                        <td valign='absmiddle'><input type="file" id="up_1" name="upfile[]" class="logbox"  style="width:95%" onChange="file_offset_reset('1');" />&nbsp;<?=$file_1_view?></td>
                      </tr>

					  <tr>
                        <td height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> �̹��� 2 </td>
                        <td valign='absmiddle'><input type="file" id="up_2" name="upfile[]" class="logbox"  style="width:95%" onChange="file_offset_reset('2');" />&nbsp;<?=$file_2_view?></td>
                      </tr>
					  
					  <tr>
                        <td height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> �̹��� 3 </td>
                        <td valign='absmiddle'><input type="file" id="up_3" name="upfile[]" class="logbox"  style="width:95%" onChange="file_offset_reset('3');" />&nbsp;<?=$file_3_view?></td>
                      </tr>
                    </table>
                </td>
              </tr>
          </table></td>
        </tr>
      </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="645" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
			<a href="#" onClick="goPrSubmit();"><img src="/img/btn_write_ok.gif" width="60" height="20" border="0" /></a>&nbsp;
			<a href="#" onClick="go_shop_pr();"><img src="/img/btn_cancle05.gif" width="60" height="20" border="0" /></a></td>
        </tr>
      </table></td>
  </tr>
</form>
</table>

<script language="javascript">
// lightbox �ε�
initLightbox();
</script>

<? include "../include/_foot.php"; ?>