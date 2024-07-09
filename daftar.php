<?php
session_start();
include 'config/config.php';

// Mencari sebuah email di table user, jika ada dapat data
// Kalau tidak ada, kembali ke login dengan pesan data tidak ditemukan
// $_POST[] => variable sistem untuk mengambil nilai dari input dengan method post


if (isset($_POST['daftar'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $hp = $_POST['hp'];
    $gender = $_POST['gender'];
    $alamat = $_POST['alamat'];
    $pendidikan = $_POST['pendidikan'];
    $id_gelombang = $_POST['id_gelombang'];
    $tahun_pelatihan = date("Y");
    $id_jurusan = $_POST['id_jurusan'];

    // masukkan ke dalam table pendaftaran dimana kolom nama diambil nilainya dari input
    $insertDaftar = mysqli_query($koneksi, "INSERT INTO pendaftaran (nik, nama, email, hp, gender, alamat, pendidikan, id_gelombang, tahun_pelatihan, id_jurusan) VALUES('$nik', '$nama', '$email', '$hp', '$gender', '$alamat', '$pendidikan', '$id_gelombang', '$tahun_pelatihan', $id_jurusan)");

    if ($insertDaftar) {
        // redirect ke:
        header("location:daftar.php?notif=tambah-succes");
    }
}

$gelombang = mysqli_query($koneksi, "SELECT * FROM gelombang WHERE aktif = 1 ORDER BY id DESC");
$dataGelombang = mysqli_fetch_assoc($gelombang);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php'; ?>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <?php if (isset($_GET['success'])) : ?>
                                        <div class="alert alert-success">Terimakasih sudah mendaftar di PPKD Jakarta Pusat :)</div>
                                    <?php endif ?>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Daftar Pelatihan-PPKD Jakarta Pusat</h1>
                                    </div>

                                    <form class="user" method="POST">
                                        <div class="form-group">
                                            <input name="nik" type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukkan NIK KTP Anda">
                                        </div>
                                        <div class="form-group">
                                            <input name="nama" type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukkan Nama Anda">
                                        </div>
                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukkan Email Anda">
                                        </div>
                                        <div class="form-group">
                                            <input name="hp" type="number" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukkan Nomor Telepon Anda">
                                        </div>
                                        <div class="form-group">
                                            <input name="gender" type="radio" id="exampleInputEmail" value="laki-laki"> Laki-laki
                                            <input name="gender" type="radio" id="exampleInputEmail" value="perempuan"> Perempuan
                                        </div>
                                        <div class="form-group">
                                            <textarea name="alamat" type="radio" class="form-control" placeholder="Masukkan Alamat Anda"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input name="pendidikan" type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukkan Pendidikan Anda">
                                        </div>
                                        <div class="form-group">
                                            <select name="id_jurusan" id="" class="form-control">
                                                <option value="">Pilih jurusan</option>
                                                <?php
                                                $queryJurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
                                                ?>
                                                <?php while ($dataJurusan = mysqli_fetch_assoc($queryJurusan)) { ?>
                                                    <option value="<?php echo $dataJurusan['id'] ?>"><?php echo $dataJurusan['nama_jurusan'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" readonly value="<?php echo $dataGelombang['nama_gelombang'] ?>" class="form-control" placeholder="Nama Gelombang"></input>
                                            <input type="hidden" name="id_gelombang" value="<?php echo $dataGelombang['id'] ?>">
                                        </div>

                                        <hr>
                                        <button name="daftar" type="submit" class="btn btn-primary btn-user btn-block">
                                            Daftar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <?php include 'inc/js.php'; ?>

</body>

</html>