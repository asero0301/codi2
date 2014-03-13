<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/product/product_view.php
 * date   : 2008.10.20
 * desc   : 코디 상세보기
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/chk_frame.inc.php";

auth_chk( my64encode($_SERVER['REQUEST_URI']) );

$mainconn->open();

$mem_id = $_SESSION['mem_id'];


$mem_kind = $_SESSION['mem_kind'];
$p_idx = $_REQUEST['p_idx'];

$ret_arr = getWeekDay("last", time());
$f_day = $ret_arr[0];
$l_day = $ret_arr[1];

################################################################################
// 최근 1시간 이내 보지 않았으면 조회수를 증가시킨다.
if ( !$_COOKIE["cookie_product_view_".$p_idx] ) {
	$sql = "update tblProduct set p_view = p_view + 1 where p_idx = $p_idx ";
	$res = $mainconn->query($sql);
	if ( $res ) {	// 쿠키를 굽는다.
		setcookie("cookie_product_view_".$p_idx, "Y", time()+3600, "/", "coditop10.com");
	}
}

################################################################################
// 주간top10(베스트코디) 횟수
$sql = "
select count(*) from tblRankProduct where 1
and p_idx = $p_idx and rp_rank > 0 and rp_rank <= 10
and date_sub(rp_end_dt, INTERVAL 6 DAY) = rp_start_dt
";
//echo "sql : $sql <p>";
$best_codi_cnt = $mainconn->count($sql);

################################################################################
// tblProudct, tblProductEach, tblShop, tblRankProduct, tblProductUpDown, tblProductComment
// 서브쿼리로 한번에 처리
// 현재 진행중인 갯수만 취한다(up, down, 댓글)
$sql = "
select A.*, B.p_e_idx, B.end_dt, C.shop_name, C.shop_medal, C.shop_url,
ifnull((select rp_rank from tblRankProduct where p_idx=A.p_idx and rp_start_dt = '$f_day' and rp_end_dt = '$l_day'),10000) as rp_rank,
ifnull((select rp_last_rank from tblRankProduct where p_idx=A.p_idx and rp_start_dt = '$f_day' and rp_end_dt = '$l_day'),10000) as rp_last_rank,
ifnull((select rp_total_rank from tblRankProduct where p_idx=A.p_idx and rp_start_dt = '$f_day' and rp_end_dt = '$l_day'),10000) as rp_total_rank,
ifnull((select rp_total_last_rank from tblRankProduct where p_idx=A.p_idx and rp_start_dt = '$f_day' and rp_end_dt = '$l_day'),10000) as rp_total_last_rank,
ifnull((select rpc_rank from tblRankProduct where p_idx=A.p_idx and rp_start_dt = '$f_day' and rp_end_dt = '$l_day'),10000) as rpc_rank,
ifnull((select rpc_rank from tblRankProduct where p_idx=A.p_idx and rp_start_dt = '$f_day' and rp_end_dt = '$l_day'),10000) as best_codi_cnt,
ifnull((select sum(p_u_val) from tblProductUpDown where p_idx=A.p_idx and p_u_reg_dt between B.start_dt and B.end_dt and p_u_val > 0),0) as up_cnt,
ifnull((select abs(sum(p_u_val)) from tblProductUpDown where p_idx=A.p_idx and p_u_reg_dt between B.start_dt and B.end_dt and p_u_val < 0),0) as down_cnt,
ifnull((select count(*) from tblProductComment where p_idx=A.p_idx and p_c_reg_dt between B.start_dt and B.end_dt ),0) as comment_cnt
from tblProduct A, tblProductEach B, tblShop C
where 1
and A.p_idx = B.p_idx and A.shop_idx = C.shop_idx
and A.p_idx = $p_idx
and now() between B.start_dt and B.end_dt
";

//echo "sql : $sql <p>";
$res = $mainconn->query($sql);
$row = $mainconn->fetch($res);

if ( !$row ) {	// 기간이 지난 코디일때..
	//echo "<script>alert('코디평가가 끝났습니다.');history.back();</script>";
	$active = "N";
	$sql = "select A.*, unix_timestamp(A.p_reg_dt) as stamp,B.shop_name, B.shop_medal, B.shop_url from tblProduct A, tblShop B where A.shop_idx = B.shop_idx and A.p_idx = $p_idx";
	$res2 = $mainconn->query($sql);
	$row2 = $mainconn->fetch($res2);

	$shop_mem_id		= trim($row2['mem_id']);
	$shop_idx			= trim($row2['shop_idx']);
	$s_shop_name			= trim($row2['shop_name']);
	$shop_medal			= trim($row2['shop_medal']);
	$shop_url			= trim($row2['shop_url']);
	$p_categ			= trim($row2['p_categ']);
	$p_title			= trim($row2['p_title']);
	$p_info				= trim($row2['p_info']);
	$p_desc				= trim($row2['p_desc']);
	$p_price			= trim($row2['p_price']);
	$p_url				= trim($row2['p_url']);
	$p_style_kwd		= trim($row2['p_style_kwd']);
	$p_item_kwd			= trim($row2['p_item_kwd']);
	$p_theme_kwd		= trim($row2['p_theme_kwd']);
	$p_etc_kwd			= trim($row2['p_etc_kwd']);
	$p_gift				= trim($row2['p_gift']);
	$p_gift_cnt			= trim($row2['p_gift_cnt']);
	$p_gift_cond		= trim($row2['p_gift_cond']);
	$p_main_img			= trim($row2['p_main_img']);
	$p_base_img			= trim($row2['p_base_img']);
	$p_etc_img			= trim($row2['p_etc_img']);
	$p_desc_img			= trim($row2['p_desc_img']);
	$p_auto_extend		= trim($row2['p_auto_extend']);
	$p_judgment			= trim($row2['p_judgment']);
	$p_pay_cash			= trim($row2['p_pay_cash']);
	$p_view				= trim($row2['p_view']);
	$p_reg_dt			= trim($row2['p_reg_dt']);
	$stamp				= trim($row2['stamp']);
	$p_top10_num		= trim($row2['p_top10_num']);
	

} else {
	$active = "Y";

	$shop_mem_id		= trim($row['mem_id']);
	$shop_idx			= trim($row['shop_idx']);
	$s_shop_name			= trim($row['shop_name']);
	$shop_medal			= trim($row['shop_medal']);
	$shop_url			= trim($row['shop_url']);
	$p_categ			= trim($row['p_categ']);
	$p_title			= trim($row['p_title']);
	$p_info				= trim($row['p_info']);
	$p_desc				= trim($row['p_desc']);
	$p_price			= trim($row['p_price']);
	$p_url				= trim($row['p_url']);
	$p_style_kwd		= trim($row['p_style_kwd']);
	$p_item_kwd			= trim($row['p_item_kwd']);
	$p_theme_kwd		= trim($row['p_theme_kwd']);
	$p_etc_kwd			= trim($row['p_etc_kwd']);
	$p_gift				= trim($row['p_gift']);
	$p_gift_cnt			= trim($row['p_gift_cnt']);
	$p_gift_cond		= trim($row['p_gift_cond']);
	$p_main_img			= trim($row['p_main_img']);
	$p_base_img			= trim($row['p_base_img']);
	$p_etc_img			= trim($row['p_etc_img']);
	$p_desc_img			= trim($row['p_desc_img']);
	$p_auto_extend		= trim($row['p_auto_extend']);
	$p_judgment			= trim($row['p_judgment']);
	$p_pay_cash			= trim($row['p_pay_cash']);
	$p_view				= trim($row['p_view']);
	$p_reg_dt			= trim($row['p_reg_dt']);
	$stamp				= trim($row['stamp']);
	$p_top10_num		= trim($row['p_top10_num']);
	$p_e_idx			= trim($row['p_e_idx']);
	$end_dt				= trim($row['end_dt']);
	$rp_rank			= trim($row['rp_rank']);
	$rp_last_rank		= trim($row['rp_last_rank']);
	$rp_total_rank		= trim($row['rp_total_rank']);
	$rp_total_last_rank = trim($row['rp_total_last_rank']);
	$rpc_rank			= trim($row['rpc_rank']);
	$up_cnt				= trim($row['up_cnt']);
	$down_cnt			= trim($row['down_cnt']);
	$comment_cnt		= trim($row['comment_cnt']);
}
$p_title	= strip_str($p_title,"V");
$p_info		= strip_str($p_info,"V");
$p_desc		= strip_str($p_desc,"V");

