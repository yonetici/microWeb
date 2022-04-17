<?php
session_start();
include_once 'mainClass.php';
$title='Geçiş Ekranı';
if(isset($_GET['action']) && $_GET['action'] == 'newUser'){
    $uye_ad = $admin->test_input($_POST['uye_ad']);
    $uye_mail = $admin->test_input($_POST['uye_mail']);
    $uye_parola = $admin->test_input($_POST['uye_parola']);
    $uye_durum = 0;
    $uye_cinsiyet = $admin->test_input($_POST['uye_cinsiyet']);
    $hpassword = sha1($uye_parola);

    $userAdded = $admin->addNewUser($uye_ad,$uye_mail,$hpassword,$uye_durum,$uye_cinsiyet);
    if($userAdded != null){
        echo 'news_added';
        print_r($admin->addNewUser($uye_ad,$uye_mail,$hpassword,$uye_durum,$uye_cinsiyet));
//        Header("Location:index.php?register=ok");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        Header("Location:index.php?register=no");
    }

}

//MicroWeb Handle add Assginment request
if(isset($_GET['action']) && $_GET['action'] == 'addAssignment'){
    $gorev_yeri   = $_POST['gorev_yeri'];
    $gorev_basla   = $_POST['gorev_basla'];
    $gorev_bitir   = $_POST['gorev_bitir'];
    $kategori_id    = $admin->test_input($_POST['kategori_id']);
    $ekip    = $admin->test_input($_POST['personel']);
    $old_date = strtotime($gorev_basla);
    $gorev_basla = date('Y-m-d H:i:s', $old_date);
    $old_date = strtotime($gorev_bitir);
    $gorev_bitir = date('Y-m-d H:i:s', $old_date);

    $newsAdded = $admin->addAssignment($gorev_yeri,$kategori_id,$ekip,$gorev_basla,$gorev_bitir);
    if($newsAdded != null){
        echo 'news_added';
        Header("Location:assigmentManagement.php?addNewUser=1");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        Header("Location:assigmentManagement.php?addNewUser=0");
    }
}
//MicroWeb Handle add Assginment request
if(isset($_GET['action']) && $_GET['action'] == 'addItem'){
    $personel  = $_POST['personel'];
    $kategori_id = $_POST['kategori_id'];
    $gorev_bitir = $_POST['gorev_bitir'];
    $old_date = strtotime($gorev_bitir);
    $gorev_bitir = date('Y-m-d H:i:s', $old_date);

    $newsAdded = $admin->addItem($personel,$kategori_id,$gorev_bitir);
    if($newsAdded != null){
        echo 'news_added';
        Header("Location:itemManagement.php?addNewUser=1");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        Header("Location:itemManagement.php?addNewUser=0");
    }
}

//MicroWeb Handle add Assginment request
if(isset($_GET['action']) && $_GET['action'] == 'editAssignment'){
    $gorev_yeri   = $_POST['gorev_yeri'];
    $gorev_basla   = $_POST['gorev_basla'];
    $gorev_bitir   = $_POST['gorev_bitir'];
    $kategori_id    = $admin->test_input($_POST['kategori_id']);
    $ekip    = $admin->test_input($_POST['personel']);
    $old_date = strtotime($gorev_basla);
    $gorev_basla = date('Y-m-d H:i:s', $old_date);
    $old_date = strtotime($gorev_bitir);
    $gorev_bitir = date('Y-m-d H:i:s', $old_date);

    $newsAdded = $admin->editAssignment($gorev_yeri,$kategori_id,$ekip,$gorev_basla,$gorev_bitir,$_GET['haber_id']);
    if($newsAdded != null){
        echo 'news_added';
        Header("Location:assigmentManagement.php?addNewUser=1");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        Header("Location:assigmentManagement.php?addNewUser=0");
    }
}

//MicroWeb Handle edit Item request
if(isset($_GET['action']) && $_GET['action'] == 'editItem'){
    $personel  = $_POST['personel'];
    $kategori_id = $_POST['kategori_id'];
    $gorev_bitir = $_POST['gorev_bitir'];
    $old_date = strtotime($gorev_bitir);
    $gorev_bitir = date('Y-m-d H:i:s', $old_date);


    $newsAdded = $admin->editItem($personel,$kategori_id,$gorev_bitir,$_GET['haber_id']);
    if($newsAdded != null){
        echo 'news_added';
        Header("Location:itemManagement.php?addNewUser=1");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        Header("Location:itemManagement.php?addNewUser=0");
    }
}
//MicroWeb Handle add task request
if(isset($_GET['action']) && $_GET['action'] == 'addTask'){
    $haber_baslik   = $admin->test_input($_POST['haber_baslik']);
    $haber_icerik   = $_POST['haber_icerik'];
    $kategori_id    = $admin->test_input($_POST['kategori_id']);
    $ekip    = $admin->test_input($_POST['ekip']);
    $newsAdded = $admin->addTask($haber_baslik,$haber_icerik,$kategori_id,$ekip);
    if($newsAdded != null){
        echo 'news_added';
        Header("Location:taskManagement.php?addNewUser=1");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        Header("Location:taskManagement.php?addNewUser=0");
    }
}

