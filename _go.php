<?php

	// TIMEZONE設定
	date_default_timezone_set('Asia/Tokyo');

	$sg				= parse_ini_file("./conf/sg.ini");

	require_once($sg["LIB_PATH"]."/lib.php");
	require_once($sg["LIB_PATH"]."/alog.php");
	require_once($sg["LIB_PATH"]."/check.php");


	require_once("./test/mysql.php");
	
	$errmsg = "";
	$hh = "";
	
	
	$db = new DBLib($sg);
	$db->connect();
	
	

	$uri = basename($_SERVER["SCRIPT_FILENAME"]);
	
	// 通常なら通常TEMPLATE使用
	$template = $sg["TEMPLATE_PATH"]."/".$temp;
	if(!file_exists($template)){
		$template = $sg["TEMPLATE_PATH"]."/_no.php";
	}
	
	require_once($sg["TEMPLATE_PATH"]."/basic/_basic.php");
	
	
	$db->close();
	
	
?>