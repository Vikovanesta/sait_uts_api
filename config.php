<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'hailpanda');
define('DB_PASSWORD', 'Vikova2003');
define('DB_NAME', 'kuliah');
  
$mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($mysqli === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>