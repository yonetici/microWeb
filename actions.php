<?php
session_start();
require_once 'mainClass.php';
$admin = new Database();
function turkcetarih_formati($format, $datetime = 'now'){
    $z = date("$format", strtotime($datetime));
    $gun_dizi = array(
        'Monday'    => 'Pazartesi',
        'Tuesday'   => 'Salı',
        'Wednesday' => 'Çarşamba',
        'Thursday'  => 'Perşembe',
        'Friday'    => 'Cuma',
        'Saturday'  => 'Cumartesi',
        'Sunday'    => 'Pazar',
        'January'   => 'Ocak',
        'February'  => 'Şubat',
        'March'     => 'Mart',
        'April'     => 'Nisan',
        'May'       => 'Mayıs',
        'June'      => 'Haziran',
        'July'      => 'Temmuz',
        'August'    => 'Ağustos',
        'September' => 'Eylül',
        'October'   => 'Ekim',
        'November'  => 'Kasım',
        'December'  => 'Aralık',
        'Mon'       => 'Pts',
        'Tue'       => 'Sal',
        'Wed'       => 'Çar',
        'Thu'       => 'Per',
        'Fri'       => 'Cum',
        'Sat'       => 'Cts',
        'Sun'       => 'Paz',
        'Jan'       => 'Oca',
        'Feb'       => 'Şub',
        'Mar'       => 'Mar',
        'Apr'       => 'Nis',
        'Jun'       => 'Haz',
        'Jul'       => 'Tem',
        'Aug'       => 'Ağu',
        'Sep'       => 'Eyl',
        'Oct'       => 'Eki',
        'Nov'       => 'Kas',
        'Dec'       => 'Ara',
    );
    foreach($gun_dizi as $en => $tr){
        $z = str_replace($en, $tr, $z);
    }
    if(strpos($z, 'Mayıs') !== false && strpos($format, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
    return $z;
}
//Handle admin login request
if(isset($_POST['action']) && $_POST['action'] == 'adminLogin'){
    $username = $admin->test_input($_POST['username']);
    $password = $admin->test_input($_POST['password']);

    $hpassword = sha1($password);

    $loggedInAdmin = $admin->admin_login($username,$hpassword);

    if($loggedInAdmin != null){
        echo 'admin_login';
        if(isset($_POST['hatirla'])) {
            $deleteCookie = $admin->deleteCookie($loggedInAdmin['kullanici_id']);
            $createToken = sha1(md5(uniqid()));

            $addToken = $admin->addToken($loggedInAdmin['kullanici_id'],$createToken);
            setcookie('HBR', $createToken, time()+ 86400, '/');
        }
        $_SESSION['username'] = $username;
        $_SESSION['uye_id'] = $loggedInAdmin['kullanici_id'];
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
    }
}
//MicroWeb: Handle add task request
if(isset($_POST['action']) && $_POST['action'] == 'addTask'){
    $haber_baslik   = $admin->test_input($_POST['haber_baslik']);
    $haber_icerik   = $admin->test_input($_POST['haber_icerik']);
    $kategori_id    = $admin->test_input($_POST['kategori_id']);
    //$uye_id         = $admin->test_input($_POST['uye_id']);
    $newsAdded = $admin->addTask($haber_baslik,$haber_icerik,$kategori_id);

    if($newsAdded != null){
        echo 'news_added';
        print_r($_POST);
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
    }
}
//MicroWeb Handle delete a task request
if(isset($_POST['olay_id'])){
    $id = $_POST['olay_id'];

    $admin->taskAction($id);
}
//MicroWeb Handle delete a assignment request
if(isset($_POST['gorevlendirme_id'])){
    $id = $_POST['gorevlendirme_id'];

    $admin->assigmentAction($id);
}
//MicroWeb Handle delete a ceride request
if(isset($_POST['takip_id'])){
    $id = $_POST['takip_id'];

    $admin->cerideAction($id);
}

//MicroWeb Handle fetch all news request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllTasks'){
    $output = '';

    $data = $admin->fetchAllTasks();
    if($data){
        $output .= '<table class="table table-striped table-bordered text-center">
									<thead>
										<tr>
											<th>#</th>
											<th>Olay</th>
											<th>Olay Türü</th>
											<th>Başlangıç</th>
											<th>Bitiş</th>
											<th>İşlem</th>
										</tr>
									</thead>
									<tbody>';
        foreach ($data as $row) {

            $output .= '<tr>
										<td>'.$row['olay_id'].'</td>
										<td>'.$row['olay_isim'].'</td>
										<td>'.$row['olay_turu'].'</td>
										<td>'.$admin->timeAgo($row['olay_baslangic']).'</td>
										<td>'.(($row['olay_bitis'] != null) ? $admin->timeAgo($row['olay_bitis']) : "Devam Ediyor").'</td>
										<td>
											<a href="cerideManagement.php?taskId='.$row['olay_id'].'" title="Ceride Kayıtları" class="text-primary userDetailsIcon"><i class="fa fa-list-ul" aria-hidden="true"></i></a>&nbsp;&nbsp; <a href="editTask.php?taskId='.$row['olay_id'].'" title="Olay Düzenle" class="text-primary userDetailsIcon"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp; <a href="#" id="'.$row['olay_id'].'" title="Olay Sil" class="text-danger userDeleteIcon"><i class="fas fa-trash fa-lg"></i></a>
										</td>
									</tr>';
        }
        $output .= '</tbody>
								</table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">Henüz eklenmiş bir olay kaydı yok!</h3>';
    }
}
//MicroWeb Handle fetch all news request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllAssignments'){
    $output = '';

    $data = $admin->fetchAllAssignments();
    if($data){
        $output .= '<table class="table table-striped table-bordered text-center">
									<thead>
										<tr>
											<th>#</th>
											<th>Personel</th>
											<th>Görev Türü</th>
											<th>Görev Yeri</th>
											<th>Başlangıç</th>
											<th>Bitiş</th>
											<th>İşlem</th>
										</tr>
									</thead>
									<tbody>';
        foreach ($data as $row) {
//            $date_now = date("Y-m-d"); // this format is string comparable
//
//            if ($date_now > $row['gorevlendirme_bitis']) {
//                echo 'greater than';
//            }else{
//                echo 'Less than';
//            }
            $output .= '<tr>
										<td>'.$row['gorevlendirme_id'].'</td>
										<td>'.$row['personel_isim'].'</td>
										<td>'.$row['gorev_turu_isim'].'</td>
										<td>'.$row['gorev_yeri'].'</td>
										<td>'.turkcetarih_formati('j F Y',$row['gorevlendirme_baslangic']).'</td>
										<td>'.turkcetarih_formati('j F Y',$row['gorevlendirme_bitis']).'</td>
										<td>
											<a href="editAssignment.php?taskId='.$row['gorevlendirme_id'].'" title="Görev Düzenle" class="text-primary userDetailsIcon"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp; <a href="#" id="'.$row['gorevlendirme_id'].'" title="Görevlendirme Sil" class="text-danger userDeleteIcon"><i class="fas fa-trash fa-lg"></i></a>
										</td>
									</tr>';
        }
        $output .= '</tbody>
								</table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">Henüz eklenmiş bir olay kaydı yok!</h3>';
    }
}
//MicroWeb Handle fetch all news request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllItems'){
    $output = '';

    $data = $admin->fetchAllItems();
    if($data){
        $output .= '<table class="table table-striped table-bordered text-center">
									<thead>
										<tr>
											<th>#</th>
											<th>Personel</th>
											<th>Verilen Malzeme</th>
											<th>Veriliş Tarihi</th>
											<th>İşlem</th>
										</tr>
									</thead>
									<tbody>';
        foreach ($data as $row) {
//            $date_now = date("Y-m-d"); // this format is string comparable
//
//            if ($date_now > $row['gorevlendirme_bitis']) {
//                echo 'greater than';
//            }else{
//                echo 'Less than';
//            }
            $output .= '<tr>
										<td>'.$row['takip_id'].'</td>
										<td>'.$row['personel_isim'].'</td>
										<td>'.$row['tur_isim'].'</td>
										<td>'.turkcetarih_formati('j F Y',$row['takip_tarih']).'</td>
										<td>
											<a href="editItem.php?taskId='.$row['takip_id'].'" title="Malzeme Düzenle" class="text-primary userDetailsIcon"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp; <a href="#" id="'.$row['takip_id'].'" title="Malzeme Sil" class="text-danger userDeleteIcon"><i class="fas fa-trash fa-lg"></i></a>
										</td>
									</tr>';
        }
        $output .= '</tbody>
								</table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">Henüz eklenmiş bir olay kaydı yok!</h3>';
    }
}
//MicroWeb Handle fetch all news request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllCeride'){
    $output = '';

    $data = $admin->fetchAllCeride($_POST['taskId']);
    if($data){
        $output .= '<table class="table table-striped table-bordered text-center">
									<thead>
										<tr>
											<th>#</th>
											<th>Olay</th>
											<th>Yapılan İşlem</th>
											<th>İşlem Tarihi</th>
											<th>İşlem</th>
										</tr>
									</thead>
									<tbody>';
$index=1;
        foreach ($data as $row) {
            $takip_islem = strip_tags($row['takip_islem'],'<br>');
            $output .= '<tr>
										<td>'.$index.'</td>
										<td>'.$row['olay_isim'].'</td>
										<td>'.$takip_islem.'</td>
										<td>'.$row['takip_zaman'].'</td>
										<td>
											<a href="editCeride.php?taskId='.$row['takip_id'].'" title="Kayıt Düzenle" class="text-primary userDetailsIcon"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp; <a href="#'.$row['takip_id'].'" id="'.$row['takip_id'].'" title="Kayıt Sil" class="text-danger userDeleteIcon"><i class="fas fa-trash fa-lg"></i></a>
										</td>
									</tr>';
            $index++;
        }
        $output .= '</tbody>
								</table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">Henüz eklenmiş bir ceride kaydı yok!</h3>';
    }
}
//Handle add new user request
if(isset($_POST['action']) && $_POST['action'] == 'addNewUser'){
    $uye_ad = $admin->test_input($_POST['uye_ad']);
    $uye_mail = $admin->test_input($_POST['uye_mail']);
    $uye_parola = $admin->test_input($_POST['uye_parola']);
    $uye_durum = $admin->test_input($_POST['uye_durum']);
    $hpassword = sha1($uye_parola);

    $userAdded = $admin->addNewUser($uye_ad,$uye_mail,$hpassword,$uye_durum);

    if($userAdded != null){
        echo 'user_added';
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
    }
}

