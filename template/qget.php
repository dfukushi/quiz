<?php

$sql = "select * from q_quiz where delete_flg = 0";	
$db->prepare($sql);

$arr = $db->execute();

$c = rand(0, count($arr)-1);
$ar = $arr[$c];

$max = 4;

for($i = 0; $i < $max; $i++){
	if($ar["ans".($i+1)] == ""){
		break;
	}
}
$max = $i;

$ret = array();

$ans = 0;
$hash = array();
for($i = 0; $i < $max; $i++){
	
loop:
	$n = rand(0, $max-1);	
	if(isset($hash[$n])){
		// 既に出てればcontinue
		goto loop;
	}
	
	$hash[$n] = "1";
	
	$ret[] = $ar["ans".($n+1)];
	if($n == 0){
		$ans = count($ret)-1;
	}
}

print $ar["id"]."\n";
print $max."\n";
print $ans."\n";
print $ar["corrent"]."\n";
print $ar["total"]."\n";

foreach($ret as $r){
	print $r."\n";
}
print $ar["question"]."\n";

?>