//MicroWeb Handle add task request
if(isset($_GET['action']) && $_GET['action'] == 'addCeride'){
    $haber_icerik   = $_POST['haber_icerik'];
    $taskId = $_GET['taskId'];
    $newsAdded = $admin->addCeride($haber_icerik,$taskId);
    if($newsAdded != null){
        echo 'news_added';
        Header("Location:cerideManagement.php?taskId=".$taskId);
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        Header("Location:taskManagement.php?addNewUser=0");
    }
}

// MicroWeb Handle edit Ceride request
if($_GET['action'] == 'editCeride' && $_GET['haber_id']){
    $haber_baslik   = $admin->test_input($_POST['haber_baslik']);
    $newsAdded = $admin->editCeride($_GET['haber_id'],$haber_baslik);

    if($newsAdded != null){
        echo 'news_added';
        Header("Location:cerideManagement.php?taskId=".$_GET['olay_id']);
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        Header("Location:cerideManagement.php?editNews=hubele");
    }
}

// MicroWeb Handle edit task request
if($_GET['action'] == 'editNews' && $_GET['haber_id']){
    $haber_baslik   = $admin->test_input($_POST['haber_baslik']);
    $haber_icerik   = $_POST['haber_icerik'];
    $kategori_id    = $admin->test_input($_POST['kategori_id']);
    $ekip    = $admin->test_input($_POST['ekip']);
    $olay_bitis = ($_POST['olay_bitir'] == 1) ? date("Y-m-d H:i:s") : $_POST['olay_bitis'];

    $newsAdded = $admin->editTask($_GET['haber_id'],$haber_baslik,$haber_icerik,$kategori_id,$olay_bitis);

    if($newsAdded != null){
        echo 'news_added';
        Header("Location:taskManagement.php?editNews=1");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        Header("Location:taskManagement.php?editNews=hubele");
    }
}

//MicroWeb Handle edit Cat request
if($_GET['action'] == 'editCat' && ($_GET['cat_id'])){
    $cat_id         = intval($_GET['cat_id']);
    $tur         = $_GET['tur'];
    $kategori_ad    = $admin->test_input($_POST['kategori_ad']);

    if($admin->editCatDetails($cat_id,$kategori_ad,$tur) != null){
        echo 'category_edited';
        Header("Location:categories.php?editCat=1&tur=".$tur."");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        //Header("Location:users.php?editUser=0");
    }
}


//Handle edit user request
if($_GET['action'] == 'editUser' && ($_GET['user_id'])){
    $uye_id         = intval($_GET['user_id']);
    $uye_mail       = $admin->test_input($_POST['uye_mail']);
    $uye_ad         = $admin->test_input($_POST['uye_ad']);
    $uye_durum      = $admin->test_input($_POST['uye_durum']);

    if($admin->editUserDetails($uye_id,$uye_mail,$uye_ad, $uye_durum) != null){
        echo 'user_edited';
        Header("Location:users.php?editUser=1");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        //Header("Location:users.php?editUser=0");
    }
}

//Handle edit profile request
if($_GET['action'] == 'editProfile' && ($_GET['user_id'])){
    $uye_id         = intval($_GET['user_id']);
    $uye_mail       = $admin->test_input($_POST['uye_mail']);
    $uye_ad         = $admin->test_input($_POST['uye_ad']);
    $uye_cinsiyet   = $admin->test_input($_POST['uye_cinsiyet']);

    if($admin->editUserDetails($uye_id,$uye_mail,$uye_ad, $uye_cinsiyet)){
        echo 'user_edited';
        Header("Location:profile.php?editProfile=1");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        //Header("Location:users.php?editUser=0");
    }
}