//Handle add new user request
if(isset($_POST['action']) && $_POST['action'] == 'adminRegister'){
    $uye_ad = $admin->test_input($_POST['uye_ad']);
    $uye_mail = $admin->test_input($_POST['uye_mail']);
    $uye_parola = $admin->test_input($_POST['uye_parola']);
    $uye_durum = 0;
    $uye_cinsiyet = $admin->test_input($_POST['uye_cinsiyet']);
    $hpassword = sha1($uye_parola);

    $userAdded = $admin->addNewUser($uye_ad,$uye_mail,$hpassword,$uye_durum,$uye_cinsiyet);

    if($userAdded != null){
        echo 'admin_login';
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
    }
}
//Handle lost password request
if(isset($_POST['action']) && $_POST['action'] == 'lostPassword'){
    print_r($_POST);
    $uye_mail   = $admin->test_input($_POST['uye_mail']);
    $checkUser  = $admin->checkUniqueUsername($uye_mail);
    print_r($checkUser);
    if ($checkUser > 0) {
        $userAdded = $admin->sendConfirmationCode($uye_mail);
        if($userAdded != null){
            echo 'admin_login';
        }
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
    }
}

//Handle add new user request
if(isset($_POST['action']) && $_POST['action'] == 'addNewVideo'){
    $video_isim = $admin->test_input($_POST['video_isim']);
    $video_key = $admin->test_input($_POST['video_key']);
    $video_durum = $admin->test_input($_POST['video_durum']);
    $video_key = parse_str( parse_url( $video_key, PHP_URL_QUERY ), $my_array_of_vars );
    $video_key = $my_array_of_vars['v'];
    $userAdded = $admin->addNewVideo($_SESSION['uye_id'],$video_isim,$video_key,$video_durum);

    if($userAdded != null){
        echo 'user_added';
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
    }
}

