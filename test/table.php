<pre>
<?php
	$sg = parse_ini_file("../conf/sg.ini");


	print "[".$_GET["t"]."]\n";

	//$db = mysql_connect("localhost", "u_triplexross", "VWXWCLWC");
	$db = mysql_connect("localhost", "u_test", "1999");
	if(!$db){
		die('DB connect error '.mysql_error());
	}

	$s = mysql_select_db("testdb", $db);
	if(!$s){
		print mysql_error();
		mysql_close($db);
		die('DB select error ');
	}

	mysql_set_charset('sjis');
	

	$sql="SHOW COLUMNS FROM ".$_GET["t"];
	$res=mysql_query($sql,$db);
	if(!$res){
		print mysql_error();
		mysql_close($db);
		die("error ...");
	}


	if(mysql_num_rows($res) > 0){
	    while($dat=mysql_fetch_object($res)){
	        echo $dat->Field."\n";
	    }
	}


	
	mysql_close($db);


?>
</pre>