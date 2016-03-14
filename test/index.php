<html>
<head>
	<meta name="robots" content="noindex,nofollow,noarchive,noydir">
	<meta name="Googlebot-Image" content="noindex,nofollow">
	<meta name="psbot" content="noindex,nofollow">
	<meta name="Yahoo-MMCrawler" content="noindex,nofollow">
	<meta http-equiv="Content-Type" content="text/html ; charset=UTF-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
	<title>MySQL</title>
	<link rel="stylesheet" type="text/css" href="css/a.css">
	<link rel="stylesheet" type="text/css" href="css/a2.css">
	<script type="text/javascript" src="css/a.js"></script>
</head>
<body>
<pre>
<a href="./">トップへ</a>
<?php


$p0 = microtime(true) * 1000;



require_once("./mysql.php");
$sg = parse_ini_file("../conf/sg.ini");

$db = new DBLib($sg);
$db->connect();

$p1 = microtime(true) * 1000;
echo "接続時間 :".($p1 - $p0)."msec\n";



function ht($str){
	return htmlspecialchars($str);
}


function run($db, $sql){

	$sql = trim($sql);
	$db->prepare($sql);

	$s = $sql.";";
	$s = str_replace("\r", "", $s);
	$s = str_replace("\n", "", $s);
	$s = preg_replace("/\t+/", " ", $s);

	$r = $db->execute_update();
	if($r){

		print "[".ht($s)."]\n";
		print "<font color=\"blue\">";
		print "SUCCESS!\n";
		print "</font>";
		$db->commit();

	}else{
		print "Error!\n";
		print "<font color=\"red\">";
		print ht($s)."\n";
		print mysql_error();
		print "</font>\n";
		$db->rollback();
	}
	print "\n";
}

function run2($db, $sql){

	$sql = trim($sql);

	$s = $sql.";";
	$s = str_replace("\r", "", $s);
	$s = str_replace("\n", "", $s);
	$s = preg_replace("/\t+/", " ", $s);

	$r = $db->execute_update();
	if($r){

		print "[".ht($s)."]\n";
		print "<font color=\"blue\">";
		print "SUCCESS!\n";
		print "</font>";

	}else{
		print "Error!\n";
		print "<font color=\"red\">";
		print ht($s)."\n";
		print mysql_error();
		print "</font>\n";
	}
	print "\n";
}



if(isset($_POST["type"])){


	if($_POST["type"] == 1){

		run($db, $_POST["sql1"]);


	}else if($_POST["type"] == 2){

		$db->prepare($_POST["sql2"]);
		$arr = $db->execute();


		$first = true;
		print "<table border=1>";
		foreach($arr as $row) {

			print "<tr>";
			if($first){
				foreach ($row as $key => $value){
					print "<td>".ht($key)."</td>";
				}
				$first = false;
			}
			print "</tr>\n";

			print "<tr>";
			foreach ($row as $value){
				print "<td>".ht($value)."</td>";
			}
			print "</tr>\n";
		}
		print "</table>\n";


	}else if($_POST["type"] == 3){

		$ss = explode(";", $_POST["sql3"]);

		foreach($ss as $sql){

			if(trim($sql) == ""){
				continue;
			}
			run($db, $sql);
		}

	}else if($_POST["type"] == 4){

		$sql = "insert into access_log (log_date, proc_time, url) values (now(), ?, ?)";
		$db->prepare($sql);
		$db->bind("60");
		$db->bind("http://www.google.co'-'.jp");

		run2($db, $sql);

	}


}

?>
<form action="./" method="post">INSERT / UPDATE
<textarea cols="80" rows="6" name="sql1"><?php print isset($_POST["sql1"]) ? ht($_POST["sql1"]) : ""; ?></textarea>
<input type="hidden" name="type" value="1"><input type="submit" value=" GO ">
insert into AAA values()
update AAA set x = x where x = x
delete from AAA where x = x
create table AAA ()
truncate table waza
</form>

<form action="./" method="post">SELECT
<textarea cols="80" rows="6" name="sql2"><?php print isset($_POST["sql2"]) ? ht($_POST["sql2"]) : ""; ?></textarea>
<input type="hidden" name="type" value="2"><input type="submit" value=" GO ">
select * from AAA
select * from AAA where x = x
</form>


<form action="./" method="post">SCRIPT
<textarea cols="80" rows="10" name="sql3"><?php print isset($_POST["sql3"]) ? ht($_POST["sql3"]) : ""; ?></textarea>
<input type="hidden" name="type" value="3"><input type="submit" value=" GO ">
</form>


<form action="./" method="post">
<input type="hidden" name="type" value="4"><input type="submit" value=" プログラム ">
</form>


<?php


	$db->prepare("show tables from ".$sg["DB_NAME"]);
	$arr = $db->execute();

	print "--- table list ---\n";

	foreach($arr as $ar){
		foreach($ar as $k => $a){
			print "<a href=\"table.php?t=".$a."\">".$a."</a>\n";
		}
	}
	print "------------------\n";

	$db->close();


?>
</pre>
</body>
</html>