// 해당 코디에 대한 이미지 (베스트,코디짱,인증샵,신상품)
if ( time() - $stamp < $CODI_NEW_STAMP ) {
	$up_img = "<img src='/img_seri/bar_newproduct.gif' border='0' />";
} else if ( $p_top10_num < 2 ) {
	$up_img = "<img src='/img_seri/banner_001.gif' border='0' />";
} else if ( $p_top10_num < 4 ) {
	$up_img = "<img src='/img_seri/bar_best.gif' border='0' />";
} else if ( $p_top10_num >= 4 ) {
	$up_img = "<img src='/img_seri/bar_codizzang.gif' border='0' />";
}

$btm_img = ( $shop_medal == "Y" ) ? "<img src='/img_seri/bar_goodshop.gif' border='0' />" : "<img src='/img_seri/banner_002.gif' border='0' />";

// 랭킹 아이콘, 폭
if ( $rp_rank > $rp_last_rank ) {
	$week_rank_icon = "icon_minus_mini.gif";
} else if ( $rp_rank < $rp_last_rank ) {
	$week_rank_icon = "icon_plus_mini.gif";
} else {
	$week_rank_icon = "icon_plus_mini.gif";
}
$week_rank_diff = abs($rp_rank - $rp_last_rank);

if ( $rp_total_rank > $rp_total_last_rank ) {
	$total_rank_icon = "icon_minus_mini.gif";
} else if ( $rp_total_rank < $rp_total_last_rank ) {
	$total_rank_icon = "icon_plus_mini.gif";
} else {
	$total_rank_icon = "icon_plus_mini.gif";
}
$total_rank_diff = abs($rp_total_rank - $rp_total_last_rank);

// 키워드
$kwd_str = "";
$style_kwd_arr = explode(",", $p_style_kwd);
foreach ( $style_kwd_arr as $k => $v ) {
	$kkk = trim($v);
	if ( $kkk == "" || $kkk == "0" ) continue;
	$kwd_str .= "<a href='#' onClick=\"go_kwd_info('$kkk');\">$kkk</a>, ";
}
$item_kwd_arr = explode(",", $p_item_kwd);
foreach ( $item_kwd_arr as $k => $v ) {
	$kkk = trim($v);
	if ( $kkk == "" || $kkk == "0" ) continue;
	$kwd_str .= "<a href='#' onClick=\"go_kwd_info('$kkk');\">$kkk</a>, ";
}
$theme_kwd_arr = explode(",", $p_theme_kwd);
foreach ( $theme_kwd_arr as $k => $v ) {
	$kkk = trim($v);
	if ( $kkk == "" || $kkk == "0" ) continue;
	$kwd_str .= "<a href='#' onClick=\"go_kwd_info('$kkk');\">$kkk</a>, ";
}
$kwd_str = substr($kwd_str, 0, -2);

// 경품지급 조건
$p_gift_cond_str = ( $p_gift_cond == "T" ) ? "<font color='#FF6600'>TOP10</font>에 선정될 경우" : "<font color='#FF6600'>TOP10</font>과 상관없이 무조건 지급";

// 인증샵 여부
$shop_medal_str = ( $shop_medal == "Y" ) ? "<img src='/img_seri/icon_goodshop.jpg' border='0' align='absmiddle'>" : "";

// 이미지 (main + base + etc)
$codi_img_arr = array();

// 메인 이미지
$src_main_img = $UP_URL."/thumb/".$p_main_img;
$cntperimgpage = 6;

array_push($codi_img_arr, $src_main_img);

if ( $p_base_img ) {
	$arr_base = explode(";", $p_base_img);
	foreach ( $arr_base as $k => $v ) {
		if ( trim($v) == "" ) continue;	
		array_push($codi_img_arr, $UP_URL."/thumb/".trim($v));
	}
}
if ( $p_etc_img ) {
	$arr_etc = explode(";", $p_etc_img);
	foreach ( $arr_etc as $k => $v ) {
		if ( trim($v) == "" ) continue;
		array_push($codi_img_arr, $UP_URL."/thumb/".trim($v));
	}
}


// 자바스크립트 변수 초기화
echo "<script language='javascript'>";
echo "var img_page = 1; var cur_img = 0;";
for ( $i=0; $i<=30; $i++ ) {
	echo "var js_img_{$i} = '';";
}

// 이미지 배열들을 자바스크립트 변수에 저장한다.
$img_record_cnt = 0;
foreach ( $codi_img_arr as $k => $v ) {
	echo "js_img_$k = '$v';";
	$img_record_cnt++;
}
echo "img_total_page = ".ceil($img_record_cnt/$cntperimgpage).";";
echo "</script>";


