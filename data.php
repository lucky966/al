<?php
$host = mysqli_connect("localhost", "root", "", "ujicoba");

if (isset($_POST['simpan'])) {
    // uji apakah disimpan or edit
    if (isset($_GET['hal']) == "edit") {
        // data di edit
        $edit = mysqli_query($host, "UPDATE pelajar SET 
                                    nama = '$_POST[nama]',
                                    alamat = '$_POST[alamat]',
                                    telepon = '$_POST[telepon]'
                                    WHERE id_pelajar = '$_GET[id]'
                                    ");
        if ($edit) {
            echo "<script>
            alert('Edit data berhasil');
            document.location='data.php';
        </script>";
        } else {
            echo "<script>
            alert('Edit data gagal');
            document.location='data.php';
        </script>";
        }
    } else {
        // data akan disimpan baru
        $simpan = mysqli_query($host, "INSERT INTO pelajar (nama , alamat , telepon)
                                        VALUES ('$_POST[nama]',
                                                '$_POST[alamat]',
                                                '$_POST[telepon]')");

        if ($simpan) {
            echo "<script>
                    alert('Simpan data berhasil');
                    document.location='data.php';
                    </script>";
        } else {
            echo "<script>
                    alert('Simpan data gagal');
                    document.location='data.php';
                    </script>";
        }
    }
}
// deklarasi variabel untuk di edit
$nama    = "";
$alamat  = "";
$telepon = "";

if (isset($_GET['hal'])) {
    // test uji edit
    if ($_GET['hal'] == "edit") {
        $execute = mysqli_query($host, "SELECT * FROM pelajar WHERE id_pelajar = '$_GET[id]'");
        $see = mysqli_fetch_assoc($execute);
        if ($see) {
            // jika data ditemukan maka di tampung ke dlm var
            $nama = $see['nama'];
            $alamat = $see['alamat'];
            $telepon = $see['telepon'];
        }
    } else if ($_GET['hal'] == "delete") {
        $hapus = mysqli_query($host, "DELETE FROM pelajar WHERE id_pelajar = '$_GET[id]'");
        if ($hapus) {
            echo "<script>
                    alert('Hapus data berhasil');
                    document.location='data.php';
                    </script>";
        } else {
            echo "<script>
                    alert('Hapus data gagal');
                    document.location='data.php';
                    </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../gabut/ujisatu/assets/css/bootstrap.min.css">
    <title>Data Pelajar</title>
</head>

<body>
    <!-- Form Tambah -->
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card ">
                    <div class="card-header">
                        <h5>Tambah Pelajar</h5>
                    </div>
                    <div class="card-body">
                        <form class="" method="POST">
                            <label class="label form" for="">Nama Lengkap</label>
                            <input type="text" class="form-control mb-2" value="<?= $nama ?>" name="nama">
                            <label class="label form" for="">Alamat </label>
                            <textarea class="form-control" value="<?= $alamat ?>" name="alamat" id="alamat" cols="30" rows="2"></textarea>
                            <label class="label form" for="">Nomor Telepon </label>
                            <input type="" class="form-control mb-2" value="<?= $telepon ?>" name="telepon">
                            <button class="btn btn-success align-center" name="simpan">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Data Pelajar -->
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Data Pelajar</h5>
                    </div>
                    <div class="card-body">
                        <a href="" class="btn btn-success ">Tambah </a>
                        <table class="table table-bordered table-striped table-hover mt-3">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Telpon</th>
                                <th>Aksi</th>
                            </tr>
                            <?php
                            $query   = "SELECT * FROM pelajar";
                            $execute = mysqli_query($host, $query);
                            $no      = 1;
                            while ($see = mysqli_fetch_assoc($execute)) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $see['nama'] ?></td>
                                    <td><?= $see['alamat'] ?></td>
                                    <td><?= $see['telepon'] ?></td>
                                    <td>
                                        <a href="data.php?hal=edit&id=<?= $see['id_pelajar'] ?>" class="btn btn-warning">Edit</a>
                                        <a href="data.php?hal=delete&id=<?= $see['id_pelajar'] ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin mau hapus data ini')">Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
<script src="../../pandoradev_23/javascript/assets/bootsrap/js/jquery.min.js"></script>
<script>
    // ajax milik jquery
    $(document).ready(function() {

        $('.form-tambah').submit(function(e) {
            e.preventDefault();
            // antisipasi form agar menggunakan ajax

            var action = $(this).attr('action') + '?tambah=true';
            var method = $(this).attr('method');
            var data = $(this).serialize();

            // serealize= untuk mendapatkan semua data yang ada d form 
            // proses kirimm data menggunakan ajax
            $.ajax({
                url: action,
                type: method,
                data: data,
                success: function(data) {
                    alert(data);
                }
            });
        })
    });
</script>

</html>