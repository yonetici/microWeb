<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location:index.php');
    exit();
}
$ekipBilgileri = ["1. Acil Müdahale Ekibi", "2. Acil Müdahale Ekibi", "3. Acil Müdahale Ekibi","4. Acil Müdahale Ekibi","DAK (Dağda Arama Kurtarma) Ekibi", "Suda Arama Kurtarma Ekibi", "KBRN Ekibi"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Rıdvan BİLGİN">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <style>
        .admin-nav {
            min-height: 100vh;
            width: 220px;
            overflow: hidden;
            background-color: #343a40;
        }
        .admin-link{
            background-color: #343a40;
        }
        .admin-link:hover, .nav-active{
            background-color: #212529;
            text-decoration: none;
        }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" defer></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#close-nav").click(function(){
                $(".admin-nav").animate({'width':'0'});
            });
            $("#open-nav").click(function(){
                $(".admin-nav").animate({'width':'220px'});
            });

        });
    </script>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="admin-nav p-0">
            <h4 class="text-light text-center p-2">Yönetim Paneli<a href="#" class="text-light float-right" id="close-nav"><i class="fas fa-times"></i></a></h4>
            <div class="list-group list-group-flush" id="main-menu">
                <a href="dashboard.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == "dashboard.php")?"nav-active":""; ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;Ana Sayfa</a>
                <!--<a href="profile.php" class="list-group-item text-light admin-link"><i class="fas fa-id-card"></i>&nbsp;&nbsp;Profil</a>-->
                <?php     if ($admin->checkUserStatus($_SESSION['uye_id'])==2 || $admin->checkUserStatus($_SESSION['uye_id'])==3) { ?>
                <a href="taskManagement.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == "taskManagement.php")?"nav-active":""; ?>"><i class="fas fa-sticky-note"></i>&nbsp;&nbsp;Olay Yönetimi</a>
                <?php } ?>
                <?php     if ($admin->checkUserStatus($_SESSION['uye_id'])==2 || $admin->checkUserStatus($_SESSION['uye_id'])==5) { ?>
                <a href="assigmentManagement.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == "taskManagement.php")?"nav-active":""; ?>"><i class="fa fa-random" aria-hidden="true"></i>  Görev Yönetimi</a>
                <?php } ?>
                <?php     if ($admin->checkUserStatus($_SESSION['uye_id'])==2 || $admin->checkUserStatus($_SESSION['uye_id'])==4) { ?>
                <a href="itemManagement.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == "videoNews.php")?"nav-active":""; ?>"><i class="fa fa-database" aria-hidden="true"></i>  Malzeme Yönetimi</a>
                <?php } ?>
<?php     if ($admin->checkUserStatus($_SESSION['uye_id'])==2) {
?>
                <div id="main-menu" class="list-group">
                <a href="#sub-menu" data-toggle="collapse" data-parent="#main-menu" data-target="#sub-menu" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == "categories.php")?"nav-active":""; ?>"><i class="fas fa-cog"></i>&nbsp;&nbsp;Tür Yönetimi<i class="fas fa-angle-down"></i></a>
    <div class="collapse list-group-level1" id="sub-menu">
        <a href="categories.php?tur=gorevturu" class="list-group-item" data-parent="#sub-menu">Görev Türleri</a>
        <a href="categories.php?tur=malzemetur" class="list-group-item" data-parent="#sub-menu">Malzeme Türleri</a>
        <a href="categories.php?tur=olayturu" class="list-group-item" data-parent="#sub-menu">Olay Türleri</a>
        <!--<a href="#sub-sub-menu" class="list-group-item" data-toggle="collapse" data-parent="#sub-menu" data-target="#sub-sub-menu">Statik Sayfalar <i class="fas fa-angle-down"></i></a>
        <div class="collapse list-group-level2" id="sub-sub-menu">
            <a href="staticPages.php?type=kunye" class="list-group-item" data-parent="#sub-sub-menu">Künye</a>
            <a href="staticPages.php?type=gizlilik" class="list-group-item" data-parent="#sub-sub-menu">Gizlilik Politikası</a>
            <a href="staticPages.php?type=cerez" class="list-group-item" data-parent="#sub-sub-menu">Çerez Politikası</a>
            <a href="staticPages.php?type=sartname" class="list-group-item" data-parent="#sub-sub-menu">Kullanım Şartnamesi</a>
            <a href="staticPages.php?type=veri" class="list-group-item" data-parent="#sub-sub-menu">Veri Politikası</a>
            <a href="staticPages.php?type=hakkimizda" class="list-group-item" data-parent="#sub-sub-menu">Hakkımızda</a>
        </div>-->
    </div>  </div>
    <a href="users.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == "users.php")?"nav-active":""; ?>"><i class="fas fa-user-friends"></i>&nbsp;&nbsp;Kullanıcılar</a>

<?php } ?>

            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-lg-12 bg-primary pt-2 justify-content-between d-flex">
                    <a href="#" class="text-white" id="open-nav"><h3><i class="fas fa-bars"></i></h3></a>
                    <h4 class="text-light"><?= $title; ?></h4>
                    <a href="logout.php" class="text-light mt-1"><i class="fas fa-sign-out-alt"></i>&nbsp;Çıkış</a>
                </div>
            </div>
