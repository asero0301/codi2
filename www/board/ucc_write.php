<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/board/ucc_write.php
 * date   : 2009.01.16
 * desc   : �ڵ� ucc �ۼ� (��ü ī�װ�)
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";

// �������� üũ
auth_chk($RURL);

// �Ϲ�ȸ���� ����
if ( $_SESSION['mem_kind'] == "S" ) {
	echo "<script>alert('�Ϲ�ȸ���� �ۼ������մϴ�'); location.href='/board/ucc_list.php';</script>";
	exit;
}

$mode = trim($_REQUEST['mode']);
$categ = trim($_REQUEST['categ']);
$ucc_idx = trim($_REQUEST['ucc_idx']);

if ( !$mode ) $mode = "I";

if ( $mode == "E" ) {
	$mainconn->open();
	$sql = "select * from tblUcc where ucc_idx = $ucc_idx";
	$res = $mainconn->query($sql);
	$row = $mainconn->fetch($res);

	$ucc_categ		= trim($row['ucc_categ']);
	$mem_id			= trim($row['mem_id']);
	$ucc_title		= trim($row['ucc_title']);
	$ucc_content	= trim($row['ucc_content']);
	$ucc_file		= trim($row['ucc_file']);
	$ucc_view		= trim($row['ucc_view']);
	$ucc_ip			= trim($row['ucc_ip']);
	$ucc_reg_dt		= trim($row['ucc_reg_dt']);

	if ( $ucc_file ) {
		$arr_file = explode(";", $ucc_file);
		$cnt = 0;
		foreach ( $arr_file as $k => $v ) {
			if ( trim($v) == "" ) continue;
			$cnt++;
			$t_ucc_file = trim($v);
			$t_ucc_file = $UP_URL."/attach/".$t_ucc_file;
			${'file_'.$cnt.'_view'} .= "<a href='$t_ucc_file' rel='lightbox'><img src='$t_ucc_file' border='0' width='20' height='20' align='absmiddle' style='cursor:hand;' /></a>";
		}
	}

	$ucc_title		= strip_str($ucc_title);
	$ucc_content	= strip_str($ucc_content);

	$mainconn->close();
}
?>

<? require_once "../include/_head.php"; ?>

<script language="JavaScript" src="/wysiwyg/wysiwyg.js"></script>
<script language="JavaScript">
function goUccSubmit() {
	var f = document.board_frm;
	
	if ( f.ucc_title.value == "" ) {
		alert("������ �Է��ϼ���");
		f.ucc_title.focus();
		return;
	}
	if ( f.ucc_content.value == "" ) {
		alert("������ �Է��ϼ���");
		f.ucc_content.focus();
		return;
	}
	if ( f.ucc_categ.value == "" ) {
		alert("������ �����ϼ���");
		f.ucc_categ.focus();
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

	f.action = "/board/ucc_write_ok.php";
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
<input type="hidden" name="ucc_idx" id="ucc_idx" value="<?=$ucc_idx?>" />
<input type="hidden" name="old_file_list" id="old_file_list" value="<?=$ucc_file?>" />
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
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">�ڵ�UCC :</font></b> <font color="#FFFFFF">�ڵ� ��︱��? �ڵ���! �ڵ� ��εǸ� �ڵ��Ƿ�! ���� �ڵ� ������ ������ �ڵ�����!!</font> </td>
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
                      <td style="padding:10 10 10 10" class="intext"><img src="/img/icon_book.gif" width="14" height="15"  align="absmiddle" /> <font color="#333333">�ڵ� UCC �Խ����� �� ����� <font color="FF0078">�Ϲ�ȸ���� ����</font>�մϴ�. (��ȸ���� ��۸� ����)</font> 

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
                      <td width="80" height="24" class="intitle" ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� </td>
                      <td>
						  <select name="ucc_categ" id="ucc_categ" class="logbox"  style="width:150">
							<option value="">::: �������ּ��� :::</option>
							<?
							foreach ( $UCC_CATEG as $k => $v ) {
								if ( $k == $ucc_categ ) $sel = " selected";
								echo "<option value='".$k."' $sel>".$v[0]."</option>";
							}
							?>
						  </select>
					  </td>
                    </tr>
                    <tr>
                      <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� </td>
                      <td><input type="text" name="ucc_title" id="ucc_title" class="logbox" value="<?=$ucc_title?>" style="width:100%" /></td>
                    </tr>
                    <tr>
                       <td height="24" class="intitle"  ><img src="/img/pop_icon.gif"  align="absmiddle" /> �� �� </td>
                      <td>
					  <textarea name="ucc_content" id="ucc_content" class="memobox" type="editor" style="width:100%; height:300;"><?=$ucc_content?>
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
			<a href="#" onClick="goUccSubmit();"><img src="/img/btn_write_ok.gif" width="60" height="20" border="0" /></a>&nbsp;
			<a href="#" onClick="go_ucc('');"><img src="/img/btn_cancle05.gif" width="60" height="20" border="0" /></a></td>
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