	<?
	include '../../config/koneksi.php';

	$id = $_POST['kd_survey'];		
	$res = array();

	if (isset($id)) {

		$result = $DBcon->query("SELECT * FROM survey WHERE kd_survey='$id'");

		while($items=$result->fetch_object()){
			$res = $items;
		}
		
		echo json_encode($res);

		
		// include 'tampil_edit.php';
	} else{
		echo "salah";
	} ?>