<?php

if(!isset($_GET["id"])){
	print "error";
	return;
}
$id = $_GET["id"];
$type = $_GET["type"];  // 0:失敗  1:成功

$cor = 0;
if($type == 1){
	$cor = 1;
}

$sql = "update q_quiz set 
		corrent = corrent + ?, total = total + 1 
		where id = ?";

$db->prepare($sql);
$db->bind($cor);
$db->bind($id);

print $db->execute_update_w();
	

?>