<?php

$d = date("YmdHis", time());

ob_start();
phpinfo();
$phpinfo = ob_get_contents();
ob_end_clean();
$filename = "./log/phpinfo.".$d.".log.html";
//file_put_contents($filename, $phpinfo);

$secret = true;
?>
<pre>


Coming Soon...
</pre>