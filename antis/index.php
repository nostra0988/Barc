<?php
header_remove();
header("Connection: close\r\n");
http_response_code(404);
exit;
?>

