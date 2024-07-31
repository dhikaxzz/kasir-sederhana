<?php

session_start();

//Koneksi
$conn = mysqli_connect('localhost', 'root', '', 'kasir');
 if($conn){
    echo 'berhasil';
 }

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


?>