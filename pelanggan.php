<?php
    require 'ceklogin.php';
    //hitung jumlah pelanggan
    $h1 = mysqli_query($conn, "SELECT * FROM pelanggan");
    $h2 = mysqli_num_rows($h1); //jumlah pelanggan
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Kasir Sederhana</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Aplikasi Kasir</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                    <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link d-flex align-items-center mb-2 py-2 px-3" href="index.php">
                            <div   div class="sb-nav-link-icon me-2"><i class="fas fa-tachometer-alt"></i></div>
                            Order
                            </a>
                            <a class="nav-link d-flex align-items-center mb-2 py-2 px-3" href="stock.php">
                                <div class="sb-nav-link-icon me-2"><i class="fas fa-box"></i></div>
                                Stok Barang
                            </a>
                            <a class="nav-link d-flex align-items-center mb-2 py-2 px-3" href="masuk.php">
                                <div class="sb-nav-link-icon me-2"><i class="fas fa-inbox"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link d-flex align-items-center mb-2 py-2 px-3" href="pelanggan.php">
                                <div class="sb-nav-link-icon me-2"><i class="fas fa-users"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link d-flex align-items-center mb-2 py-2 px-3 bg-danger text-white" href="logout.php">
                            <div class="sb-nav-link-icon me-2"><i class="fas fa-sign-out-alt"></i></div>
                            Logout
                            </a>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Pelanggan</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Selamat Datang di Kasir Sederhana</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Jumlah Pelanggan: <?=$h2?></div>
                                </div>
                            </div>
                        </div>
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn btn-info mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
                        Tambah Pelanggan
                        </button>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pelanggan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pelanggan</th>
                                            <th>No Hp</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                    $get = mysqli_query($conn,"SELECT * FROM pelanggan");
                                    $i = 1;

                                    while($p=mysqli_fetch_array($get)){
                                    $namapelanggan = $p['namapelanggan'];
                                    $nohp = $p['nohp'];
                                    $alamat = $p['alamat'];
                                    $idpl = $p['idpelanggan'];
                                    ?>
                                        <tr>
                                            <td><?=$i++?></td>
                                            <td><?=$namapelanggan?></td>
                                            <td><?=$nohp?></td>
                                            <td><?=$alamat?></td>
                                            <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idpl?>">Edit</button> 
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idpl?>">Delete</button>
                                            </td>
                                        </tr>

                                                                               <!-- Modal edit -->
                    <div class="modal" id="edit<?=$idpl?>">
                        <div class="modal-dialog">
                            <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Ubah <?=$namapelanggan?> </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form method="post">
                            
                                <!-- Modal body -->
                                <div class="modal-body">
                                <input type="text" name="namapelanggan" class="form-control mt-3" placeholder="Nama Pelanggan" value="<?=$namapelanggan?>">
                                <input type="text" name="nohp" class="form-control mt-3" placeholder="No Hp" value="<?=$nohp?>">
                                <input type="text" name="alamat" class="form-control mt-3" placeholder="Alamat" value="<?=$alamat?>">
                                <input type="hidden" name="idpl" value="<?=$idpl?>">
                            </div>
                            
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="editpelanggan">Submit</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                            </div>
                        </div>
                        </div>
                                        <!-- Modal delete -->
                        <div class="modal" id="delete<?=$idpl?>">
                        <div class="modal-dialog">
                            <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Hapus <?=$namapelanggan?></h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form method="post">
                            
                                <!-- Modal body -->
                                <div class="modal-body">
                                Apakah anda yakin ingin menghapus pelanggan ini?
                                <input type="hidden" name="idpl" value="<?=$idpl?>">
                            </div>
                            
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="hapuspelanggan">Submit</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>

                            </form>

                            </div>
                        </div>
                        </div>

                                    <?php 
                                    }; //end off while 
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

    <!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data Pelanggan</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

    <form method="post">
    
        <!-- Modal body -->
        <div class="modal-body">
        <input type="text" name="namapelanggan" class="form-control mt-3" placeholder="Nama Pelanggan">
        <input type="text" name="nohp" class="form-control mt-3" placeholder="Nomor Hp">
        <input type="num" name="alamat" class="form-control mt-3" placeholder="Alamat">
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
          <button type="submit" class="btn btn-success" name="tambahpelanggan">Submit</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>

    </form>

    </div>
  </div>
</div>

</html>
