<?php


function design_write(){
	global $design;
	global $sg;

	// バックアップ
	copy($sg["TEMPLATE_PATH"]."/conf/design.ini", $sg["TEMPLATE_PATH"]."/conf/design.ini.".date("YmdHis").".bk");

	$fp = fopen($sg["TEMPLATE_PATH"]."/conf/design.ini", "w");
	foreach($design as $key => $val){
		$v = sprintf("%s = \"%s\"\n", $key, str_replace("\"", "'", $val));
		fwrite($fp, $v);
	}
	fclose($fp);
}
function ment_write(){
	global $ment_ini;
	global $sg;

	// バックアップ
	copy($sg["TEMPLATE_PATH"]."/conf/ment.ini", $sg["TEMPLATE_PATH"]."/conf/ment.ini.".date("YmdHis").".bk");

	$fp = fopen($sg["TEMPLATE_PATH"]."/conf/ment.ini", "w");
	foreach($ment_ini as $key => $val){
		$v = sprintf("%s = \"%s\"\n", $key, $val);
		fwrite($fp, $v);
	}
	fclose($fp);

}

function encode($v, $key){
	return hash_hmac("crc32", $v, $key, false);
}


function rnd_id($seed){
	$v = encode($seed, rand(1,20));
	return substr($v, 0, 16);
}


function _make_id($type, $db){


	$sql = "select id_".$type." from id_list for update";

	$db->prepare($sql);
	$id = $db->execute11();
	$id += 1;  // 今回のID

	$sql = "update id_list set id_".$type." = ?";
	$db->prepare($sql);
	$db->bind($id);
	$r = $db->execute_update();
	if(!$r){
		print mysql_error();
		$db->rollback();
		die("IDの払い出しに失敗");
	}

	$db->commit();

	$id = sprintf("%010d", $id);
	$id = encode($id, $type);
	return $id;
}
function make_id($type, $db = null){

	global $sg;

	if($db == null){  // DB渡って来ないと接続～解放までやってあげる
		$db = new DBLib($sg);
		$db->connect();
		$id = _make_id($type, $db);
		$db->close();
		return $id;
	}

	return _make_id($type, $db);
}

function deletedir($rootPath){


    $strDir = opendir($rootPath);
    while($strFile = readdir($strDir)){

        if($strFile != '.' && $strFile != '..'){
            unlink($rootPath.'/'.$strFile);
        }
    }
    closedir($strDir);
    return rmdir($rootPath);
}


function startsWith($haystack, $needle){
    return strpos($haystack, $needle, 0) === 0;
}

function ht($str){
	if(phpversion() == "5.3.29"){
		return htmlspecialchars($str);
	}
	return htmlspecialchars($str, ENT_HTML401, "utf-8");
}
function htbr($str){
	$v = htmlspecialchars($str);
	$v = str_replace("\r", "", $v);
	$v = str_replace("\n", "<br>", $v);
	return $v;
}
function htlink($str){
	return url_henkan($str);
}

function url_henkan($mojiretu){



	if(preg_match('/(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/',$mojiretu)){

		preg_match_all('/(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/',$mojiretu,$pattarn);
			foreach ($pattarn[0] as $key=>$val){
				$replace[] = '<a href="'.$val.'" target="_blank" title="'.$val.'">'.$val.'</a>';
			}
		$mojiretu = str_replace($pattarn[0],$replace,$mojiretu);

	}
	if (preg_match("/([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+/", $mojiretu)) {

		preg_match_all("/([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+/",$mojiretu,$pattarn);
			foreach ($pattarn[0] as $key=>$val){
				$rep[] = '<a href="mailto:'.$val.'"  title="メールを送る">'.$val.'</a>';
			}
		$mojiretu = str_replace($pattarn[0],$rep,$mojiretu);
	}

	return $mojiretu;
}



function paging($db, $sql, $max = 0){

	global $paging;
	global $paging_max;

	if($max == 0){
		$n = preg_replace("/\..*$/", "", basename($_SERVER["SCRIPT_NAME"]));
		if(!isset($paging_max[$n])){
			$max = $paging_max["default"];
		}else{
			$max = $paging_max[$n];
		}
	}

	$sq = str_replace("\r", " ", $sql);
	$sq = str_replace("\n", " ", $sq);

	$sqlc = preg_replace("/select .* from /", "select count(1) from ", $sq);

	$db->prepare($sqlc);
	$cnt = $db->execute11();

	$page_cnt = ceil($cnt / $max);

	if($page_cnt <= 1){
		$paging = "<hr>\n";
		return $sql;
	}

	$ix = "1";
	if(isset($_GET["ix"])){
		$ix = $_GET["ix"];
	}else if(isset($_POST["ix"])){
		$ix = $_POST["ix"];
	}

	if($ix < 1){
		$ix = 1;
	}
	if($ix >= $page_cnt){
		$ix = $page_cnt;
	}




	$s = ($max * ($ix-1));

	$temp = "template/loop/_paging.php";
	ob_start();
	include($temp);
	$paging = ob_get_clean();

	return $sql.= " limit ".$s.",".$max;
}



function g_title($v){
	if($v === ""){
		return "無題";
	}
	return $v;
}
function g_name($v){
	if($v === ""){
		return "名無しさん";
	}
	return $v;
}
function g_song($v){
	if($v === ""){
		return "不明";
	}
	return $v;
}
function g_body($v){
	if($v === ""){
		return "特になし";
	}
	return $v;
}


function imgsize($img, $width, $height){

	if(!file_exists($img)){
		return;
	}

	$size = getimagesize($img);
	if($size[0] > $width){
		return " width=\"".$width."px\"";
	}
	if($size[1] > $height){
		return " height=\"".$height."px\"";
	}
}

?>
