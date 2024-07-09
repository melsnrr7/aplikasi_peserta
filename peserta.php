<?php
    session_start();
    include 'config/config.php';
    // Jika session tidak ada, tolong redirect ke login
    if (!isset ($_SESSION['nama'])) {
        header("location:index.php?error=access-failed");
    }

    $queryPeserta = mysqli_query($koneksi, "SELECT jurusan.nama_jurusan, pendaftaran. * FROM pendaftaran LEFT JOIN jurusan ON jurusan.id = pendaftaran.id_jurusan WHERE deleted = 0 ORDER BY pendaftaran.id DESC");

    // delete query 
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $delete = mysqli_query($koneksi, "UPDATE pendaftaran SET deleted = 1 WHERE id = '$id'");
    }

    // 3, 2, 1, 0(3:lolos sortir, 2:lolos wawancara, 1:lolos full, 0:tidak lolos)
    function customStatus($status) {
        // 1:lolos
        // 2:lolos wawancara
        // 3:lolos sortir
        if ($status == 1) {
            $pesan = "Peserta lolos";
        } elseif ($status == 2) {
            $pesan = "Peserta lolos wawancara";
        } elseif ($status == 3) {
            $pesan = "Peserta lolos sortir";
        } else {
            $pesan = "Peserta tidak lolos";
        }
        return $pesan;
    }

    function customStatus2($status) {
        // 1:lolos
        // 2:lolos wawancara
        // 3:lolos sortir
        switch ($status) {
            case '1':
                $pesan = "Peserta lolos";
                break;
            case '2':
                $pesan = "Peserta lolos wawancara";
                break;
            case '3':
                $pesan = "Peserta lolos sortir";
                break;
            default:
                $pesan = "Peserta tidak lolos";
                break;
        }
        return $pesan;
    }

    // query updates
    if (isset($_POST['ubah_status'])) {
        $status = $_POST['status'];
        $id = $_POST['id'];

        // ubah peserta kolom status dimana id = nilai post id
        $ubahStatus = mysqli_query($koneksi, "UPDATE pendaftaran SET status='$status' WHERE id='$id'");
        header("location:peserta.php?ubah-status-berhasil");
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
                    <h1 class="h3 mb-4 text-gray-800">Data Peserta</h1>
        
                    <div class="table-responsive">
                        <table class="table table-bordered" id="datatables">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jurusan</th>
                                    <th>Gelombang</th>
                                    <th>Tahun</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>No. Telp</th>
                                    <th>Alamat</th>
                                    <th>Pendidikan Terakhir</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; while($dataPeserta = mysqli_fetch_assoc($queryPeserta)) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $dataPeserta['nama_jurusan'] ?></td>
                                    <td><?php echo $dataPeserta['gelombang']?></td>
                                    <td><?php echo $dataPeserta['tahun_pelatihan']?></td>
                                    <td><?php echo $dataPeserta['nik'] ?></td>
                                    <td><?php echo $dataPeserta['nama'] ?></td>
                                    <td><?php echo $dataPeserta['gender'] ?></td>
                                    <td><?php echo $dataPeserta['email'] ?></td>
                                    <td><?php echo $dataPeserta['hp'] ?></td>
                                    <td><?php echo $dataPeserta['alamat'] ?></td>
                                    <td><?php echo $dataPeserta['pendidikan'] ?></td>
                                    <td><?php echo customStatus($dataPeserta['status'])?></td>
                                    
                                    <td>
                                    <a data-toggle="modal" data-target="#ubahstatus-<?php echo $dataPeserta['id']?>" href="#" class="btn btn-primary btn-sm">Edit</a>
                                    <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="peserta.php?delete=<?php echo $dataPeserta['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                                   </td>

                                </tr>
                                <?php include 'modal-ubah-status.php'; ?>
                               <?php }?>
                            </tbody>
                        </table>
                    </div>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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