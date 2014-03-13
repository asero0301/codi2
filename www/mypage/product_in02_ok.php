<?
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/mypage/product_in02_ok.php
 * date   : 2008.10.12
 * desc   : ���������� �ڵ��ǰ ��� 2�ܰ� ����

	�ڵ� ó����Ͻ�(mode:I)
		- ����ĳ�ð� �����ϸ� ����Ʈ�� ����
		- tblProduct �Ǵ� tblProductTmp ����
		- ��������(savemode�� "R")�϶��� tblProductEach�� ����
		- tblCash insert
		- tblMember update

	�ڵ� ������(mode:E)
		1. �ӽ�����(savemode:T)�̸�?
			- ����ĳ�ð� �����ϸ� ����Ʈ�� ����.
			- tblProductTmp ����
			- �Ҹ�� cash���� Ʋ���� tblCash, tblMember Update
		2. ��������(savemode:R)�̸�?
			case 1 : ����->���� �� ���
				- ����ĳ�ð� �����ϸ� ����Ʈ�� ����.
				- tblProduct ����
				- �Ҹ�� cash���� Ʋ���� tblCash, tblMember Update
			case 2 : �ӽ�->���� �� ���
				- ����ĳ�ð� �����ϸ� ����Ʈ�� ����.
				- tblProduct insert
				- tblProductEach insert
				- �Ҹ�� cash���� Ʋ���� tblCash, tblMember Update
				- tblProductTmp delete
 *******************************************************/
session_start();
require_once "../inc/common.inc.php";
require_once "../inc/util.inc.php";

auth_chk($RURL);

/*
foreach ( $_REQUEST as $k => $v ) {
	echo "$k:$v<br>";
}
exit;
*/

$mainconn->open();

$mem_id		= $_SESSION['mem_id'];
$mem_name	= $_SESSION['mem_name'];
$mem_date	= date("Ymd", time());

$mode			= trim($_POST['mode']);
$savemode		= trim($_POST['savemode']);		// ��������:R, �ӽ�����:T
$tbl			= trim($_POST['tbl']);
$shop_idx		= trim($_POST['shop_idx']);
$p_idx			= trim($_POST['p_idx']);
$p_categ		= trim($_POST['p_categ']);
$p_style_kwd	= trim($_POST['p_style_kwd']);
$p_style_kwd2	= trim($_POST['p_style_kwd2']);
$p_item_kwd		= trim($_POST['p_item_kwd']);
$p_item_kwd2	= trim($_POST['p_item_kwd2']);
$p_theme_kwd	= trim($_POST['p_theme_kwd']);
$p_theme_kwd2	= trim($_POST['p_theme_kwd2']);
$p_etc_kwd		= addslashes(trim($_POST['p_etc_kwd']));
$p_gift_kind	= trim($_POST['p_gift_kind']);
$p_gift			= addslashes(trim($_POST['p_gift']));
$p_gift_cond	= trim($_POST['p_gift_cond']);
$p_gift_cnt		= trim($_POST['p_gift_cnt']);
$p_current_cash = trim($_POST['p_current_cash']);

$p_title		= addslashes(trim($_POST['p_title']));
$p_info			= addslashes(trim($_POST['p_info']));
$p_desc			= addslashes(trim($_POST['p_desc']));
$p_price		= trim($_POST['p_price']);
$p_url			= trim($_POST['p_url']);
$p_judgment		= trim($_POST['p_judgment']);
$p_auto_extend	= trim($_POST['p_auto_extend']);

//echo "p_auto_extend : ".$p_auto_extend; exit;

$p_desc_img_txt_1	= trim($_POST['p_desc_img_txt_1']);
$p_desc_img_txt_2	= trim($_POST['p_desc_img_txt_2']);
$p_desc_img_txt_3	= trim($_POST['p_desc_img_txt_3']);

$old_p_main_img	= trim($_POST['old_p_main_img']);
$old_p_base_img	= trim($_POST['old_p_base_img']);
$old_p_etc_img	= trim($_POST['old_p_etc_img']);
$old_p_desc_img	= trim($_POST['old_p_desc_img']);

