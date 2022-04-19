<?php
ob_start();
$title = 'Olay Düzenleme Paneli';
include_once 'mainClass.php';
include_once 'header.php';
if (isset($_GET["taskId"])) {
    $taskId = intval($_GET["taskId"]);
    $getTask = $admin->fetchTask($taskId);
    /** Kullanıcı Kontrolu */
    if ($admin->checkUserStatus($_SESSION['uye_id'])!=2 && $admin->checkUserStatus($_SESSION['uye_id'])!=3) {
        Header("Location:taskManagement.php?editNews=Izinsiz-Erisim");
        exit();

    }

    /** Kullanıcı Kontrolu */


    } else {
    Header("Location:taskManagement.php?editNews=error");
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
                <h4 class="header-title">Olay Düzenle</h4>
                <form method="POST" action="process.php?action=editNews&haber_id=<?php echo $getTask["olay_id"]; ?>" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Olay Başlığı*</b></label>
                        <input class="form-control" required="" name="haber_baslik" value="<?php echo $getTask["olay_isim"]; ?>" type="text" id="example-text-input">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"><b>İhbar Açıklaması*</b></label>
                        <textarea class="form-control" name="haber_icerik" id="mytextarea" rows="15"><?php echo $getTask["olay_detay"]; ?></textarea>
                    </div>
                    <label class="col-form-label"><b>Olay Türü*</b></label>
                    <select name="kategori_id" required="" class="form-control">
                        <?php
                        $catList = $admin->getTaskCat();
                        foreach ($catList as $cat) {
                        ?>
                        <option value="<?php echo $cat['olay_turu_id']; ?>" <?php echo ($getTask['olay_turu_id'] == $cat['olay_turu_id'] ? ' selected' : ''); ?>><?php echo $cat['olay_turu']; ?></option>
                        <?php } ?>
                    </select>
                    <div class="form-group">
                    <label class="col-form-label"><b>Olay Başlangıç</b></label>
                    <input class="form-control" value="<?php echo $getTask['olay_baslangic']; ?>" name="olay_baslangic" disabled/>
                    </div>
                    <?php
                    if ($getTask['olay_bitis'] != null) {
 ?>
                        <div class="form-group">
                            <label class="col-form-label"><b>Olay Bitimi</b></label>
                            <input class="form-control" value="<?php echo $getTask['olay_bitis']; ?>" name="olay_bitis" disabled/>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="olay_bitir" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Olayı Kapat
                            </label>
                        </div>
                        <?php
                    }
                    ?>
                    <br>
                    <label class="col-form-label"><b>Görevlendirilen Ekip*</b></label>
                    <select name="ekip" required="" class="form-control">
                        <?php
                        $index=0;
                        foreach ($ekipBilgileri as $ekip) {
                            ?>
                            <option value="<?php echo $index; ?>" <?php echo ($getTask['olay_ekip'] == $index ? ' selected' : ''); ?>><?php echo $ekip; ?></option>
                        <?php
                        $index++;
                        } ?>
                    </select>
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
    $date = new DateTime($getTask['olay_baslangic']);
    $date = $date->format('d/m/Y');
    ?>
    $('#datepicker').datepicker('setDate', '<?php echo $date; ?>');
    // End of datepicker one
    $('#datepicker2').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        showWeekDays: true,
        language: 'tr'
    });
    //$('#datepicker2').datepicker("setDate", new Date());
    <?php
    $date1 = new DateTime($getTask['olay_bitis']);
    $date1 = $date1->format('d/m/Y');

    ?>
    $('#datepicker2').datepicker('setDate', '<?php echo $date1; ?>');
    // End of datepicker two
</script>

</body>

</html>
