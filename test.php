<?php

     $ServerName = "OFFEYICIAL\Elder";
     $ConnectionInfo = array("Database" => "offeyicial");
     $conn = sqlsrv_connect($ServerName, $ConnectionInfo);

     if($conn) {
          echo "Connection established";
     } else {
          echo "Connection could not be established.<br>";
          die( print_r( sqlsrv_errors(), true));
     }
?>
