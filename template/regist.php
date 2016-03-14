<?php

function get($ar, $n){
	if(isset($ar[$n])){
		return trim($ar[$n]);
	}
	return "";
}

if(isset($_POST["quiz"])){
	// 登録
	if($_POST["quiz"] == ""){
		print "問題が設定されていません<br>";
		goto fin;
	}
	
	$aa = explode("\n", $_POST["ans_t"]);
	$a1 = get($aa, 0);
	$a2 = get($aa, 1);
	$a3 = get($aa, 2);
	$a4 = get($aa, 3);
	
	//print "[".$a1."]";
	
	if($a1 == ""){
		print "答えが設定されていません<br>";
		goto fin;
	}
	$sql = "insert into q_quiz (question, ans1, ans2, ans3, ans4, delete_flg, create_date)
			values
			(?, ?, ?, ?, ?, 0, now())";
	
	$db->prepare($sql);
	$db->bind($_POST["quiz"]);
	$db->bind($a1);
	$db->bind($a2);
	$db->bind($a3);
	$db->bind($a4);
	
	print $db->execute_update_w();
fin:
	
}


?>

<form action="regist.php" method="post" name="f1">
問題：<br>
<textarea name="quiz" cols=80 rows=6></textarea>
<br><br>

答え：<br>
<textarea name="ans_t" cols=80 rows=5></textarea>
<!--
A.1 <input type="text" name="a_1">　答え<br>
A.2 <input type="text" name="a_2"><br>
A.3 <input type="text" name="a_3"><br>
A.4 <input type="text" name="a_4"><br>
-->
<br><br>
<input type="button" value="　登録　" onclick="go_q()" style="height:90px; padding: 60px;">
</form> 

<script>
function go_q(){

	
	//if(!confirm("登録してよろしいですか？")){
		//return;
	//}

	document.f1.submit();
}
</script>