################################################################################
// 현재 업다운에 참여했는지 그렇지 않은지 확인
if ( $active == "Y" ) {	// 평가진행중
	if ( $mem_id ) {
		$sql = "
		select count(*) from tblProductUpDown 
		where p_idx = $p_idx and p_e_idx = $p_e_idx and mem_id = '$mem_id' 
		";
		$updown_yn = $mainconn->count($sql);
		$updown_yn = ( $updown_yn ) ? "Y" : "N";
	} else {
		$updown_yn = "N";
	}
	
	if ( $mem_id == "" ) {
		$cmt_str = $CODI_CMT[0];
	} else {
		if ( $updown_yn == "Y" ) {
			$cmt_str = $CODI_CMT[1];
		} else {

			$cmt_str = $CODI_CMT[2];
		}
	}
} else {
	// 최근 당첨자를 구한다.
	$sql = "select p_e_idx from tblProductEach where p_idx = $p_idx order by p_e_idx desc limit 1 ";
	$end_p_e_idx = $mainconn->count($sql);
	$sql = "
	select user_mem_id, 
	(select mem_name from tblMember where mem_id=tblGiftTracking.user_mem_id) as user_mem_name 
	from tblGiftTracking
	where p_e_idx = $end_p_e_idx
	";
	//echo $sql;
	$res = $mainconn->query($sql);
	$end_mem_list = "";
	while ( $row = $mainconn->fetch($res) ) {
		$end_user_mem_id = trim($row['user_mem_id']);
		$end_user_mem_name = trim($row['user_mem_name']);

		$end_mem_list .= substr($end_user_mem_id, 0, -2)."** (".substr($end_user_mem_name,0,2)."*".substr($end_user_mem_name,4).")<br>";
	}
	if ( $end_mem_list == "" ) $end_mem_list = "당첨자 없음";
	$cmt_str = $CODI_CMT[3];
}



################################################################################
if ( $active == "Y" ) {
	// 현재 p_e_idx 의 점수
	$sql = "select ifnull(sum(A.score),0) from tblScoreConfig A, tblScore B where A.sc_cid = B.sc_cid and B.p_e_idx = $p_e_idx ";
	//echo "sql : $sql <p>";
	$score = $mainconn->count($sql);
}
################################################################################
// 이 샵이 등록한 다른 코디 보기 - 현재 p_idx는 제외 (라운드 롤링으로 처리)
$sql = "
select A.p_idx, B.p_e_idx, A.p_main_img
from tblProduct A, tblProductEach B
where 1 
and A.p_idx = B.p_idx
and A.p_idx != $p_idx
and A.shop_idx = $shop_idx
and now() between B.start_dt and B.end_dt
";
//echo "sql : $sql <p>";
$res = $mainconn->query($sql);

$other_cnt = 0;
while ( $row = $mainconn->fetch($res) ) {
	$other_p_idx		= trim($row['p_idx']);
	$other_p_e_idx		= trim($row['p_e_idx']);
	$other_p_main_img	= trim($row['p_main_img']);
	$other_p_main_img	= $UP_URL."/thumb/".$other_p_main_img;
	
	echo "
	<script language='javascript'>
	var other_codi_{$other_cnt} = [ '$other_p_idx', '$other_p_e_idx', '$other_p_main_img' ];
	</script>
	";

	$other_cnt++;
}

if ( $other_cnt < 5 ) {
	for ( $i=$other_cnt; $i<5; $i++ ) {
		echo "
		<script language='javascript'>
		var other_codi_{$i} = [ '-1', '-1', '/img/photo_no.gif' ];
		</script>
		";
	}
}

// 코디평가 남은시간 계산을 위한 서버시간 체크 "2008-10-21 21:09:38"
//$target_time = mktime(03,40,25,10,21,2008);
$target_time = mktime( substr($end_dt,11,2),substr($end_dt,14,2),substr($end_dt,17,2),substr($end_dt,5,2),substr($end_dt,8,2),substr($end_dt,0,4) );
$cur_time = time();
$time_diff = $target_time - $cur_time;


// ajax 댓글을 위한 view/write url
$view_url = "/product/ajax_product_comment.php?p_idx=$p_idx&pe_idx=$p_e_idx&page=1";
$write_url = "/product/ajax_product_comment_ok.php";
$rurl = my64encode("/product/product_view.php?p_idx=$p_idx#reply_anc");

// 마이페이지에서 쓰일 다음/이전 코디
if ( $mem_id ) {
	$sql = "select A.p_idx from tblProduct A, tblProductEach B where A.p_idx = B.p_idx and A.p_idx < $p_idx and unix_timestamp() between unix_timestamp(B.start_dt) and unix_timestamp(B.end_dt) order by A.p_idx desc limit 1 ";
	$prev_p_idx = $mainconn->count($sql);

	$sql = "select A.p_idx from tblProduct A, tblProductEach B where A.p_idx = B.p_idx and A.p_idx > $p_idx and unix_timestamp() between unix_timestamp(B.start_dt) and unix_timestamp(B.end_dt) order by A.p_idx asc limit 1 ";
	$next_p_idx = $mainconn->count($sql);
}

$mainconn->close();
?>

<? include "../include/_head.php"; ?>

<script language="javascript">
function init_img(page) {
	for ( var i=0; i<6; i++ ) {
		if ( eval("js_img_" + parseInt(6*(img_page-1)+i)) != "" ) {
			document.getElementById("small_img_"+i).src = eval("js_img_" + parseInt(6*(img_page-1)+i));
		} else {
			document.getElementById("small_img_"+i).src = "/img/photo_no.gif";
		}
	}
	page_navi();
	go_big_img(cur_img);
}

function go_big_img(num) {
	document.getElementById("big_img_id").src = document.getElementById("small_img_"+num).src;

	size = GetImageSize(big_img_id);
	ratio_obj = img_resize_ratio(size);

	// width,height 값이 28*30 이면 350*308로 맞춘다.
	if ( ratio_obj.Width == 28 && ratio_obj.Height == 30 ) {
		ratio_obj.Width = 350; ratio_obj.Height = 308;
	}
	
	document.getElementById("main_img_div").innerHTML = "<a href='"+document.getElementById("small_img_"+num).src+"' rel='lightbox' title=''><img id='big_img_id' src='"+document.getElementById("small_img_"+num).src+"' width='"+ratio_obj.Width+"' height='"+ratio_obj.Height+"' border='0' /></a>";
	//document.getElementById("main_img_div").innerHTML = "<a href='"+document.getElementById("small_img_"+num).src+"' rel='lightbox' title=''><img id='big_img_id' src='"+document.getElementById("small_img_"+num).src+"' width='350' height='308' border='0' /></a>";
	
	cur_img = num;

	// 이미지가 동적으로 바뀌기때문에 반드시 호출해야 한다.
	initLightbox();
}

