<?php
/*******************************************************
 * author : Chan Hwang (gogisnim@gmail.com)
 * file   : /coditop/manage/logout.php
 * date   : 2008.08.07
 * desc   : logout
 *******************************************************/

session_start();
require_once "../inc/common.inc.php";

session_destroy(); 


goto_url("$ADMIN_AUTH");
//echo "<script>alert('로그아웃 되었습니다.');</script>";
?>