<?php
session_start();
require_once 'mainClass.php';
$admin = new Database();


if(isset($_POST["username"])) {

    $user_count = $admin->checkUniqueUsername($_POST["username"]);
    if($user_count>0) {
        echo "<span class='text-danger'> E-posta adresi daha önce kayıt edilmiş.</span>";
    }else{
        echo "<span class='text-success'> E-posta kayıt işlemi için uygundur</span>";
    }
}


if(isset($_POST["lostPassword"])) {

    $user_count = $admin->checkUniqueUsername($_POST["lostPassword"]);
    if($user_count<1) {
        echo "<span class='text-danger'> Bu e-posta adresi sisteme kayıtlı değil.</span>";
    }
}