function go_prev() {
	if ( img_page == 1 ) return;
	img_page -= 1;
	init_img(img_page);
	cur_img = 0;
	go_big_img(cur_img);
}

function go_next() {
	if ( img_page == img_total_page ) return;
	img_page += 1;
	init_img(img_page);
	cur_img = 0;
	go_big_img(cur_img);
}

function go_first() {
	if ( img_page == 1 ) return;
	img_page = 1;
	init_img(img_page);
	cur_img = 0;
	go_big_img(cur_img);
}

function go_last() {
	if ( img_page == img_total_page ) return;
	img_page = img_total_page;
	init_img(img_page);
	cur_img = 0;
	go_big_img(cur_img);
}

function go_page(page) {
	img_page = page;
	init_img(img_page);
	cur_img = 0;
	go_big_img(cur_img);
}

function page_navi() {
	var navi = "";
	for ( var i=1; i<=img_total_page; i++ ) {
		if ( i == img_page ) {
			navi += "<b><font color='#000000'>"+i+"</font></b>&nbsp;";
		} else {
			navi += "<a href='#' onClick='go_page("+i+");'>"+i+"</a>&nbsp;";
		}
	}
	document.getElementById("js_page_navi_area").innerHTML = navi;
}

function big_img_prev() {
	if ( cur_img == 0 ) return;
	cur_img -= 1;
	go_big_img(cur_img);
}

function big_img_next() {
	if ( cur_img == 5 ) return;
	cur_img += 1;
	go_big_img(cur_img);
}

function goUpDown(flag) {
	var f = document.frm;
	var id = '<?=$mem_id?>';
	if ( id == "" ) {
		alert("로그인을 하셔야 평가참여가 가능합니다.");
		f.target = "_self";
		f.action = "/member/login.php";
		f.submit();
	}
	if ( '<?=$mem_kind?>' == 'S' ) {
		alert("샵회원은 평가참여를 할 수 없습니다.");
		return false;
	}
	f.updown.value = flag;
	f.mode.value = "I";
	f.target = "__blank__";
	f.action = "/product/up_down_proc.php";
	f.submit();
}

function goVisit() {
	var f = document.frm;
	f.mode.value = "I";
	f.target = "__blank__";
	f.action = "/product/visit_proc.php";
	f.submit();
}

// 설명레이어 보이기/감추기
function p_detail_toggle() {
	var img_obj = document.getElementById("btn_detail_img_id");
	var obj = document.getElementById("product_detail_area");
	if ( obj.style.display == "block" ) {
		obj.style.display = "none";
		img_obj.src = "/img/btn_detail_open.gif";
	} else {
		obj.style.display = "block";
		img_obj.src = "/img/btn_detail_close.gif";
	}
}

// other_codi_NAN 어쩌구저쩌구 에러 원인 (0으로 나눠서 생김 - 주의)
var other_size = <?=$other_cnt?>;
var cur_focus = 0;

// 지긋지긋하다 ㅠㅠ
function init_other_img() {
	for ( var i=0; i<5; i++ ) {
		if ( other_size == 0 ) {
			document.getElementById("dy_other_area_"+i).innerHTML = "<img src='/img/photo_no.gif' id='dy_other_codi_"+i+"' width='95' height='95' border='0'>";
			img_id = document.getElementById( "dy_other_codi_"+ i );
			img_id.src = "/img/photo_no.gif";
		} else if ( other_size < 5 ) {
			
			obj = eval("other_codi_" + i + "[2]");
			obj2 = eval("other_codi_" + i + "[0]");
			if ( obj ) {
				document.getElementById("dy_other_area_"+i).innerHTML = "<a href='#' onClick='codi_view("+obj2+");'><img src='/img/photo_no.gif' id='dy_other_codi_"+i+"' width='95' height='95' border='0'></a>";
				img_id = document.getElementById( "dy_other_codi_"+ i );
				img_id.src = obj;
			}
		} else {
			idx = i + cur_focus + other_size;
			obj = eval("other_codi_" + (idx%other_size) + "[2]");
			obj2 = eval("other_codi_" + (idx%other_size) + "[0]");
			
			if ( obj ) {
				document.getElementById("dy_other_area_"+i).innerHTML = "<a href='#' onClick='codi_view("+obj2+");'><img src='/img/photo_no.gif' id='dy_other_codi_"+i+"' width='95' height='95' border='0'></a>";
				img_id = document.getElementById( "dy_other_codi_"+ i );
				img_id.src = obj;
			}
		}

	}
}

// 다음
function other_shift() {
	if ( other_size <= 5 ) return;
	cur_focus += 1;
	init_other_img();
}

// 이전
function other_unshift() {
	if ( other_size <= 5 ) return;
	cur_focus -= 1;
	init_other_img();
}

// 카테코리별 검색 페이지로
function go_by_categ() {
	var f = document.frm;
	go_categ_info(f.menu1.options[f.menu1.selectedIndex].value);
}

// 댓글, 경품지급내역, 경품당첨후기 각각의 레이어 처리
function layer_view(flag) {
	if ( flag == "C" ) {
		document.getElementById("comment_layer").style.display = "block";
		document.getElementById("gift_layer").style.display = "none";
		document.getElementById("gift_after_layer").style.display = "none";
	} else if ( flag == "G" ) {
		document.getElementById("comment_layer").style.display = "none";
		document.getElementById("gift_layer").style.display = "block";
		document.getElementById("gift_after_layer").style.display = "none";
	} else {
		document.getElementById("comment_layer").style.display = "none";
		document.getElementById("gift_layer").style.display = "none";
		document.getElementById("gift_after_layer").style.display = "block";
	}
}
</script>

<iframe name="__blank__" width="0" height="0"></iframe>

<table width="860" height="25" border="0" cellpadding="0" cellspacing="0">

<form id="frm" name="frm" method="post">
<input type="hidden" id="mode" name="mode" value="" />
<input type="hidden" id="p_idx" name="p_idx" value="<?=$p_idx?>" />
<input type="hidden" id="p_e_idx" name="p_e_idx" value="<?=$p_e_idx?>" />
<input type="hidden" id="shop_mem_id" name="shop_mem_id" value="<?=$shop_mem_id?>" />
<input type="hidden" id="updown" name="updown" value="" />
<input type="hidden" id="rurl" name="rurl" value="<?=my64encode($_SERVER['REQUEST_URI'])?>" />