//Handle edit video request
if(isset($_POST['action']) && $_POST['action'] == 'editVideoNews'){
    $video_isim = $admin->test_input($_POST['video_isim']);
    $video_id = $admin->test_input($_POST['video_id']);
    $video_key = $admin->test_input($_POST['video_key']);
    $video_durum = (isset($_POST['video_durum'])) ? '1':'0';
    $video_key = parse_str( parse_url( $video_key, PHP_URL_QUERY ), $my_array_of_vars );
    $video_key = $my_array_of_vars['v'];
    $userAdded = $admin->editVideoNews($video_id,$video_isim,$video_key,$video_durum);

    if($userAdded != null){
        echo 'user_added';
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
    }
}



//Handle add new cat request
if(isset($_POST['action']) && $_POST['action'] == 'addNewCat'){
    $tur =$_POST['tur'];
    $kategori_ad = $admin->test_input($_POST['kategori_ad']);
    $catAdded = $admin->addNewCat($kategori_ad,$tur);

    if($catAdded != null){
        echo 'cat_added';
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
    }
}

//Handle add news request
if(isset($_POST['action']) && $_POST['action'] == 'addNews'){
    $haber_baslik   = $admin->test_input($_POST['haber_baslik']);
    $haber_icerik   = $admin->test_input($_POST['haber_icerik']);
    $kategori_id    = $admin->test_input($_POST['kategori_id']);
    $uye_id         = $admin->test_input($_POST['uye_id']);
    $newsAdded = $admin->addNews($haber_baslik,$haber_icerik,$kategori_id,$haber_manset,$uye_id,$haber_durum,$haber_resim);

    if($newsAdded != null){
        echo 'news_added';
        print_r($_POST);
    }
    else{
        echo $admin->showMessage('danger','Kullanıcı adı ya da şifre hatası!');
    }
}