// ���� ���� ĳ�ø� ���Ѵ�.
$sql = "select mem_cash from tblMember where mem_id = '$mem_id' ";
$current_mem_cash = $mainconn->count($sql);

// ���ε��̹���+url�̹��� �� �и��Ѵ�.
$old_desc_tmp_img_arr = explode(";", $old_p_desc_img);
$new_desc_str = "";
for ( $i=0; $i<sizeof($old_desc_tmp_img_arr); $i++ ) {
	if ( $old_desc_tmp_img_arr[$i] == "" ) continue;
	if ( substr($old_desc_tmp_img_arr[$i],0,7) == "http://" ) continue;
	$new_desc_str .= $old_desc_tmp_img_arr[$i].";";
}

if ( $new_desc_str ) $old_p_desc_img = $new_desc_str;

// ������ �̹����� ������ ������ ������ ����(�ε����� 1���� ����)
$img_base_index	= trim($_POST['img_base_index']);
$img_etc_index	= trim($_POST['img_etc_index']);
$img_desc_index	= trim($_POST['img_desc_index']);
if ($img_base_index) $img_base_index = substr($img_base_index,0,strlen($img_base_index)-1);
if ($img_etc_index) $img_etc_index  = substr($img_etc_index,0,strlen($img_etc_index)-1);
if ($img_desc_index) $img_desc_index = substr($img_desc_index,0,strlen($img_desc_index)-1);

/*
echo "================ �̹��� ����üũ2 ==================<br>";
echo "img_base_index : $img_base_index <br>";
echo "img_etc_index : $img_etc_index <br>";
echo "img_desc_index : $img_desc_index <br>";
echo "old_p_desc_img : $old_p_desc_img <br>";
echo "================ �̹��� ����üũ2 ==================<br><p>";
*/

//$p_key			= trim($_POST['p_key']);

if ( $p_desc_img_txt_1 == "http://" ) $p_desc_img_txt_1 = "";
if ( $p_desc_img_txt_2 == "http://" ) $p_desc_img_txt_2 = "";
if ( $p_desc_img_txt_3 == "http://" ) $p_desc_img_txt_3 = "";

$txt_desc_img_list = "";
if ( $p_desc_img_txt_1 ) {
	$txt_desc_img_list .= $p_desc_img_txt_1.";";
}
if ( $p_desc_img_txt_2 ) {
	$txt_desc_img_list .= $p_desc_img_txt_2.";";
}
if ( $p_desc_img_txt_3 ) {
	$txt_desc_img_list .= $p_desc_img_txt_3.";";
}

if ( $p_gift_kind == "Y" ) $p_gift = $DEFAULT_GIFT_STR;
if ( $mode == "" ) $mode = "I";
if ( $p_judgment == "" ) $p_judgment = "N";
$p_style_kwd_list = ( $p_style_kwd2 ) ? $p_style_kwd.",".$p_style_kwd2 : $p_style_kwd;
$p_item_kwd_list = ( $p_item_kwd2 ) ? $p_item_kwd.",".$p_item_kwd2 : $p_item_kwd;
$p_theme_kwd_list = ( $p_theme_kwd2 ) ? $p_theme_kwd.",".$p_theme_kwd2 : $p_theme_kwd;

// p_key md5 üũ
//$this_p_key = md5($mem_id.$mem_name.$mem_date);
//if ( $this_p_key != $p_key ) {
//	echo "<script>alert('�߸��� ��η� �����Ͽ����ϴ�.'); location.href='/mypage/Mcodi.php';</script>";
//	exit;
//}

