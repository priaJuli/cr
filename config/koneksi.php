<?php
//error_reporting(0);
$DBuser = "root";
$DBpass = "";
$DBhost = "localhost";
$DBname = "e_survey";
  
  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
?>