<input type="hidden" id="session_id" name="session_id" value="<?=$_SESSION['mem_id']?>" />

  <tr>
    <td bgcolor="D11D5A"><b><font color="#FFFFFF">&nbsp;평가대기 ▶ </font></b>

        <select name="menu1" onChange="go_by_categ();" class="logbox">
          <option value="T" <?if ($p_categ=="T") echo " selected";?>>Top : 상의</option>
		  <option value="B" <?if ($p_categ=="B") echo " selected";?>>Bottom : 하의</option>
		  <option value="O" <?if ($p_categ=="O") echo " selected";?>>Outwear : 아웃웨어</option>
		  <option value="U" <?if ($p_categ=="U") echo " selected";?>>Underwear : 언더웨어</option>
		  <option value="A" <?if ($p_categ=="A") echo " selected";?>>ACC : 액세서리</option>
	    </select>    
	</td>
    <td width="60"><img src="/img/bbg2.jpg" width="60" height="25"></td>
    <td width="200" background="/img/bbg.jpg"><font color="#FFFFFF"><b><a href="#" onClick="shop_view('<?=$shop_idx?>');"><font color="#FFFF00"><?=$s_shop_name?></font></a></b> <?=$shop_medal_str?></font></td>
	<td width="25" background="/img/bbg.jpg"><img src="/img/bbg3.jpg" width="25" height="25"></td>
    <td width="150" align="center" background="/img/bbg.jpg"><font color="#FFFFFF"><b><font color="36FF00">주간순위</font></b> <?=$rp_rank?>위 &nbsp; <img src="/img/<?=$week_rank_icon?>" width="10" height="10"> <?=$week_rank_diff?></font></td>
    <td width="25" background="/img/bbg.jpg"><img src="/img/bbg3.jpg" width="25" height="25"></td>
    <td width="150" align="center" background="/img/bbg.jpg"><font color="#FFFFFF"><b><font color="#FF9900">전체순위</font></b> <?=$rp_total_rank?>위 &nbsp; <img src="/img/<?=$total_rank_icon?>" width="10" height="10">   <?=$total_rank_diff?> </font></td>
  </tr>
</form>
</table>
<table width="100" height="8" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table width="860" height="100" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="610" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="6" colspan="2" bgcolor="e1e1e1"></td>
        </tr>
      <tr>
        <td style="PADDING-top: 10px;PADDING-bottom: 10px;PADDING-left: 0px;PADDING-right: 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="bigtitle "><font color="#00CC33">[<?=$s_shop_name?>]</font><font color="414141"><?=$p_title?></font></td>
            </tr>
          <tr>
            <td height="10"></td>
            </tr>
        </table>

          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>
			  <!-- 메인 이미지 시작 -->
			  <table width="350" height="308" cellpadding="3" cellspacing="0"  style='border:1 dotted #BFBFBF;'>
                <tr>
                  <td align="center" valign="middle">
					
					<div id="main_img_div">
					<!--<img id="big_img_id" src="" width="348" height="306" border="0" />-->
					<img id="big_img_id" src="" width="350" height="308" border="0" />
					</div>
					

				  </td>
                </tr>
              </table>
			  <!-- 메인 이미지 시작 -->
			  </td>
              <td width="230">

			  <!-- 추가이미지 시작 -->
			  <table width="100%" height="308" border="0" cellpadding="0" cellspacing="0" bgcolor="3D3D3D">
                <tr>
                  <td width="15" align="center"><img src="/img/btn_prev2.gif" width="10" height="25" border="0" onClick="go_prev();" style="cursor:hand;" /></td>
                  <td align="center">

				  <table width="200" border="0" cellspacing="0" cellpadding="0">

