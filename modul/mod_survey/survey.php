<?php 

function grid() {
	include "config/koneksi.php";
	$val = null;
	$val.='
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Survey</h1>
			<a href="index.php?page='.$_GET['page'].'&act=tambah" class="btn btn-success">Tambah Survey</a>
			<br><br>
		</div>


	</div>
	<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Data Survey
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th>No</th>
							<th>Kd. Survey</th>
							<th>Nama Survey</th>
							<th>Aspek</th>
							<th>Tgl. Mulai</th>
							<th>Tgl. Selesai</th>
							<th>Type Option</th>
							<th width="20%">Kepada</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>';
						$i = 1;
						$q = mysqli_query($DBcon, "SELECT * FROM survey");
						while ($dq = $q->fetch_assoc()) {

							$decode_aspek = explode(",", $dq['aspek']);
							$temp = "";
							foreach ($decode_aspek as $key) {
								$temp = $temp.', '. $key;
							}

							$decode_kepada = explode(",", $dq['kepada']);
							$temp2 = "";
							foreach ($decode_kepada as $key) {
								$temp2 = $temp2.', '. $key;
							}

							/*tgl mulai*/
							$exp = explode('-',$dq['tgl_mulai']);
							$tgl_mulai = $exp[2].'-'.$exp[1].'-'.$exp[0];

							/*tgl selesai*/
							$exp2 = explode('-',$dq['tgl_selesai']);
							$tgl_selesai = $exp2[2].'-'.$exp2[1].'-'.$exp2[0];

							$val.='<tr>
							<td>'.$i.'</td>
							<td>'.$dq['kd_survey'].'</td>
							<td>'.$dq['nama_survey'].'</td>
							<td>'.substr($temp,1).'</td>
							<td>'.$tgl_mulai.'</td>
							<td>'.$tgl_selesai.'</td>
							<td>'.$dq['type_option'].'</td>
							<td>'.substr($temp2,1).'</td>
							<td>
								<ol style="margin-left:-20px">
									
									<li>
										<a href="?page='.$_GET['page'].'&act=edit&id='.$dq['id_survey'].'" title="Edit" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> 
										<a href="?page='.$_GET['page'].'&act=delete&id='.$dq['id_survey'].'" title="Delete" class="btn btn-danger btn-xs" ><i onclick="return confirm(\'Anda Yakin Akan Menghapus\')" class="fa fa-times"></i></a> 
									</li>
									<a href=?page='.$_GET['page'].'&act=pilihaspek&id='.$dq['kd_survey'].'><li>Tambah Pernyataan</li>
									</a>
									
									<a href=?page='.$_GET['page'].'&act=listpernyataan&id='.$dq['kd_survey'].'><li>List Pernyataan</li>
									</a>
									
									<a href="" onclick="duplikasi(\''.$dq['kd_survey'].'\')"  data-target="#myModal" data-toggle="modal" ><li>Clone Survey</li></a>

								</ol>
								
							</td>
						</tr>'; 
						$i++;
					}

					$val.='</tbody>
				</table>

			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
	</div>';
	return $val;
}


/*rule*/
function pilihaspek() {
	include "config/koneksi.php";
	$kd_survey = $_GET['id'];
	$sql1 = mysqli_query($DBcon, "SELECT * FROM survey WHERE kd_survey = '$kd_survey' ");
	$result1 = $sql1->fetch_assoc();
	$array_aspek = explode(",", $result1['aspek']);
	$val = null;
	$val.=' <div class="row">

	<div class="col-lg-12">
		<h1 class="page-header">Tambah Pernyataan Survey : '.$result1['nama_survey'].'</h1>
		<a href="index.php?page='.$_GET['page'].'" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Data Survey</a>
		<br><br>
		<p>Gunakan tombol <strong>"Tab"</strong> untuk berpindah kolom</p>
	</div>

	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Pilih Aspek
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
								<div class="table-responsive">
	                                <table class="table table-hover">
	                                    <thead>
	                                        <tr>
	                                            <th>No</th>
	                                            <th>Nama Aspek</th>
	                                            <th>Action</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>';
					                        $no = 1;
					                        for ($i = 0; $i < count($array_aspek); $i++) {
											   $val.='
													<tr class="odd gradeX">
						                                <td>'.$no.'</td>
						                                <td>'.$array_aspek[$i].'</td>
						                                <td class="center">
						                                	<a href=?page='.$_GET['page'].'&act=typesoal&id_survey='.$_GET['id'].'&aspek='.$array_aspek[$i].'><button type="button" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Pilih</button>
															
						                                </td>
					                            	</tr>
												';
											$no++; 
											}
					                        $val.='</tbody>
	                                </table>
	                            </div>
							</div>
						</div>
						<!-- /.row (nested) -->
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>';
			return $val;
}


