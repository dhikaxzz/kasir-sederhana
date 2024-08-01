<?php

session_start();

//Koneksi
$conn = mysqli_connect('localhost', 'root', '', 'kasir');

//Login
if(isset($_POST['login'])){
    //inisiate variabel
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' and password='$password' ");
    $hitung = mysqli_num_rows($check);

    if($hitung>0){
        //jika datanya ditemukan
        //berhasil login

        $_SESSION['login'] = 'True';
        header('location:index.php');
    } else {
        //data tidak ditemukan
        //gagal login 
        echo '
        <script>
            alert("Username atau Password salah");
            window.location.href="login.php"
        </script>
        ';
    }

}

// Tambah Barang
if(isset($_POST['tambahbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $insert = mysqli_query($conn, " INSERT INTO produk VALUES ('NULL', '$namaproduk', '$deskripsi', '$harga', '$stock') ");

    if($insert){
        header('location:stock.php') ;
    } else {
        echo '
        <script>
            alert("Gagal menambah barang baru");
            window.location.href="stock.php"
        </script>
        ';
    }
}


// Tambah Pelanggan
if(isset($_POST['tambahpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $nohp = $_POST['nohp'];
    $alamat = $_POST['alamat'];

    $insert = mysqli_query($conn, " INSERT INTO pelanggan VALUES ('NULL', '$namapelanggan', '$nohp', '$alamat') ");

    if($insert){
        header('location:pelanggan.php') ;
    } else {
        echo '
        <script>
            alert("Gagal menambah pelanggan baru");
            window.location.href="pelanggan.php"
        </script>
        ';
    }
}

// tambah pesanan
if(isset($_POST['tambahpesanan'])){
    $idpelanggan = $_POST['idpelanggan'];

    $insert = mysqli_query($conn, " INSERT INTO pesanan (idpelanggan) VALUES ('$idpelanggan') ");

    if($insert){
        header('location:index.php') ;
    } else {
        echo '
        <script>
            alert("Gagal menambah pesanan baru");
            window.location.href="index.php"
        </script>
        ';
    }
}

if(isset($_POST['addproduk'])){
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp'];
    $qty = $_POST['qty']; //jumlah atau total

    $insert = mysqli_query($conn, " INSERT INTO detailpesanan (idpesanan, idproduk, qty) VALUES ('$idp', '$idproduk', '$qty') ");

    if($insert){
        header('location:view.php?idp='.$idp) ;
    } else {
        echo '
        <script>
            alert("Gagal menambah pesanan baru");
            window.location.href="view.php?idp="'.$idp.'
        </script>
        ';
    }
}

?>