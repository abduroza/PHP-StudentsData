<?php
session_start();
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

require 'functions.php';


//koneksi database. dipindah ke function.php
//$conn = mysqli_connect("localhost", "abduroza", "password", "phpdasar");


//cek apakah tombol submit sudah di klik atau belum
if(isset($_POST["submit"])){ //apakah ada element yang memiliki method post (yaitu form) yg key nya submit

    //cek apakah data berhasil ditambahkan atau tidak
    if(add($_POST) > 0){
        echo "
            <script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>
         ";
    } else {
        echo "
            <script>
                alert('Data gagal ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Data Student</title>
    <style>
    </style>
</head>
<body>

    <h1>Add Student Data</h1>
    <form action="" method="post" enctype="multipart/form-data"> <!--encytpe untuk mengelola file atau $_FILES-->
        <ul>
            <li>
                <label for="NIM">NIM</label>
                <input type="text" name="nim" id="NIM" required>
            </li>
            <li>
                <label for="NAME">Nama</label>
                <input type="text" name="nama" id="NAME" required>
            </li>
            <li>
                <label for="DEPARTMENT">Jurusan</label>
                <input type="text" name="jurusan" id="DEPARTMENT" required>
            </li>
            <li>
                <label for="EMAIL">Email</label>
                <input type="text" name="email" id="EMAIL" required>
            </li>
            <li>
                <label for="IMAGE">Gambar</label>
                <input type="file" name="gambar" id="IMAGE">
            </li>
            <li>
                <button type="submit" name="submit">Add Student</button>
            </li>
        </ul>
    </form>
</table>

</body>
</html>
