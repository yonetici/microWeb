<?php
$title = 'Malzeme Teslim Paneli';
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
                <h4 class="header-title">Teslim kaydı oluştur</h4>
                <form method="POST" action="process.php?action=addItem" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                    <label class="col-form-label"><b>Malzeme Türü*</b></label>
                    <select name="kategori_id" required="" class="form-control">
                        <?php
                        $catList = $admin->getItemCat();
                        foreach ($catList as $cat) {
                            ?>
                            <option value="<?php echo $cat['tur_id']; ?>"><?php echo $cat['tur_isim']; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><b>Teslim Alan Personel</b></label>
                        <select name="personel" required="" class="form-control">
                            <?php
                            $catList = $admin->getEmployees();
                            foreach ($catList as $cat) {
                                ?>
                                <option value="<?php echo $cat['personel_id']; ?>"><?php echo $cat['personel_isim']; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="col-form-label"><b>Teslim Tarihi</b></label><br />
                        <input name="gorev_bitir" id="datepicker">
                    </div>
                    <input type="hidden" name="uye_id" value="<?php echo $_SESSION['uye_id'] ?>">
                    <input type="hidden" name="haber_durum" value="1">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="./inc/bootstrap-datepicker.tr.js"></script>
<script type="text/javascript">
    $('#datepicker').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        showWeekDays: true,
        language: 'tr'
    });
    //$('#datepicker').datepicker("setDate", new Date());
    $('#datepicker').datepicker('setDate', new Date());
</script>
</body>

</html>
