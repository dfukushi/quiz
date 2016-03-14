<?php

class DBLib{

	private $db = null;
	private $sql = "";
	private $url = "";

	private $sg = array();

	private $bind = array();

	function __construct($sg){
		$this->sg = $sg;
	}
	function __destruct(){
		$this->close();
   }

	function connect(){

		//print $this->sg["DB_HOST"]." ".$this->sg["DB_USER"]." ".$this->sg["DB_PASS"];
		$this->db = mysql_connect($this->sg["DB_HOST"], $this->sg["DB_USER"], $this->sg["DB_PASS"]);
		if(!$this->db){
			die('DB connect error '.mysql_error());
		}

		$s = mysql_select_db($this->sg["DB_NAME"], $this->db);
		if(!$s){
			print mysql_error();
			mysql_close($this->db);
			die('DB select error '.$this->sg["DB_NAME"]);
		}

		mysql_set_charset($this->sg["DB_CHARSET"], $this->db);

		$this->autocommit_off();

	}

	function close(){
		if($this->db == null){
			return;
		}
		mysql_close($this->db);
		$this->db = null;
	}


	function prepare($sql){
		$this->sql = $sql;
		$this->bind = array();  // バインドリストも初期化
	}

	private function escape($s){
		$ret = $s;
		$ret = str_replace("\\", "￥", $ret);
		$ret = str_replace("'", "\\'", $ret);
		$ret = str_replace("?", "#QUES#", $ret);

		return $ret;
	}
	private function reverse($s){
		$ret = $s;
		$ret = str_replace("#QUES#", "?", $ret);

		return $ret;
	}

	private function bind_replace($log = true){

		foreach($this->bind as $s){
			$this->sql = preg_replace("/\?/", ("'".$this->escape($s)."'"), $this->sql, 1);
		}
		$this->sql = $this->reverse($this->sql);

		if($log){
			//print "[".htmlspecialchars($this->sql)."]<br>";
		}
	}

	function bind($str){
		array_push($this->bind, $str);
	}


	function execute_update($log = true){

		$this->bind_replace($log);

		return mysql_query($this->sql, $this->db);
	}


	function execute_update_w(){

		$this->bind_replace();
		$r = mysql_query($this->sql, $this->db);

		$err = mysql_errno();

		if(!$r && $err != 1062){  // 一意制約は黙殺
			$m = htmlspecialchars(mysql_error());
			$this->rollback();
			$msg = "登録に失敗しました・・・<br />\n";
			$msg .=  $m."<br />\n";
		}else{
			$this->commit();
			$msg = "登録が完了しました<br />\n";
		}

		return $msg;
	}


	function execute(){
		$this->bind_replace();
		$rs = mysql_query($this->sql, $this->db);
		if(!$rs){
			print mysql_error();
			mysql_free_result($rs);
			return $ar;
		}

		$ar = array();
		while($row = mysql_fetch_assoc($rs)){
			array_push($ar, $row);  // arrayに詰めて上位に返却する
		}
		mysql_free_result($rs);

		return $ar;
	}

	function execute1(){
		$this->bind_replace();
		$rs = mysql_query($this->sql, $this->db);
		if(!$rs){
			print mysql_error();
			mysql_free_result($rs);
			return $ar;
		}

		$ar = array();
		$n = mysql_num_rows($rs);
		if($n == 0){
			mysql_free_result($rs);
			return null;
		}

		while($row = mysql_fetch_assoc($rs)){
			$ar = $row;
			break;
		}

		mysql_free_result($rs);
		return $ar;
	}

	function execute11(){
		$this->bind_replace();
		$rs = mysql_query($this->sql, $this->db);
		if(!$rs){
			print mysql_error();
			mysql_free_result($rs);
			return $ar;
		}

		$ar = array();
		$n = mysql_num_rows($rs);
		if($n == 0){
			mysql_free_result($rs);
			return null;
		}

		while($row = mysql_fetch_assoc($rs)){

			foreach($row as $r){
				$ar = $r;
				break;
			}
			break;
		}

		mysql_free_result($rs);
		return $ar;
	}

	function rollback(){
		$this->sql = "rollback";
		$this->bind_replace();
		$rs = mysql_query($this->sql, $this->db);
		if(!$rs){
			print mysql_error();
		}
	}

	function commit($log = true){
		$this->sql = "commit";
		$this->bind_replace($log);
		$rs = mysql_query($this->sql, $this->db);
		if(!$rs){
			print mysql_error();
		}
	}

	function autocommit_off(){
		$this->sql = "SET AUTOCOMMIT=0";
		$this->bind_replace(false);
		$rs = mysql_query($this->sql, $this->db);
		if(!$rs){
			print mysql_error();
		}
	}



/*
	function execute1(){  // 取得結果が1件とわかりきっている場合
		$this->bind_replace();
		$rs = sqlite_query($this->db, $this->sql, SQLITE_BOTH, $sqliteerror);
		if(!$rs){
			die("データベースエラー ".$sqliteerror);
		}
		$ar = array();
		$n = sqlite_num_rows($rs);

		if($n == 0){
			return null;
		}

		for ($i = 0 ;$i < 1; $i++){
	    	$rows = sqlite_fetch_array($rs, SQLITE_ASSOC);
	    	break;  // 最初の1行のみを返却する
	    }
		return $rows;
	}
*/
}
?>