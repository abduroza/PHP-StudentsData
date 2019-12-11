<?php
session_start();
$_SESSION = []; //melakukan set array kosong suapaya benar2 kosong sessionnya.
session_unset(); //memastikan supaya session bener2 kosong
session_destroy();

setcookie('id', '', time()-3600); //dimundurkan 1 jam
setcookie('key', '', time()-3600); //dimundurkan 1 jam


header("Location: login.php"); //redirect ke login
exit;

?>