//Handle fetch all users request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllUsers'){
    $output = '';
    $data = $admin->fetchAllUsers();

    if($data){
        $output .= '<table class="table table-striped table-bordered text-center">
									<thead>
										<tr>
											<th>#</th>
											<th>İsim</th>
											<th>E-Mail</th>
											<th>Statü</th>
											<th>İşlem</th>
										</tr>
									</thead>
									<tbody>';
        foreach ($data as $row) {
            $amirBilgileri = ["Boş","Boş","Ana Yönetici","AADYM Birim Yöneticisi","Sosyal İşler ve İaşe Birim Yöneticisi","Arama Kurtarma Birim Yöneticisi"];
            $output .= '<tr>
										<td>'.$row['kullanici_id'].'</td>
										<td>'.$row['kullanici_ad'].'</td>
										<td>'.$row['kullanici_mail'].'</td>
<!--										<td>'.($row['kullanici_yetki'] == 2 ? 'Ana Yönetici' : 'Birim Yöneticisi').'</td>-->
                                        <td>'.$amirBilgileri[$row['kullanici_yetki']].'</td>
										<td>
											 '.($row['kullanici_mail'] == "iletisim@live.com" ? '<i class="fa fa-ban" aria-hidden="true"></i>' : '<a href="editUser.php?userId='.$row['kullanici_id'].'"  title="Kullanıcı Düzenle" class="text-primary userDetailsIcon"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp;<a href="#" id="'.$row['kullanici_id'].'" title="Kullanıcı Sil" class="text-danger userDeleteIcon"><i class="fas fa-trash fa-lg"></i></a>').'
										</td>
									</tr>';
        }
        $output .= '</tbody>
								</table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( Henüz kullanıcımız yok!</h3>';
    }
}


//Handle fetch all news request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllCats'){
    $output = '';
    $data = $admin->fetchAllCats($_POST['tur']);

    if($data){

        $output .= '<table class="table table-striped table-bordered text-center">
									<thead>
										<tr>
											<th>#</th>
											<th>Kategori İsmi</th>
											<th>İşlem</th>
										</tr>
									</thead>
									<tbody>';
        foreach ($data as $row) {
            switch ($_POST['tur']) {
                case "olayturu":
                    $getId=$row['olay_turu_id'];
                    $getType = $row['olay_turu'];
                    break;
                case "malzemetur":
                    $getId=$row['tur_id'];
                    $getType = $row['tur_isim'];
                    break;
                case "gorevturu":
                    $getId=$row['gorev_turu_id'];
                    $getType = $row['gorev_turu_isim'];
                    break;
                default:
                    echo "TurHata";
            }
            $output .= '<tr>
										<td>'.$getId.'</td>
										<td>'.$getType.'</td>
										<td>
											<a href="editCat.php?tur='.$_POST['tur'].'&catId='.$getId.'" title="Kategori Düzenle" class="text-primary userDetailsIcon"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp; <a href="#" id="'.$getId.'" title="Kategori Sil" class="text-danger userDeleteIcon"><i class="fas fa-trash fa-lg"></i></a>
										</td>
									</tr>';
        }
        $output .= '</tbody>
								</table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( Henüz kategorimiz yok!</h3>';
    }
}


