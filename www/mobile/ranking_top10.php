<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/proc/make_weekly_codi_top10.php
 * date   : 2008.10.23
 * desc   : 분류별 랭킹 top 10
 *******************************************************/
require_once "../inc/common.inc.php";
require_once "../config/config.php";

header("Content-Type:text/html;charset=euc-kr");
header("Content-Encoding: utf-8");

$mainconn->open();

$prt_today = date("Y년 n월 j일", time());
$ret_arr = getWeekDay("last", time());

$f_date = $ret_arr[0];
$l_date = $ret_arr[1];

$p_cate = iconv("UTF-8", "CP949", trim($_REQUEST['p_cate']));
$sql = "select count(*) from tblRankProduct where rp_start_dt = '$f_date' and rp_end_dt = '$l_date'";

$record_cnt = $mainconn->count($sql);

if ( $record_cnt == 0 ) {
	$ret_arr = getWeekDay("last", time()-86400);
	$f_date = $ret_arr[0];
	$l_date = $ret_arr[1];
}

$f_date_detail = $f_date." 00:00:00";
$l_date_detail = $l_date." 23:59:59";

$prt_f_y = substr($f_date,0,4);
$prt_f_m = substr($f_date,5,2); $prt_f_m = ( substr($prt_f_m,0,1) == "0" ) ? substr($prt_f_m,-1) : $prt_f_m;
$prt_f_d = substr($f_date,8,2); $prt_f_d = ( substr($prt_f_d,0,1) == "0" ) ? substr($prt_f_d,-1) : $prt_f_d;
$prt_l_y = substr($l_date,0,4);
$prt_l_m = substr($l_date,5,2); $prt_l_m = ( substr($prt_l_m,0,1) == "0" ) ? substr($prt_l_m,-1) : $prt_l_m;
$prt_l_d = substr($l_date,8,2); $prt_l_d = ( substr($prt_l_d,0,1) == "0" ) ? substr($prt_l_d,-1) : $prt_l_d;



// tblProduct, tblShop, tblRankProduct
// 지난주 인기있었던 코디 10개를 추출한다 (상의,하의,아웃웨어,언더웨어,악세사리 한꺼번에)
$sql = "
select A.p_idx, A.p_title, A.p_main_img, A.shop_idx, B.shop_name, C.rp_score, C.rpc_rank,
(select count(*) from tblProductUpDown where p_idx=A.p_idx and p_u_reg_dt between '$f_date_detail' and '$l_date_detail') as up_cnt
from tblProduct A, tblShop B, tblRankProduct C
where 1
and A.p_idx = C.p_idx
and A.shop_idx = B.shop_idx
and C.p_categ = '$p_cate'
and C.rp_start_dt = '$f_date' and C.rp_end_dt = '$l_date'
order by C.rpc_rank asc
limit 10
";

//echo "main_sql : $sql <p>";

$res = $mainconn->query($sql);

$array = array();

while ( $row = $mainconn->fetch($res) ) {
	$obj = new stdClass;
	$obj->p_idx = trim($row['p_idx']);
	$obj->p_title = iconv("CP949", "UTF-8", strip_str(trim($row['p_title'])));
	$obj->p_main_img = trim($row['p_main_img']);
	$obj->shop_idx = trim($row['shop_idx']);
	$obj->shop_name = iconv("CP949", "UTF-8", trim($row['shop_name']));
	$obj->rp_score = trim($row['rp_score']);
	$obj->rpc_rank = trim($row['rpc_rank']);
	$obj->up_cnt = trim($row['up_cnt']);
	$obj->p_main_img = $UP_URL."/thumb/".$p_main_img;
	
//	print_r($obj);
	$array[] = $obj;
}


$mainconn->close();

echo json_encode($array);
?>