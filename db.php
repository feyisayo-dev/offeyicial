<?php

$ServerName = "offeyicial"; // or the name or IP address of the SQL Server
$ConnectionInfo = array("Database"=>"offeyicial", "UID"=>"offeyicial", "PWD"=>"1oladejoA");
$conn = sqlsrv_connect($ServerName, $ConnectionInfo);

if ($conn) {
  #echo "Connection established";
} else {
  echo "Connection could not be established.<br>";
  die( print_r( sqlsrv_errors(), true));
}

?>
