<?php

session_start();

//Koneksi
$conn = mysqli_connect('localhost', 'root', '', 'kasir');

//registrasi
function registrasi($data) {
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

	if( mysqli_fetch_assoc($result) ) {
		echo "<script>
				alert('username sudah terdaftar!')
		      </script>";
		return false;
	}


	// cek konfirmasi password
	if( $password !== $password2 ) {
		echo "<script>
				alert('konfirmasi password tidak sesuai!');
		      </script>";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO user VALUES('NULL', '$username', '$password')");

	return mysqli_affected_rows($conn);
}

//Login
// if(isset($_POST['login'])){
//     //inisiate variabel
//     $username = $_POST['username'];
//     $password = $_POST['password'];

//     $check = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' and password='$password' ");
//     $hitung = mysqli_num_rows($check);

//     if($hitung>0){
//         //jika datanya ditemukan
//         //berhasil login

//         $_SESSION['login'] = 'True';
//         header('location:index.php');
//     } else {
//         //data tidak ditemukan
//         //gagal login 
//         echo '
//         <script>
//             alert("Username atau Password salah");
//             window.location.href="login.php"
//         </script>
//         ';
//     }

// }



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

//produk dipilih dipesanan
if(isset($_POST['addproduk'])){
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp']; //idpesanan
    $qty = $_POST['qty']; //jumlah atau total yang mau dikeluarin

    //hitung stock sekarang ada berapa
    $hitung1 = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stocksekarang = $hitung2['stock']; //stock barang saat ini

    if($stocksekarang>=$qty){

        //kurangi stok dengan jumlah yang dikeluarkan
        $selisih = $stocksekarang-$qty;

        //stocknya cukup
        $insert = mysqli_query($conn, " INSERT INTO detailpesanan (idpesanan, idproduk, qty) VALUES ('$idp', '$idproduk', '$qty') ");
        $update = mysqli_query($conn, "UPDATE produk SET stock='$selisih' WHERE idproduk='$idproduk'");

        if($insert&&$update){
            header('location:view.php?idp='.$idp) ;
        } else {
            echo '
            <script>
                alert("Gagal menambah pesanan baru");
                window.location.href="view.php?idp='.$idp.'"
            </script>
            ';
        }
    } else{
        //stock ga cukup
        echo '
        <script>
            alert("Stock barang tidak cukup untuk saat ini!");
            window.location.href="view.php?idp='.$idp.'"
        </script>';
    }
}


//menambah barang masuk
if (isset($_POST['barangmasuk'])){
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    $insertb = mysqli_query($conn, "INSERT INTO masuk (idproduk, qty) VALUES ('$idproduk','$qty')");

    if($insertb){
        header('location:masuk.php');
    } else {
        echo '
        <script>alert("Gagal");
        window.location.href="masuk.php"
        </script> 
        ';
    }
}

// hapus produk pesanan
if(isset($_POST['hapusprodukpesanan'])){
    $idp = $_POST['idp'];   //id detail pesanan
    $idproduk = $_POST['idproduk'];
    $idpesanan = $_POST['idpesanan'];

    //cek jumlah sekarang
    $cek1 = mysqli_query($conn, "SELECT * FROM detailpesanan WHERE iddetailpesanan='$idp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    // cek stok sekarang
    $cek3 = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
    $cek4 = mysqli_fetch_array($cek3);
    $stocksekarang = $cek4['stock'];
    
    $hitung = $stocksekarang+$qtysekarang;

    $update = mysqli_query($conn, "UPDATE produk SET stock='$hitung' WHERE idproduk='$idproduk'"); //update stock
    $hapus = mysqli_query($conn, "DELETE FROM detailpesanan WHERE idproduk='$idproduk' AND iddetailpesanan='$idp'");

    if($update&&$hapus){
        header('location:view.php?idp='.$idpesanan);

    } else{
        echo '
        <script>alert("Gagal menghapus barang");
        window.location.href="view.php?id='.$idpesanan.'"
        </script> 
        ';
    }
}

//edit barang
    if(isset($_POST['editbarang'])){
        $np = $_POST['namaproduk'];
        $desc = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $idp = $_POST['idp']; //idproduk

        $query = mysqli_query($conn, "UPDATE produk SET namaproduk='$np', deskripsi='$desc', harga='$harga' WHERE idproduk='$idp' ");

        if($query){
            header('location:stock.php');
        } else {
            echo '
            <script>alert("Gagal");
            window.location.href="stock.php"
            </script> 
            ';

        }

    }

//hapus barang
if(isset($_POST['hapusbarang'])){
    $idp = $_POST['idp']; //idproduk

    $query = mysqli_query($conn, "DELETE FROM produk WHERE idproduk='$idp'");

    if($query){
        header('location:stock.php');
    } else {
        echo '
        <script>alert("Gagal");
        window.location.href="stock.php"
        </script> 
        ';

    }

}

//edit pelanggan
if(isset($_POST['editpelanggan'])){
    $np = $_POST['namapelanggan'];
    $nohp = $_POST['nohp'];
    $a = $_POST['alamat'];
    $id = $_POST['idpl'];

    $query = mysqli_query($conn, "UPDATE pelanggan SET namapelanggan='$np', nohp='$nohp', alamat='$a' WHERE idpelanggan='$id' ");

    if($query){
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal");
        window.location.href="pelanggan.php"
        </script> 
        ';

    }

}

//hapus pelanggan
if(isset($_POST['hapuspelanggan'])){
    $idpl = $_POST['idpl'];

    $query = mysqli_query($conn, "DELETE FROM pelanggan WHERE idpelanggan='$idpl'");

    if($query){
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal");
        window.location.href="pelanggan.php"
        </script> 
        ';

    }

}


//mengubah data barang masuk
if(isset($_POST['editdatabarangmasuk'])){
    $qty = $_POST['qty'];
    $idm = $_POST['idm']; //id masuk
    $idp = $_POST['idp']; //id produk

    //mencari tau qty sekarang
    $caritahu = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm' ");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    //cari tau stock sekarang berapa
    $caristock = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idp'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    if($qty >= $qtysekarang){
        //kalau input user lebih besar daripada qty yg tercatat sekarang
        //hitung selisih
        $selisih = $qty-$qtysekarang;
        $newstock = $stocksekarang+$selisih;

        $query1 = mysqli_query($conn, "UPDATE masuk SET qty='$qty' WHERE idmasuk='$idm' ");
        $query2 = mysqli_query($conn, "UPDATE produk SET stock='$newstock' WHERE idproduk='$idp' ");
        if($query1&&$query2){
            header('location:masuk.php');
        } else {
            echo '
            <script>alert("Gagal");
            window.location.href="masuk.php"
            </script> 
            ';
        }

    } else{
        //kalau lebih kecil
        //hitung selisih
        $selisih = $qtysekarang-$qty;
        $newstock = $stocksekarang-$selisih;

        $query1 = mysqli_query($conn, "UPDATE masuk SET qty='$qty' WHERE idmasuk='$idm' ");
        $query2 = mysqli_query($conn, "UPDATE produk SET stock='$newstock' WHERE idproduk='$idp' ");
        if($query1&&$query2){
            header('location:masuk.php');
        } else {
            echo '
            <script>alert("Gagal");
            window.location.href="masuk.php"
            </script> 
            ';
        }
    }

  

}



?>