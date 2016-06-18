<?php
/**
 *	Single use download variables
 * 
 *	Sets a fake files name to show to users (should not be the same name as the real file)
 *	Sets the admin password to generate a new download link
 *	Sets a date when the file will expire (examples: +1 year, +5 days, +13 hours)
 */	
	
	// What the file will be displayed to users as
	define('SUGGESTED_FILENAME','demo.txt');
	
	// The admin password to generate a new download link (change this as soon as you set up)
	define('ADMIN_PASSWORD','45813749');
	
	// The expiration date of the link (examples: +1 year, +5 days, +13 hours)
	define('EXPIRATION_DATE', '+1 days');
	
	// Don't worry about this
	define('CONTENT_TYPE','application/zip');
	header("Cache-Control: no-cache, must-revalidate");
?>
