<?
/*��[ ���α׷�  ���� ]��������������������������������������������������������
�� ���α׷� : CMySQL (MySQL class) Ver 1.05                                 ��
�� �� �� �� : �̱�ö (������)                                               ��
�� ȭ���̸� : CMySQL.inc.php                                                ��
�� ��    �� : MySQL Ŭ����                                                  ��
�� ����� : PHP                                                           ��
������������������������������������������������������������������������������

����[ �����̷� ]��������������������������������������������������������������
�� �۾��� ��  ��  �� ���泻��                                               ��
�� ------ ---------- ------------------------------------------------------ ��
�� �̱�ö 2004.05.21 �����ۼ�                                               ��
�� �̱�ö 2007.02.09 �ּ��۾�                                               ��
����������������������������������������������������������������������������*/



function GetMicrotime($old, $new) 
{
	// �־��� ���ڿ��� ���� (sec, msec���� ��������) 
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



class CMySQL
{
	var $host, $id, $password, $db, $port;
	var $oldhost, $olddb, $conn;
	var $mbuff;

	function CMySQL()
	{
		$this->oldhost = "";
		$this->id      = "";
		$this->pass    = "";
		$this->db      = "";

		$this->mbuff   = array();
		$this->conn = null;
	}



	/*��[ �Լ����� ]��������������������������������������������������������������
	�� �� �� �� : function CMySQL::close()                                      ��
	�� ��    �� : MySQL��� ���� (���ϴݱ�)                                     ��
	����������������������������������������������������������������������������*/

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



	/*��[ �Լ����� ]��������������������������������������������������������������
	�� �� �� �� : function CMySQL::set()                                        ��
	�� ��    �� : MySQL����� ���� ���� (���� ������ ���� �ʰ� �غ�)            ��
	�� �� �� �� : $host     = �����ּ� (localhost, www.test.com, ������)        ��
	��            $id       = ���̵�                                            ��
	��            $password = ��й�ȣ                                          ��
	��            $db       = ���Ӱ� ���ÿ� ����� ����Ÿ���̽���               ��
	��            $port     = ��Ʈ��ȣ                                          ��
	����������������������������������������������������������������������������*/

	function set($host, $id, $password, $db, $port = 3306)
	{
		if($host == $this->oldhost && $db == $this->olddb)
			return;
	
		$this->close();
	
		$this->host = $host;
		$this->id   = $id;
		$this->pass = $password;
		$this->db   = $db;
		$this->port = $port;

		$this->oldhost = $host;
		$this->olddb   = $db;
	}



	/*��[ �Լ����� ]��������������������������������������������������������������
	�� �� �� �� : function CMySQL::open()                                       ��
	�� ��    �� : ����Ÿ���̽� ������ ����                                      ��
	����������������������������������������������������������������������������*/

	function open()
	{
		if($this->conn != null)
			return;
//print __FILE__ . __LINE__ . "host:" . $this->host . "<br>"; 
//print __FILE__ . __LINE__ . "id:" . $this->id . "<br>"; 
//print __FILE__ . __LINE__ . "pass:" . $this->pass . "<br>"; 
//print __FILE__ . __LINE__ . "db:" . $this->db . "<br>"; 
//print __FILE__ . __LINE__ . "$_SERVER['HTTP_HOST']:" . $_SERVER['HTTP_HOST'] . "<br>"; 
//TODO TEMPCODE
if ($_SERVER['HTTP_HOST'] == "localhost")
{
	$this->id = "roothope";
	$this->pass = "codi1324!";
	$this->db = "roothope";
}
else /* hostinger http://codi.esy.es */
{
	$this->host = "localhost";
	$this->id = "roothope";
	$this->pass = "asero1324!";
	$this->db = "roothope";
}
/*
print __FILE__ . __LINE__ . "_SERVER['HTTP_HOST']:" . $_SERVER['HTTP_HOST'] . "<br>"; 
print __FILE__ . __LINE__ . "host:" . $this->host . "<br>"; 
print __FILE__ . __LINE__ . "id:" . $this->id . "<br>"; 
print __FILE__ . __LINE__ . "pass:" . $this->pass . "<br>"; 
print __FILE__ . __LINE__ . "db:" . $this->db . "<br>"; 
*/

		$this->conn = mysql_connect($this->host, $this->id, $this->pass) or die("exit");
//		mysql_query("set names utf8") ; // TODO 2014-01-06 add
		mysql_query("set names euckr") ; // TODO 2014-01-06 add
		mysql_select_db($this->db, $this->conn);

//print __FILE__ . __LINE__ . "<br>";  exit;
//		register_shutdown_function($this->close);
	}



	/*��[ �Լ����� ]��������������������������������������������������������������
	�� �� �� �� : function CMySQL::query()                                      ��
	�� ��    �� : ������ ����Ϸ��� ���� ����                                   ��
	�� �� �� �� : $str      = ���� ���ڿ�                                       ��
	�� �� �� �� : ��� ����Ÿ (fetchRow, fetch�Լ��� �̿��Ͽ� ���)             ��
	����������������������������������������������������������������������������*/

	// ���� ������ ������
	function query($str)
	{
		$ret = null;

		if($this->conn == null)
			return null;

		if(strlen($str) < 1)
			return null;

		$start = microtime();
		$ret = mysql_query($str, $this->conn);
		$ftime = GetMicrotime($start, microtime());

		if($ftime >= 1)
		{
			$fp = fopen(MYSQL_LOG_DIR."/query_delay/".date("Y-m-d").".log", "a");
			fputs($fp, "=== [".date("Y/m/d H:i:s")."] =========================== [����ð�: ".$ftime."]======================\n");
			fputs($fp, $str."\n");
			fputs($fp, "===========================================================================================\n\n");
			fclose($fp);

			chmod(MYSQL_LOG_DIR."/query_delay/".date("Y-m-d").".log", 0777);
		}

		if ( mysql_errno() || mysql_error() )
		{
			echo mysql_errno() . " : " . mysql_error();

			$fp = fopen(MYSQL_LOG_DIR."/query_error/".date("Y-m-d").".log", "a");
			fputs($fp, "=== [".date("Y/m/d H:i:s")."] =================================================================\n");
			fputs($fp, "filename: $_SERVER[REQUEST_URI]\n");
			fputs($fp, $str."\n");
			fputs($fp, "------------------------------------------------------------------------------------------\n");
			fputs($fp, mysql_errno()." : ".mysql_error()."\n");
			fputs($fp, "===========================================================================================\n\n");
			fclose($fp);

			chmod(MYSQL_LOG_DIR."/query_error/".date("Y-m-d").".log", 0777);
		}

		return $ret;
	}



	/*��[ �Լ����� ]��������������������������������������������������������������
	�� �� �� �� : function CMySQL::fetchRow()                                   ��
	�� ��    �� : query�� �޾ƿ� ����Ÿ�� �����Ͽ� �迭�� �ֱ�                  ��
	��            $res = query("SELECT idx, name, jumin FROM member_info");     ��
	��            while(($row = fetchRow($res)))                                ��
	��            {                                                             ��
	��                echo $row[0]."/".$row[1];  // $row["name"] (x)            ��
	��            }                                                             ��
	��                                                                          ��
	��            freeResult($res) // �޸� ��ȯ (�ݵ�� ��� ����Ŀ� ȣ��)   ��
	��                                                                          ��
	�� �� �� �� : $res  = ���� ���ڿ�                                           ��
	�� �� �� �� : �迭 ����Ÿ (���� ���ڿ��� ������� ����)                   ��
	����������������������������������������������������������������������������*/

	function fetchRow($res)
	{
		if($res == null)
			return null;

		return mysql_fetch_row($res);
	}



	/*��[ �Լ����� ]��������������������������������������������������������������
	�� �� �� �� : function CMySQL::fetch()                                      ��
	�� ��    �� : query�� �޾ƿ� ����Ÿ�� �����Ͽ� �迭�� �ֱ�                  ��
	��            $res = query("SELECT idx, name, jumin FROM member_info");     ��
	��            while(($row = fetchRow($res)))                                ��
	��            {                                                             ��
	��                echo $row[0]."/".$row["name"];  // $row["name"] (o)       ��
	��            }                                                             ��
	��                                                                          ��
	��            freeResult($res) // �޸� ��ȯ (�ݵ�� ��� ����Ŀ� ȣ��)   ��
	�� �� �� �� : $res  = ���� ���ڿ�                                           ��
	�� �� �� �� : �迭 ����Ÿ (���ڿ� ��� ����)                                ��
	����������������������������������������������������������������������������*/

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



	/*��[ �Լ����� ]��������������������������������������������������������������
	�� �� �� �� : function CMySQL::count()                                      ��
	�� ��    �� : ������ �ʵ尡 �ϳ��̸� ���ڷε� ����϶� ���                 ��
	�� �� �� �� : $str      = ���� ���ڿ�                                       ��
	�� �� �� �� : ��� ����Ÿ                                                   ��
	����������������������������������������������������������������������������*/

	function count($str)
	{
		$row = $this->fetchRow($this->query($str));
		if($row == null)
			return 0;

		return $row[0];
	}



	/*��[ �Լ����� ]��������������������������������������������������������������
	�� �� �� �� : function CMySQL::freeResult()                                 ��
	�� ��    �� : result�� ���� �޸�(memory)�� �ִ� ������ ��� �����Ѵ�.     ��
	����������������������������������������������������������������������������*/

	function freeResult($res)
	{
		if($res == null)
			return;

		mysql_free_result($res);
	}
	



	/*��[ �Լ����� ]��������������������������������������������������������������
	�� �� �� �� : function CMySQL::numRows()                                    ��
	�� ��    �� : ����κ��� �� ������ ��ȯ                                     ��
	�� �� �� �� : �� ����                                                       ��
	����������������������������������������������������������������������������*/

	function numRows($res)
	{
		if($res == null)
			return 0;

		return mysql_num_rows($res);
	}



	/*��[ �Լ����� ]��������������������������������������������������������������
	�� �� �� �� : function CMySQL::affectedRows()                               ��
	�� ��    �� : �ֱ� ����� INSERT, UPDATE, DELETE ���Ƿ� ó���� ���� ������ȯ��
	��            ������ ���ǰ� WHERE ���� ���� DELETE ���Ƕ��,                ��
	��            ���̺��� ��� ���ڵ尡 �����Ǵ��� �� �Լ��� 0���� �����ش�. ��
	��            �� �Լ��� SELECT ������ �������� ������, ���ڵ尡 �����Ǵ�    ��
	��            ��쿡�� �����Ѵ�.                                            ��
	��            SELECT �������κ��� �������� ���� ������ ��������,            ��
	��            numRows()�� ���� �ȴ�.                                        ��
	�� �� �� �� : ����� ������ ��                                              ��
	����������������������������������������������������������������������������*/

	function affectedRows()
	{
		if($this->conn == null)
			return 0;

		return mysql_affected_rows($this->conn);
	}



	/*��[ �Լ����� ]��������������������������������������������������������������
	�� �� �� �� : function CMySQL::fetch()                                      ��
	�� ��    �� : �ֱ� INSERT �۾����κ��� ������ identifier ���� ��ȯ          ��
	�� �� �� �� : identifier ��                                                 ��
	����������������������������������������������������������������������������*/

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



	function mclear()
	{
		unset($this->mbuff);
		$this->mbuff = array();
	}


	function mpush($str)
	{
		if(strlen($str) < 1)
			return;

		array_push($this->mbuff, $str);
	}

	function mquery()
	{
		if(count($this->mbuff) < 1)
			return;

		for($i=0; $i<count($this->mbuff); $i++)
		{
	//		$str = join($this->mbuff, ";");
			$this->query($this->mbuff[$i]);
		}

		$this->mclear();
	}
}

?>