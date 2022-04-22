<?php
session_start();
include 'mainClass.php';

if((!isset($_GET["dogrulama"])) && isset($_SESSION['username'])) {

    header("Location:dashboard.php");
    exit;
} else {
    if (isset($_COOKIE['HBR']) && $_COOKIE['HBR'] != 'false' ) {
        $cookieToken= $_COOKIE['HBR'];
        $browser    = md5($_SERVER['HTTP_USER_AGENT']); // Tarayıcı bilgisi.
        $timeValue  = time(); // Unix zaman.
        $checkToken = $admin->checkCookie($cookieToken, $browser, $timeValue);
        if ($checkToken) {
            $username = $admin->fetchUserDetailsByID($checkToken['uye_id']);
            $_SESSION['username'] = $username['kullanici_mail'];
            $_SESSION['uye_id'] = $checkToken['kullanici_id'];
            header("Location:dashboard.php");
            exit;
        }
    }
    /*Orjinal
     * if(isset($_SESSION['username'])){
        header('location:dashboard.php');
        exit();
    }
    */
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Rıdvan BİLGİN">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AFAD MicroWeb - Yönetim Paneli</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style type="text/css">
        html{
            height: 100%;
        }
        body{
            height: 100%;
            width: 100%;
            background-image: radial-gradient( circle farthest-corner at -3.1% -4.3%,  rgba(57,255,186,1) 0%, rgba(21,38,82,1) 90% );
        }
    </style>
</head>

<body class="bg-info">

<div class="container h-100">
    <div class="row align-items-center justify-content-center h-100">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">

        <!--            <form action="" method="post" class="px-3" id="admin-login-form">
                        <div id="adminLoginAlert"></div>
                        <div class="form-group">
                            <input type="text" name="username" class="form-control form-control-lg rounded-0" placeholder="Kullanıcı Adı" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control form-control-lg rounded-0" placeholder="Şifre" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="adminLogin" id="adminLoginBtn" value="Giriş" class="btn btn-danger btn-block btn-lg rounded-0">
                        </div>
                        <div class="text-center">Üye ol</div>
                    </form>-->
                    <!-- login area start -->


                            <div class="login-box">
                                <form method="POST" action="" id="admin-login-form">
    <?php
    if(isset($_GET["register"]) && $_GET["register"]=="ok") {
        ?>
        <div class="bg-danger d-flex justify-content-center card my-2">
            <p class="text-center lead align-self-center text-white m-2">Üye kayıt işlemi tamamlandı. Yönetici onayı beklenmektedir.</p>
        </div>
    <?php
    } elseif (isset($_GET["giris"]) && $_GET["giris"]=="hatali")  {
        ?>
        <div class="bg-danger d-flex justify-content-center card my-2">
            <p class="text-center lead align-self-center text-white m-2">Kullanıcı adı ya da şifre hatası oluştu. Lütfen bilgilerinizi kontrol ediniz.</p>
        </div>
        <?php
    } else {
    ?>
        <div class="login-form-head bg-danger">
                                        <h4>Üye Girişi</h4>
                                        <p>Merhaba, üye girişi yapmaya hazırmısın!</p>
                                    </div>
    <?php
}
        ?>
                                    <div class="login-form-body">
                                        <div class="form-gp">
                                            <label for="username1"><b>Kullanıcı adı</b></label>
                                            <input type="text" name="username" class="form-control form-control-lg rounded-0" id="username1" placeholder="Kullanıcı Adı" required autofocus>
                                            <i class="ti-email"></i>
                                            <div class="text-danger"></div>
                                        </div>
                                        <div class="form-gp mt-3">
                                            <label for="password1"><b>Şifre</b></label>
                                            <input type="password" name="password" id="password1" class="form-control form-control-lg rounded-0" placeholder="Şifre" required>
                                            <i class="ti-lock"></i>
                                            <div class="text-danger"></div>
                                        </div>
                                        <div class="row mb-4 rmber-area">
                                            <div class="col-6">
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" class="custom-control-input"  name="hatirla" id="customControlAutosizing">
                                                    <label class="custom-control-label" for="customControlAutosizing">Beni Hatırla</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="submit-btn-area">
                                            <button name="adminLogin" id="adminLoginBtn" type="submit">Giris Yap <i class="ti-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                    <!-- login area end -->
<!----->

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" defer></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#adminLoginBtn").click(function(e){
            if($("#admin-login-form")[0].checkValidity()){
                e.preventDefault();
                $(this).val('Lütfen Bekleyin...');
                $.ajax({
                    url: 'actions.php',
                    method: 'post',
                    data: $("#admin-login-form").serialize()+'&action=adminLogin',
                    success:function(response){

                        if(response === 'admin_login'){

                            window.location = 'dashboard.php';
                        }else{
                            window.location = 'index.php?giris=hatali';
                        }
                        $("#adminLoginBtn").val('Login');
                    }
                });
            }
        });
    });
</script>
</body>
</html>
<?php

}
?>