<?
/*━[ 프로그램  정보 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 프로그램 : CSQLRelay (MySQL class) Ver 1.00                                 ┃
┃ 작 성 자 : 이광철 (따식이)                                               ┃
┃ 화일이름 : CSQLRelay.inc.php                                                ┃
┃ 설    명 : MySQL 클래스                                                  ┃
┃ 사용언어 : GNU C/C++                                                     ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

┏━[ 변경이력 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 작업자 작  업  일 변경내용                                               ┃
┃ ------ ---------- ------------------------------------------------------ ┃
┃ 이광철 2004.05.21 최초작성                                               ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/

function GetMicrotime($old, $new) 
{
	// 주어진 문자열을 나눔 (sec, msec으로 나누어짐) 
	$old = explode(" ", $old); 
	$new = explode(" ", $new); 

	$time[msec] = $new[0] - $old[0]; 
	$time[sec]  = $new[1] - $old[1]; 

	if($time[msec] < 0)
	{
		$time[msec] = 1.0 + $time[msec]; 
		$time[sec]--; 
	}

	$time = sprintf("%.2f", $time[sec] + $time[msec]); 

	return $time; 
}


class CSQLRelay
{
	var $host, $id, $pass, $db, $port;
	var $oldhost, $olddb, $conn;

	function CSQLRelay()
	{
		$this->oldhost = "";
		$this->id      = "";
		$this->pass    = "";
		$this->db      = "";

		$this->conn = null;
	}



	function close()
	{
		if($this->conn == null)
			return;

		$this->oldhost = "";
		$this->id      = "";
		$this->pass    = "";
		$this->db      = "";

		$this->port    = 3306;
		mysql_close($this->conn);
		unset($this->conn);

		$this->conn = null;
	}



	function set($host, $id, $pass, $db, $port = 3306)
	{
		if($host == $this->oldhost && $db == $this->olddb)
			return;
	
		$this->close();
	
		$this->host = $host;
		$this->id   = $id;
		$this->pass = $pass;
		$this->db   = $db;
		$this->port = $port;

		$this->oldhost = $host;
		$this->olddb   = $db;
	}



	function open()
	{
		if($this->conn != null)
			return;

//		echo "///////////////".$this->host."..................".$this->db;

		$this->conn = mysql_connect($this->host, $this->id, $this->pass) or die("exit");
		mysql_select_db($this->db, $this->conn);

//		register_shutdown_function($this->close);
	}

//register_shutdown_function(array(&$this, 'close_error'));

	// 실제 쿼리를 날린다
	function query($str)
	{
		$ret = null;

		if($this->conn == null)
			return null;


		$start = microtime();
		$ret = mysql_query($str, $this->conn);
		$ftime = GetMicrotime($start, microtime());

		if($ftime >= 1)
		{
			$fp = fopen("/assalabia/log/query_delay/".date("Y-m-d").".log", "a");
			fputs($fp, "=== [".date("Y/m/d H:i:s")."] =========================== [수행시간: ".$ftime."]======================\n");
			fputs($fp, $str."\n");
			fputs($fp, "===========================================================================================\n\n");
			fclose($fp);

			chmod("/assalabia/log/query_delay/".date("Y-m-d").".log", 0777);
		}

/*
		$fp = fopen("/assalabia/log/query/".date("Y-m-d").".log", "a");
		fputs($fp, "=== [".date("Y/m/d H:i:s")."] =================================================================\n");
		fputs($fp, $str."\n");
		fputs($fp, "------------------------------------------------------------------------------------------\n");
		fputs($fp, "===========================================================================================\n\n");
		fclose($fp);

		chmod("/assalabia/log/query/".date("Y-m-d").".log", 0777);
*/
		
		if ( mysql_errno() || mysql_error() )
		{
			echo mysql_errno() . " : " . mysql_error();

			$fp = fopen("/assalabia/log/query_error/".date("Y-m-d").".log", "a");
			fputs($fp, "=== [".date("Y/m/d H:i:s")."] =================================================================\n");
			fputs($fp, "filename: $_SERVER[REQUEST_URI]\n");
			fputs($fp, $str."\n");
			fputs($fp, "------------------------------------------------------------------------------------------\n");
			fputs($fp, mysql_errno()." : ".mysql_error()."\n");
			fputs($fp, "===========================================================================================\n\n");
			fclose($fp);

			chmod("/assalabia/log/query_error/".date("Y-m-d").".log", 0777);
		}

		return $ret;
	}


	function fetchRow($res)
	{
		if($res == null)
			return null;

		return mysql_fetch_row($res);
	}



	function fetch($res)
	{
		if($res == null)
			return null;

		return 	mysql_fetch_assoc($res);
	}


	function rand($start, $end)
	{
		$end = ($end-$start+1);
		return "rand()*".$end."%".$end."+".$start;
	}

	function addslashes($str)
	{
		return ereg_replace("('|\\\)", "\\\\1", $str);
	}


	function seek($res, $pos)
	{
		if($res == null)
			return null;

		if($this->numRows($res) < 1)
			return null;

		return mysql_data_seek($res, $pos);
	}


	function count($str)
	{
		$row = $this->fetchRow($this->query($str));
		if($row == null)
			return 0;

		return $row[0];
	}



	function freeResult($res)
	{
		if($res == null)
			return;

		mysql_free_result($res);
	}
	

	function numRows($res)
	{
		if($res == null)
			return 0;

		return mysql_num_rows($res);
	}


	function affectedRows()
	{
		if($this->conn == null)
			return 0;

		return mysql_affected_rows($this->conn);
	}


	function lastInsertID()
	{
		return $this->count("SELECT LAST_INSERT_ID()");
	}


	function errstr()
	{
		if ( mysql_error() || mysql_error() )
		{
			return mysql_errno() . " : " . mysql_error();
		}
		else
		{
			return 0;
		}
	}
	
}

?>