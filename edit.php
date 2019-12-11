<?php
session_start();
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

require 'functions.php';

//ambil data dari url
$id = $_GET["id"];

//query data mahasiswa berdasarkan id
$list_mahasiswa = queryy("SELECT * FROM mahasiswa WHERE id = $id")[0];


//cek apakah tombol edit sudah di klik atau belum
if(isset($_POST["submit"])){ //apakah ada element yang memiliki method post (yaitu form) yg key nya submit

    //cek apakah data berhasil diubah atau tidak
    if(edit($_POST) > 0){
        echo "
            <script>
                alert('Data berhasil diedit!');
                document.location.href = 'index.php';
            </script>
         ";
    } else {
        echo "
            <script>
                alert('Data gagal diupdate!');
                document.location.href = 'index.php';
            </script>
        ";
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Student</title>
    <style>
    </style>
</head>
<body>

    <h1>Edit Student Data</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $list_mahasiswa["id"]; ?>"> <!--menambahkan input yg hidden. Hanya untuk mengambil data id supaya bisa diidentifikasi-->
        <input type="hidden" name="oldImage" value="<?= $list_mahasiswa["gambar"]; ?>">
        
        <ul>
            <li>
                <label for="NIM">NIM</label>
                <input type="text" name="nim" id="NIM" required value="<?= $list_mahasiswa["nim"];?>">
            </li>
            <li>
                <label for="NAME">Nama</label>
                <input type="text" name="nama" id="NAME" required value="<?= $list_mahasiswa["nama"];?>">
            </li>
            <li>
                <label for="DEPARTMENT">Jurusan</label>
                <input type="text" name="jurusan" id="DEPARTMENT" required value="<?= $list_mahasiswa["jurusan"];?>">
            </li>
            <li>
                <label for="EMAIL">Email</label>
                <input type="text" name="email" id="EMAIL" required value="<?= $list_mahasiswa["email"];?>">
            </li>
            <li>
                <label for="IMAGE">Gambar</label>
                <img src="img/<?= $list_mahasiswa["gambar"];?>" width="50" alt=""> <!--menampilkan gambar yg sudah diupload sebelumnya-->
                <input type="file" name="gambar" id="IMAGE">
            </li>
            <li>
                <button type="submit" name="submit">Edit Data</button>
            </li>
        </ul>
    </form>
</table>

</body>
</html>
