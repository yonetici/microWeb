<?php
$title = 'Görevlendirme Ekleme Paneli';
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
                <h4 class="header-title">Görevlendirme Oluştur</h4>
                <form method="POST" action="process.php?action=addAssignment" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"><b>Görev Yeri*</b></label>
                        <select name="gorev_yeri" required="" class="form-control">
                        <option value="Adana">Adana</option>
                        <option value="Adıyaman">Adıyaman</option>
                        <option value="Afyonkarahisar">Afyonkarahisar</option>
                        <option value="Ağrı">Ağrı</option>
                        <option value="Amasya">Amasya</option>
                        <option value="Ankara">Ankara</option>
                        <option value="Antalya">Antalya</option>
                        <option value="Artvin">Artvin</option>
                        <option value="Aydın">Aydın</option>
                        <option value="Balıkesir">Balıkesir</option>
                        <option value="Bilecik">Bilecik</option>
                        <option value="Bingöl">Bingöl</option>
                        <option value="Bitlis">Bitlis</option>
                        <option value="Bolu">Bolu</option>
                        <option value="Burdur">Burdur</option>
                        <option value="Bursa">Bursa</option>
                        <option value="Çanakkale">Çanakkale</option>
                        <option value="Çankırı">Çankırı</option>
                        <option value="Çorum">Çorum</option>
                        <option value="Denizli">Denizli</option>
                        <option value="Diyarbakır">Diyarbakır</option>
                        <option value="Edirne">Edirne</option>
                        <option value="Elazığ">Elazığ</option>
                        <option value="Erzincan">Erzincan</option>
                        <option value="Erzurum">Erzurum</option>
                        <option value="Eskişehir">Eskişehir</option>
                        <option value="Gaziantep">Gaziantep</option>
                        <option value="Giresun">Giresun</option>
                        <option value="Gümüşhane">Gümüşhane</option>
                        <option value="Hakkâri">Hakkâri</option>
                        <option value="Hatay">Hatay</option>
                        <option value="Isparta">Isparta</option>
                        <option value="Mersin">Mersin</option>
                        <option value="İstanbul">İstanbul</option>
                        <option value="İzmir">İzmir</option>
                        <option value="Kars">Kars</option>
                        <option value="Kastamonu">Kastamonu</option>
                        <option value="Kayseri">Kayseri</option>
                        <option value="Kırklareli">Kırklareli</option>
                        <option value="Kırşehir">Kırşehir</option>
                        <option value="Kocaeli">Kocaeli</option>
                        <option value="Konya">Konya</option>
                        <option value="Kütahya">Kütahya</option>
                        <option value="Malatya">Malatya</option>
                        <option value="Manisa">Manisa</option>
                        <option value="Kahramanmaraş">Kahramanmaraş</option>
                        <option value="Mardin">Mardin</option>
                        <option value="Muğla">Muğla</option>
                        <option value="Muş">Muş</option>
                        <option value="Nevşehir">Nevşehir</option>
                        <option value="Niğde">Niğde</option>
                        <option value="Ordu">Ordu</option>
                        <option value="Rize">Rize</option>
                        <option value="Sakarya">Sakarya</option>
                        <option value="Samsun">Samsun</option>
                        <option value="Siirt">Siirt</option>
                        <option value="Sinop">Sinop</option>
                        <option value="Sivas">Sivas</option>
                        <option value="Tekirdağ">Tekirdağ</option>
                        <option value="Tokat">Tokat</option>
                        <option value="Trabzon">Trabzon</option>
                        <option value="Tunceli">Tunceli</option>
                        <option value="Şanlıurfa">Şanlıurfa</option>
                        <option value="Uşak">Uşak</option>
                        <option value="Van">Van</option>
                        <option value="Yozgat">Yozgat</option>
                        <option value="Zonguldak">Zonguldak</option>
                        <option value="Aksaray">Aksaray</option>
                        <option value="Bayburt">Bayburt</option>
                        <option value="Karaman">Karaman</option>
                        <option value="Kırıkkale">Kırıkkale</option>
                        <option value="Batman">Batman</option>
                        <option value="Şırnak">Şırnak</option>
                        <option value="Bartın">Bartın</option>
                        <option value="Ardahan">Ardahan</option>
                        <option value="Iğdır">Iğdır</option>
                        <option value="Yalova">Yalova</option>
                        <option value="Karabük">Karabük</option>
                        <option value="Kilis">Kilis</option>
                        <option value="Osmaniye">Osmaniye</option>
                        <option value="Düzce">Düzce</option>
                        <option value="Yurtdışı">Yurtdışı</option>
                        </select>
                    </div>
                    <label class="col-form-label"><b>Görev Türü*</b></label>
                    <select name="kategori_id" required="" class="form-control">
                        <?php
                        $catList = $admin->getAssignCat();
                        foreach ($catList as $cat) {
                            ?>
                            <option value="<?php echo $cat['gorev_turu_id']; ?>"><?php echo $cat['gorev_turu_isim']; ?></option>
                        <?php } ?>
                    </select>
                    <br>
                    <label class="col-form-label"><b>Görevlendirilen Personel*</b></label>
                    <select name="personel" required="" class="form-control">
                        <?php
                        $catList = $admin->getEmployees();
                        foreach ($catList as $cat) {
                            ?>
                            <option value="<?php echo $cat['personel_id']; ?>"><?php echo $cat['personel_isim']; ?></option>
                        <?php } ?>

                    </select>
                    <br>
                    <div class="form-group">
                        <label class="col-form-label"><b>Görevlendirme Başlangıcı</b></label><br />
                        <input name="gorev_basla" id="datepicker">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><b>Görevlendirme Bitişi</b></label><br />
                        <input name="gorev_bitir" id="datepicker2">
                    </div>
                    <input type="hidden" name="uye_id" value="<?php echo $_SESSION['uye_id'] ?>">
                    <input type="hidden" name="haber_durum" value="1">
                    <button type="submit" name="uyeekle" id="addUserBtn" class="btn btn-primary btn-lg btn-block">Görevlendirme Ekle</button>
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
    $('#datepicker2').datepicker('setDate', new Date()+1);
    // End of datepicker two
</script>
</body>

</html>
