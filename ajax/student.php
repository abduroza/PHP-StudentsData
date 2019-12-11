<?php


require '../functions.php';

$keyword = $_GET["keyword"];
$queries = "SELECT * FROM mahasiswa 
            WHERE
            -- nama = '$keyword' //kata kunci harus sama persis. pakai LIKE akan membaca semua data yg memiliki nama depan sama
            nama LIKE '%$keyword%' OR
            nim LIKE '%$keyword%' OR
            email LIKE '%$keyword%' OR 
            jurusan LIKE '%$keyword%'
            ";
$list_mahasiswa = queryy($queries);
?>


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