function typesoal() {
	include "config/koneksi.php";
	$kd_survey = $_GET['id_survey'];
	$nama_aspek = $_GET['aspek'];
	$sql1 = mysqli_query($DBcon, "SELECT * FROM survey WHERE kd_survey = '$kd_survey' ");
	$result1 = $sql1->fetch_assoc();
	$array_aspek = explode(",", $result1['aspek']);
	$val = null;
	$val.=' <div class="row">

	<div class="col-lg-12">
		<h1 class="page-header">Tambah Pernyataan Survey : '.$result1['nama_survey'].'<br>
		Aspek soal : '.$nama_aspek.'</h1>

		<a href="index.php?page=survey&act=pilihaspek&id='.$kd_survey.'" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Pilih Aspek</a>
		<br><br>
		<p>Gunakan tombol <strong>"Tab"</strong> untuk berpindah kolom</p>
	</div>
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Pilih Aspek
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
								<div class="table-responsive">
	                                <table class="table table-hover">
	                                    <thead>
	                                        <tr>
	                                            <th>No</th>
	                                            <th>Type Pernyataan</th>
	                                            <th>Action</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                    	<tr class="odd gradeX">
	                                    		<td>1</td>
	                                    		<td>Favorite</td>
	                                    		<td class="center">
	                                    			<a href=?page='.$_GET['page'].'&act=addpernyataan&id_survey='.$_GET['id_survey'].'&aspek='.$_GET['aspek'].'&typesoal=Favorite><button type="button" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Pilih</button>
	                                    		</td>
	                                    	</tr>
	                                    	<tr class="odd gradeX">
	                                    		<td>2</td>
	                                    		<td>Unvaforite</td>
	                                    		<td class="center">
	                                    			<a href=?page='.$_GET['page'].'&act=addpernyataan&id_survey='.$_GET['id_survey'].'&aspek='.$_GET['aspek'].'&typesoal=Unfavorite><button type="button" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Pilih</button>
	                                    		</td>
	                                    	</tr>
	                                    </tbody>
	                                </table>
	                            </div>
							</div>
						</div>
						<!-- /.row (nested) -->
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>';
			return $val;
}
/*end rule*/


/*pernyataan*/
function listpernyataan() {
	include "config/koneksi.php";
	$kd_survey = $_GET['id'];
	
	$sql1 	= mysqli_query($DBcon, "SELECT * FROM survey WHERE 	kd_survey = '$kd_survey' ");
	

	$result1 = $sql1->fetch_assoc();
	$val = null;
	$val.=' <div class="row">

	<div class="col-lg-12">
		<h3 class="page-header">List Pernyataan Survey : '.$result1['nama_survey'].'</h3>
		<a href="index.php?page='.$_GET['page'].'" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Data Survey</a>
		<br><br>
		<p>Gunakan tombol <strong>"Tab"</strong> untuk berpindah kolom</p>
	</div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    DataTables Advanced Tables
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pernyataan</th>
                                <th>Aspek</th>
                                <th>Type Pernyataan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>';
                        $i = 1;
						$q 	= mysqli_query($DBcon, "SELECT m_pernyataan.id_pernyataan,m_pernyataan.pernyataan,m_pernyataan.type_pernyataan,temp.nama_aspek FROM m_pernyataan JOIN temp ON m_pernyataan.id_pernyataan = temp.id_soal WHERE temp.kd_survey = '$kd_survey'");
						while ($show = $q->fetch_assoc()) {
                            $val.='
                            	<tr class="odd gradeX">
	                                <td>'.$i.'</td>
	                                <td>'.$show['pernyataan'].'</td>
	                                <td>'.$show['nama_aspek'].'</td>
	                                <td>'.$show['type_pernyataan'].'</td>
	                                <td class="center">
										<a href="?page='.$_GET['page'].'&act=edit_pernyataan&id='.$show['id_pernyataan'].'" title="Edit" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> 
										<a href="?page='.$_GET['page'].'&act=delete_pernyataan&id_survey='.$kd_survey.'&id='.$show['id_pernyataan'].'" title="Delete" class="btn btn-danger btn-xs" ><i onclick="return confirm(\'Anda Yakin Akan Menghapus\')" class="fa fa-times"></i></a>
										
	                                </td>
                            	</tr>';
                            $i++;
                        	}
                            $val.='</tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>';
	return $val;
}