<?
$sm_img_cnt = 0;
for ( $i=0; $i<6; $i++ ) {

	if ( ! $sm_img_cnt % 2 ) {
		echo "<tr>";
	}
		
	echo "
	<td width='100' align='right'>
	<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
		<tr>
			<td bgcolor='#3D3D3D'><a href='#' onClick='go_big_img($sm_img_cnt);'><img id='small_img_{$sm_img_cnt}' src='/img/photo_no.gif' width='95' height='95' border='0' /></a></td>
		</tr>
	</table>
	</td>
	";
	
	if ( $sm_img_cnt % 2 ) {
		echo "</tr>";
	}
	$sm_img_cnt++;
}
?>

                  </table>
				  </td>
                  <td width="15" align="center"><img src="/img/btn_next2.gif" width="10" height="25" border="0" onClick="go_next();" style="cursor:hand;" /></td>
                </tr>
              </table>
			  <!-- 추가이미지 끝 -->
			  
			  </td>
            </tr>
            <tr>
              <td>
			  <table width="355" border="0" cellspacing="0" cellpadding="6">
                <tr>
                  <td width="210"><b><font color="#333333" size="3">샵 판매가격</font></b>&nbsp; <font color="#CC0000" size="3"><b><?=number_format($p_price);?> 원</b></font></td>

                  <td align="right">
				  <!-- 메인이미지 (다음,이전) -->
				  <img src="/img/btn_prev3.gif" width="47" height="14" border="0" onClick="big_img_prev();" style="cursor:hand;" /> 
				  <img src="/img/btn_next3.gif" width="47" height="14" border="0" onClick="big_img_next();" style="cursor:hand;" />
				  </td>
                </tr>
              </table>
			  </td>
              <td>
			  <!-- 이미지 페이지 내비게이션 -->
			  <table width="100%" border="0" cellspacing="0" cellpadding="6">
                <tr>
                  <td align="center">
				  <img src="/img/btn_first_go.gif" width="20" height="11" border="0" onClick="go_first();" style="cursor:hand;" /> <img src="/img/btn_prev4.gif" width="41" height="11" border="0" onClick="go_prev();" style="cursor:hand;" /> 
				  
				  <span id="js_page_navi_area"></span>
				  
				  <img src="/img/btn_next4.gif" width="41" height="11" border="0" onClick="go_next();" style="cursor:hand;" /> <img src="/img/btn_end_go.gif" width="20" height="11" border="0" onClick="go_last();" style="cursor:hand;" />
				  </td>
                  </tr>
              </table>
			  <!-- 이미지 페이지 내비게이션 -->
			  </td>
            </tr>
          </table>
          <table width="100" height="10" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <table width="590" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="29" background="/images/progu_01.gif"><table width="100%" height="29" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="29%" align="center" valign="bottom"><img src="/img/typo_001.gif" width="147" height="20"></td>
                  <td width="45%" align="center"><b><?=$p_gift_cond_str?></b></td>
                  <td width="26%" align="center"><b><font color="#000000">당첨대상자수</font></b></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td background="/images/progu_02.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="29%" align="center" valign="top"><img src="/img/typo_002.gif" width="86" height="20"></td>
                  <td width="45%"style="PADDING-top: 5px;PADDING-bottom: 0px;PADDING-left: 10px;PADDING-right: 10px;"><font color="#CC3300"><?=$p_gift?></font></td>
                  <td width="26%" align="center"><?=$p_gift_cnt?>명</td>
                </tr>
              </table></td>
            </tr>
            
            <tr>
              <td height="5" background="/images/progu_04.gif"></td>
            </tr>
          </table></td>
        <td width="6" bgcolor="e1e1e1"></td>
      </tr>
      <tr>
        <td height="6" colspan="2" bgcolor="e1e1e1"></td>
        </tr>
    </table></td>
    <td width="10" valign="top"></td>
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="6" colspan="2" bgcolor="FF5C5C"></td>
        </tr>
      <tr>
        <td width="6" bgcolor="FF5C5C"></td>
        <td valign="bottom" style="PADDING-top: 10px;PADDING-left: 10px;PADDING-right: 0px;">
	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="20" colspan="2" valign="top">
				<img src="/img/icon_clock.gif" width="16" height="16" align="absmiddle"> 
				<font color="#000000"><b>남은 평가기간</b></font> : 
				<font color="#FF6600"><b><span id="deadline_area">6일 11시간 20분</span></b></font>
			</td>
          </tr>
          <tr>
            <td height="1" colspan="2" bgcolor="D4D4D5"></td>
          </tr>
          <tr>
            <td width="58%" height="50" align="center" valign="middle" class="bignom"><span id="sp_current_total_score"><?=number_format($score)?></span></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="54%" height="18" class="evfont">코디업</td>
                  <td width="46%" align="right" class="date"><b><font color="#000000"><span id="sp_up_1"><?=$up_cnt?></span></font></b></td>
                </tr>
                <tr>
                  <td height="1" colspan="2" background="/img/dot_garo_mini.gif"></td>
                </tr>
                <tr>
                  <td height="18" class="evfont">코디다운</td>
                  <td align="right" class="nomber"><b class="date"><font color="#000000"><span id="sp_down_1"><?=$down_cnt?></span></font></b></td>
                </tr>
                <tr>
                  <td height="1" colspan="2" background="/img/dot_garo_mini.gif"></td>
                </tr>
                <tr>
                  <td height="18" class="evfont">평가댓글</td>
                  <td align="right"><b class="evfont"><font color="#000000"><span id="sp_comment_1"><?=$comment_cnt?></span></font></b></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="1" colspan="2" bgcolor="D4D4D5"></td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="20" align="center" valign="bottom"><b class="date"><img src="/img/icon_all.gif" align="absmiddle"> 분야별&nbsp; <font color="#FF3366"><?=$rpc_rank?>위</font></b> </td>
                  <td width="10" align="center" valign="bottom">|</td>
                  <td align="center" valign="bottom"><b class="date"><img src="/img/icon_section.gif" align="absmiddle"> 전체&nbsp;&nbsp; <font color="#00CC33"><?=$rp_total_rank?>위</font></b> </td>
                </tr>
            </table></td>
          </tr>
        </table>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#E4E4E4">
            <tr>
              <td height="1"></td>
            </tr>
          </table>
          <table width="100" height="8" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <table width="100%" border="0" cellpadding="6" cellspacing="0" bgcolor="BDBDBD">
            <tr>
              <td valign="top" bgcolor="#FFFFFF"><b><font color="#003366">판매자 한마디! </font></b><br>
                <table width="100" height="5" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td></td>
                  </tr>
                </table>
                <span class="evfont"><?=$p_info?></span></td>
            </tr>
          </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="34" align="left" valign="top"><img src="/img/icon_key_ori.gif" width="28" height="18"></td>
              <td valign="top" class="evfont"><font color="#003399"><?=$kwd_str?></font></td>
            </tr>
			     <tr>
              <td height="7" colspan="2"></td>
              </tr>
            <tr>
              <td height="1" colspan="2" background="/img/dot_garo_max.gif"></td>
              </tr>
	  	      <tr>
              <td height="7" colspan="2"></td>
              </tr>
          </table>


<? if ( $active == "Y" ) { ?>
		<table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="106">
			<!-- 코디 업다운 버튼 -->
			<a href="#" onclick="goUpDown('U');" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image58','','/img/btn_up_ov.gif',1)"><img src="/img/btn_up.gif" alt="코디 업 ▲" name="Image58" width="102" height="68" border="0"></a>
			</td>
            <td>
			<a href="#" onclick="goUpDown('D');" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image59','','/img/btn_down_ov.gif',1)"><img src="/img/btn_down.gif" alt="코디 다운 ▼" name="Image59" width="102" height="68" border="0">
			</a>
			<!-- 코디 업다운 버튼 -->
			</td>
          </tr>
        </table>
<? } else { ?>
		<table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="100%" colspan="2" align="center">평가기간이 완료되었습니다.</td>
          </tr>
		  <tr>
            <td width="40%" height="50" align="center" valign="absmiddle"><b>당첨<br>회원</b></td>
			<td width="60%" align="center"><?=$end_mem_list?></td>
          </tr>
        </table>
<? } ?>


          <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>
              <td width="34" height="7"></td>
            </tr>
            <tr>
              <td height="1" background="/img/dot_garo_max.gif"></td>
            </tr>
            <tr>
              <td height="7"></td>
            </tr>
          </table>

		  

          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="17" height="7"><table width="210" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="35" valign="top">
					<?=$up_img?>
				  </td>
                </tr>
                <tr>
                  <td height="1" background="/img/dot_garo_mini.gif"></td>
                </tr>
                <tr>
                  <td height="35" valign="bottom"><?=$btm_img?></td>
                </tr>
				   <tr>
                  <td height="8"></td>
                </tr>
                <tr>
                  <td><a href="<?=$p_url?>" target="_blank"><img src="/img/btn_goshop.gif" width="210" height="66" border="0" onclick="goVisit();" /></a></td>
                </tr>
					   <tr>
                  <td height="10"></td>
                </tr>
              </table>
                </td>
              <td width="6" bgcolor="FF5C5C">&nbsp;</td>
            </tr>
       
          </table></td>
        </tr>
		
      <tr>
        <td height="6" colspan="2" bgcolor="FF5C5C"></td>
        </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="860" height="25" border="0" cellpadding="0" cellspacing="0" background="/img/bbg.jpg">
  <tr>
    <td width="310" align="center" bgcolor="CC0000"><font color="#FFCC66">&nbsp;&nbsp; 댓글로 평가를 하시면 당첨확률이 더욱 올라갑니다.</font></td>
    <td width="25"><img src="/img/bbg5.gif" width="25" height="25"></td>
    <td align="right"><b><font color="#FFFFFF">평가참여  &nbsp; <span id="sp_updown_2"><?=$up_cnt+$down_cnt?></span> 명</font></b> &nbsp; |  <font color="#FFFFFF">&nbsp; 코디<font color="#99FF00"><b>업</b></font>  <span id="sp_up_2"><?=$up_cnt?></span></font>  &nbsp; |  &nbsp; <font color="#FFFFFF">코디<font color="#FF9933"><b>다운</b></font>  <span id="sp_down_2"><?=$down_cnt?></span></font>  &nbsp; |  &nbsp; <a href="#reply_anc"><font color="#FFFFFF">댓글    <span id="sp_comment_2"><?=$comment_cnt?></span></font></a>&nbsp;&nbsp;&nbsp;&nbsp; </td>
  </tr>
