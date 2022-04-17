<?php
$title = 'Haber Ekleme Paneli';
include_once 'mainClass.php';
include_once 'header.php';
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
                <h4 class="header-title">Yeni Haber Ekle</h4>
                <form enctype="multipart/form-data" method="POST" action="process.php?action=addNews" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Haber Başlığı*</b></label>
                        <input class="form-control" required="" name="haber_baslik" type="text" id="example-text-input">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"><b>Haber İçeriği*</b></label>
                        <textarea class="form-control" name="haber_icerik" id="mytextarea" rows="15"></textarea>
                    </div>

                    <label class="col-form-label"><b>Haber Görseli*</b></label>
                    <div class="input-group mb-3">

                        <div class="custom-file">
                            <input type="file" name="haber_gorsel" required="" class="custom-file-input" id="inputGroupFile01">
                            <label class="custom-file-label"  for="inputGroupFile01">Dosya seçin</label>
                        </div>
                    </div>

                    <label class="col-form-label"><b>Kategori*</b></label>
                    <select name="kategori_id" required="" class="form-control">
                        <?php
                        $catList = $admin->getCategories();
                        foreach ($catList as $cat) {
                        ?>
                        <option value="<?php echo $cat['kategori_id']; ?>"><?php echo $cat['kategori_ad']; ?></option>
                        <?php } ?>
                    </select>
                    <label class="col-form-label"><b>Manşet Seçimi</b></label>
                    <select name="haber_manset" required="" class="form-control">
                        <!--<option value="0">Banlı</option>-->
                        <option value="1">Evet</option>
                        <option value="0">Hayır</option>
                    </select>
                    <br>
                    <input type="hidden" name="uye_id" value="<?php echo $_SESSION['uye_id'] ?>">
                    <input type="hidden" name="haber_durum" value="1">
                    <button type="submit" name="uyeekle" id="addUserBtn" class="btn btn-primary btn-lg btn-block">Haberi Ekle</button>
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
