<?php
$title = 'Ceride Kaydı Ekleme Paneli';
include_once 'mainClass.php';
include_once 'header.php';
if (isset($_GET["taskId"])) {
    $taskId = intval($_GET["taskId"]);
    $getTask = $admin->fetchCeride($taskId);
    /** Kullanıcı Kontrolu */
    if ($admin->checkUserStatus($_SESSION['uye_id'])!=2 && $admin->checkUserStatus($_SESSION['uye_id'])!=3) {
        Header("Location:cerideManagement.php?editNews=Izinsiz-Erisim");
        exit();

    }

    /** Kullanıcı Kontrolu */


} else {
    Header("Location:cerideManagement.php?editNews=error");
    exit();
}
?>
<script src="https://cdn.tiny.cloud/1/0xx094qr55d3xassqws8lkxlr6tnvlmby3al6dvbkyc4clyt/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#mytextarea'
    });
</script>
<div class="row">

    <!-- Textual inputs start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Ceride kaydı gir</h4>
                <form method="POST" action="process.php?action=addCeride&taskId=<?php echo $taskId; ?>" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"><b>Yapılan İşlem*</b></label>
                        <textarea class="form-control" name="haber_icerik" rows="15"></textarea>
                    </div>
                    <input type="hidden" name="uye_id" value="<?php echo $_SESSION['uye_id'] ?>">
                    <button type="submit" name="uyeekle" id="addUserBtn" class="btn btn-primary btn-lg btn-block">Kayıt Ekle</button>
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
