<?php 


function sJenis($var) {
	$val = null;
	if($var == 'KAPSUL') {
		$val.='<option value="KAPSUL" selected>KAPSUL</option>
			   <option value="SIRUP">SIRUP</option>';
	} else {
		$val.='<option value="KAPSUL">KAPSUL</option>
			   <option value="SIRUP" selected>SIRUP</option>';
	}

	return $val;
}

function sFavorite($var) {
	$val = null;
	if($var == 'Favorite') {
		$val.='<option value="Favorite" selected>Favorite</option>
			   <option value="Unfavorite">Unfavorite</option>';
	} else {
		$val.='<option value="Favorite">Favorite</option>
			   <option value="Unfavorite" selected>Unfavorite</option>';
	}

	return $val;
}

function list_kategori($id_survey){
	$val = null;
	include "config/koneksi.php";
	$sql = mysqli_query($DBcon, "SELECT * FROM survey WHERE id_survey = '$id_survey' ");
	$result = $sql->fetch_assoc();
	$decode_kategori = json_decode($result['kategori']);

	for ($i = 0; $i < count($decode_kategori); $i++) {
		$val.='
		<option value='.$decode_kategori[$i].'>'.$decode_kategori[$i].'</option>
		';
	}
	return $val;
}


?>