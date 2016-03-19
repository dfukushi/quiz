<?php

$sql = "select menu_id,score, review from don_review";	
$db->prepare($sql);

$arr = $db->execute();

print json_encode($arr);

?>