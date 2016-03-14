<?php
if (array_shift(get_included_files()) === __FILE__) die('cannot call directly');


class Alog{

	public $log_date = "";
	public $db = null; //
	public $accept_date = ""; //
	public $proc_time = ""; //
	public $status = ""; //

	public $url = ""; //
	public $uri = ""; //
	
	
	public $from_ip = "";  //
	public $from_addr = ""; //
	public $referer = ""; //
	public $referer_full = ""; //
	public $ua = ""; //
	public $carrier = "";
	public $ment_flg = ""; //
	public $option1 = "";
	public $option2 = "";
	public $option3 = "";
	public $option4 = "";
	public $option5 = "";
	public $option6 = "";
	
	public $nowment = "";
	
	
	
	function __construct(){
		
		global $ment_mode;
		global $template;
		
		$this->accept_date = microtime(true) * 1000;

		$ref	= isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "";
		$ref2	= preg_replace("/\?.*$/", "", $ref);

		$this->status		= "0000";
		$this->url			= preg_replace("/\?.*$/", "", preg_replace("/^.*\//", "", $_SERVER["REQUEST_URI"]));
		$this->uri			= basename($_SERVER["SCRIPT_NAME"]);
		$this->from_ip		= $_SERVER["REMOTE_ADDR"];
		$this->from_addr	= $_SERVER["REMOTE_ADDR"];
		$this->referer_full = $ref;
		$this->referer		= $ref2;
		$this->ua			= $_SERVER["HTTP_USER_AGENT"];
		
		$this->ment_flg		= ($ment_mode ? "1" : "0");	
		$this->set_carrier($this->ua);
		$this->option1		= $template;
		
		$id = "";
		if(isset($_REQUEST["id"])){
			$id = $_REQUEST["id"];
		}else if(isset($_REQUEST["i"])){
			$id = $_REQUEST["i"];
		}
		
		$this->option2		= (isset($_GET["ix"]) ? $_GET["ix"] : "");
		$this->option3		= (isset($_POST["p"]) ? $_POST["p"] : "");
		$this->option4		= ($id);
		
		$nowment 			= 0;
	}
	

	function _throw(){
		return (microtime(true) * 1000) - $this->accept_date;
	}

	function fin(){
		$this->proc_time = $this->_throw();
	}


	private function get_carrier($ua){

		$car = stripos($ua, "Android");
		if($car !== false){
			return "Android";
		}
		$car = stripos($ua, "iPhone");
		if($car !== false){
			return "iPhone";
		}
		$car = stripos($ua, "iPod");
		if($car !== false){
			return "iPod";
		}
		$car = stripos($ua, "iPad");
		if($car !== false){
			return "iPad";
		}
		$car = stripos($ua, "BlackBerry");
		if($car !== false){
			return "BlackBerry";
		}
		$car = stripos($ua, "Symbian");
		if($car !== false){
			return "Symbian";
		}
		
		$car = stripos($ua, "docomo/");
		if($car !== false){
			return "DoCoMo携帯";
		}
		$car = stripos($ua, "UP.Browser/");
		if($car !== false){
			return "au携帯";
		}
		$car = stripos($ua, "SoftBank/");
		if($car !== false){
			return "SoftBank携帯";
		}
		$car = stripos($ua, "J-PHONE/");
		if($car !== false){
			return "J-PHONE携帯";
		}
		$car = stripos($ua, "Vodafone/");
		if($car !== false){
			return "Vodafone携帯";
		}		

		return "other";
	}
	
	function set_carrier($ua){

		$this->carrier = $this->get_carrier($ua);
	}
	
	
	function write(){
		
		global $sg;
		
		$db = $this->db;


		$sql = "insert into access_log (log_date,accept_date,proc_time,status,url,uri,from_ip,from_addr,referer,referer_full,ua,
carrier,ment_flg,option1,option2,option3,option4,option5,option6) values (
?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$db->prepare($sql);
		$db->bind($this->log_date);
		$db->bind($this->log_date);
		$db->bind(floor($this->proc_time));
		$db->bind($this->status);
		$db->bind($this->url);
		$db->bind($this->uri);
		$db->bind($this->from_ip);
		$db->bind($this->from_addr);
		$db->bind($this->referer);
		$db->bind($this->referer_full);
		$db->bind($this->ua);
		$db->bind($this->carrier);
		$db->bind($this->ment_flg);
		$db->bind($this->option1);
		$db->bind($this->option2);
		$db->bind($this->option3);
		$db->bind($this->option4);
		$db->bind($this->option5);
		$db->bind($this->nowment);

		$db->execute_update(true);
		print mysql_error();
	}
}




?>