<?php
session_start();
require "functions.php";

//cek cookie. kalau ada cek session. supaya aman, cookie menggunakan sistem hash dengan memanfaatkan username.
if(isset($_COOKIE["id"]) && isset($_COOKIE["key"])){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    //ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    //cek cookie dan username
    if($key === hash('sha256', $row['username'])){
        $_SESSION['login'] = true;
    }

}
if(isset($_SESSION['login'])){ //yg sudah login tidak bisa mengakses halaman login. akan di redirect ke index
    header("Location: index.php");
    exit;
}




if(isset($_POST["signin"])){
    $username_email = $_POST["username_email"];
    //$email = $_POST["email"];
    $password = $_POST["password"];
    
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username_email' OR email = '$username_email'");

    //cek username
    if(mysqli_num_rows($result) === 1){ //untuk menghitung ada berapa baris nilai yg dikembalikan dari result. jka ada, akan mengembalikan nilai 1(true)

        //cek password
        $row = mysqli_fetch_assoc($result); //ambil datanya dulu
        if (password_verify($password, $row["password"])){ //merubah password yg sudah di hash menjadi plain text
            //set session. jika login berhasil akan melakukan set sessionnya
            $_SESSION["login"] = true; //session:mekanisme penyimpanan informasi, sehingga variabel bisa diakses di halaman lain

            //cek remember me
            if(isset($_POST["remember"])){
                //buat cookie
                //ambil dulu data user
                setcookie('id', $row['id'], time()+60);
                setcookie('key', hash('sha256', $row['username']), time()+60); //'key' sebagai key dan username sbg value. username di hash biar sulit ditebak valuenya.
                //setcookie('login', 'true', time()+60); ///cara ini terlalu simple. login sebagai key dan true sebagai value
            }

            header("Location: index.php");
            exit;
        }
    }
    $error = true; //digunakan sebagai pesan kesalahan
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Halaman Login</title>
    <style>
        label{
            display: block;
        }
    </style>
</head>
<body>

<h1>Halaman Login</h1>

<?php if(isset($error)) : ?>
    <p style="color: red; font-style: italic;">username or password wrong</p>
<?php endif; ?>

<form action="" method="post">
    <ul>
        <li>
            <label for="USERNAME_EMAIL" >Username or Email: </label>
            <input type="text" name="username_email" id="USERNAME_EMAIL" required placeholder="type your username or email ...">
        </li>
        <li>
            <label for="PASSWORD">Password: </label>
            <input type="password" name="password" id="PASSWORD" required placeholder="type your password ...">
        </li>
        <li>
            <input type="checkbox" name="remember" id="REMEMBER">
            <label for="REMEMBER">Remember me</label>
        </li>
            <button type="submit" name="signin">Sign In</button>
    </ul>

</form>

</body>
</html>
