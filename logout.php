<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['uye_id']);
setcookie("HBR", 'false', time() -3600,'/');
header('location:./index.php');
?>