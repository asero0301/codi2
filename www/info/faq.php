<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/info/faq.php
 * date   : 2008.12.22
 * desc   : FAQ
 *******************************************************/
require_once "../inc/common.inc.php";

$mainconn->open();

$page = trim($_REQUEST['page']);

if ( $page == "" ) $page = 1;

$cond = " where 1 ";

// record count
$sql = "select count(*) from tblFaq $cond ";
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
$orderby = " order by faq_reg_dt desc ";

$sql = "select * from tblFaq $cond $orderby limit $first, $PAGE_SIZE ";
//echo "row : $sql <br>";
$res = $mainconn->query($sql);

$LIST = "";
$article_num = $total_record - $PAGE_SIZE*($page-1);
while ( $row = $mainconn->fetch($res) ) {
	$faq_idx		= trim($row['faq_idx']);
	$faq_categ		= trim($row['faq_categ']);
	$faq_title		= strip_str(trim($row['faq_title']),"V");
	$faq_content	= strip_str(trim($row['faq_content']),"V");
	$faq_reg_dt		= trim($row['faq_reg_dt']);

	$LIST .= "
        <tr onClick=\"qClick('$article_num');\" style='cursor:hand;'>
          <td width='50' height='30' align='center'>$article_num</td>
          <td width='595'><img src='/img/icon_q.gif'  align='absmiddle'> $faq_title </td>
        </tr>
		
		<tr id='a{$article_num}' style='display:none;'>
          <td height='28' colspan='2' class='faqATp'><table width='100' border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
            <table width='100%' border='0' cellspacing='0' cellpadding='0' style='border:1 dotted #BFBFBF;'>
            <tr>
              <td bgcolor='F9F9F9' class='intext' style='padding:10 10 10 10'><img src='/img/icon_a.gif'  align='absmiddle'> $faq_content </td>
            </tr>
          </table>
            <table width='100' border='0' cellspacing='0' cellpadding='0'>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height='1' colspan='2' bgcolor='#CCCCCC' ></td>
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

$mainconn->close();

require_once "../include/_head.php";
?>

<script LANGUAGE="JavaScript">
<!--
function qClick(num) {
	var obj = document.getElementById("a"+num);
	if ( obj.style.display == "none" ) {
		obj.style.display = "block";
	} else {
		obj.style.display = "none";
	}
}
//-->
</script>



<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" valign="top">
        <table width="200" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			
			 <!-- 마이페이지 시작 //-->
			
			<? require_once "../include/left_info.php" ?>
			
			 <!-- 마이페이지 시작 //-->
			</td>
          </tr>
        </table>
      
        </td>
    <td width="15"></td>
    <td valign="top"><table width="645" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="19"><img src="/img/bar01.gif" width="19" height="37" /></td>
        <td background="/img/bar03.gif"><b><font color="FFFC11">FAQ :</font></b> <font color="#FFFFFF">코디탑텐의 FAQ입니다.</font> </td>
        <td width="19"><img src="/img/bar02.gif" width="19" height="37" /></td>
      </tr>
    </table>
      <table width="100" height="6" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="6" colspan="2" bgcolor="FF5B5C" ></td>
        </tr>
        <tr>
          <td width="50" height="28" align="center" bgcolor="FFDADA"><font color="CC0000">번호</font></td>
          <td align="center" bgcolor="FFDADA"><font color="CC0000">질문내용</font></td>
        </tr>
        <tr>
          <td height="1" colspan="2" bgcolor="FF5B5C" ></td>
        </tr>
      </table>
      <table width="645" border="0" cellpadding="0" cellspacing="0">
      
	   
<?=$LIST?>

        <tr>
          <td height="6" colspan="2" bgcolor="FF5B5C" ></td>
        </tr>
      </table>
      <table width="645" height="45" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center">
<?
if ( $total_record > 0 ) 
echo page_navi($page,$first_page,$last_page,$total_page,$block,$total_block,"/info/faq.php",$qry_str);
?>		  
		  </td>
        </tr>
      </table></td>
  </tr>
</table>
<? require_once "../include/_foot.php"; ?>