//Handle edit site settings request
if($_GET['action'] == 'editSettings'){
    $ayar_siteadi		= $admin->test_input($_POST['ayar_siteadi']);
    $ayar_hakkimizda    = $admin->test_input($_POST['ayar_hakkimizda']);
    $ayar_adres       	= $admin->test_input($_POST['ayar_adres']);
    $ayar_mail       	= $admin->test_input($_POST['ayar_mail']);
    $ayar_telefon       = $admin->test_input($_POST['ayar_telefon']);
    $ayar_facebook      = $admin->test_input($_POST['ayar_facebook']);
    $ayar_twitter       = $admin->test_input($_POST['ayar_twitter']);
    $ayar_youtube       = $admin->test_input($_POST['ayar_youtube']);
    $ayar_bilgilendirme = $admin->test_input($_POST['ayar_bilgilendirme']);


    if($admin->editSiteDetails($ayar_siteadi, $ayar_hakkimizda, $ayar_adres, $ayar_mail, $ayar_telefon, $ayar_facebook, $ayar_twitter, $ayar_youtube, $ayar_bilgilendirme)){
        echo 'user_edited';
        Header("Location:settings.php?editSettings=1");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        //Header("Location:users.php?editUser=0");
    }
}


//Handle edit user request
if($_GET['action'] == 'editCat' && ($_GET['cat_id'])){
    $cat_id         = intval($_GET['cat_id']);
    $kategori_ad    = $admin->test_input($_POST['kategori_ad']);
    $kategori_detay = $admin->test_input($_POST['kategori_detay']);

    if($admin->editCatDetails($cat_id,$kategori_ad,$kategori_detay) != null){
        echo 'category_edited';
        Header("Location:categories.php?editCat=1");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        //Header("Location:users.php?editUser=0");
    }
}

//Handle edit static page request
if(isset($_GET['type']) && $_GET['action'] == 'editStaticPages'){
    $staticBaslik = $_POST['ayar_siteadi'];
    $staticIcerik = $_POST['haber_icerik'];
    $userAdded = $admin->editStaticPages($_GET['type'],$staticBaslik,$staticIcerik);
    if($userAdded != null){
        Header("Location:staticPages.php?editSettings=1&type=".$_GET['type']);
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'addNewMessage'){
    $mesaj_isim = $admin->test_input($_POST['mesaj_isim']);
    $mesaj_mail = $admin->test_input($_POST['mesaj_mail']);
    $mesaj_icerik = $admin->test_input($_POST['mesaj_icerik']);
    $userAdded = $admin->addNewMessage($mesaj_isim,$mesaj_mail,$mesaj_icerik);

    if($userAdded != null){
        echo 'user_added';
        Header("Location:../iletisim.php?addNewMessage=1");
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'lostPassword'){

    $uye_mail   = $admin->test_input($_POST['uye_mail']);
    $checkUser  = $admin->checkUniqueUsername($uye_mail);
    if ($checkUser > 0) {
        $createToken = sha1(md5(uniqid()));
        $userAdded = $admin->sendConfirmationCode($uye_mail,$createToken);
        if($userAdded != null){

            $postaGonder = new PHPMailer();
            $postaGonder->IsSMTP();
            $postaGonder->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//$postaGonder->SMTPDebug = 1;
            $postaGonder->SMTPAuth = true;
            $postaGonder->SMTPSecure = 'tls';
            $postaGonder->Host = 'smtp.yandex.com';
            $postaGonder->Port = 587;
            $postaGonder->IsHTML(true);
            $postaGonder->CharSet ="utf-8";
            $postaGonder->Username = "kumandan@yandex.com";
            $postaGonder->Password = "Deneme12!";
            $postaGonder->SetFrom("kumandan@yandex.com", "Haber Merkezi");
            // Mail attigimizda yazacak isim
            $postaGonder->AddAddress($uye_mail);
            // Maili gonderecegimiz kisi/ alici
            $postaGonder->Subject = "Şifre Oluşturma";
            // Konu basligi
            $content = '<div style="background: #eee; padding: 10px; font-size: 14px">Yeni Şifrenizi almak için lütfen <a href="http://www.afetegitimyili.com/habermerkezi/yonetim/getPassword.php?email='.$uye_mail.'&code='.$createToken.'">tıklayın.</a><br><br>Link aktif değilse şu linki kullanabilirsiniz:<br>http://www.afetegitimyili.com/habermerkezi/yonetim/getPassword.php?email='.$uye_mail.'&code='.$createToken.'</div>';
            $postaGonder->MsgHTML($content);
            if (!$postaGonder->send()) {
                echo 'Mailer Error: ' . $postaGonder->ErrorInfo;
            } else {
                echo 'Message sent!';
            }
            echo 'admin_login';
            Header("Location:forgotPassword.php?confirmation=1");
        }
        else{
            echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
        }
    }
}