//Handle fetch all news request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllVideoNews'){
    $output = '';
    $data = $admin->fetchAllVideoNews();
    if($data){
        $output .= '<table class="table table-striped table-bordered text-center">
									<thead>
										<tr>
											<th>#</th>
											<th>Video Başlık</th>
											<th>Video Link</th>
											<th>İşlem</th>
										</tr>
									</thead>
									<tbody>';
        foreach ($data as $row) {

            $output .= '<tr>
										<td>'.$row['video_id'].'</td>
										<td>'.$row['video_isim'].'</td>
										<td>'.$row['video_key'].'</td>
										<td>
											<a href="editVideoNews.php?videoId='.$row['video_id'].'" title="Video Haber Düzenle" class="text-primary userDetailsIcon"><i class="fas fa-edit fa-lg"></i></a>&nbsp;&nbsp; <a href="#" id="'.$row['video_id'].'" title="Video Sil" class="text-danger userDeleteIcon"><i class="fas fa-trash fa-lg"></i></a>
										</td>
									</tr>';
        }
        $output .= '</tbody>
								</table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( Henüz Video Haber yok!</h3>';
    }
}

//Handle display user's details request
if(isset($_POST['details_id'])){
    $id = $_POST['details_id'];
    $data = $admin->fetchUserDetailsByID($id);
    echo json_encode($data);
}

//Handle delete a user request
if(isset($_POST['del_id'])){
    $id = $_POST['del_id'];

    $admin->userAction($id);
}
//Handle delete a user request
if(isset($_POST['videoHaber_id'])){
    $id = $_POST['videoHaber_id'];

    $admin->videoNewsAction($id,0);
}
//Handle delete a category request
if(isset($_POST['cat_id'])){
    $id = $_POST['cat_id'];
    $tur = $_POST['tur'];

    $admin->catAction($id,$tur);
}

