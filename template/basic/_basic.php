<?php

	$alog = new Alog();

	ob_start();
	// ここだけ動的に  (バッファリングする)
	require_once($template);
	$body = ob_get_clean();

	print $body;

?>