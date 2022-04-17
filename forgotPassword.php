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
                    <?php
        if(isset($_GET["confirmation"]) && $_GET["confirmation"]==1) {
            ?>
        <div class="bg-danger d-flex justify-content-center card my-2">
            <p class="text-center lead align-self-center text-white m-2">Şifre oluşturma linkiniz e-posta adresinize gönderildi.</p>
        </div>
        <?php
        }

                    if(isset($_GET["sent"]) && $_GET["sent"]==1) {
                    ?>
                    <div class="bg-danger d-flex justify-content-center card my-2">
                        <p class="text-center lead align-self-center text-white m-2">Şifreniz e-posta adresinize gönderildi.</p>
                    </div>
                    <?php
        }
        ?>
                            <div class="login-box">
                                <form method="POST" action="process.php?action=lostPassword" id="admin-login-form">
                                    <div class="login-form-head bg-danger">
                                        <h4>Kayıp Şifre Formu</h4>
                                        <p>Lütfen e-posta adresinizi giriniz.</p>
                                    </div>
                                    <div class="login-form-body">
                                        <div class="form-gp mb-4 mt-4">
                                            <label for="username2"><b>E-posta</b></label>
                                            <input type="email" name="uye_mail" class="form-control form-control-lg rounded-0" id="username2" onBlur="checkUniqueEmail()" placeholder="E-posta" required><span id="user-availability-status"></span>
                                            <i class="ti-email"></i>
                                            <div class="text-danger"></div>
                                        </div>
                                        <div class="submit-btn-area" style="margin-top: 100px">
                                            <button name="adminLogin" id="adminLoginBtn" type="submit">Şifre İste <i class="ti-arrow-right"></i></button>
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
            data:'lostPassword='+$("#username2").val(),
            type: "POST",
            success:function(data){
                $("#user-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error:function (){}
        });
    }
</script>
</body>
</html>
