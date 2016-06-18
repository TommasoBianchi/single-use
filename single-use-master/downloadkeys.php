<?php
		$keys = rtrim(str_replace("NEWLINE", "\r\n", $_SERVER['QUERY_STRING']));

        header('Content-Length: ' . strlen($keys));
        header('Connection: close');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="keys.txt"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        echo $keys;    

        exit;
?>
