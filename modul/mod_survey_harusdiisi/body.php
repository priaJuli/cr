
<?php 

function grid() {
    include "config/koneksi.php";
    
    $val = null;
    $val.='
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Survey Harus Dikerjakan</h3>

        </div>
    </div>
    ';
    
    $sess_nik = $_SESSION['nik'];
    $cek    = mysqli_query($DBcon, "SELECT * FROM kuesioner_user WHERE nik = '$sess_nik' AND status ='new' ");

    while ($sql = $cek->fetch_assoc()) {
            $val.='
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Nama Survey: '.$sql['nama_survey'].'
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="col-md-12">                                                  
                                    <p>Terakhir dikerjakan pada : '.$sql['tgl_selesai'].'</p>       
                                </div>
                            <div class="col-md-12">
                            <a href="?page='.$_GET['page'].'&act=kerjakan&id='.$sql['kd_survey'].'"><button type="button" class="btn btn-primary">Kerjakan</button></a> 

                            </div>
                        </div>
                        <!-- /.panel-body -->
                        </div>
                    <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>';
    }


    return $val;
}


function kerjakan() {
    include "config/koneksi.php";
    $kd_survey = $_GET['id'];
    $sql = mysqli_query($DBcon, "SELECT nama_survey,jml_option,type_option FROM survey WHERE kd_survey = '$kd_survey'");
    $result = $sql->fetch_assoc();

    $val = null;
    $val.=' <div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Survey '.$result['nama_survey'].'</h3>
        <a href="index.php?page='.$_GET['page'].'" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Kembali</a> 
        <br><br>
    </div>

    <div class="col-lg-12">
    <div class="panel panel-default">
    <div class="panel-heading">
    Pernyataan   
    </div>
    <div class="panel-body">
    <div class="row">
    <div class="col-lg-12">';
    if(!isset($_POST['proses'])) {
        $join = mysqli_query($DBcon, "SELECT m_pernyataan.pernyataan,m_pernyataan.id_pernyataan,temp.kd_survey FROM m_pernyataan JOIN temp ON m_pernyataan.id_pernyataan = temp.id_soal WHERE temp.kd_survey = '$kd_survey'");
        $q = $join->fetch_assoc();
        $val.='
        <div class="table-responsive">
            <form  enctype="multipart/form-data" method="POST" action="modul/mod_survey_harusdiisi/hitungsurvey.php">
                <input type="hidden" name="proses">
                <input type="hidden" name="nik" value="'.$_SESSION['nik'].'">
                <input type="hidden" name="kd_survey" value="'.$q['kd_survey'].'">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="7%">No</th>
                                <th>Pernyataan</th>
                            </tr>
                        </thead>
                    <tbody>';
                    $i = 1;

                    $array_type_option = explode(",", $result['type_option']);
                    $ni = 1;
/*                    $res = $join->fetch_assoc();
                    do {
                        $val.='
                        <tr>
                            <input type="hidden" name="id_pernyataan[]" value="'.$res['id_pernyataan'].'">
                                <td>'.$i.'</td>
                                <td>'.$res['pernyataan'].'<br>';
                                    $a = 1;


                                    while ($a <= $result['jml_option']) {
                                        $val.='
                                        <div col-md-12>
                                        <div class="col-md-3" style="margin-top:8px;margin-bottom:8px"><input  type="radio" multiple name="'.$ni.'" value="'.$array_type_option[$a - 1].'"><label>'.$array_type_option[$a - 1].'</label></div>
                                        </div>';
                                        $a++;
                                    }
                            $val.='</td>
                        </tr>
                    ';
                    $i++;
                    $ni++;
                    } while ($res = $join->fetch_assoc());*/

                    while ($res = $join->fetch_assoc()) {

                    $val.='
                        <tr>
                            <input type="hidden" name="id_pernyataan[]" value="'.$res['id_pernyataan'].'">
                                <td>'.$i.'</td>
                                <td>'.$res['pernyataan'].'<br>';
                                    $a = 1;

                                    while ($a <= $result['jml_option']) {
                                        $val.='
                                        <div col-md-12>
                                        <div class="col-md-3" style="margin-top:8px;margin-bottom:8px"><input  type="radio" multiple name="'.$ni.'" value="'.$array_type_option[$a - 1].'"><label>'.$array_type_option[$a - 1].'</label></div>
                                        </div>';
                                        $a++;
                                    }
                            $val.='</td>
                        </tr>
                    ';
                    $i++;
                    $ni++;}
                    $val.='        
                    </tbody>
                    </table>
                <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>
            </form>
        </div>';
        } else {
/*            $id_pernyataan      = $_POST['id_pernyataan'];
            $count_pernyataan   = count($id_pernyataan);
            $nik_user           = $_SESSION['nik'];

            for ($i=1; $i <= $count_pernyataan; $i++) { 
                $value = $_POST[$i];
                $kd_soal = $id_pernyataan[$i - 1];

                $sql    = mysqli_query($DBcon, "INSERT INTO hasil_kuesioner (nik,kd_soal,value) VALUES ('$nik_user','$kd_soal','$value')");
            }

                if ($sql) {
                    echo '<script>window.alert("BERHASIL");window.location=("index.php?page='.$_GET['page'].'")</script>';
                } else {
                    echo "GAGAL";
                }
*/        }
        $val.='
        </div>
        </div>
        <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        </div>
        </div>';
        return $val;
    }

    function delete(){
        include "config/koneksi.php";
        $id = $_GET['id'];

        $q1 = mysqli_query($DBcon,"DELETE FROM m_aspek WHERE id_aspek='$id'");

        if ($q1) {
           echo '<script>window.alert("BERHASIL");window.location=("index.php?page='.$_GET['page'].'")</script>';
       } else {
        echo "GAGAL";
    }   
}



if(!@$_GET['act']) {
    echo grid();
} elseif ($_GET['act'] == 'kerjakan') {
    echo kerjakan();
} 


?>

