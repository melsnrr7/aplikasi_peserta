<?php
session_start();
include 'config/config.php';
// Jika session tidak ada, tolong redirect ke login
if (!isset($_SESSION['nama'])) {
    header("location:index.php?error=access-failed");
}

// jika button disubmit, ambil nilai dari form, nama, email, password
if (isset($_POST['simpan'])) {
    $nama_pertanyaan = $_POST['nama_pertanyaan'];
    $id_jurusan = $_POST['id_jurusan'];
    // masukkan ke dalam table user dimana kolom nama diambil nilainya dari input
    $insert = mysqli_query($koneksi, "INSERT INTO pertanyaan_wawancara (id_jurusan, nama_pertanyaan) VALUES('$id_jurusan', '$nama_pertanyaan')");
    if ($insert) {
        header("location:pertanyaan_wawancara.php?notif=tambah-succes");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// jika parameter delete ada, buat perintah/query delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM pertanyaan_wawancara WHERE id='$id'");
    header('location:pertanyaan_wawancara.php?notif=delete-success');
}

//tampilkan semua data dari table user, dimana id nya diambil dari parameter edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    // $queryEdit = mysqli_query($koneksi, "SELECT * FROM pertanyaan_wawancara  WHERE id='$id'");
    // $dataEdit = mysqli_fetch_assoc($queryEdit);
    $queryEdit = mysqli_query($koneksi, "SELECT jurusan.nama_jurusan, pertanyaan_wawancara.* FROM pertanyaan_wawancara LEFT JOIN jurusan ON jurusan.id = pertanyaan_wawancara.id_jurusan WHERE pertanyaan_wawancara.id ='$id'");
    $dataEdit = mysqli_fetch_assoc($queryEdit);
}

if (isset($_POST['edit'])) {
    $nama_jurusan = $_POST['id_jurusan'];
    $nama_pertanyaan = $_POST['nama'];
    $id = $_GET['edit'];

    // ubah data dari table user, dimana nilai nama diambil dari inputan nama dan nilai id usernya diambil dari parameter
    $edit = mysqli_query($koneksi, "UPDATE pertanyaan_wawancara SET id_jurusan='$nama_jurusan', nama_pertanyaan='$nama_pertanyaan' WHERE id = '$id'");
    header("location:pertanyaan_wawancara.php?notif=edit-success");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include 'inc/head.php'; ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        include 'inc/sidebar.php';
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include 'inc/navbar.php';
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <?php if (isset($_GET['edit'])) { ?>
                        <h1 class="h3 mb-4 text-gray-800">Edit Pertanyaan</h1>
                    <?php } else { ?>
                        <h1 class="h3 mb-4 text-gray-800">Tambah Pertanyaan</h1>
                    <?php } ?>
                    <?php if (isset($_GET['edit'])) { ?>
                        <div class="card">
                            <div class="card-header">Edit Pertanyaan</div>
                            <div class="card-body">
                                <form action="" method="POST">

                                    <div class="form-group">
                                        <select name="id_jurusan" id="Pilih" class="form-control">

                                            <?php $querytampil = mysqli_query($koneksi, "SELECT * FROM jurusan") ?>

                                            <!-- <option value="<?PHP echo $dataEdit['id'] ?>">Pilih Jurusan</option> -->
                                            <option value="<?PHP echo $dataEdit['id_jurusan'] ?>" hidden><?php echo $dataEdit['nama_jurusan'] ?></option>

                                            <?php while ($dataJurusan = mysqli_fetch_assoc($querytampil)) { ?>
                                                <option value="<?php echo $dataJurusan['id'] ?>"><?php echo $dataJurusan['nama_jurusan'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Nama Pertanyaan</label>
                                        <input value="<?php echo $dataEdit["nama_pertanyaan"] ?>" type="text" class="form-control" name="nama" placeholder="Masukkan pertanyaan...">
                                    </div>

                                    <div class="mb-3">
                                        <input type="submit" class="btn btn-primary" name="edit" value="Ubah">
                                        <a href="pertanyaan_wawancara.php" class="btn btn-danger">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } else { ?>

                        <div class="card">
                            <div class="card-header">Tambah Pertanyaan</div>

                            <div class="card-body">
                                <form action="" method="POST">
                                    <div class="mb-3">
                                        <label for="">Nama Jurusan</label>
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
                                        <div class="mb-3">
                                            <label for="">Nama Pertanyaan</label>
                                            <input type="text" class="form-control" name="nama_pertanyaan" placeholder="Masukkan pertanyaan jurusan">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" class="btn btn-primary" name="simpan">
                                        <a href="pertanyaan_wawancara.php" class="btn btn-danger">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'inc/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <?php include 'inc/js.php'; ?>

</body>

</html>