<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/_top.php
 * date   : 2008.08.07
 * desc   : Admin top html
 *******************************************************/
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title><?=$ADMIN_TITLE?></title>
<link rel = StyleSheet HREF='<?=$ADMIN_DIR?>style_ad.css' type='text/css' title='thehigh CSS'>
<script language="JavaScript" src="/js/common.js"></script>
<script language="JavaScript" src="/js/codi.js"></script>
<script language="JavaScript" src="/js/popup.js"></script>
<script language="JavaScript" src="/js/ajax.js"></script>
</head>

<body bgcolor="#F9F9F2" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="150" border="0" cellpadding="0" cellspacing="0" background="<?=$ADMIN_DIR?>img/top_bg.jpg">
  <tr>
    <td width="220" align="center"><a href="http://www.golfro.co.kr/admin/"><img src="<?=$ADMIN_DIR?>img/top_logo.jpg" width="200" height="150" border=0></a></td>
    <td align="left"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"><table width="700" border="0" cellspacing="0" cellpadding="2" >

            <tr>
              <td width="110"><font color="#FFFFFF">�� <b>ȸ������</b></font></td>
              <td  class="evmem">
				<a href="/manage/member/member_list.php">��üȸ��</a> &nbsp;&nbsp; 
				<a href="/manage/member/member_list.php?mem_kind=U">�Ϲ�ȸ��</a> &nbsp;&nbsp;  
				<a href="/manage/member/member_list.php?mem_kind=S">��ȸ��</a> &nbsp;&nbsp;  
				<a href="/manage/member/member_lotto_grade_config.php">�Ϲ�ȸ�� ��÷��޼���</a> &nbsp;&nbsp;  
				<a href="/manage/member/shop_cash_config.php">��ȸ�����ʽ�ĳ������</a> &nbsp;&nbsp;  
				<a href="/manage/member/member_write.php">ȸ���߰�</a> &nbsp;&nbsp;
				<a href="/manage/member/bankbook_list.php">�������Ա� ó��</a>
			  </td>
            </tr>

            <tr>
              <td><font color="#FFFFFF">�� <b>�ڵ��ǰ����</b> </font></td>
              <td class="evmem">
				<a href="/manage/product/wait_list.php?judge=R">�ɻ��û �ڵ�</a> &nbsp;&nbsp; 
				<a href="/manage/product/ing_list.php">�������� �ڵ�</a> &nbsp;&nbsp; 
				<a href="/manage/product/ed_list.php">�򰡿Ϸ�� �ڵ�</a> &nbsp;&nbsp; 
				<a href="/manage/product/all_list.php">�ڵ��ǰ ��ü����</a> &nbsp;&nbsp; 
				<a href="/manage/product/codi_config.php">�ڵ��ǰ ��ϼ���</a></td>
            </tr>
            <tr>
              <td><font color="#FFFFFF">�� <b>��ŷ����</b> </font></td>
              <td class="evmem">
				<a href="#">�ڵ��������</a> &nbsp;&nbsp; 
				<a href="#">����Ʈ������</a> &nbsp;&nbsp; 
				<a href="#"> ������ ����</a>
			  </td>
            </tr>
            <tr>
              <td><font color="#FFFFFF">�� <b>�Խ��ǰ��� </b></font></td>
              <td class="evmem">
				<a href="/manage/board/notice_list.php">��������</a> &nbsp;&nbsp; 
				<a href="/manage/board/ucc_list.php">�ڵ�UCC</a> &nbsp;&nbsp; 
				<a href="/manage/board/pr_list.php">��PR�Խ���</a>  &nbsp;&nbsp; 
				<a href="/manage/board/bad_list.php">�ҷ����Ű�</a>  &nbsp;&nbsp; 
				<a href="/manage/board/faq_list.php">FAQ</a>  &nbsp;&nbsp; 
				<a href="/manage/board/qna_list.php">QNA</a> 
				<!--<a href="#">�Խ��� ����</a>-->
			  </td>
            </tr>
            <tr>
              <td><font color="#FFFFFF">�� <b>���������� </b></font></td>
              <td class="evmem">
				<a href="/manage/contents/focus_list.php" >��Ŀ������</a> &nbsp;&nbsp; 
				<a href="/manage/contents/popup_list.php">�˾�����</a> &nbsp;&nbsp; 
				<a href="/manage/contents/banner_list.php">��ʰ���</a> &nbsp;&nbsp; 
				<!--<a href="/manage/contents/kwd_list.php">Ű�������</a> &nbsp;&nbsp; -->
				Ű�������(<a href="/manage/contents/kwd_categ.php">�з���</a> / <a href="/manage/contents/kwd_main.php">����</a> / <a href="/manage/contents/kwd_new.php">�ű�</a>) &nbsp;&nbsp;
				<a href="/manage/contents/toadmin_list.php">�����ڿ���</a>
			  </td>
            </tr>
            <tr>
              <td><font color="#FFFFFF">�� <b>��������</b> </font></td>
              <td class="evmem">
				<a href="#">��������</a> &nbsp;&nbsp; 
				<a href="#">�����󼼰���</a>
			  </td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>


<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="#FFFFFF" height=1  colspan="2" ></td>
  </tr>
  <tr>
    <td height="25" align="left"  bgcolor="#000000"> </td>
	 <td height="25" align="right"  bgcolor="#000000" style="PADDING-top: 4px;" class="tienom"><a href="<?=$ADMIN_URL?>"><font color="C7DD99">�����ڸ���</font></a>  <font color="C7DD99">:</font>   <a href="<?=$WEB_URL?>" target="_blank"><font color="C7DD99">Ȩ������ ��â</font></a>  <font color="C7DD99">:</font>  <a href="<?=$ADMIN_DIR."logout.php"?>"><font color="C7DD99">�α׾ƿ�</font></a> &nbsp; &nbsp; &nbsp; &nbsp; </td>
  </tr>
</table>



<table width="100%" border="0" cellspacing="0" cellpadding="20">
  <tr>
    <td align="center" valign="top" bgcolor="#FFFFFF">
	
