<?php
session_start();
require_once 'mainClass.php';
$admin = new Database();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'inc/PHPMailer/src/Exception.php';
require 'inc/PHPMailer/src/PHPMailer.php';
require 'inc/PHPMailer/src/SMTP.php';

if(isset($_GET["email"]) && isset($_GET["code"])) {
    $createToken = substr(sha1(md5(uniqid())),0,10);
    $user_count = $admin->checkLostPassword($_GET["email"],$_GET["code"]);
    if($user_count>0) {

        $postaGonder = new PHPMailer();
        $postaGonder->IsSMTP();
        $postaGonder->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//$postaGonder->SMTPDebug = 1;
        $postaGonder->SMTPAuth = true;
        $postaGonder->SMTPSecure = 'tls';
        $postaGonder->Host = 'smtp.yandex.com';
        $postaGonder->Port = 587;
        $postaGonder->IsHTML(true);
        $postaGonder->CharSet ="utf-8";
        $postaGonder->Username = "kumandan@yandex.com";
        $postaGonder->Password = "Deneme12!";
        $postaGonder->SetFrom("kumandan@yandex.com", "Haber Merkezi");
        // Mail attigimizda yazacak isim
        $postaGonder->AddAddress($_GET["email"]);
        // Maili gonderecegimiz kisi/ alici
        $postaGonder->Subject = "Şifre Oluşturma";
        // Konu basligi
        $content = '<div style="background: #eee; padding: 10px; font-size: 14px">Yeni Şifreniz: '.$createToken.'</div>';
        $postaGonder->MsgHTML($content);
        if (!$postaGonder->send()) {
            echo 'Mailer Error: ' . $postaGonder->ErrorInfo;
        } else {
            echo 'Message sent!';
        }
        $changePassword = $admin->changeUserPassword($_GET["email"],sha1($createToken));
        Header("Location:forgotPassword.php?sent=1");
        exit();
//        echo "<span class='text-danger'> E-posta adresi daha önce kayıt edilmiş.</span>";
    } else {
        echo "<span class='text-success'> E-posta adresinize gönderilen linki takip ediniz.</span>";
    }
}


