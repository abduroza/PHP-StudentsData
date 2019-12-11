<?php
session_start();
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}


//import
require 'functions.php';

//ambil/query data dari tabel mahasiswa
$list_mahasiswa = queryy("SELECT * FROM mahasiswa"); //bentuknya array assosiatif yg sumbernya dari database

//tombol cari ditekan
if(isset($_POST["search"])){
    $list_mahasiswa = searc($_POST["keyword"]);
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Admin</title>
    <style>
    .loader{
        width: 30px;
        position: absolute;
        top: 145px;
        z-index: -1;
        display: none; /*membuat loader tersembunyi secara default. muncul saat ada event*/
    }

    @media print{
        .logout {display: none;}
        .add{display: none;}
    }
    </style>
</head>
<body>

<a href="logout.php" class="logout">Sign Out</a>

<h1>Daftar Mahasiswa</h1>

<a href="add.php" class="add" >Tambah data Mahasiswa</a>
<br><br>

<form action="" method="post">
    <input type="text" name="keyword" size="20p" autofocus placeholder="type your keyword ..." autocomplete="off" id="keyword"> <!--autofocus: supaya input langsung aktif, placeholder: memberi hint, autocomplete="off": supaya tidak menyimpan inputan sebelumnya-->
    <button type="submit" name="search" id="button-search">Search</button>

    <img src="img/loader2.gif" class="loader">


</form>
<br>

<div id="container"> <!--container ini diberikan karena tidak semua page akan di reload-->

<table border="1" cellpadding="10" cellspacing="0">

    <tr>
        <th>No.</th>
        <th>Action</th>
        <th>Image</th>
        <th>NIM</th>
        <th>Name</th>
        <th>Email</th>
        <th>Department</th>
    </tr>
    <?php $i= 1; ?> <!--menambahkan no.urut-->
    <?php foreach ($list_mahasiswa as $mahasiswa) : ?>
    <tr>
        <td><?= $i; ?></td> <!--menambahkan no.urut-->
        <td>
            <a href="edit.php?id=<?= $mahasiswa["id"]; ?>" >Edit</a> | 
            <a href="delete.php?id=<?= $mahasiswa["id"]; ?>" onclick=" return confirm('Yakin');">Delete</a>
        </td>
        <td><img src="img/<?= $mahasiswa["gambar"];?>" width="50" alt=""></td>
        <td><?= $mahasiswa["nim"];?></td>
        <td><?= $mahasiswa["nama"];?></td>
        <td><?= $mahasiswa["email"];?></td>
        <td><?= $mahasiswa["jurusan"];?></td>
    </tr>
    <?php $i++; ?> <!--menambahkan no.urut-->
    <?php endforeach;?>

</table>
</div>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
