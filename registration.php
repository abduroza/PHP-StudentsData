<?php

require 'functions.php';

if(isset($_POST["signup"])){
    if(registration($_POST) > 0){
        echo "
            <script>
                alert('New user success added');
            </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Registrasi</title>
    <style>
        label{
            display: block;
        }
    </style>
</head>
<body>

<h1>Halaman Registrasi</h1>

<form action="" method="post">
    <ul>
        <li>
            <label for="USERNAME">Username: </label>
            <input type="text" name="username" id="USERNAME">
        </li>
        <li>
            <label for="EMAIL">Email: </label>
            <input type="text" name="email" id="EMAIL">
        </li>
        <li>
            <label for="PASSWORD">Password: </label>
            <input type="password" name="password" id="PASSWORD">
        </li>
        <li>
            <label for="PASSWORD2">Password Confirmation: </label>
            <input type="password" name="password2" id="PASSWORD2">
        </li>
            <button type="submit" name="signup">Sign Up</button>
    </ul>

</form>

</body>
</html>
