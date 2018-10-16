<?php
session_start();
require_once 'engine/engine.php';


$_SESSION['username']=NULL;
$_SESSION['password']=NULL;


echo '<script>window.location=("index.php")</script>';	

?>