<?php

class DBLib{
	
	private $con = null;
	private $sql = "";
	private $url = "";
	private $bind = array();
	
	function __construct($_url){
		$this->url = $_url;
	}
	function __destruct(){
		$this->close();
   }

	function open(){
		$this->db = sqlite_open($this->url, 0666, $sqliteerror);
		if(!$this->db){
			die('接続失敗'.$sqliteerror);
		}
	}

	function close(){
		if($this->db == null){
			return;
		}
		sqlite_close($this->db);
		$this->db = null;
	}

	function prepare($sql){
		$this->sql = $sql;
		$this->bind = array();  // バインドリストも初期化
	}

	private function escape($s){
		$ret = $s;
		$ret = str_replace("'", "''", $ret);
		$ret = str_replace("\\", "\\\\", $ret);
		
		return $ret;
	}

	private function bind_replace(){
		
		foreach($this->bind as $s){
			
			$this->sql = preg_replace("/\?/", ("'".$this->escape($s)."'"), $this->sql, 1);
			//print "[".$this->sql."]<br>";
		}
	}

	function bind($str){
		array_push($this->bind, $str);
	}

	function execute_update(){
		$this->bind_replace();
		
		print $this->sql;
		sqlite_query($this->db, $this->sql);
	}

	function execute(){
		$this->bind_replace();
		$rs = sqlite_query($this->db, $this->sql, SQLITE_BOTH, $sqliteerror);
		if(!$rs){
			die("データベースエラー ".$sqliteerror);
		}
		$ar = array();
		$n = sqlite_num_rows($rs);
		for ($i = 0 ;$i < $n; $i++){
	    	$rows = sqlite_fetch_array($rs, SQLITE_ASSOC);
	    	array_push($ar, $rows);  // arrayに詰めて上位に返却する
	    }
		return $ar;
	}

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
	
}
?>