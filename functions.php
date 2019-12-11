<?php

//koneksi ke database
$conn = mysqli_connect("localhost", "abduroza", "password", "phpdasar");

function queryy($query){
    global $conn; //menjadikan $conn yg diluar menjadi variabel global. kalau gak pakai ini gak bisa. ini ttg variable scope
    $result = mysqli_query($conn, $query); // hasilnya berupa object dan belum ada datanya. biar muncul data harus di fetch. 

    $rows = []; //membuat wadah
    while($row = mysqli_fetch_assoc($result)){

        //menambahkan element baru diakhir array
        $rows[] = $row;

    }
    return $rows; //bentuknya data array assosiatif yg sumbernya dari database
}

function add($data){
    global $conn;

    //ambil data dari tiap elemen dalam form kemudiam save dalam variable. biar querynya simple. 
    $nim = htmlspecialchars($data['nim']); //htmlspecialchars() untuk menmpilkan apadanya. sehingga jika ada yg iseng memasukkan script akan nampak asli
    $name = htmlspecialchars($data['nama']);
    $department = htmlspecialchars($data['jurusan']) ;
    $email = htmlspecialchars($data['email']) ;

    //upload gambar
    $image = upload();
    if(!$image){
        return false;
    }

    //query insert data. 
    $query = "INSERT INTO mahasiswa VALUES (DEFAULT, '$name', '$nim','$department', '$email', '$image')"; //jangan sampai kebalik urutannya
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
function upload(){
    //ambil data dari $_FILES. cara mengetahui letak ngambilnya adalah dg var_dump($_FILES). nanti akan muncul data array. jika tidak ada yg diupload akan null.
    $fileName = $_FILES['gambar']['name'];
    $fileSize = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];
    
    // var_dump($_FILES);
    // var_dump($fileSize);
    // die;

    //cek apakah tidak ada gambar yg diupload
    if($error === 4){
        echo "<script>
                alert('choose image first');
              </script>";
        return false; //berguna untuk menggagalkan fungsi add data jika fungsi upload gambar gagal
    }
    //cek apakah yang diupload adalah gambar
    $permitImageExtension = ['jpg', 'jpeg', 'png', 'gif'];
    $imageExtension0 = explode('.', $fileName); //explode: sebuah fungsi berguna untuk memecah string menjadi array. delimiter ('.')adalah alat pemecahnya. misal rozaq.jpg akan menjadi ['rozaq', 'jpg']
    $imageExtension1 = strtolower(end($imageExtension0)); //mengambil array terakhir dan mengubah karakternya menjadi lowercase
    if (!in_array($imageExtension1, $permitImageExtension)){
        echo "<script>
                alert('Please upload image. Only for jpg, jpeg, png or gif image allowed');
            </script>";
        return false;
    }
    //cek jika ukurannya terlalu besar
    if($fileSize >= 1000000){ //default max size file is 2 mb
        echo "<script>
                alert('Image size too large. Max 1 Mb');
             </script>";
        return false;
    }
    //lolos pengecekan, gambar  siap upload
    //generate nama gambar baru, biar tidak menimpa gambar sebelumnya jika nama file yg diupload sama.
    $NIM = $_POST['nim']; //pakai nim gak perlu pakai uniqid() udah pasti uniq asal mhs yg mengisi nim benar
    $newFileName = 'Websiteku-' . $NIM . '-' . uniqid() . '.' . $imageExtension1;

    move_uploaded_file($tmpName, 'img/' . $newFileName); //memindah dari tempat sementara(tmp_name) ke penyimpanan gambar
    return $newFileName; //mengembalikan nilai ke fungsi upload
}


function delete($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($conn);
}
function edit($data){
    global $conn;

    //ambil data dari tiap elemen dalam form (harus sama dg name yg diberikan) kemudiam save dalam variable. biar querynya simple. 
    $id = $data["id"];
    $name = htmlspecialchars($data['nama']); //htmlspecialchars() untuk menmpilkan apa adanya. sehingga jika ada yg iseng memasukkan script akan nampak asli
    $nim = htmlspecialchars($data['nim']);
    $department = htmlspecialchars($data['jurusan']);
    $email = htmlspecialchars($data['email']);
    $oldImage = $data['oldImage'];

    //cek apakah user memilih gambar baru apa tidak
    if($_FILES['gambar']['error'] === 4){ //angka 4 berarti user tidak mengupload gambar baru
        $gambar = $oldImage; //nilai $gambar akan di set seperti gambar lama
    } else {
        $gambar = upload(); //nilai $image akan diganti menjadi nilai gambar yg baru di upload
    }

    //query insert data.
    $query = "UPDATE mahasiswa SET
                nama = '$name',
                nim = '$nim',
                jurusan = '$department',
                email = '$email',
                gambar= '$gambar'
            WHERE id = $id;
                "; //jangan sampai kebalik
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function searc($keyword){
    $queries = "SELECT * FROM mahasiswa 
                WHERE
                -- nama = '$keyword' //kata kunci harus sama persis. pakai LIKE akan membaca semua data yg memiliki nama depan sama
                nama LIKE '%$keyword%' OR
                nim LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR 
                jurusan LIKE '%$keyword%'
                ";
    return queryy($queries); //mengubah nilai queryy dengan nilai baru hasil pencarian
}

function registration($data){
    global $conn;
    $username = strtolower(stripslashes($data["username"])); //stripslashes: membersihkan backslah, strtolower: merubah menjadi huruf kecil
    $email = strtolower(stripslashes($data["email"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    //cek username sudah ada atau belum. lakukan query dulu
    $usernameCheck = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if(mysqli_fetch_assoc($usernameCheck)){
        echo "<script>
                 alert('Username already exist');
              </script>";
        return false;
    }

    //cek email sudah ada atau belum. lakukan query dulu
    $emailCheck = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email'");
    if(mysqli_fetch_assoc($emailCheck)){
        echo "<script>
                alert('Email already exist');
              </script>";
        return false;
    }

    //cek konfirmasi password
    if($password !== $password2){
        echo "<script>
            alert('Password confirmation not match');
         </script>";
        return false;
    }
    //enksripsi password
    $passwordd = password_hash($password, PASSWORD_DEFAULT);

    //menambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES(DEFAULT, '$username', '$email', '$passwordd')");

    return mysqli_affected_rows($conn); //menghasilkan angka 1 jika berhasil, -1 jika gagal.
}


?>