// ���� �̹��� ���ε� ó��
if ( $_FILES['p_main_img']['name'] ) {
	if ( $_FILES["p_main_img"][name] && !preg_match("#\.(gif|jpg|png)$#", $_FILES["p_main_img"]['name']) ) {
		echo "<script> alert('�̹��� Ȯ���ڴ� gif,jpg,png �̾�� �մϴ�.'); history.go(-1);</script>";
		exit;
	}

	$path = "../".$UP_DIR."/thumb/";
	@mkdir($path.date("Ym"), 0777);
	//if(!@mkdir($path.date("Ym"), 0777)) {
	//	 echo "���� : ���丮�� �������� ���߽��ϴ�.".$path.date("Ym"); 
	//	 exit; 
	//}
	//else {
	//	 echo "���� : ���丮�� �����߽��ϴ�.".$path.date("Ym");
	//}

	$p_main_img = date("Ym")."/".date("YmdHis").random_code2(10).strtolower(strrchr($_FILES["p_main_img"]['name'], "."));
	$result = FileUpload("p_main_img", $path, $p_main_img);
} else {
	$p_main_img = $old_p_main_img;
}

// �⺻ �߰� �̹��� ���ε� ó��
if ( sizeof($_FILES['p_base_img']['size']) ) {
	$p_base_img_list = "";
	for ( $i=0; $i< sizeof($_FILES['p_base_img']['size']); $i++ ) {
		if ( !$_FILES['p_base_img']['size'][$i] ) continue;

		$path = "../".$UP_DIR."/thumb/";
		@mkdir($path.date("Ym"), 0777);
		//if(!@mkdir($path.date("Ym"), 0777)) {
		//	 echo "���� : ���丮�� �������� ���߽��ϴ�.".$path.date("Ym"); 
		//	 exit; 
		//}
		//else {
		//	 echo "���� : ���丮�� �����߽��ϴ�.".$path.date("Ym");
		//}

		$p_base_img = date("Ym")."/".date("YmdHis").random_code2(10).strtolower(strrchr($_FILES["p_base_img"]['name'][$i], "."));
		$result = MultiFileUpload("p_base_img", $i, $path, $p_base_img, true);
		$p_base_img_list .= $p_base_img.";";
	}
} else {
	$p_base_img_list = $old_p_base_img;
}

// �⺻ �߰� �̹��� ���ε� ó��(ĳ��)
if ( sizeof($_FILES['p_etc_img']['size']) ) {
	$p_etc_img_list = "";
	for ( $i=0; $i< sizeof($_FILES['p_etc_img']['size']); $i++ ) {
		if ( !$_FILES['p_etc_img']['size'][$i] ) continue;

		$path = "../".$UP_DIR."/thumb/";
		@mkdir($path.date("Ym"), 0777);
		//if(!@mkdir($path.date("Ym"), 0777)) {
		//	 echo "���� : ���丮�� �������� ���߽��ϴ�.".$path.date("Ym"); 
		//	 exit; 
		//}
		//else {
		//	 echo "���� : ���丮�� �����߽��ϴ�.".$path.date("Ym");
		//}

		$p_etc_img = date("Ym")."/".date("YmdHis").random_code2(10).strtolower(strrchr($_FILES["p_etc_img"]['name'][$i], "."));
		$result = MultiFileUpload("p_etc_img", $i, $path, $p_etc_img, true);
		$p_etc_img_list .= $p_etc_img.";";
	}
} else {
	$p_etc_img_list = $old_p_etc_img;
}

// ���� �̹��� ���ε� ó��(ĳ��)
if ( sizeof($_FILES['p_desc_img']['size']) ) {
	$p_desc_img_list = "";
	for ( $i=0; $i< sizeof($_FILES['p_desc_img']['size']); $i++ ) {
		if ( !$_FILES['p_desc_img']['size'][$i] ) continue;

		$path = "../".$UP_DIR."/thumb/";
		@mkdir($path.date("Ym"), 0777);
		//if(!@mkdir($path.date("Ym"), 0777)) {
		//	 echo "���� : ���丮�� �������� ���߽��ϴ�.".$path.date("Ym"); 
		//	 exit; 
		//}
		//else {
		//	 echo "���� : ���丮�� �����߽��ϴ�.".$path.date("Ym");
		//}

		$p_desc_img = date("Ym")."/".date("YmdHis").random_code2(10).strtolower(strrchr($_FILES["p_desc_img"]['name'][$i], "."));
		$result = MultiFileUpload("p_desc_img", $i, $path, $p_desc_img, true);
		$p_desc_img_list .= $p_desc_img.";";
	}
} else {
	$p_desc_img_list = $old_p_desc_img;
}

