<?php 
session_start();
require_once('engine/function.php');
require_once('config/koneksi.php');
require_once('engine/engine.php');
if (empty ($_SESSION["username"]) and empty ($_SESSION["password"])) {
        if (empty ($_POST["proses"])) {
			require_once('login.php'); 
			echo form_login ();
		}
        elseif ($_POST["proses"]=="login") { 
			require_once('login.php'); 
			cek_login (); 
        }
		else {
			require_once('login.php');
			echo form_login ();			
		}
	}
	else {
		if ($_SESSION["level"] == "admin") {
			require_once 'view.php';
		}else{
			require_once('engine/engine.php');
			require_once 'pegawai.php';
		}
}
?>