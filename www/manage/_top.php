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
              <td width="110"><font color="#FFFFFF">■ <b>회원관리</b></font></td>
              <td  class="evmem">
				<a href="/manage/member/member_list.php">전체회원</a> &nbsp;&nbsp; 
				<a href="/manage/member/member_list.php?mem_kind=U">일반회원</a> &nbsp;&nbsp;  
				<a href="/manage/member/member_list.php?mem_kind=S">샵회원</a> &nbsp;&nbsp;  
				<a href="/manage/member/member_lotto_grade_config.php">일반회원 당첨등급설정</a> &nbsp;&nbsp;  
				<a href="/manage/member/shop_cash_config.php">샵회원보너스캐쉬설정</a> &nbsp;&nbsp;  
				<a href="/manage/member/member_write.php">회원추가</a> &nbsp;&nbsp;
				<a href="/manage/member/bankbook_list.php">무통장입금 처리</a>
			  </td>
            </tr>

            <tr>
              <td><font color="#FFFFFF">■ <b>코디상품관리</b> </font></td>
              <td class="evmem">
				<a href="/manage/product/wait_list.php?judge=R">심사신청 코디</a> &nbsp;&nbsp; 
				<a href="/manage/product/ing_list.php">평가진행중 코디</a> &nbsp;&nbsp; 
				<a href="/manage/product/ed_list.php">평가완료된 코디</a> &nbsp;&nbsp; 
				<a href="/manage/product/all_list.php">코디상품 전체보기</a> &nbsp;&nbsp; 
				<a href="/manage/product/codi_config.php">코디상품 등록설정</a></td>
            </tr>
            <tr>
              <td><font color="#FFFFFF">■ <b>랭킹관리</b> </font></td>
              <td class="evmem">
				<a href="#">코디순위관리</a> &nbsp;&nbsp; 
				<a href="#">베스트샵관리</a> &nbsp;&nbsp; 
				<a href="#"> 인증샵 관리</a>
			  </td>
            </tr>
            <tr>
              <td><font color="#FFFFFF">■ <b>게시판관리 </b></font></td>
              <td class="evmem">
				<a href="/manage/board/notice_list.php">공지사항</a> &nbsp;&nbsp; 
				<a href="/manage/board/ucc_list.php">코디UCC</a> &nbsp;&nbsp; 
				<a href="/manage/board/pr_list.php">샵PR게시판</a>  &nbsp;&nbsp; 
				<a href="/manage/board/bad_list.php">불량샵신고</a>  &nbsp;&nbsp; 
				<a href="/manage/board/faq_list.php">FAQ</a>  &nbsp;&nbsp; 
				<a href="/manage/board/qna_list.php">QNA</a> 
				<!--<a href="#">게시판 설정</a>-->
			  </td>
            </tr>
            <tr>
              <td><font color="#FFFFFF">■ <b>컨텐츠관리 </b></font></td>
              <td class="evmem">
				<a href="/manage/contents/focus_list.php" >포커스관리</a> &nbsp;&nbsp; 
				<a href="/manage/contents/popup_list.php">팝업관리</a> &nbsp;&nbsp; 
				<a href="/manage/contents/banner_list.php">배너관리</a> &nbsp;&nbsp; 
				<!--<a href="/manage/contents/kwd_list.php">키워드관리</a> &nbsp;&nbsp; -->
				키워드관리(<a href="/manage/contents/kwd_categ.php">분류별</a> / <a href="/manage/contents/kwd_main.php">메인</a> / <a href="/manage/contents/kwd_new.php">신규</a>) &nbsp;&nbsp;
				<a href="/manage/contents/toadmin_list.php">관리자에게</a>
			  </td>
            </tr>
            <tr>
              <td><font color="#FFFFFF">■ <b>결제관리</b> </font></td>
              <td class="evmem">
				<a href="#">결제관리</a> &nbsp;&nbsp; 
				<a href="#">결제상세관리</a>
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
	 <td height="25" align="right"  bgcolor="#000000" style="PADDING-top: 4px;" class="tienom"><a href="<?=$ADMIN_URL?>"><font color="C7DD99">관리자메인</font></a>  <font color="C7DD99">:</font>   <a href="<?=$WEB_URL?>" target="_blank"><font color="C7DD99">홈페이지 새창</font></a>  <font color="C7DD99">:</font>  <a href="<?=$ADMIN_DIR."logout.php"?>"><font color="C7DD99">로그아웃</font></a> &nbsp; &nbsp; &nbsp; &nbsp; </td>
  </tr>
</table>



<table width="100%" border="0" cellspacing="0" cellpadding="20">
  <tr>
    <td align="center" valign="top" bgcolor="#FFFFFF">
	