</table>

<!-- 댓글 입력창 1번째 -->
<span id="updown_btn_area_1"></span>
<!-- 댓글 입력창 1번째 -->

<a name="detailview"></a>
<br>




<table width="860" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table width="293" height="30" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><a href="#detailview"><img src="/images/view_btn_02set_01.gif" alt="코디상품 상세정보" width="154" height="30" border="0"></a></td>
        <td><a href="#reply_anc" onClick="layer_view('C');"><img src="/images/view_btn_02set_02.gif" alt="댓글평가 리스트" width="139" height="30" border="0"></a></td>
		<td><a href="#giftlist" onClick="layer_view('G');"><img src="/images/view_btn_03set_03.gif" width="199" height="30" alt="해당샵의 경품지급 내역보기" border="0"></a></td>
		<td><a href="#giftafterlist" onClick="layer_view('A');"><img src="/images/view_btn_04set_04.gif" alt="경품당첨 후기" border="0"></a></td>
      </tr>
    </table>
	</td>
    <td align="right" valign="bottom"><img id="btn_detail_img_id" src="/img/btn_detail_close.gif" alt="코디상품 상세정보 열기/닫기" width="164" height="22" border="0" onClick="p_detail_toggle();" style="cursor:hand;" /></td>
  </tr>
</table>


<!-- 코디 상세보기 시작 -->
<div id="product_detail_area" style="display:block;">
<table width="860" border="0" cellpadding="15" cellspacing="1" bgcolor="#E1E1E1">
  <tr>
    <td bgcolor="#FFFFFF">
	<?
	echo $p_desc."<p>";

	if ( strlen($p_desc_img) > 10 ) {
		$tmp_arr_p_desc_img = explode(";", $p_desc_img);
		foreach ( $tmp_arr_p_desc_img as $k => $v ) {
			if ( trim($v) == "" ) continue;
			if ( substr($v,0,7) != "http://" ) {
				$v = $UP_URL."/thumb/".$v;
			}
			echo "<a href='$v' rel='lightbox'><img src='$v' border='0' id='big_pic_$k' /></a><p>";
		}
	}
	?>


	</td>
  </tr>
</table>
</div>
<!-- 코디 상세보기 끝 -->




<!-- 다른 코디 보기 스크롤 시작 -->
<table width="860" border="0" cellpadding="8" cellspacing="6" bgcolor="#FF5C5C">
  <tr>
    <td bgcolor="#FFFFFF">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="591">
		<table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30"><img src="/img/btn_prev5.gif" width="30" height="51" border="0" onClick="other_unshift();" style="cursor:hand;" /></td>

<?

$other_img_cnt = 0;
for ( $i=0; $i<5; $i++ ) {

	echo "
	<td width='105' align='center'>
	<table width='96' height='96' border='0' cellpadding='0' cellspacing='1' bgcolor='#CCCCCC'>
		<tr>
			<td bgcolor='#3D3D3D'>
				<span id='dy_other_area_{$other_img_cnt}'></span>
			</td>
		</tr>
	</table>
	</td>
	";
	$other_img_cnt++;
}

?>

            <td width="30" align="center"><img src="/img/btn_next5.gif" width="30" height="51" border="0" onClick="other_shift();" style="cursor:hand;" /></td>
          </tr>
        </table>
		</td>
        <td width="241" align="right">
		<table width="235" height="95" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><a href="#" onClick="shop_view(<?=$shop_idx?>);"><img src="/images/keki_01.gif" alt="" width="118" height="95" border="0"></a></td>
            <td><a href="<?=$shop_url?>" target="_blank"><img src="/images/keki_02.gif" alt="" width="117" height="95" border="0" /></a></td>
          </tr>
        </table>
		</td>
      </tr>
    </table>
	</td>
  </tr>
</table>
<!-- 다른 코디 보기 스크롤 끝 -->


<a name="reply_anc"></a>
<br>

<div id="comment_layer">
<!-- 댓글평가리스트 부분 //-->

<table width="860" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="550"><table width="500" height="30" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><a href="#reply_anc" onClick="layer_view('C');"><img src="/images/view_btn_03set_01.gif" width="141" height="30" alt="" border="0"></a></td>
        <td><a href="#detailview"><img src="/images/view_btn_03set_02.gif" width="160" height="30" alt="" border="0"></a></td>
        <td><a href="#giftlist" onClick="layer_view('G');"><img src="/images/view_btn_03set_03.gif" width="199" height="30" alt="" border="0"></a></td>
		<td><a href="#giftafterlist" onClick="layer_view('A');"><img src="/images/view_btn_04set_04.gif" alt="경품당첨 후기" border="0"></a></td>
      </tr>
    </table></td>
    <td width="310" align="right" valign="bottom">&nbsp;</td>
  </tr>
</table>


<table width="860" height="30" border="0" cellpadding="0" cellspacing="0" background="/img/title_bg_memo.gif">
  <tr>
    <td width="65" align="center" class="evfont"><b><font color="#333333">번호</font></b></td>
    <td width="80" align="center" class="evfont"><b><font color="#333333">평가</font></b></td>
    <td align="center" class="evfont"><b><font color="#333333">평가내용</font></b></td>
    <td width="90" align="center" class="evfont"><b><font color="#333333">작성자</font></b></td>
    <td width="80" align="center" class="evfont"><b><font color="#333333">작성일</font></b></td>
  </tr>
</table>


<!-- 코디 평가 댓글/입력 시작 -->
<div id="ProductCommentArea"></div>

