<?php 


function main() {
  $page = isset($_GET['page']) ? $_GET['page'] : null;
  if (empty($page) or $page=='beranda' or $page=='home') {
	require_once 'modul/home.php';
  } elseif ($page == 'aspek') {
    require_once 'modul/mod_aspek/aspek.php';
  } elseif ($page == 'survey') {
    require_once 'modul/mod_survey/survey.php';
  } 
}

function main_pegawai() {
  $page = isset($_GET['page']) ? $_GET['page'] : null;
  if (empty($page) or $page=='beranda' or $page=='home') {
	require_once 'modul/mod_pegawai/blank.php';
  } elseif ($page == 'obat') {
    require_once 'modul/mod_obat/obat.php';
  } elseif ($page == 'survey') {
    require_once 'modul/mod_survey/survey.php';
  } 
}

?>