<?php

if(isset($_POST["menu"])){


$sql = "insert into don_review (menu_id, score, review, uuid, create_date) values (?, ?, ?, ?, now())";	
$db->prepare($sql);

$db->bind($_POST["menu"]);
$db->bind($_POST["score"]);
$db->bind($_POST["review"]);
$db->bind($_POST["uuid"]);

print $db->execute_update_w();
print "<br><br>";
	
}

?>


<form method="post" action="don_save.php">

メニューID：<input type="text" name="menu"><br>
スコア：<input type="text" name="score"><br>
レビュー：<textarea name="review" cols=30 rows=5></textarea><br>
UUID：<input type="text" name="uuid"><br>

<br>
<input type="submit" value=" 登録 ">
</form>
