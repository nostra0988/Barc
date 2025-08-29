<?php
if ($_SERVER['HTTP_USER_AGENT'] == "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727)") {
	header_remove();
	header("Connection: close\r\n");
	http_response_code(404);
	exit;
}
?>