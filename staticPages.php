<?php
$title = 'Statik Sayfa Paneli';
include_once 'mainClass.php';
include_once 'header.php';
    if ($admin->checkUserStatus($_SESSION['uye_id'])!=2 || !isset($_GET['type'])) {

            Header("Location:dashboard.php?editNews=Izinsiz-Erisim");
            exit();

    }
if ($admin->staticDetails($_GET['type'])) {
    $getUser = $admin->staticDetails($_GET['type']);
} else {
    Header("Location:dashboard.php?editNews=Izinsiz-Erisim");
    exit();
}

?>
<script src="https://cdn.tiny.cloud/1/0xx094qr55d3xassqws8lkxlr6tnvlmby3al6dvbkyc4clyt/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#mytextarea',
        language_url: '../js/tr.js',
        language: 'tr_TR',
    });

</script>
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
    switch ($_GET['type']) {
        case "kunye":
            $baslik = "Künye";
            break;
        case "gizlilik":
            $baslik = "Gizlilik Politikası";
            break;
        case "cerez":
            $baslik = "Çerez Politikası";
            break;
        case "sartname":
            $baslik = "Kullanım Şartnamesi";
            break;
        case "veri":
            $baslik = "Veri Politikası";
            break;
        default:
            $baslik = "Hakkımızda";
    }
        //if(isset($_GET['type']) && $_GET['action'] == 'editStaticPages'){
		?>
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"><?php echo $baslik; ?> Sayfası Bilgileri</h4>
                <form method="POST" action="process.php?type=<?php echo $_GET['type']; ?>&action=editStaticPages" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Başlık</b></label>
                        <input class="form-control" required="" name="ayar_siteadi" value="<?php echo $getUser["sayfa_baslik"]; ?>" type="text" id="example-text-input">
                    </div>
					
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"><b>İçerik</b></label>
                        <textarea class="form-control" name="haber_icerik" id="mytextarea" rows="15"><?php echo $getUser["sayfa_icerik"]; ?></textarea>
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
