<?php
ob_start();
$title = 'Malzeme Düzenleme Paneli';
include_once 'mainClass.php';
include_once 'header.php';
if (isset($_GET["taskId"])) {
    $taskId = intval($_GET["taskId"]);
    $getTask = $admin->fetchItem($taskId);
    /** Kullanıcı Kontrolu */
    if ($admin->checkUserStatus($_SESSION['uye_id'])!=2 && $admin->checkUserStatus($_SESSION['uye_id'])!=4) {

            Header("Location:itemManagement.php?editNews=Izinsiz-Erisim");
            exit();
    }

    /** Kullanıcı Kontrolu */


    } else {
    Header("Location:itemManagement.php?editNews=error");
    exit();
}



?>
<script src="https://cdn.tiny.cloud/1/0xx094qr55d3xassqws8lkxlr6tnvlmby3al6dvbkyc4clyt/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
        selector: '#mytextarea',
        plugins: 'autolink lists media table link code',
        //menubar: "insert",
        toolbar: 'addcomment link showcomments casechange code checklist code export formatpainter pageembed permanentpen table',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        language_url: '../js/tr.js',
        language: 'tr_TR',
    });
</script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<div class="row">

    <!-- Textual inputs start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Malzeme Teslim Düzenle</h4>
                <form method="POST" action="process.php?action=editItem&haber_id=<?php echo $getTask["takip_id"]; ?>" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <label class="col-form-label"><b>Malzeme Türü*</b></label>
                    <select name="kategori_id" required="" class="form-control">
                        <?php
                        $catList = $admin->getItemCat();
                        foreach ($catList as $cat) {
                        ?>
                        <option value="<?php echo $cat['tur_id']; ?>" <?php echo ($getTask['tur_id'] == $cat['tur_id'] ? ' selected' : ''); ?>><?php echo $cat['tur_isim']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="form-group">
                    <label class="col-form-label"><b>Teslim Alan Personel</b></label>
                        <select name="personel" required="" class="form-control">
                            <?php
                            $catList = $admin->getEmployees();
                            foreach ($catList as $cat) {
                                ?>
                                <option value="<?php echo $cat['personel_id']; ?>"<?php echo ($cat['personel_id'] == $getTask['personel_id'] ? ' selected' : ''); ?>><?php echo $cat['personel_isim']; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><b>Teslim Tarihi</b></label><br />
                        <input name="gorev_bitir" id="datepicker">
                    </div>
                    <br>
                    <input type="hidden" name="uye_id" value="<?php echo $_SESSION['uye_id'] ?>">
                    <button type="submit" name="uyeekle" id="addUserBtn" class="btn btn-primary btn-lg btn-block">Düzenle</button>
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
    <?php
    $date = new DateTime($getTask['takip_tarih']);
    $date = $date->format('m/d/Y');
    ?>
    $('#datepicker').datepicker('setDate', '<?php echo $date; ?>');
</script>

</body>

</html>