function edit_pernyataan() {
	include "config/koneksi.php";
	$id_kuesioner = $_GET['id'];

	$data = mysqli_query($DBcon, "SELECT m_pernyataan.id_pernyataan,m_pernyataan.pernyataan,m_pernyataan.type_pernyataan,temp.nama_aspek,temp.kd_survey,temp.id_temp FROM m_pernyataan JOIN temp ON m_pernyataan.id_pernyataan = temp.id_soal WHERE temp.id_soal = '$id_kuesioner'");
	$result1 = $data->fetch_assoc();

	$kd_survey = $result1['kd_survey'];

	$survey = mysqli_query($DBcon, "SELECT * FROM survey WHERE kd_survey = '$kd_survey' ");
	$result = $survey->fetch_assoc();
	
	$val = null;
	$val.=' <div class="row">

	<div class="col-lg-12">
		<h1 class="page-header">Edit Pernyataan Survey : '.$result['nama_survey'].'</h1>
		<a href="index.php?page=survey&act=listpernyataan&id='.$result['kd_survey'].'" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> List Pernyataan : '.$result['nama_survey'].' </a>
		<br><br>
		<p>Gunakan tombol <strong>"Tab"</strong> untuk berpindah kolom</p>
	</div>

	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Tambah Survey
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">';
						if(!isset($_POST['proses'])) {
							
							$val.='
							<form role="form" enctype="multipart/form-data" method="POST" action="">
								<input type="hidden" name="proses">
								
								<input type="hidden" name="id_pernyataan" value='.$result1['id_pernyataan'].'>
								<input type="hidden" name="id_temp" value='.$result1['id_temp'].'>

								<div class="form-group">
									<label>Pernyataan</label>
									<input type="text" class="form-control" name="pernyataan" value="'.$result1['pernyataan'].'"  required>

								</div>
								<div class="form-group">
									<label>Aspek</label>
									<select class="form-control" name="nama_aspek" required="" >
										
										<option value='.$result1['nama_aspek'].' selected>'.$result1['nama_aspek'].'</option>';
										
										$sql = mysqli_query($DBcon, "SELECT * FROM survey WHERE kd_survey = '$kd_survey' ");
										$result = $sql->fetch_assoc();
										$decode_kategori = explode(",", $result['aspek']);
								
										for ($i = 0; $i < count($decode_kategori); $i++) {
												$val.='
												<option value='.$decode_kategori[$i].'>'.$decode_kategori[$i].'</option>
											';
										}

										$val.='</select>
								</div>

								<div class="form-group">
                                    <label>Type Pernyataan</label>
                                    <select name="type_pernyataan" required="" class="form-control">
                                        <option value="">-Pilih-</option>
                                        '.sFavorite($result1['type_pernyataan']).'
                                    </select>
                                </div>

									<button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>';
								} else {
									$id_pernyataan = mysqli_real_escape_string($DBcon, $_POST['id_pernyataan']);
									$id_temp = mysqli_real_escape_string($DBcon, $_POST['id_temp']);
									$pernyataan = mysqli_real_escape_string($DBcon, $_POST['pernyataan']);
									$nama_aspek = mysqli_real_escape_string($DBcon, $_POST['nama_aspek']);
									$type_pernyataan = mysqli_real_escape_string($DBcon, $_POST['type_pernyataan']);

									$q = mysqli_query($DBcon, "UPDATE m_pernyataan SET 
											type_pernyataan='$type_pernyataan',
											pernyataan='$pernyataan'											
											WHERE id_pernyataan='$id_pernyataan'");

									$p = mysqli_query($DBcon, "UPDATE temp SET 
											nama_aspek='$nama_aspek'
											WHERE id_temp='$id_temp'");

									if ($q && $p) {
										echo '<script>window.alert("BERHASIL");window.location=("index.php?page='.$_GET['page'].'")</script>';
									} else {
										echo "GAGAL";
									}    


								}
								$val.='</form>
							</div>
						</div>
						<!-- /.row (nested) -->
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>';
			return $val;
}


function delete_pernyataan(){
	include "config/koneksi.php";
	$id = $_GET['id'];
	$id_survey = $_GET['id_survey'];

	$q1 = mysqli_query($DBcon,"DELETE FROM m_pernyataan WHERE id_pernyataan='$id'");
	$q2 = mysqli_query($DBcon,"DELETE FROM temp WHERE id_soal='$id'");

	if ($q1 && $q2) {
		echo '<script>window.alert("BERHASIL");window.location=("index.php?page='.$_GET['page'].'&act=listpernyataan&id='.$id_survey.'")</script>';
	} else {
		echo "GAGAL";
	}    
}


function addpernyataan() {
	include "config/koneksi.php";
	$kd_survey = $_GET['id_survey'];
	$aspek = $_GET['aspek'];
	$type_pernyataan = $_GET['typesoal'];
	$sql1 = mysqli_query($DBcon, "SELECT * FROM survey WHERE kd_survey = '$kd_survey' ");
	$result1 = $sql1->fetch_assoc();
	$val = null;
	$val.=' <div class="row">

	<div class="col-lg-12">
		<h1 class="page-header">Tambah Pernyataan Survey : '.$result1['nama_survey'].'<br>
			Aspek Pernyataan : '.$aspek.'<br> Type Pernyataan : '.$type_pernyataan.'
		</h1>
		<a href="index.php?page='.$_GET['page'].'" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Data Survey</a>
		<br><br>
		<p>Gunakan tombol <strong>"Tab"</strong> untuk berpindah kolom</p>
	</div>

	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Tambah Survey
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">';
						if(!isset($_POST['proses'])) {
							
							$val.='
							<form role="form" enctype="multipart/form-data" method="POST" action="">
								<input type="hidden" name="proses">
								<div class="form-group">';
									
									/*mengambil jumlah data pernyataan berdasarkan survey*/
									$pernyataan = mysqli_query($DBcon, "SELECT COUNT(*) FROM m_pernyataan ");
									$count = $pernyataan->fetch_row();

									if ($count == 0 ) {
										$angka = 1;
									}else{
										$angka = $count[0]++;
									}

									$val.='
									<label>Pernyataan mulai dari : '.$angka.'</label>
								</div>

								<input type="hidden" name="kd_survey" value='.$kd_survey.'>
								<input type="hidden" name="aspek" value='.$aspek.'>
								<input type="hidden" name="type_pernyataan" value='.$type_pernyataan.'>
								
								<div class="text-right control-group after-add-more">
									<button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
						        </div>

						       

									<button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
								</form>
									<!-- Copy Fields -->
						        <div class="copy hide">
						          <div class="control-group input-group" style="margin-top:10px">
						            <input type="text" name="pernyataan[]" class="form-control" placeholder="Ex : Tulis pernyataan disini">
						            <div class="input-group-btn"> 
						              <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
						            </div>
						          </div>
						        </div>
							';
								} else {
									$kd_survey = mysqli_real_escape_string($DBcon, $_POST['kd_survey']);
									$aspek = mysqli_real_escape_string($DBcon, $_POST['aspek']);
									$type_pernyataan = mysqli_real_escape_string($DBcon, $_POST['type_pernyataan']);
									$pernyataan = $_POST['pernyataan'];

									
									

									/*$cari = mysqli_query($DBcon, "SELECT * FROM '' ORDER BY `popularity` DESC LIMIT 1");*/
									foreach ($pernyataan as $key => $value) {
										$q = mysqli_query($DBcon, "INSERT INTO m_pernyataan (type_pernyataan,pernyataan) VALUES ('$type_pernyataan','$value')");

										$carikode = mysqli_query($DBcon, "SELECT max(id_pernyataan) FROM m_pernyataan");
										$datakode = mysqli_fetch_array($carikode);

										$kode = (int) $datakode[0];

										$sql = mysqli_query($DBcon, "INSERT INTO temp (kd_survey,nama_aspek,id_soal,option1,option2,option3,option4,scoring) VALUES ('$kd_survey','$aspek','$kode',NULL,NULL,NULL,NULL,NULL)");
										$kode = $kode + 1;
									}

									if ($sql) {

										echo '<script>window.alert("BERHASIL");window.location=("index.php?page='.$_GET['page'].'")</script>';
									} else {
										echo "GAGAL";
									}    


								}
								$val.='</form>
							</div>
						</div>
						<!-- /.row (nested) -->
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>';
			return $val;
}


/*end pernyataan*/
function delete(){
	include "config/koneksi.php";
	$id = $_GET['id'];

	$data = mysqli_query($DBcon, "SELECT * FROM survey WHERE id_survey = '$id' ");
	$result = $data->fetch_assoc();

	$kd_survey = $result['kd_survey'];


	$q1 = mysqli_query($DBcon,"DELETE FROM survey WHERE id_survey='$id'");
	$q2 = mysqli_query($DBcon,"DELETE FROM temp WHERE kd_survey='$kd_survey'");
	$q3 = mysqli_query($DBcon,"DELETE FROM kuesioner WHERE kd_survey='$kd_survey'");

	$cek = mysqli_query($DBcon,"SELECT id_soal FROM temp WHERE kd_survey = '$kd_survey'");
	$result_cek = $cek->fetch_assoc();
	$id_soal = $result_cek['id_soal'];

	$q4 = mysqli_query($DBcon,"DELETE FROM m_pernyataan WHERE id_soal='$id_soal'");

	if ($q1 || $q3 || $q2) {
		echo '<script>window.alert("BERHASIL");window.location=("index.php?page='.$_GET['page'].'")</script>';
	} else {
		echo "GAGAL";
	}    
}


function add() {
	include "config/koneksi.php";
	$val = null;
	$val.=' <div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Tambah Survey</h1>
		<a href="index.php?page='.$_GET['page'].'" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Data Survey</a>
		<br><br>
		<p>Gunakan tombol <strong>"Tab"</strong> untuk berpindah kolom</p>
	</div>

	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Tambah Survey
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">';
						if(!isset($_POST['proses'])) {
							$val.='
							<form role="form" enctype="multipart/form-data" method="POST" action="">
								<input type="hidden" name="proses">
								<div class="form-group">
									<label>Kode Survey</label>';
									$carikode = mysqli_query($DBcon, "SELECT max(kd_survey) FROM kuesioner_user");
									$datakode = mysqli_fetch_array($carikode);
									  // jika $datakode
									if ($datakode) {
										$nilaikode = substr($datakode[0], 2);
									   // menjadikan $nilaikode ( int )
										$kode = (int) $nilaikode;
									   // setiap $kode di tambah 1
										$kode = $kode + 1;
										$kode_otomatis = "SV".str_pad($kode, 4, "0", STR_PAD_LEFT);
									} else {
										$kode_otomatis = "SV0001";
									}
									$val.='<input type="text" class="form-control" readonly name="kd_survey" value='.$kode_otomatis.' required>
								</div>
								<div class="form-group">
									<label>Nama Survey</label>
									<input type="text" class="form-control" name="nama_survey" placeholder="Ex : Kepuasan Karyawan" required>
								</div>
								<div class="form-group">
									<label>Aspek</label>
									
									<select id="select-beast" multiple class="demo-default form-control" name="aspek[]" required>
										<option value="">--pilih--</option>';
										$sql = mysqli_query($DBcon, "SELECT * FROM m_aspek");
										while ($result = $sql->fetch_assoc()) {
											$val.='
											<option value=\''.$result['nama_aspek'].'\'>'.$result['nama_aspek'].'</option>
										';
									}
									$val.='</select>
								</div>

								<div class="form-group">
									<label>Tgl Mulai</label>
									<input type="date" class="form-control" required name="tgl_mulai" >
								</div>
								<div class="form-group">
									<label>Tgl Selesai</label>
									<input type="date" class="form-control" required name="tgl_selesai" >
								</div>

								<div class="form-group">
									<label>Jumlah Option</label>
									<input type="text" class="form-control" name="jml_option" placeholder="Ex : 4" required>
								</div>
								
								<div class="form-group">
									<label>Type Option</label>
									<input type="text" class="form-control" name="type_option" placeholder="SS, S, TS, STS" required>
									<p class="help-block">Example : SS, S, TS, STS</p>
								</div>

								<div class="form-group">
									<label>Di Tujukan Kepada</label>
									
									<select id="select2" multiple class="demo-default form-control" name="kepada[]" required>
										<option value="">--pilih--</option>';
										$sql = mysqli_query($DBcon, "SELECT unit FROM pegawai GROUP BY unit");
										while ($result = $sql->fetch_assoc()) {
											$val.='
											<option value=\''.$result['unit'].'\'>'.$result['unit'].'</option>
										';
									}
									$val.='</select>
								</div>

								<button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>';
							} else {

								$kd_survey = mysqli_real_escape_string($DBcon, $_POST['kd_survey']);
								$nama_survey = mysqli_real_escape_string($DBcon, $_POST['nama_survey']);

								$array = $_POST['aspek'];
								$aspek = implode(", ", $array);

								$tgl_mulai 		= mysqli_real_escape_string($DBcon, $_POST['tgl_mulai']);
								$tgl_selesai 	= mysqli_real_escape_string($DBcon, $_POST['tgl_selesai']);
								$jml_option 	= mysqli_real_escape_string($DBcon, $_POST['jml_option']);
								
								/*$array2		 	= $_POST['type_option'];
								$type_option 	= implode(", ", $array2);*/
								$type_option 	= mysqli_real_escape_string($DBcon, $_POST['type_option']);

								$array3	 	= $_POST['kepada'];
								$kepada 	= implode(", ", $array3);
								/*$kepada 	= json_encode($array3);*/
							

								$q = mysqli_query($DBcon, "INSERT INTO survey (kd_survey,
									nama_survey,aspek,tgl_mulai,tgl_selesai,jml_option,type_option,kepada) VALUES ('$kd_survey','$nama_survey','$aspek','$tgl_mulai','$tgl_selesai','$jml_option','$type_option','$kepada')");


								if ($q) {
									echo '<script>window.alert("BERHASIL");window.location=("index.php?page='.$_GET['page'].'")</script>';
								} else {
									echo "GAGAL";
								}   
							}
							$val.='</form>
						</div>
					</div>
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>';
		return $val;
}


function edit() {
	include "config/koneksi.php";
	$id = $_GET['id'];

	$q1 = mysqli_query($DBcon,"SELECT * FROM survey WHERE id_survey='$id'");
	$dq1 = $q1->fetch_assoc();
	$array_aspek = explode(",", $dq1['aspek']);
	$array_kepada = explode(",", $dq1['kepada']);

	$val = null;
	$val.=' <div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Edit Survey : '.$dq1['nama_survey'].'</h1>
		<a href="index.php?page='.$_GET['page'].'" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Data Survey</a>
		<br><br>
		<p>Gunakan tombol <strong>"Tab"</strong> untuk berpindah kolom</p>
	</div>

	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Tambah Obat
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">';
						if(!isset($_POST['proses'])) {
							$val.='
							<form role="form" enctype="multipart/form-data" method="POST" action="">
								<input type="hidden" name="proses">
								<div class="form-group">
									<label>Kd Survey</label>
									<input type="text" readonly class="form-control" name="kd_survey" autofocus value="'.$dq1['kd_survey'].'">
								</div>
								<div class="form-group">
									<label>Nama Survey</label>
									<input type="text" class="form-control" name="nama_survey"  autofocus required value="'.$dq1['nama_survey'].'">
								</div>
								<div class="form-group">
									<label>Aspek</label>
									
									<select id="select-beast" multiple class="demo-default form-control" name="aspek[]" required>';

										for ($i = 0; $i < count($array_aspek); $i++) {
										   $val.='
												<option value='.$array_aspek[$i].' selected>'.$array_aspek[$i].'</option>
											';
										}

										$sql = mysqli_query($DBcon, "SELECT * FROM m_aspek");
										while ($result = $sql->fetch_assoc()) {
											$val.='
											<option value=\''.$result['nama_aspek'].'\'>'.$result['nama_aspek'].'</option>
										';
									}
									$val.='</select>
								</div>
								<div class="form-group">
									<label>Tgl Mulai</label>
									<input type="date" class="form-control" name="tgl_mulai" value="'.$dq1['tgl_mulai'].'" >
								</div>
								<div class="form-group">
									<label>Tgl Mulai</label>
									<input type="date" class="form-control" name="tgl_selesai" value="'.$dq1['tgl_selesai'].'" >
								</div>
								<div class="form-group">
									<label>Jml Option</label>
									<input type="text" class="form-control" name="jml_option"  autofocus required value="'.$dq1['jml_option'].'">
								</div>
								<div class="form-group">
									<label>Type Option</label>
									<input type="text" class="form-control" name="type_option"  autofocus required value="'.$dq1['type_option'].'">
								</div>

								<div class="form-group">
									<label>Kepada</label>
									
									<select id="select2" multiple class="demo-default form-control" name="kepada[]" required>';

										for ($i = 0; $i < count($array_kepada); $i++) {
										   $val.='
												<option value='.$array_kepada[$i].' selected>'.$array_kepada[$i].'</option>
											';
										}

										$sql = mysqli_query($DBcon, "SELECT unit FROM pegawai GROUP BY unit");
										while ($result = $sql->fetch_assoc()) {
											$val.='
											<option value=\''.$result['unit'].'\'>'.$result['unit'].'</option>
										';
									}
									$val.='</select>
								</div>

								<button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>';
							} else {
								$id = $_GET['id'];
								$kd_survey = mysqli_real_escape_string($DBcon, $_POST['kd_survey']);
								$nama_survey = mysqli_real_escape_string($DBcon, $_POST['nama_survey']);
								$array = $_POST['aspek'];
								$aspek = implode(",", $array);
								$jml_option = mysqli_real_escape_string($DBcon, $_POST['jml_option']);
								$type_option = mysqli_real_escape_string($DBcon, $_POST['type_option']);
								$tgl_mulai = mysqli_real_escape_string($DBcon, $_POST['tgl_mulai']);
								$tgl_selesai = mysqli_real_escape_string($DBcon, $_POST['tgl_selesai']);
								
								$array2 = $_POST['kepada'];
								$kepada = implode(",", $array2);

								$q = mysqli_query($DBcon, "UPDATE survey SET kd_survey='$kd_survey',
									nama_survey='$nama_survey',
									aspek='$aspek',
									tgl_mulai='$tgl_mulai',
									tgl_selesai='$tgl_selesai',
									jml_option='$jml_option',
									type_option='$type_option',
									kepada='$kepada'
									WHERE id_survey='$id'");


								if ($q) {
									echo '<script>window.alert("BERHASIL");window.location=("index.php?page='.$_GET['page'].'")</script>';
								} else {
									echo "GAGAL";
								}    


							}
							$val.=           '</form>
						</div>
					</div>
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>';
		return $val;
}


function detail() {
	include "configurasi/koneksi.php";
	$id = $_GET['id'];
	$q1 = mysqli_query($DBcon,"SELECT * FROM users WHERE id_users='$id'");
	$dq1 = $q1->fetch_assoc();
	$val = null;
	$val.=' <div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Tambah Users</h1>
		<a href="media_admin.php?module=users" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Data User</a>
		<br><br>
		<p>Gunakan tombol <strong>"Tab"</strong> untuk berpindah kolom</p>
	</div>

	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Tambah User
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">';
						$val.='
						<form role="form" enctype="multipart/form-data" method="POST" action="">
							<input type="hidden" name="proses">
							<div class="form-group">
								<label>No. Cek</label>
								<input type="text" class="form-control" disabled name="NIK" value="'.$dq1['NIK'].'" placeholder="Ex : 00001" autofocus required>
							</div>
							<div class="form-group">
								<label>Nama Lengkap</label>
								<input type="text" class="form-control" disabled name="EmployeeName"  value="'.$dq1['EmployeeName'].'" placeholder="Ex : John" required>
							</div>
							<div class="form-group">
								<label>Username</label>
								<input type="text" class="form-control" disabled name="username_login"  value="'.$dq1['username_login'].'"  placeholder="Ex : 00001" required>
							</div>
							<div class="form-group">
								<label>PosTitle</label>
								<input type="text" class="form-control" disabled name="PosTitle"  value="'.$dq1['PosTitle'].'" placeholder="Ex : Accounting Officer" required>
							</div>
							<div class="form-group">
								<label>Unit</label>
								<input type="text" class="form-control" disabled name="Unit" value="'.$dq1['Unit'].'" placeholder="Ex : Akuntansi" required>
							</div>
							<div class="form-group">
								<label>Alamat</label>
								<p>'.$dq1['alamat'].'</p>
							</div>';

							if ($dq1['jenis_kelamin'] == 'L') {
								$jkl = "Laki-laki";
							} else {
								$jkl = "Perempuan";
							}

							$val.='
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<input type="text" class="form-control" disabled value="'.$jkl.'">
							</div>';
							$val.='
							<div class="form-group">
								<label>E-Mail</label>
								<input type="text" class="form-control" name="email" disabled value="'.$dq1['email'].'" placeholder="Ex : jhon@phapros.co.id">
							</div>
							<div class="form-group">
								<label>No. Telp / HP</label>
								<input type="text" class="form-control" name="no_telp" disabled value="'.$dq1['no_telp'].'" placeholder="Ex : 08123456789">
							</div>
							<div class="form-group">
								<label>Foto : </label>';
								if(empty($dq1['foto'])) {
									$val.='<img class="img-responsive" src="foto_pengajar/no-image.jpg" style="width:300px;height:100%;">';
								} else {
									$val.='<img class="img-responsive" src="foto_users/'.$dq1['foto'].'" style="width:300px;height:100%;">';
								}   


								$val.=           '</form>
							</div>
						</div>
						<!-- /.row (nested) -->
					</div>
					<!-- /.panel-body -->
				</div>
				<!-- /.panel -->
			</div>';
	return $val;
}


function detailprofil() {
	include "configurasi/koneksi.php";
	$username = $_SESSION['namauser'];
	$q1 = mysqli_query($DBcon,"SELECT * FROM users WHERE username_login='$username'");
	$dq1 = $q1->fetch_assoc();
	$val = null;
	$val.=' <div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Profil '.$_SESSION['namalengkap'].'</h1>
		<br><br>
		<p>Gunakan tombol <strong>"Tab"</strong> untuk berpindah kolom</p>
	</div>



	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Tambah User
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">';
						if(!isset($_POST['proses'])) {
							$val.='
							<form role="form" enctype="multipart/form-data" method="POST" action="">
								<input type="hidden" name="proses">
								<div class="form-group">
									<label>No. Cek</label>
									<input type="text" class="form-control" name="NIK" value="'.$dq1['NIK'].'" placeholder="Ex : 00001" disabled>
								</div>
								<div class="form-group">
									<label>Nama Lengkap</label>
									<input type="text" class="form-control" name="EmployeeName"  value="'.$dq1['EmployeeName'].'" placeholder="Ex : John" disabled>
								</div>
								<div class="form-group">
									<label>Username</label>
									<input type="text" class="form-control" name="username_login"  value="'.$dq1['username_login'].'"  placeholder="Ex : 00001" disabled>
								</div>
								<div class="form-group">
									<label>PosTitle</label>
									<input type="text" class="form-control" name="PosTitle"  value="'.$dq1['PosTitle'].'" placeholder="Ex : Accounting Officer" disabled>
								</div>
								<div class="form-group">
									<label>Unit</label>
									<input type="text" class="form-control" name="Unit" value="'.$dq1['Unit'].'" placeholder="Ex : Akuntansi" disabled>
								</div>
								<div class="form-group">
									<label>Alamat</label>
									<textarea class="form-control" name="alamat" placeholder="Ex : Semarang">'.$dq1['alamat'].'</textarea>
								</div>';

								if ($dq1['jenis_kelamin'] == 'L') {
									$jkl = "checked";
									$jkp = "";
								} else {
									$jkl = "";
									$jkp = "checked";
								}

								if ($dq1['blokir'] == 'Y') {
									$bky = "checked";
									$bkt = "";
								} else {
									$bky = "";
									$bkt = "checked";
								}
								$val.='
								<div class="form-group">
									<label>Jenis Kelamin</label>
									<div class="radio">
										<label>
											<input type="radio" name="jenis_kelamin" value="L" '.$jkl.'>Laki- Laki
										</label>
									</div>
									<label>
										<div class="radio">
											<label>
												<input type="radio" name="jenis_kelamin" value="P"  '.$jkp.'>Perempuan
											</label>
										</div>
									</label>
								</div>';
								$val.='
								<div class="form-group">
									<label>E-Mail</label>
									<input type="text" class="form-control" name="email" value="'.$dq1['email'].'" placeholder="Ex : jhon@phapros.co.id">
								</div>
								<div class="form-group">
									<label>No. Telp / HP</label>
									<input type="text" class="form-control" name="no_telp"  value="'.$dq1['no_telp'].'" placeholder="Ex : 08123456789">
								</div>
								<div class="form-group">
									<label>Foto : </label>';
									if(empty($dq1['foto'])) {
										$val.='<img class="img-responsive" src="foto_pengajar/no-image.jpg" style="width:300px;height:100%;">';
									} else {
										$val.='<img class="img-responsive" src="foto_users/'.$dq1['foto'].'" style="width:300px;height:100%;">';
									}   
									$val.='<br>
									<input type="file" class="form-control" name="foto">';

									$val.='</div>
									<button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>';
								} else {
									$username = $_SESSION['namauser'];
									$alamat = $_POST['alamat'];
									$jenis_kelamin = $_POST['jenis_kelamin'];
									$email = $_POST['email'];
									$no_telp = $_POST['no_telp'];


									if ($_FILES["foto"]["tmp_name"]=="") {
										$q = mysqli_query($DBcon, "UPDATE users SET     alamat = '$alamat',
											jenis_kelamin = '$jenis_kelamin',
											email = '$email',
											no_telp = '$no_telp' WHERE username_login='$username'");


										if (($q)) {
											echo '<script>window.alert("BERHASIL");window.location=("media.php?module=users&act=detailprofilusers")</script>';
										} else {
											echo "Gagal";
										} 
									} else {
                            //$pic = $mysqli->real_escape_string($_POST['gambar']);
										$error = false;
										$file_type = array('jpg','png','jpeg','JPG','PNG','JPEG');
										$max_size = 1000000;    
										$file_name = $_FILES['foto']['name'];
										$file_size = $_FILES['foto']['size'];
										$folder = 'foto_users';

										$explode = explode(".", $file_name);
										$extensi  = $explode[count($explode)- 1];
										$random = rand(00000000,99999999);
										$file_namex = $random.$file_name;


                             //check apakah type file sudah sesuai
										if((!isset($_FILES['foto'])) OR (!in_array($extensi,$file_type))){
											$error   = true;
											$pesan .= '<div class="alert alert-warning">
											<strong>Maaf</strong> - Type file yang Anda upload tidak sesuai
										</div>';        
									}
									if($file_size > $max_size){
										$error   = true;
										$pesan .= '<div class="alert alert-warning">
										<strong>Maaf</strong> - Ukuran file melebihi batas maximum<br />
									</div>';        
								}
                            //check ukuran file apakah sudah sesuai

								if($error == true){
									echo '<div id="eror">'.$pesan.'</div>';
								} else {
									unlink('foto_users/'.$dq1['foto']);

									$q = mysqli_query($DBcon, "UPDATE users SET     alamat = '$alamat',
										jenis_kelamin = '$jenis_kelamin',
										email = '$email',
										no_telp = '$no_telp',
										foto = '$file_namex' WHERE username_login='$username'");


									if (move_uploaded_file($_FILES['foto']['tmp_name'], $folder.'/'.$file_namex)) {
										$kon = 1;
									} else {
										$kon = 0;
									}

								}


								if (($q) AND ($kon == 1)) {
									echo '<script>window.alert("BERHASIL");window.location=("media.php?module=users&act=detailprofilusers")</script>';
								} else {
									echo "Gagal";
								}
							}


						}
						$val.=           '</form>
					</div>
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>';
	return $val;
}


function editpassword() {
	include "configurasi/koneksi.php";
	$username = $_SESSION['namauser'];
	$val = null;
	$val.=' <div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Edit Password</h1>
	</div>



	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Ganti Password
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">';
						if(!isset($_POST['proses'])) {
							$val.='
							<form role="form" enctype="multipart/form-data" method="POST" action="">
								<div class="col-md-6">
									<input type="hidden" name="proses">
									<div class="form-group">
										<label>Password Baru</label>
										<input type="text" class="form-control" name="passwordbaru" value="" placeholder="Masukkan Password Baru Anda" >
									</div>
									<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
								</div>';
							} else {
								$username = $_SESSION['namauser'];
								$password = md5($_POST['passwordbaru']);

								$q = mysqli_query($DBcon, "UPDATE users SET password_login = '$password'
									WHERE username_login='$username'");

								if ($q) {
									echo '<script>window.alert("BERHASIL");window.location=("media.php?module=home")</script>';
								} else {
									echo "GAGAL";
								}    

							}

							$val.=           '</form>
						</div>
					</div>
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>';
		return $val;
}


if(!@$_GET['act']) {
	echo grid();
} elseif ($_GET['act'] == 'tambah') {
	echo add();
} elseif ($_GET['act'] == 'edit') {
	echo edit();
} elseif ($_GET['act'] == 'detail') {
	echo detail();
} elseif ($_GET['act'] == 'addpernyataan') {
	echo addpernyataan();
} elseif ($_GET['act'] == 'pilihaspek') {
	echo pilihaspek();
} elseif ($_GET['act'] == 'typesoal') {
	echo typesoal();
} elseif ($_GET['act'] == 'delete') {
	echo delete();
} elseif ($_GET['act'] == 'listpernyataan') {
	echo listpernyataan();
} elseif ($_GET['act'] == 'edit_pernyataan') {
	echo edit_pernyataan();
} elseif ($_GET['act'] == 'delete_pernyataan') {
	echo delete_pernyataan();
} 

?>