<table width="860" height="25" border="0" cellpadding="0" cellspacing="0" background="/img/bbg.jpg">
  <tr>
    <td width="310" align="center" bgcolor="CC0000"><font color="#FFCC66">&nbsp;&nbsp; 댓글로 평가를 하시면 당첨확률이 더욱 올라갑니다.</font></td>
    <td width="25"><img src="/img/bbg5.gif" width="25" height="25"></td>
    <td align="right"><b><font color="#FFFFFF">평가참여  &nbsp; <span id="sp_updown_3"><?=$up_cnt+$down_cnt?></span> 명</font></b> &nbsp; | <font color="#FFFFFF">&nbsp; 코디<font color="#99FF00"><b>업</b></font> <span id="sp_up_3"><?=$up_cnt?></span></font> &nbsp; |  &nbsp; <font color="#FFFFFF">코디<font color="#FF9933"><b>다운</b></font> <span id="sp_down_3"><?=$down_cnt?></span></font> &nbsp; |  &nbsp; <a href="#reply_anc"><font color="#FFFFFF">댓글    <span id="sp_comment_3"><?=$comment_cnt?></span></font></a>&nbsp;&nbsp;&nbsp;&nbsp; </td>
  </tr>
</table>

<div id="ProductComment2Area"></div>
<!-- 코디 평가 댓글/입력 끝 -->

</div>



<!-- 경품지급내역 리스트 부분 //-->
<a name="giftlist"></a>
<br>

<div id="gift_layer" style="display:none;">

<table width="860" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="550"><table width="500" height="30" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<a href="#reply_anc" onClick="layer_view('C');"><img src="/images/view_btn_04set_01.gif" alt="" width="141" height="30" border="0"></a></td>
		<td>
			<a href="#detailview"><img src="/images/view_btn_04set_02.gif" alt="" width="160" height="30" border="0"></a></td>
		<td>
			<a href="#giftlist" onClick="layer_view('G');"><img src="/images/view_btn_04set_03.gif" alt="" width="199" height="30" border="0"></a></td>
	</tr>
</table></td>
    <td width="310" align="right" valign="bottom">&nbsp;</td>
  </tr>
</table>


<table width="860" height="30" border="0" cellpadding="0" cellspacing="0" background="/img/title_bg_presnet.gif">
  <tr>
    <td align="center" class="evfont"><b><font color="#333333">코디제목</font></b></td>
    <td width="200" align="center" class="evfont"><b><font color="#333333">경품내용</font></b></td>
    <td width="90" align="center" class="evfont"><b><font color="#333333">마감일</font></b></td>
    <td width="120" align="center" class="evfont"><b><font color="#333333">당첨자</font></b></td>
    <td width="80" align="center" class="evfont"><b><font color="#333333">경품지급</font></b></td>
  </tr>
</table>


<!-- 경품지급 내역 -->
<div id="ProductGiftTrackingArea"></div>
<br>

</div>


<!-- 당첨후기 부분 //-->
<a name="giftafterlist"></a>
<br>

<div id="gift_after_layer" style="display:none;">

<table width="860" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="550">
	<table width="500" height="30" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<a href="#reply_anc" onClick="layer_view('C');"><img src="/images/view_btn_04set_01.gif" alt="" width="141" height="30" border="0"></a></td>
		<td>
			<a href="#detailview"><img src="/images/view_btn_04set_02.gif" alt="" width="160" height="30" border="0"></a></td>
		<td>
			<a href="#giftlist" onClick="layer_view('G');"><img src="/images/view_btn_03set_03.gif" alt="" width="199" height="30" border="0"></a></td>
		<td><a href="#giftafterlist" onClick="layer_view('A');"><img src="/images/view_btn_04set_04_ov.gif" alt="경품당첨 후기" border="0"></a></td>
	</tr>
	</table>
	</td>
    <td width="310" align="right" valign="bottom">&nbsp;</td>
  </tr>
</table>


<table width="860" height="30" border="0" cellpadding="0" cellspacing="0" background="/img/title_bg_presnet.gif">
  <tr>
    <td width="65" align="center" class="evfont"><b><font color="#333333">번호</font></b></td>
    <td align="center" class="evfont"><b><font color="#333333">후기</font></b></td>
    <td width="90" align="center" class="evfont"><b><font color="#333333">작성자</font></b></td>
    <td width="80" align="center" class="evfont"><b><font color="#333333">작성일</font></b></td>
  </tr>
</table>

<div id="ProductGiftAfterArea">
<form id="frm1" name="frm1" method="post">
<input type="hidden" id="session_id" name="session_id" value="<?=$_SESSION['mem_id']?>" />
</form>
</div>
<br>

</div>
<!-- 당첨후기 부분 //-->

<script language="javascript">
// 이미지 초기화
init_img(img_page);

// 다른코디 롤링 이미지 초기화
init_other_img();

// lightbox 로딩
initLightbox();

// 코디댓글 로딩


// 평가기간 남은시간
var ts = <?=$time_diff?>;
function deadline() {
	day = Math.floor(ts/86400);
    restHour = ts%86400;
    hour = Math.floor(restHour/3600);
    restMin = restHour%3600;
    min = Math.floor(restMin/60);
    sec = Math.floor(restMin%60);
	
	if ( ts > 0 ) {
		document.getElementById('deadline_area').innerHTML = day+"일 "+hour+"시간 "+min+"분";
		ts -= 60;
		setTimeout("deadline()", 1000*60);
		//setTimeout("deadline()", 1000);
	} else {
		document.getElementById('deadline_area').innerHTML = "<br>&nbsp;&nbsp;&nbsp;&nbsp;코디평가가 끝났습니다.";
	}
}
deadline();


// 이미지 크기에 맞게 로딩
// 페이지 로딩되고 1초후에 리사이즈 된다.
window.setTimeout("img_resize(800)",500);

// 상품코디 댓글
loadProductComment('<?=$mem_id?>','<?=$mem_kind?>','<?=$rurl?>','<?=$p_idx?>','<?=$p_e_idx?>',1,'<?=$view_url?>','<?=$write_url?>','<?=$updown_yn?>','<?=$active?>');

// 상품코디 경품지급 내역
loadProductGiftTracking('<?=$p_idx?>','<?=$p_e_idx?>','<?=$shop_idx?>',1);

// 상품코디 당첨후기
loadProductGiftAfter('<?=$p_idx?>','<?=$p_e_idx?>','',1);

</script>



<!-- 경품관련 이용안내 -->
<? include "../include/about_gift.php"; ?>

<? include "../include/_foot.php"; ?>