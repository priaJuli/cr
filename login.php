<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>:: Login ::</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
  <body>


<?php


function form_login() {
	$val=null;
    $val.='<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="" method="POST">
                         <input name="proses" type="hidden" value="login">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
';
		
		return $val;
	
}


function cek_login() {
	$val=null;
    include "config/koneksi.php";
	$username = $_POST['username'];
	$password = md5($_POST['password']);
    $timeZone = date_default_timezone_get();
    date_default_timezone_set($timeZone);
	
	$query = "SELECT * FROM users WHERE username='$username' and password='$password'";
	$result = mysqli_query($DBcon, $query);
	if(mysqli_num_rows($result) > 0) {
	    $d = $result->fetch_assoc();
        $_SESSION['username']=$username;
        $_SESSION['password']=$password;
        $_SESSION['nama']=$d['nama'];
        $_SESSION['level']="admin";  	
        //$dateNow = date('Y-m-d h:i:s');


        $qlog = mysqli_query($DBcon,"UPDATE user SET lastLogin=now() WHERE username='$username'");

    	echo '<script>window.location=("index.php")</script>';
	}
	else {
    	$query = "SELECT * FROM pegawai WHERE username_login='$username' and password_login='$password'";
        $result = mysqli_query($DBcon, $query);
        if(mysqli_num_rows($result) > 0) {
            $d = $result->fetch_assoc();
            $_SESSION['username']   = $username;
            $_SESSION['nama']       = $d['EmployeeName'];
            $_SESSION['unit']        = $d['Unit'];
            $_SESSION['nik']        = $d['NIK'];
            $_SESSION['level']      = "user";   
            //$dateNow = date('Y-m-d h:i:s');

                /*insert data ke tabel kuesioner_user */
                    $q = mysqli_query($DBcon, "SELECT nama_survey,kd_survey,kepada,tgl_mulai,tgl_selesai FROM survey");
                    $array_kd = array();
                    while ($sql = $q->fetch_assoc()) {
                        $unit = $sql['kepada'];
                        $array_unit = explode(",", $unit);

                        for ($i = 0; $i < count($array_unit); $i++) {
                            if (strcmp($array_unit[$i], $_SESSION['unit']) == 0) {
                                $array_kd[$i] = $sql['kd_survey'];
                                
                                $nik            = $_SESSION['nik'];
                                $kd_survey      = $sql['kd_survey'];
                                $nama_survey    = $sql['nama_survey'];
                                $tgl_selesai    = $sql['tgl_selesai'];


                                $cek = mysqli_query($DBcon, "SELECT * FROM kuesioner_user WHERE nik = '$nik' AND kd_survey='$kd_survey'");

                                if (mysqli_num_rows($cek) == 0) {
                                    
                                    $sql_insert = mysqli_query($DBcon, "INSERT INTO kuesioner_user (nik,kd_survey,nama_survey,tgl_selesai,status) VALUES ('$nik','$kd_survey','$nama_survey','$tgl_selesai','new')");
                                }
                            }
                        }
                    }
              echo '<script>window.location=("pegawai.php")</script>';
        }
        else {
            echo '<script type="text/javascript">   alert("Maaf, username User / password Salah User!"); </script>';
            echo '<script>window.location=("index.php")</script>';  
        }
	}
}

?>

          <!-- jQuery -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="assets/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="assets/dist/js/sb-admin-2.js"></script>
    <script src="assets/js/bootstrap-tokenfield.js"></script>

</body>
</html>



