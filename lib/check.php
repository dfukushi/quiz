<?php

define("P_ALPHA", "/^[a-zA-Z]*$/");
define("P_ALPHANUM", "/^[a-zA-Z0-9]*$/");
define("P_MAIL", "/^[-a-zA-Z0-9\._@+*#$%&=~\|]*$/");
define("P_YMD_YMDH", "/^([0-9]{4}[-\/][0-9]{1,2}[-\/][0-9]{1,2}|[0-9]{4}[-\/][0-9]{1,2}[-\/][0-9]{1,2} [0-9]{1,2}:[0-9]{1,2})$/");
define("P_YMD", "/^([0-9]{4}[-\/][0-9]{1,2}[-\/][0-9]{1,2})$/");
define("P_URL", "/^(http:\/\/|https:\/\/).*$/");


class RULE{
	
	var $chk;
	var $msg;
	
	function __construct($_chk, $_msg){
		$this->chk = $_chk;
		$this->msg = $_msg;
	}
	function run(){
		if($this->chk){
			throw new Exception($this->msg);
		}
	}
}


class RULE2{
	
	var $val;
	var $msg;
	var $need;
	var $min;
	var $max;
	var $pattern;
	
	function __construct($_val, $_msg, $_need = false, $_min = 0, $_max = 0, $_pattern = ""){
		
		$this->val = $_val;
		$this->msg = $_msg;
		$this->need = $_need;
		$this->min = $_min;
		$this->max = $_max;
		$this->pattern = $_pattern;
	}
	
	function run(){
		
		if($this->need){ // 必須チェック
			if($this->val == null || $this->val === ""){
				throw new Exception($this->msg."が入力されていません");
			}
		}
		if($this->min > 0){  // 最小チェック
			if(strlen($this->val) < $this->min){
				throw new Exception($this->msg."は".$this->min."バイト以上入力してください");
			}
		}
		if($this->max > 0){  // 最大チェック
			if(strlen($this->val) > $this->max){
				throw new Exception($this->msg."は".$this->max."バイト以内で入力してください");
			}
		}
		
		if($this->val === ""){
			return;
		}
		if($this->pattern !== ""){  // パターンチェック
			if(!preg_match($this->pattern, $this->val)){
				
				if($this->pattern === P_YMD_YMDH){
					throw new Exception($this->msg."はYYYY/MM/DD もしくは YYYY/MM/DD HH:Mi 形式で入力してください");
				}
				if($this->pattern === P_YMD){
					throw new Exception($this->msg."はYYYY/MM/DD 形式で入力してください");
				}
				if($this->pattern === P_URL){
					throw new Exception($this->msg."はhttpまたはhttpsから始めてください");
				}	
				throw new Exception($this->msg."に使用出来ない文字が含まれています");
			}
		}
		
	}
}

function getPost($key){
	if(!isset($_POST[$key])){
		return null;
	}
	return $_POST[$key];
}

function check(){
	
	global $chk_rule;

	foreach($chk_rule as $chk){
		if($chk instanceof RULE){
			$chk->run();
		}else{
			$chk->run();
		}
	}
}


function makeError($v){
	
	return "<br /><img src=\"img/caution.jpg\" width=\"24px\" style=\"vertical-align: -4px\">&nbsp;<p class=\"errmsg\">".ht($v)."</p><br />\n";
}



?>
