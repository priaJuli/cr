<?php
	include "../../config/koneksi.php";

	$id_pernyataan 		= $_POST['id_pernyataan'];
	$kd_survey 			= $_POST['kd_survey'];
	$count_pernyataan 	= count($id_pernyataan);
	$nik_user 			= $_POST['nik'];

	/*ambil name button persoal*/
	for ($i=1; $i <= $count_pernyataan; $i++) { 
		$value = $_POST[$i];
		$kd_soal = $id_pernyataan[$i - 1];

		$sql = mysqli_query($DBcon, "INSERT INTO hasil_kuesioner (nik,kd_soal,value) VALUES ('$nik_user','$kd_soal','$value')");

		$update_kuesioner_user = mysqli_query($DBcon, "UPDATE kuesioner_user SET 
											status = 'finish'
											WHERE nik='$nik_user'");

		/*cek type soal*/
		$cek = mysqli_query($DBcon,"SELECT type_pernyataan FROM m_pernyataan WHERE id_pernyataan = '$kd_soal'");
		$type_pernyataan = $cek->fetch_assoc();

		/*if ($type_pernyataan == 'Favorite') {
			switch ($value) {
			    case "SS":
			        ;
			        break;
			    case "S":
			        $jmS++;
			        break;
			    case "TS":
			        $jmTS++;
			        break;
			    case "STS":
			        $jmSTS++;
			        break;
			}
		}*/
	}


 	if ($sql) {
        echo '<script>window.alert("BERHASIL");window.location=("../../index.php?page=harusdiisi")</script>';
    } else {
        echo "GAGAL";
    }    
?>