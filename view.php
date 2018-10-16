<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Survei - PT. Phapros, Tbk.</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="assets/radio-button.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="assets/js/jquery-ui.css" rel="stylesheet" type="text/css">
    <link rel="assets/stylesheet" href="dist2/fastselect.min.css">
    <script src="assets/dist2/fastselect.standalone.js"></script>

        <!-- DataTables CSS -->
    <link href="assets/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="assets/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
     <script src="assets/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="assets/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Survei - PT. Phapros, Tbk.</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li><a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                        <li><a href="index.php?page=aspek"><i class="fa fa-medkit fa-fw"></i> Master Aspek</a></li>
                        <li><a href="index.php?page=survey"><i class="fa fa-medkit fa-fw"></i> Survey</a></li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <?php echo main(); ?>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery --> 
</div>


  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Form Edit Kategori</h4>
                </div>
            <form role="form" enctype="multipart/form-data" method="POST" action="">
                <div class="modal-body">
                    <div class="row">
                    <?php 
                    if(!isset($_POST['proses1'])) {
                        ?>
                                <input type="hidden" name="proses1">
                                <div class="col-lg-3">
                                    <label>Nama Survey</label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="hidden" name="kd_survey" id="kd_survey" readonly="" class="form-control" >
                                    <input type="text" name="nama_survey" id="nama_survey" readonly="" class="form-control" required="">
                                    <input type="hidden" name="aspek" id="aspek" readonly="" class="form-control" >
                                    <input type="hidden" name="jml_option" id="jml_option" readonly="" class="form-control" required="">
                                    <input type="hidden" name="type_option" id="type_option" readonly="" class="form-control" required="">
                                </div>

                                <? } else {
                                    include "config/koneksi.php";
                                    $kd_survey      = $_POST['kd_survey'];
                                    $nama_survey    = $_POST['nama_survey'];
                                    $aspek          = $_POST['aspek'];
                                    $tgl_mulai      = "";
                                    $tgl_selesai    = "";
                                    $jml_option     = $_POST['jml_option'];
                                    $type_option    = $_POST['type_option'];
                                    $kepada         = "";


                                    $carikode = mysqli_query($DBcon, "SELECT max(kd_survey) FROM survey");
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

                                    /*copy survey*/
                                    $q = mysqli_query($DBcon, "INSERT INTO survey (kd_survey,
                                    nama_survey,aspek,tgl_mulai,tgl_selesai,jml_option,type_option,kepada) VALUES ('$kode_otomatis','$nama_survey','$aspek','$tgl_mulai','$tgl_selesai','$jml_option','$type_option','$kepada')");

                                    
                                    if ($q) {
                                        /*tabel temp*/
                                        $sql1        = mysqli_query($DBcon, "SELECT * FROM temp WHERE kd_survey = 
                                            '$kd_survey'");
                                        $datakode1   = $sql1->fetch_assoc(); 
                                        
                                        $nama_aspek = $datakode1['nama_aspek'];
                                        $id_soal    = $datakode1['id_soal'];

                                        $copy = mysqli_query($DBcon, "INSERT INTO temp (kd_survey, nama_aspek, id_soal, scoring) VALUES ('$kode_otomatis','$nama_aspek','$id_soal',NULL)");

                                       
                                        if ($copy) {
                                            echo '<script>window.alert("BERHASIL");window.location=("index.php?page='.$_GET['page'].'")</script>';
                                        }else{
                                            echo '<script>window.alert("GAGAL Copy Kuesioner");window.location=("index.php?page='.$_GET['page'].'")</script>';
                                        }
                                        
                                    } else {
                                        echo "GAGAL";
                                    }    


                                } ?>
                        
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Copy Data</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

    <script src="assets/dist/js/sb-admin-2.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/selectize.js"></script>
    <script src="js/in.js"></script>
    <script src="js/in2.js"></script>
    <script src="assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="assets/vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });

        $(".add-more").click(function(){ 
            var html = $(".copy").html();
            $(".after-add-more").after(html);
        });
        $("body").on("click",".remove",function(){ 
            $(this).parents(".control-group").remove();
        });
    });

        function duplikasi(kd_survey)
        {
            var url = ('modul/mod_survey/data_clone.php');
                $.ajax({
                    type : "POST",
                    url : url,
                    data: "kd_survey="+kd_survey,
                    success: function(data){
                        var res = JSON.parse(data);
                        $('#kd_survey').val(res.kd_survey);
                        $('#nama_survey').val(res.nama_survey);
                        $('#aspek').val(res.aspek);
                        $('#jml_option').val(res.jml_option);
                        $('#type_option').val(res.type_option);
                    }
                });                
        }

        function jml_option() 
        {
            alert('masuk');
        }

    
    </script>
</body>

</html>