//Handle fetch all deleted users request
if(isset($_POST['action']) && $_POST['action'] == 'fetchDeletedUsers'){
    $output = '';
    $data = $admin->fetchAllUsers(0);

    if($data){
        $output .= '<table class="table table-striped table-bordered text-center">
									<thead>
										<tr>
											<th>#</th>
											<th>İsim</th>
											<th>E-Mail</th>
											<th>Üyelik Tarihi</th>
											<th>Cinsiyet</th>
											<th>Statü</th>
											<th>İşlem</th>
										</tr>
									</thead>
									<tbody>';
        foreach ($data as $row) {
            $output .= '<tr>
										<td>'.$row['uye_id'].'</td>
										<td>'.$row['uye_ad'].'</td>
										<td>'.$row['uye_mail'].'</td>
										<td>'.$row['uye_tarih'].'</td>
										<td>'.($row['uye_cinsiyet'] == 1 ? 'Erkek' : 'Kadın').'</td>
										<td>'.($row['uye_durum'] == 2 ? 'Yönetici' : 'Editör').'</td>
										<td>
											<a href="editUser.php?userId='.$row['uye_id'].'"  title="Kullanıcı Düzenle" class="text-primary userDetailsIcon"><i class="fas fa-edit fa-lg"></i></a>
											<a href="#" id="'.$row['uye_id'].'" title="Aktifleştir" class="text-danger userDeleteIcon"><i class="fas fa-undo"></i></a>
										</td>
									</tr>';
        }
        $output .= '</tbody>
								</table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( Henüz silinen bir kaydımız yok!</h3>';
    }
}

//handle restore deleted user request
if(isset($_POST['res_id'])){
    $id = $_POST['res_id'];

    $admin->userAction($id,1);
}


	//handle export all users in excel
	if(isset($_GET['export']) && $_GET['export'] == 'excel'){
		//header("Content-Type: application/xls");
        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
		header("Content-Disposition: attachment; filename=".$_GET['tablo'].".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
        echo "\xEF\xBB\xBF"; // UTF-8 BOM
if ($_GET['tablo'] == 'kullanici') {
		$data = $admin->exportAllUsers();
        mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');
		echo '<table border="1" margin="0">';
		echo '<tr>
											<th>İsim</th>
											<th>E-Mail</th>
											<th>Statü</th>
					</tr>';
		foreach ($data as $row) {
            $amirBilgileri = ["Boş","Boş","Ana Yönetici","AADYM Birim Yöneticisi","Sosyal İşler ve İaşe Birim Yöneticisi","Arama Kurtarma Birim Yöneticisi"];
			echo '<tr>
										<td>'.$row['kullanici_ad'].'</td>
										<td>'.$row['kullanici_mail'].'</td>
                                        <td>'.$amirBilgileri[$row['kullanici_yetki']].'</td>
					</tr>';
		}
		echo '</table>';
} else if (($_GET['tablo'] == 'gorev')) {
    $data = $admin->fetchAllAssignments();
    mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');
    echo '<table border="1" margin="0">';
    echo '<tr>
											<th>Personel</th>
											<th>Görev Türü</th>
											<th>Görev Yeri</th>
											<th>Başlangıç</th>
											<th>Bitiş</th>
					</tr>';
    foreach ($data as $row) {
        $amirBilgileri = ["Boş","Boş","Ana Yönetici","AADYM Birim Yöneticisi","Sosyal İşler ve İaşe Birim Yöneticisi","Arama Kurtarma Birim Yöneticisi"];
        echo '<tr>
										<td>'.$row['personel_isim'].'</td>
										<td>'.$row['gorev_turu_isim'].'</td>
										<td>'.$row['gorev_yeri'].'</td>
										<td>'.turkcetarih_formati('j F Y',$row['gorevlendirme_baslangic']).'</td>
										<td>'.turkcetarih_formati('j F Y',$row['gorevlendirme_bitis']).'</td>

					</tr>';
    }
    echo '</table>';
} else if (($_GET['tablo'] == 'olay')) {
    $data = $admin->fetchAllTasks();
    mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');
    echo '<table border="1" margin="0">';
    echo '<tr>
											<th>Olay</th>
											<th>Olay Türü</th>
											<th>Başlangıç</th>
											<th>Bitiş</th>
					</tr>';
    foreach ($data as $row) {
        $amirBilgileri = ["Boş","Boş","Ana Yönetici","AADYM Birim Yöneticisi","Sosyal İşler ve İaşe Birim Yöneticisi","Arama Kurtarma Birim Yöneticisi"];
        echo '<tr>
										<td>'.$row['olay_isim'].'</td>
										<td>'.$row['olay_turu'].'</td>
										<td>'.$admin->timeAgo($row['olay_baslangic']).'</td>
										<td>'.(($row['olay_bitis'] != null) ? $admin->timeAgo($row['olay_bitis']) : "Devam Ediyor").'</td>

					</tr>';
    }
    echo '</table>';
} else if (($_GET['tablo'] == 'ceride')) {
    $taskId = $_GET['taskId'];
    $data = $admin->fetchAllCeride($taskId);
    mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');
    echo '<table border="1" margin="0">';
    echo '<tr>
											<th>İşlem Tarihi</th>
                                            <th>Olay</th>
											<th>Yapılan İşlem</th>

					</tr>';
    foreach ($data as $row) {
        $takip_islem = strip_tags($row['takip_islem'],'<br>');
        $amirBilgileri = ["Boş","Boş","Ana Yönetici","AADYM Birim Yöneticisi","Sosyal İşler ve İaşe Birim Yöneticisi","Arama Kurtarma Birim Yöneticisi"];
        echo '<tr>
										<td>'.$row['takip_zaman'].'</td>
										<td>'.$row['olay_isim'].'</td>
										<td>'.$takip_islem.'</td>
					</tr>';
    }
    echo '</table>';
} else {
    $data = $admin->fetchAllItems();
    mb_convert_encoding($data, 'UTF-16LE', 'UTF-8');
    echo '<table border="1" margin="0">';
    echo '<tr>
											<th>Personel</th>
											<th>Verilen Malzeme</th>
											<th>Veriliş Tarihi</th>
					</tr>';
    foreach ($data as $row) {
        $amirBilgileri = ["Boş","Boş","Ana Yönetici","AADYM Birim Yöneticisi","Sosyal İşler ve İaşe Birim Yöneticisi","Arama Kurtarma Birim Yöneticisi"];
        echo '<tr>
										<td>'.$row['personel_isim'].'</td>
										<td>'.$row['tur_isim'].'</td>
										<td>'.turkcetarih_formati('j F Y',$row['takip_tarih']).'</td>
					</tr>';
    }
    echo '</table>';
}
	}


//Fetch all notes of users
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllNotes'){
    $note = $admin->fetchAllNotes();
    $output = '';
    if($note){
        $output .= '<table class="table table-striped table-bordered text-center">
									<thead>
										<tr>
											<th>#</th>
											<th>User Name</th>
											<th>User E-Mail</th>
											<th>Note Title</th>
											<th>Note</th>
											<th>Written On</th>
											<th>Updated On</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>';
        foreach ($note as $row) {
            $output .= '<tr>
										<td>'.$row['id'].'</td>
										<td>'.$row['name'].'</td>
										<td>'.$row['email'].'</td>
										<td>'.$row['title'].'</td>
										<td>'.$row['note'].'</td>
										<td>'.$row['created_at'].'</td>
										<td>'.$row['updated_at'].'</td>
										<td>
											<a href="#" id="'.$row['id'].'" title="Delete Note" class="text-danger noteDeleteIcon"><i class="fas fa-trash fa-lg"></i></a>
										</td>
									</tr>';
        }
        $output .= '</tbody>
								</table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( No any note written yet!</h3>';
    }
}

//handle delate note of an user by admin
if(isset($_POST['note_id'])){
    $id = $_POST['note_id'];

    $admin->deleteNoteOfUser($id);
}

// handle fetch all notification request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllNotification'){
    $notification = $admin->fetchNotification();

    $output = '';
    if($notification){
        foreach ($notification as $row) {
            $durumu= ($row['mesaj_durum']==1) ? "<h4 class='alert-heading text-danger'>Yeni mesaj!</h4>" : "";
            $output .= '<div class="alert alert-dark" role="alert">
										 <button type="button" id="'.$row['mesaj_id'].'" class="close" data-dismiss="alert" aria-label="Close">
										   <span aria-hidden="true">&times;</span>
										 </button>
									  '.$durumu.'
									  <p class="mb-0 lead">'.nl2br($row['mesaj_icerik']).' <br><br> '.$row['mesaj_isim'].'</p>
									  <hr class="my-2">
								  	<p class="mb-0 float-left"><b>E-Mail :</b> '.$row['mesaj_mail'].'</p>
								  	<p class="mb-0 float-right">'.$admin->timeAgo($row['mesaj_tarih']).'</p>
								  	<div class="clearfix"></div>
									</div>';
        }
        echo $output;
        $admin->inactiveNotification();
    }
    else{
        echo '<h3 class="text-center text-secondary mt-5">Yeni mesaj yok!</h3>';
    }
}

//handle remove notification
if(isset($_POST['notification_id'])){
    $id = $_POST['notification_id'];

    $admin->removeNotification($id);
}

//Check notification
if(isset($_POST['action']) && $_POST['action'] == 'notificationCheck'){
    if($admin->checkNotification()){
        echo '<i class="fas fa-circle text-danger fa-sm"></i>';
    }
    else{
        echo '';
    }
}

// Handle fetch all feedback
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllFeedback'){
    $feedback = $admin->fetchFeedback();
    $output = '';
    if($feedback){
        $output .= '<table class="table table-striped table-bordered text-center">
									<thead>
										<tr>
											<th>ID</th>
											<th>Gönderen</th>
											<th>E-Mail</th>
											<th>Mesaj</th>
											<th>Tarih</th>
										</tr>
									</thead>
									<tbody>';
        foreach ($feedback as $row) {
            $output .= '<tr>
										<td>'.$row['mesaj_id'].'</td>
										<td>'.$row['mesaj_isim'].'</td>
										<td>'.$row['mesaj_mail'].'</td>
										<td>'.$row['mesaj_icerik'].'</td>
										<td>'.$row['mesaj_tarih'].'</td>
										<td>
											<a href="#" id="'.$row['mesaj_id'].'" title="Reply" class="text-primary feedbackReplyIcon" data-toggle="modal" data-target="#showReplyModal"><i class="fas fa-reply fa-lg"></i></a>
										</td>
									</tr>';
        }
        $output .= '</tbody>
								</table>';
        echo $output;
    }
    else{
        echo '<h3 class="text-center text-secondary">:( No any feedback written yet!</h3>';
    }
}

//Handle reply feedback to user request
if(isset($_POST['message'])){
    $uid = $_POST['uid'];
    $message = $_POST['message'];
    $fid = $_POST['fid'];

    $admin->replyFeedback($uid,$message);
    $admin->feedbackReplied($fid);
}
?>