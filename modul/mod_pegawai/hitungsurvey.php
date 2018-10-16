<?php
	include "../../config/koneksi.php";

	$kuesioner = mysqli_query($DBcon, "SELECT * FROM kuesioner");
	$count = $kuesioner->num_rows;
	$result = $kuesioner->fetch_assoc();

	
	echo $count;	
	$l = 1;

	while ($result1 = $kuesioner->fetch_assoc()) {
		$jmSS[$l] = $result1['SS'];
			echo $jmSS[$l];
		$jmS[$l] = $result1['S'];
			echo $jmS[$l];
		$jmTS[$l] = $result1['TS'];
			echo $jmTS[$l];
		$jmSTS[$l] = $result1['STS'];
			echo $jmSTS[$l];
		$l++;
		}



	/*for($i=1;$i<=$count;$i++){
		$jmSS = $result['SS'];
	$jmS = $result['S'];
	$jmTS = $result['TS'];
	$jmSTS = $result['STS'];
	}*/

/*	for($i=1;$i<=$count;$i++){
	$value[$i] = $_POST[$i];
	echo "<br>Value".$i." = ";
	echo $value[$i];
	}
*/	
	/*$jmSS = $result['SS'];
	$jmS = $result['S'];
	$jmTS = $result['TS'];
	$jmSTS = $result['STS'];
	*/
	for($i=1;$i<=$count;$i++){
	$value[$i] = $_POST['s'.$i];
		switch ($value[$i]) {
		    case "SS":
		        $jmSS[$i]++;
		        $q = mysqli_query($DBcon, "UPDATE kuesioner SET SS='$jmSS[$i]'
									WHERE id_kuesioner='$i'");
		        break;
		    case "S":
		        $jmS[$i]++;
		        $q = mysqli_query($DBcon, "UPDATE kuesioner SET 
									S='$jmS[$i]'
									WHERE id_kuesioner='$i'");
		        break;
		    case "TS":
		        $jmTS[$i]++;
		        $q = mysqli_query($DBcon, "UPDATE kuesioner SET 
									TS='$jmTS[$i]'
									WHERE id_kuesioner='$i'");
		        break;
		    case "STS":
		        $jmSTS[$i]++;
		        $q = mysqli_query($DBcon, "UPDATE kuesioner SET 
									STS='$jmSTS[$i]'
									WHERE id_kuesioner='$i'");
		        break;
		}
	}

/*								$q = mysqli_query($DBcon, "UPDATE kuesioner SET SS='$jmSS',
									S='$jmS',
									TS='$jmTS',
									STS='$jmSTS'
									WHERE id_kuesioner='$id_kuesioner'");*/

	// echo "<br>Jumlah SS =".$jmSS;
	// echo "<br>Jumlah S =".$jmS;
	// echo "<br>Jumlah TS =".$jmTS;
	// echo "<br>Jumlah STS =".$jmSTS;
?>