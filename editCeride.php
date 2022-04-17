<?php
ob_start();
$title = 'Ceride Düzenleme Paneli';
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
                <h4 class="header-title">Ceride Düzenle</h4>
                <form method="POST" action="process.php?action=editCeride&olay_id=<?php echo $getTask["olay_id"]; ?>&haber_id=<?php echo $getTask["takip_id"]; ?>" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Yapılan İşlem*</b></label>
                        <input class="form-control" required="" name="haber_baslik" value="<?php echo strip_tags($getTask["takip_islem"]); ?>" type="text" id="example-text-input">
                    </div>
                    <input type="hidden" name="uye_id" value="<?php echo $_SESSION['uye_id'] ?>">
                    <button type="submit" name="uyeekle" id="addUserBtn" class="btn btn-primary btn-lg btn-block">Haberi Düzenle</button>
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
