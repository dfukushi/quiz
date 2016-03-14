<pre>
<?php

$data = file_get_contents("waza.txt");

$T_ARR = array(
"打撃" => 1,
"関節" => 2,
"投げ" => 3,
"ホールド" => 4,
"飛び" => 5,
"反則" => 6);

$PARAM = array(
"S" => 100,
"A" => 80,
"B" => 70,
"C" => 60,
"D" => 50,
"E" => 40,
"F" => 30,
"G" => 10
);

$fmt = "insert into waza values('%s', %d, %d, '%s', %d, %d, %d, %d, %d, %d, %d, %d, %d, %d);";

$arr = explode("\n", $data);
foreach($arr as $ar){
	$ar = str_replace("\r", "", $ar);
	$val = explode("\t", $ar);

	if($val[0] == ""){
		continue;
	}

	$genr = explode("_", $val[1]);
	$gen = $genr[0];

	$i=5;
	$v = sprintf($fmt, $val[0], $gen, $val[2], $val[3], $T_ARR[$val[4]],
$PARAM[$val[$i++]],
$PARAM[$val[$i++]],
$PARAM[$val[$i++]],
$PARAM[$val[$i++]],
$PARAM[$val[$i++]],
$PARAM[$val[$i++]],
$PARAM[$val[$i++]],
$PARAM[$val[$i++]],
$PARAM[$val[$i++]]
	);
	
	print $v."\n";
}


?>
</pre>