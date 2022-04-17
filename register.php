<?php
session_start();
include 'mainClass.php';
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Rıdvan BİLGİN">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HaberMerkezi - Yönetim Paneli</title>
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
                                <form method="POST" action="" id="admin-login-form" oninput='uye_parola2.setCustomValidity(uye_parola2.value != uye_parola.value ? "Şifreleriniz eşleşmiyor." : "")'>
                                    <div class="login-form-head bg-danger">
                                        <h4>Kayıt Formu</h4>
                                        <p>Merhaba, üye olmaya hazır mısın?</p>
                                    </div>
                                    <div class="login-form-body">
                                        <div class="form-gp">
                                            <label for="username1"><b>İsim Soyisim</b></label>
                                            <input type="text" name="uye_ad" class="form-control form-control-lg rounded-0" id="username1" placeholder="İsim Soyisim" required autofocus>
                                            <i class="ti-email"></i>
                                            <div class="text-danger"></div>
                                        </div>
                                        <div class="form-gp mt-3">
                                            <label for="username2"><b>E-posta</b></label>
                                            <input type="email" name="uye_mail" class="form-control form-control-lg rounded-0" id="username2" onBlur="checkUniqueEmail()" placeholder="E-posta" required><span id="user-availability-status"></span>
                                            <i class="ti-email"></i>
                                            <div class="text-danger"></div>
                                        </div>
                                        <div class="form-gp mt-3">
                                            <label for="uye_parola"><b>Şifre</b></label>
                                            <input type="password" name="uye_parola" id="uye_parola" class="form-control form-control-lg rounded-0" placeholder="Şifre" required>
                                            <i class="ti-lock"></i>
                                            <div class="text-danger"></div>
                                        </div>
                                        <div class="form-gp mt-3">
                                            <label for="uye_parola2"><b>Şifre Tekrarı</b></label>
                                            <input type="password" name="uye_parola2" id="uye_parola2" class="form-control form-control-lg rounded-0" placeholder="Şifre Tekrarı" required>
                                            <i class="ti-lock"></i>
                                            <div class="text-danger"></div>
                                        </div>
                                        <div class="form-gp mt-3">
                                            <label for="gender"><b>Cinsiyet</b></label>
                                            <select class="form-control" name="uye_cinsiyet" id="gender">
                                                <option value="1">Erkek</option>
                                                <option value="0">Kadın</option>
                                            </select>
                                        </div>
                                        <div class="submit-btn-area mt-3">
                                            <button name="adminLogin" id="adminLoginBtn" type="submit">Kayıt Ol <i class="ti-arrow-right"></i></button>
                                        </div>
                                        <div class="form-footer text-center mt-5">
                                            <p class="text-muted">Zaten üye misiniz?  <a href="index.php" class="text-danger">Giriş yap</a>ın.</p>
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
    function checkUniqueEmail() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data:'username='+$("#username2").val(),
            type: "POST",
            success:function(data){
                $("#user-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error:function (){}
        });
    }
    $(document).ready(function(){
        $("#adminLoginBtn").click(function(e){
            if($("#admin-login-form")[0].checkValidity()){
                e.preventDefault();
                $(this).val('Lütfen Bekleyin...');
                $.ajax({
                    url: 'actions.php',
                    method: 'post',
                    data: $("#admin-login-form").serialize()+'&action=adminRegister',
                    success:function(response){

                        if(response === 'admin_login'){

                            window.location = 'index.php?register=ok';
                        }else{
                            alert(response);
                           // $("#adminLoginAlert").html(response);
                        }
                        $("#adminLoginBtn").val('Kayıt Ol');
                    }
                });
            }
        });
    });
</script>

</body>
</html>
