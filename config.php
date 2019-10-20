<?php
   define('DB_SERVER', 'sql12.freemysqlhosting.net');
   define('DB_USERNAME', 'sql12309137');
   define('DB_PASSWORD', '9tdW61jBMR');
   define('DB_DATABASE', 'sql12309137');
   $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
   if (mysqli_connect_errno()) {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();}
?>
