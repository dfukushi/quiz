<?php


$db = mysql_connect("localhost", "u_triplexross", "VWXWCLWC");

if(!$db){
	die('DB connect error '.mysql_error());
	die;
}

$s = mysql_select_db("u_triplexross", $db);
if(!$s){
	print mysql_error();
	mysql_close($db);
	die('DB select error ');
}

mysql_set_charset('SHIFT-JIS');

/*
$sql = "delete from AAA";
//$sql = "create table AAA (id varchar(10), name varchar(20))";
$result_flag = mysql_query($sql);

if (!$result_flag) {
	print mysql_error();
	mysql_close($db);
    die('INSERTクエリーが失敗しました。');
}
*/
$sql = "INSERT INTO AAA VALUES (4, 'ああああい')";
$result_flag = mysql_query($sql);

if (!$result_flag) {
	print mysql_error();
	mysql_close($db);
    die('INSERTクエリーが失敗しました。');
}



$result = mysql_query('SELECT id, name from AAA');
while ($row = mysql_fetch_assoc($result)) {
    print($row['id']);
    print($row['name']);
}

mysql_close($db);
?>