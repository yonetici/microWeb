<?php
$title = 'Kategori Düzenleme Paneli';
include_once 'mainClass.php';
include_once 'header.php';
if (isset($_GET["catId"])) {
    $catId = intval($_GET["catId"]);
    $tur=$_GET["tur"];
} else {
    Header("Location:categories.php?editUser=error&tur=".$_GET["tur"]."");
}
if ($admin->checkUserStatus($_SESSION['uye_id'])!=2) {
    Header("Location:dashboard.php?editUser=error");
}

if ($admin->fetchCategoryDetailsByID($catId,$tur)) {
    $getUser = $admin->fetchCategoryDetailsByID($catId,$tur);
    switch ($tur) {
        case "olayturu":
            $getId=$getUser['olay_turu_id'];
            $getType = $getUser['olay_turu'];
            break;
        case "malzemetur":
            $getId=$getUser['tur_id'];
            $getType = $getUser['tur_isim'];
            break;
        case "gorevturu":
            $getId=$getUser['gorev_turu_id'];
            $getType = $getUser['gorev_turu_isim'];
            break;
        default:
            echo "TurHata";
    }
} else {
    Header("Location:categories.php?editUser=error&tur=".$_GET["tur"]."");
}
?>

<div class="row">

    <!-- Textual inputs start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Kategori Bilgileri</h4>
                <form method="POST" action="process.php?action=editCat&tur=<?php echo $tur; ?>&cat_id=<?php echo $getId; ?>" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Kategori Adı*</b></label>
                        <input class="form-control" required="" name="kategori_ad" value="<?php echo $getType; ?>" type="text" id="example-text-input">
                    </div>
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