/*
echo "p_main_img : $p_main_img <br>";
echo "p_base_img_list : $p_base_img_list <br>";
echo "p_etc_img_list : $p_etc_img_list <br>";
*/

if ( $txt_desc_img_list ) {
	$p_desc_img_list .= $txt_desc_img_list;
}

/*
echo "================ �̹��� ����üũ3 ==================<br>";
echo "txt_desc_img_list : $txt_desc_img_list <br>";
echo "p_desc_img_list : $p_desc_img_list <br>";
echo "old_p_desc_img : $old_p_desc_img <br>";
echo "================ �̹��� ����üũ3 ==================<br><p>";
*/



// �ڵ� ó�� ����Ҷ�
if ( $mode == "I" ) {

	// ���� ĳ�ð� �����ϸ� ����Ʈ�� ����.
	if ( $current_mem_cash < $p_current_cash ) {
		echo "<script language='javascript'>alert('ĳ�ð� �����մϴ�.');location.href='/mypage/Mcodi.php';</script>";
		exit;
	}

	// tblProduct ����
	$p_table = ( $savemode == "R" ) ? "tblProduct" : "tblProductTmp";
	$sql = "
	insert into $p_table  
		(mem_id,shop_idx,p_categ,p_title,p_info,p_desc,p_price,p_url,
		p_style_kwd,p_item_kwd,p_theme_kwd,p_etc_kwd,p_gift,p_gift_cond,p_gift_cnt,
		p_main_img,p_base_img,p_etc_img,p_desc_img,p_auto_extend,p_judgment,p_pay_cash,p_reg_dt) 
	values 
		('$mem_id',$shop_idx,'$p_categ','$p_title','$p_info','$p_desc',$p_price,'$p_url',
		'$p_style_kwd_list','$p_item_kwd_list','$p_theme_kwd_list','$p_etc_kwd',
		'$p_gift','$p_gift_cond',$p_gift_cnt,
		'$p_main_img','$p_base_img_list','$p_etc_img_list','$p_desc_img_list',
		$p_auto_extend,'$p_judgment',$p_current_cash,now() )
	";
	$mainconn->query($sql);

	// ���� �����϶��� tblProductEach �����Ѵ�.
	// tblProductEach�� tblProduct�� p_idx�� ����Ǳ� ����.
	if ( $savemode == "R" ) {
		// tblProductEach ����
		$last_p_idx = mysql_insert_id();
		$se_arr = getWeekStartEnd($p_auto_extend+1);
		for ( $i=0; $i<$p_auto_extend+1; $i++ ) {
			$sql_each = "insert into tblProductEach (p_idx, start_dt, end_dt) values ($last_p_idx, '".$se_arr[$i][0]."', '".$se_arr[$i][1]."')";
			$mainconn->query($sql_each);
		}
	}
	
	// ����ĳ��
	$result = InsertCash($mem_id, 'CC90', 'O', $p_current_cash);

	// tblMember
	$result = UpdateMyCash( $mem_id, -$p_current_cash );



// �ڵ� �����Ҷ�
} else if ( $mode == "E" ) {
	if ( $img_base_index ) {	// �߰��̹����� ��������
		$base_idx_arr = explode(",", $img_base_index);
		$base_old_arr = explode(";", $old_p_base_img);
		$base_file_arr = explode(";", $p_base_img_list);

		for ( $i=0; $i<sizeof($base_idx_arr); $i++ ) {
			$base_old_arr[$base_idx_arr[$i]-1] = array_shift($base_file_arr);
		}
		$p_base_img_list = implode(";", $base_old_arr);
	} else {
		$p_base_img_list = $old_p_base_img;
	}
	if ( $img_etc_index ) {	// �߰��̹���(ĳ��)�� ��������
		$etc_idx_arr = explode(",", $img_etc_index);
		$etc_old_arr = explode(";", $old_p_etc_img);
		$etc_file_arr = explode(";", $p_etc_img_list);

		for ( $i=0; $i<sizeof($etc_idx_arr); $i++ ) {
			$etc_old_arr[$etc_idx_arr[$i]-1] = array_shift($etc_file_arr);
		}
		$p_etc_img_list = implode(";", $etc_old_arr);
	} else {
		$p_etc_img_list = $old_p_etc_img;
	}
	if ( $img_desc_index ) {	// �����̹����� ��������
		$desc_idx_arr = explode(",", $img_desc_index);
		$desc_old_arr = explode(";", $old_p_desc_img);
		$desc_file_arr = explode(";", $p_desc_img_list);

		for ( $i=0; $i<sizeof($desc_idx_arr); $i++ ) {
			$desc_old_arr[$desc_idx_arr[$i]-1] = array_shift($desc_file_arr);
		}
		$p_desc_img_list = implode(";", $desc_old_arr);
	} else {
		$p_desc_img_list = $old_p_desc_img;
	}

	if ( $p_desc_img_list ) $p_desc_img_list .= $txt_desc_img_list;

	if ( $p_base_img_list && substr($p_base_img_list,-1) != ";" ) $p_base_img_list .= ";";
	if ( $p_etc_img_list && substr($p_etc_img_list,-1) != ";" ) $p_etc_img_list .= ";";
	if ( $p_desc_img_list && substr($p_desc_img_list,-1) != ";" ) $p_desc_img_list .= ";";

	/*
	echo "p_base_img_list : $p_base_img_list<br>";
	echo "p_etc_img_list : $p_etc_img_list<br>";
	echo "p_desc_img_list : $p_desc_img_list<br><p>";
	*/
	
	if ( $savemode == "T" ) {

		$sql = "select p_pay_cash from tblProductTmp where p_idx=$p_idx";
		$old_p_pay_cash = $mainconn->count($sql);
		$diff_val = $p_current_cash - $old_p_pay_cash;

		// ���� ĳ�ð� �����ϸ� ����Ʈ�� ����.
		if ( $current_mem_cash < $diff_val ) {
			echo "<script language='javascript'>alert('ĳ�ð� �����մϴ�.');location.href='/mypage/Mcodi.php';</script>";
			exit;
		}

		$sql = "
		update tblProductTmp set 
		p_categ='$p_categ',p_title='$p_title',p_info='$p_info',p_desc='$p_desc',p_price=$p_price,
		p_url='$p_url',p_style_kwd='$p_style_kwd_list',p_item_kwd='$p_item_kwd_list',
		p_theme_kwd='$p_theme_kwd_list',p_etc_kwd='$p_etc_kwd',p_main_img='$p_main_img',
		p_base_img='$p_base_img_list',p_etc_img='$p_etc_img_list',p_desc_img='$p_desc_img_list',
		p_auto_extend=$p_auto_extend,p_judgment='$p_judgment',p_pay_cash=$p_current_cash
		where p_idx=$p_idx
		";
		//echo " T : ".$sql."<br>";
		$mainconn->query($sql);

		if ( $diff_val ) {

			// ����ĳ��
			$result = InsertCash($mem_id, 'CC90', 'O', $diff_val);

			// tblMember
			$result = UpdateMyCash( $mem_id, -$diff_val );
					
		}
	} else {	// ��������
		if ( $tbl == "R" ) {	// ��������->��������
			$sql = "select p_pay_cash from tblProduct where p_idx=$p_idx";
			$old_p_pay_cash = $mainconn->count($sql);
			$diff_val = $p_current_cash - $old_p_pay_cash;

			// ���� ĳ�ð� �����ϸ� ����Ʈ�� ����.
			if ( $current_mem_cash < $diff_val ) {
				echo "<script language='javascript'>alert('ĳ�ð� �����մϴ�.');location.href='/mypage/Mcodi.php';</script>";
				exit;
			}

			$sql = "
			update tblProduct set 
			p_categ='$p_categ',p_title='$p_title',p_info='$p_info',p_desc='$p_desc',p_price=$p_price,
			p_url='$p_url',p_style_kwd='$p_style_kwd_list',p_item_kwd='$p_item_kwd_list',
			p_theme_kwd='$p_theme_kwd_list',p_etc_kwd='$p_etc_kwd',p_main_img='$p_main_img',
			p_base_img='$p_base_img_list',p_etc_img='$p_etc_img_list',p_desc_img='$p_desc_img_list',
			p_auto_extend=$p_auto_extend,p_judgment='$p_judgment',p_pay_cash=$p_current_cash
			where p_idx=$p_idx
			";
			//echo " R : ".$sql."<br>"; exit;
			$mainconn->query($sql);

			if ( $diff_val ) {
					
				// ����ĳ��
				$result = InsertCash($mem_id, 'CC90', 'O', $diff_val);

				// tblMember
				$result = UpdateMyCash( $mem_id, -$diff_val );

			}
		} else {	// �ӽ�����->��������
			$sql = "select p_pay_cash from tblProductTmp where p_idx=$p_idx";
			$old_p_pay_cash = $mainconn->count($sql);
			$diff_val = $p_current_cash - $old_p_pay_cash;

			// ���� ĳ�ð� �����ϸ� ����Ʈ�� ����.
			if ( $current_mem_cash < $diff_val ) {
				echo "<script language='javascript'>alert('ĳ�ð� �����մϴ�.');location.href='/mypage/Mcodi.php';</script>";
				exit;
			}

			$sql = "
			insert into tblProduct 
				(mem_id,shop_idx,p_categ,p_title,p_info,p_desc,p_price,p_url,
				p_style_kwd,p_item_kwd,p_theme_kwd,p_etc_kwd,p_gift,p_gift_cond,p_gift_cnt,
				p_main_img,p_base_img,p_etc_img,p_desc_img,p_auto_extend,p_judgment,p_pay_cash,p_reg_dt) 
			values 
				('$mem_id',$shop_idx,'$p_categ','$p_title','$p_info','$p_desc',$p_price,'$p_url',
				'$p_style_kwd_list','$p_item_kwd_list','$p_theme_kwd_list','$p_etc_kwd',
				'$p_gift','$p_gift_cond',$p_gift_cnt,
				'$p_main_img','$p_base_img_list','$p_etc_img_list','$p_desc_img_list',
				$p_auto_extend,'$p_judgment',$p_current_cash,now() )
			";
			$mainconn->query($sql);
			//echo "sql : $sql<br>";


			// tblProductEach ����
			$last_p_idx = mysql_insert_id();
			$se_arr = getWeekStartEnd($p_auto_extend+1);
			for ( $i=0; $i<$p_auto_extend+1; $i++ ) {
				$sql_each = "insert into tblProductEach (p_idx, start_dt, end_dt) values ($last_p_idx, '".$se_arr[$i][0]."', '".$se_arr[$i][1]."')";
				$mainconn->query($sql_each);
				//echo "sql_each : $sql_each<br>";
			}


			if ( $diff_val ) {
					
				// ����ĳ��
				$result = InsertCash($mem_id, 'CC90', 'O', $diff_val);

				// tblMember
				$result = UpdateMyCash( $mem_id, -$diff_val );

			}
			
			// �ӽ� �������̺� ����
			$result = DeleteProductTmp( $p_idx );
		}
	}

} else {
	
}

//////////////////////// üũ��ƾ ���߿� �߰��ؾ� �� - -;; /////////////////////

$mainconn->close();

goto_url("/mypage/product_in03.php", "�ڵ� ���/���� ó���Ǿ����ϴ�.");
//require_once "../_bottom.php";
?>