<?php
$title = 'Kullanıcı Düzenleme Paneli';
include_once 'mainClass.php';
include_once 'header.php';
$userId = intval($_SESSION["uye_id"]);
if ($admin->fetchUserDetailsByID($userId)) {
    $getUser = $admin->fetchUserDetailsByID($userId);
} else {
    Header("Location:users.php?editUser=error");
}
?>

<div class="row">

    <!-- Textual inputs start -->
    <div class="col-12 mt-5">
        <?php
        if(isset($_GET["editProfile"]) && $_GET["editProfile"]==1) {
            ?>
        <div class="bg-danger d-flex justify-content-center card my-2">
            <p class="text-center lead align-self-center text-white m-2">Profiliniz başarıyla düzenlendi.</p>
        </div>
        <?php
        }
        ?>
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Kullanıcı Bilgileri</h4>
                <form method="POST" action="process.php?action=editProfile&user_id=<?php echo $getUser["uye_id"]; ?>" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Ad Soyad*</b></label>
                        <input class="form-control" required="" name="uye_ad" value="<?php echo $getUser["uye_ad"]; ?>" type="text" id="example-text-input">
                    </div>

                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Mail*</b></label>
                        <input class="form-control" required="" name="uye_mail" type="email"  value="<?php echo $getUser["uye_mail"]; ?>" id="example-text-input">
                    </div>
                    <label class="col-form-label"><b>Rol/Durum*</b></label>
                    <input class="form-control" type="text"  value="<?php echo ($getUser['uye_durum'] == 0) ? "Yasaklı / Onaylanmamış" : (($getUser['uye_durum'] == 2)  ? "Yönetici" : "Yazar") ?>" id="example-text-input" readonly>
                    <label class="col-form-label"><b>Cinsiyet*</b></label>
                    <select name="uye_cinsiyet" required="" class="form-control">
                        <!--<option value="0">Banlı</option>-->
                        <option value="1" <?php echo ($getUser['uye_cinsiyet'] == '1' ? ' selected' : ''); ?>>Erkek</option>
                        <option value="0" <?php echo ($getUser['uye_cinsiyet'] == '0' ? ' selected' : ''); ?>>Kadın</option>
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
<script type="text/javascript">
    $(document).ready(function(){

        checkNotification();

        function checkNotification(){
            $.ajax({
                url: 'actions.php',
                method: 'post',
                data: {action: 'notificationCheck'},
                success: function(response){
                    $("#showNotificationCheck").html(response);
                }
            });
        }




    });
</script>
</body>

</html>
