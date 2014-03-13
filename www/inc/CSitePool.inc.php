<?
/*━[ 프로그램  정보 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 프로그램 : CSitePool (MySQL class) Ver 1.00                                 ┃
┃ 작 성 자 : 이광철 (따식이)                                               ┃
┃ 화일이름 : CSitePool.inc.php                                                ┃
┃ 설    명 : MySQL 클래스                                                  ┃
┃ 사용언어 : GNU C/C++                                                     ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

┏━[ 변경이력 ]━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 작업자 작  업  일 변경내용                                               ┃
┃ ------ ---------- ------------------------------------------------------ ┃
┃ 이광철 2004.05.21 최초작성                                               ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━*/

require_once "/assalabia/inc/CSocket.inc.php";


function PoolGetMicrotime($old, $new) 
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


class CSitePool
{
	var $host, $id, $pass, $db, $port;
	var $oldhost, $olddb, $conn;

	function CSitePool()
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
//		mysql_close($this->conn);
//		unset($this->conn);

		fclose($this->conn);

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

//		$this->conn = mysql_connect($this->host, $this->id, $this->pass) or die("exit");
//		mysql_select_db($this->db, $this->conn);
//		$socket->set($server, $port);
		if (!($this->conn = @fsockopen($this->host, $this->port, &$errorno, &$errstr, 15)))
		{
			echo "db connecting error!!!";
			$this->conn = null;
			return;
		}

		fputs($this->conn, "action=login`id=$this->db`pwd=$this->pass"."\0");
//		fflush($this->conn);

		$ret = $this->recv();
		if($ret == null)
		{
			echo "Login Faild!!!";
			$this->conn = null;
			return;
		}

		if($ret != "action=loginok")
		{
			echo "Login2 Faild!!!";
			$this->conn = null;
			return;
		}

//		register_shutdown_function($this->close);
	}

//register_shutdown_function(array(&$this, 'close_error'));

	function recv()
	{
		$ret="";
		
		if($this->conn == null)
			return null;

		stream_set_timeout($this->conn, 7);

//		while (!feof($this->conn))
		{
			$str = fread($this->conn, 64000);
			if($str == FALSE)
				return null;
			
			$ret .= $str;
		}
		
		return trim($ret);
	}


	function send($str)
	{
		if($this->conn == null)
			return null;

		fputs($this->conn, $str."\0");
		fflush($this->conn);
	}

	// 실제 쿼리를 날린다
	function query($str)
	{
		$ret = null;

		if($this->conn == null)
			return null;

		$start = microtime();

		$this->send($str);
		$rdata = $this->recv();
		
		if($rdata == null)
			return null;

		parse_str($rdata, $ret);

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

		if($pos >= $this->numRows($res))
			$pos = $this->numRows($res) - 1;

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