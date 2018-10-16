<?php
	
    if(!@$_GET['act']) {
        include 'blank.php';
    } elseif ($_GET['act'] == 'tambah') {
        echo add();
    } elseif ($_GET['act'] == 'edit') {
        echo edit();
    } elseif ($_GET['act'] == 'delete') {
        echo delete();
    } 
?>