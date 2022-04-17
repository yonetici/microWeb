<?php
$title = 'Kullanıcı Düzenleme Paneli';
include_once 'mainClass.php';
include_once 'header.php';

if (isset($_GET["userId"])) {
    $userId = intval($_GET["userId"]);
} else {
    Header("Location:users.php?editUser=error");
}
if ($admin->checkUserStatus($_SESSION['uye_id'])!=2) {

        Header("Location:dashboard.php?editNews=Izinsiz-Erisim");
        exit();

}

if ($admin->fetchUserDetailsByID($userId)) {
    $getUser = $admin->fetchUserDetailsByID($userId);
} else {
    Header("Location:users.php?editUser=error");
}
?>

<div class="row">

    <!-- Textual inputs start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Kullanıcı Bilgileri</h4>
                <form method="POST" action="process.php?action=editUser&user_id=<?php echo $getUser["kullanici_id"]; ?>" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Ad Soyad*</b></label>
                        <input class="form-control" required="" name="uye_ad" value="<?php echo $getUser["kullanici_ad"]; ?>" type="text" id="example-text-input">
                    </div>

                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Mail*</b></label>
                        <input class="form-control" required="" name="uye_mail" type="email"  value="<?php echo $getUser["kullanici_mail"]; ?>" id="example-text-input">
                    </div>
                    <label class="col-form-label"><b>Rol/Durum*</b></label>
                    <select name="uye_durum" required="" class="form-control">
                        <option value="3" <?php echo ($getUser['kullanici_yetki'] == '3' ? ' selected' : ''); ?>>AADYM Birim Yöneticisi</option>
                        <option value="4" <?php echo ($getUser['kullanici_yetki'] == '4' ? ' selected' : ''); ?>>Sosyal İşler ve İaşe Birim Yöneticisi</option>
                        <option value="5" <?php echo ($getUser['kullanici_yetki'] == '5' ? ' selected' : ''); ?>>Arama Kurtarma Birim Yöneticisi</option>
                    </select>
                    <br>
                    <button type="submit" name="editUser" id="addUserBtn" class="btn btn-primary btn-lg btn-block">Düzenle</button>
                </form>
            </div>




        </div>
    </div>
</div>

<!-- footer end -->

</div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" defer></script>

</body>

</html>
