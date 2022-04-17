<?php
$title = 'Ayarlar Paneli';
include_once 'mainClass.php';
include_once 'header.php';
    if ($admin->checkUserStatus($_SESSION['uye_id'])!=2) {

            Header("Location:dashboard.php?editNews=Izinsiz-Erisim");
            exit();

    }
$getUser = $admin->siteDetails();

?>

<div class="row">

    <!-- Textual inputs start -->
    <div class="col-12 mt-5">
	<?php
        if(isset($_GET["editSettings"]) && $_GET["editSettings"]==1) {
            ?>
        <div class="bg-danger d-flex justify-content-center card my-2">
            <p class="text-center lead align-self-center text-white m-2">Ayarlar başarıyla düzenlendi.</p>
        </div>
        <?php
        }
		?>
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Site Bilgileri</h4>
                <form method="POST" action="process.php?action=editSettings" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Site Adı*</b></label>
                        <input class="form-control" required="" name="ayar_siteadi" value="<?php echo $getUser["ayar_siteadi"]; ?>" type="text" id="example-text-input">
                    </div>
					
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"><b>Site Hakkında*</b></label>
                        <textarea class="form-control" required="" name="ayar_hakkimizda" id="exampleFormControlTextarea1" rows="15"><?php echo $getUser["ayar_hakkimizda"]; ?></textarea>
                    </div>
					
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Adres*</b></label>
                        <input class="form-control" required="" name="ayar_adres" value="<?php echo $getUser["ayar_adres"]; ?>" type="text" id="example-text-input">
                    </div>

                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Mail*</b></label>
                        <input class="form-control" required="" name="ayar_mail" type="email"  value="<?php echo $getUser["ayar_mail"]; ?>" id="example-text-input">
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Telefon*</b></label>
                        <input class="form-control" required="" name="ayar_telefon" type="text"  value="<?php echo $getUser["ayar_telefon"]; ?>" id="example-text-input">
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Facebook*</b></label>
                        <input class="form-control" required="" name="ayar_facebook" type="text"  value="<?php echo $getUser["ayar_facebook"]; ?>" id="example-text-input">
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Twitter*</b></label>
                        <input class="form-control" required="" name="ayar_twitter" type="text"  value="<?php echo $getUser["ayar_twitter"]; ?>" id="example-text-input">
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Youtube*</b></label>
                        <input class="form-control" required="" name="ayar_youtube" type="text"  value="<?php echo $getUser["ayar_youtube"]; ?>" id="example-text-input">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"><b>Bilgilendirme Metni*</b></label>
                        <textarea class="form-control" required="" name="ayar_bilgilendirme" id="exampleFormControlTextarea1" rows="15"><?php echo $getUser["ayar_bilgilendirme"]; ?></textarea>
                    </div>
					
                    <br>
                    <button type="submit" name="editSettings" id="addUserBtn" class="btn btn-primary btn-lg btn-block">Düzenle</button>
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
