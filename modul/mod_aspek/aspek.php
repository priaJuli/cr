
<?php 

function grid() {
    include "config/koneksi.php";
    $val = null;
    $val.='
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Master Aspek</h1>
            <a href="index.php?page='.$_GET['page'].'&act=tambah" class="btn btn-success">Tambah Aspek</a>
            <br><br>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Data Obat
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th style="width:15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>';
                            $i = 1;
                            $q = mysqli_query($DBcon, "SELECT * FROM m_aspek");
                            while ($dq = $q->fetch_assoc()) {
                              $val.='<tr>
                              <td>'.$i.'</td>
                              <td>'.$dq['nama_aspek'].'</td>
                              <td>
                                <a href="?page='.$_GET['page'].'&act=edit&id='.$dq['id_aspek'].'" title="Edit" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a> 
                                <a href="?page='.$_GET['page'].'&act=delete&id='.$dq['id_aspek'].'" title="Delete" class="btn btn-danger btn-xs" ><i onclick="return confirm(\'Anda Yakin Akan Menghapus\')" class="fa fa-times"></i></a> 
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


function add() {
    include "config/koneksi.php";
    $val = null;
    $val.=' <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Tambah Aspek</h1>
        <a href="index.php?page='.$_GET['page'].'" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Data Obat</a>
        <br><br>
        <p>Gunakan tombol <strong>"Tab"</strong> untuk berpindah kolom</p>
    </div>

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Tambah Kategori
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">';
                        if(!isset($_POST['proses'])) {
                            $val.='
                            <form role="form" enctype="multipart/form-data" method="POST" action="">
                                <input type="hidden" name="proses">
                                <div class="form-group">
                                    <label>Nama Kategori</label>
                                    <input type="text" class="form-control" name="nama_kategori" placeholder="Ex : Antimo" autofocus required>
                                </div>


                                <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>';
                            } else {
                                $nama = mysqli_real_escape_string($DBcon, $_POST['nama_kategori']);
                                $q = mysqli_query($DBcon, "INSERT INTO m_aspek (nama_aspek) VALUES ('$nama')");
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

function edit() {
    include "config/koneksi.php";
    $id = $_GET['id'];
    $q1 = mysqli_query($DBcon,"SELECT * FROM m_aspek WHERE id_aspek='$id'");
    $dq1 = $q1->fetch_assoc();
    $val = null;
    $val.=' <div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><span class="fa fa-plus"> Tambah Aspek</h1>
        <a href="index.php?page='.$_GET['page'].'" class="btn btn-success"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Data Obat</a>
        <br><br>
        <p>Gunakan tombol <strong>"Tab"</strong> untuk berpindah kolom</p>
    </div>

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Tambah Aspek
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">';
                        if(!isset($_POST['proses'])) {
                            $val.='
                            <form role="form" enctype="multipart/form-data" method="POST" action="">
                                <input type="hidden" name="proses">
                                <div class="form-group">
                                    <label>Nama Obat</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Ex : Antimo" autofocus required value="'.$dq1['nama_aspek'].'">
                                </div>

                                <button type="submit" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Simpan</button>';
                            } else {
                                $id = $_GET['id'];
                                $nama = mysqli_real_escape_string($DBcon, $_POST['nama']);

                                $q = mysqli_query($DBcon, "UPDATE m_aspek SET nama_aspek='$nama'
                                    WHERE id_aspek='$id'");


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

    if(!@$_GET['act']) {
        echo grid();
    } elseif ($_GET['act'] == 'tambah') {
        echo add();
    } elseif ($_GET['act'] == 'edit') {
        echo edit();
    } elseif ($_GET['act'] == 'delete') {
        echo delete();
    } 


    ?>

