<?php
/**
 *	This file creates the single use download link
 *	The query string should contain the password (which is set in variables.php)
 *	If the password fails, then 404 is rendered
 *
 *	Expects: generate.php?pw=PASSWORD&num=4&path=/secret/file&expire=2016-06-30 12:00:00&key_amount=20
 * 		where pw is the password set in variables.php, num is the number of downloads allowed for each key,
 * 		path is the path of the file to download, expire is the expiration date and key_amount is how many key to generate
 */

    include("variables.php");
    include("dbconnect.php");
	
    // Grab the query string as an array of data
    parse_str($_SERVER['QUERY_STRING'], $url_data);
    
    if(!isset($url_data['key_amount']) || $url_data['key_amount'] <= 0)
    	$url_data['key_amount'] = 1;
        
    $html_data = "";
    $keys = "";
	
    if(!isset($url_data['pw']) || $url_data['pw'] == ADMIN_PASSWORD) {
      for($i = 0; $i < $url_data['key_amount']; $i++){
        /*
         *	Verify the admin password (in variables.php)
         */ 
            // Create a new key
            $new = md5(uniqid('',TRUE));

            $query = "SELECT MAX(D.id) AS max FROM `_table` AS D"; // replace _table with your actual db table
            $result = mysql_query($query);
            $data = mysql_fetch_array($result);

            $id = intval($data['max']) + 1;
            if(!isset($url_data['num']) || $url_data['num'] <= 0)
                $url_data['num'] = 1;
            if(!isset($url_data['expire']) || !(date('Y-m-d H:i:s', strtotime($url_data['expire'])) == $url_data['expire'])){
                $date = date("Y-m-d H:i:s");
                $date = date("Y-m-d H:i:s", strtotime($date.' '.EXPIRATION_DATE));
            }
            else
                $date = $url_data['expire'];
            if(!isset($url_data['path']))
                $url_data['path'] = PROTECTED_DOWNLOAD;            

            $query = "INSERT INTO `_table` VALUES ({$id}, '{$new}', {$url_data['num']}, 1, '{$date}', '{$url_data['path']}')"; // replace _table with your actual db table
            mysql_query($query);

            $html_data = $html_data."Key = ".$new."<br>Number of downloads = ".$url_data['num']."<br>Expiry date = ".$date."<br>Download path = ".$url_data['path']."<br><br>";
            $keys = $keys."".$new."NEWLINE";
      }        
?>

<html>
	<head>
		<title>Download created</title>
		<style>
			nl { 
				font-family: monospace 
			}
		</style>
	</head>
	<body>
		<h1><?php echo $url_data['key_amount'] ?> Download <?php echo ($url_data['key_amount'] > 1 ? 'keys' : 'key') ?> created</h1>
        <form action= <?php echo "\"downloadkeys.php?".$keys."\"" ?> method="post">
        	<input type="submit" name="download_keys" value=" Download keys as a text file ">
        </form>
		<nl><?php 
			echo $html_data; 
		?></nl>
	</body>
</html>

<?php    
	} 
    else {
		/*
		 *	Someone stumbled upon this link with the wrong password
		 *	Fake a 404 so it does not look like this is a correct path
		 */
		header("HTTP/1.0 404 Not Found");
	}
?>
