<?php
/**
 *	This file does the actual downloading
 *	It will take in a query string and return either the file, 
 *	or failure
 *
 *	Expects: download.php?3764dfh3475hd6j23d4x
 */
 
	include("variables.php");
	include("dbconnect.php");
	
	// The input string
	$key = mysql_real_escape_string (trim($_SERVER['QUERY_STRING']));
	
	$match = false;
    
    $query = "SELECT * FROM `_table` AS D WHERE D.key = '{$key}'"; // replace _table with your actual db table
    $result = mysql_query($query);
    $data = mysql_fetch_array($result);
    if($data['valid'] == 1 && date('Y-m-d H:i:s') < $data['expire'])
    {
        $match = true;
        $data['num'] = $data['num'] - 1;
        if($data['num'] <= 0)
        	$data['valid'] = 0;
        $query = "UPDATE `_table` AS D SET D.valid = {$data['valid']}, D.num = {$data['num']} WHERE D.id = {$data['id']}"; // replace _table with your actual db table
    }
	
	/*
	 * If we found a match
	 */
	if($match !== false && file_exists($data['path'])) {
		
		/*
		 *	Forces the browser to download a new file
		 */
		$contenttype = CONTENT_TYPE;
		$filename = SUGGESTED_FILENAME;
		$file = $data['path'];
		set_time_limit(0);
		header("Content-Description: File Transfer");
		header("Content-type: {$contenttype}");
		header("Content-Disposition: attachment; filename=\"{$filename}\"");
		header("Content-Length: " . filesize($file));
		header('Pragma: public');
		header("Expires: 0");
		$download = readfile($file);
        
        if($download !== false)
        	mysql_query($query);
		
		// Exit
		exit;
	
	} else {
	
	/*
	 * 	We did NOT find a match
	 *	OR the link expired
	 *	OR the file has been downloaded already
	 */
     
       if(mysql_num_rows($result) == 0)
          $error = "Key not found";
       else if (date('Y-m-d H:i:s') >= $data['expire'])
          $error = "Key expired";
       else if($data['valid'] == 0)
          $error = "Key no longer valid";
       else if(!file_exists($data['path']))
          $error = "File not found";
       else
          $error = "Unknown error, please report to system administrator";

?>

<html>
	<head>
		<title>Download failed</title>
        
	</head>
	<body>
		<div id="page">
	        	<header class="site-header"><p class="logo-title">Download failed</p></header>
	        	<p id="content"><?php echo $error ?></p>
        	</div>
	</body>
</html>

<?php
	} // end matching
?>
