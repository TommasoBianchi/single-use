<?php
  /*
  * Manage connections to the database (be sure to use the right syntax for your specific db)
  */

    $db = mysql_connect("", "", "");  // Example: mysql_connect('localhost', 'mysql_user', 'mysql_password');
    mysql_select_db("", $db);         // Example: mysql_select_db(''db_name, $db);
?>
