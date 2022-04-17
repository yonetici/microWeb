<?php
class Database
{
    const USERNAME = 'your_email_id';
    const PASSWORD = 'password';

        private $dsn = "mysql:host=localhost;dbname=microweb";

        private $dbuser = "root";

        private $dbpass = "";
    public $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->dbuser, $this->dbpass);
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
        return $this->conn;
    }

    //Check Input
    public function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //Error Success Message function
    public function showMessage($type, $message)
    {
        return '<div class="alert alert-' . $type . ' alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong class="text-center">' . $message . '</strong>
    </div>';
    }

    //Time in ago
    public function timeAgo($time_ago)
    {
        date_default_timezone_set('Asia/Istanbul');
        $time_ago = strtotime($time_ago) ? strtotime($time_ago) : $time_ago;
        $time = time() - $time_ago;

        switch ($time):
            // seconds
            case $time <= 60;
                return 'Şimdi!';
            // minutes
            case $time >= 60 && $time < 3600;
                return round($time / 60) . ' dakika önce';
            // hours
            case $time >= 3600 && $time < 86400;
                return round($time / 3600) . ' saat önce';
            // days
            case $time >= 86400 && $time < 604800;
                return round($time / 86400) . ' gün önce';
            // weeks
            case $time >= 604800 && $time < 2600640;
                return round($time / 604800) . ' hafta önce';
            // months
            case $time >= 2600640 && $time < 31207680;
                return round($time / 2600640) . ' ay önce';
            // years
            case $time >= 31207680;
                return round($time / 31207680) . ' yıl önce';

        endswitch;
    }

//MicroWeb add bulk Employee 
    public function addNewPerson($personel_isim,$personel_sicil,$personel_birim)
    {
        $sql = "INSERT INTO personel (personel_isim,personel_sicil,personel_birim) VALUES (:personel_isim,:personel_sicil,:personel_birim)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['personel_isim' => $personel_isim, 'personel_sicil' => $personel_sicil, 'personel_birim' => $personel_birim]);
        return true;
    }


    //MicroWeb Admin Login
    public function admin_login($username, $password)
    {
        $sql = "SELECT kullanici_mail,kullanici_parola,kullanici_id FROM kullanici WHERE kullanici_mail = :username AND kullanici_parola = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }
    // MicroWeb Check user privileges
    public function checkUserStatus($id)
    {
        $sql = "SELECT kullanici_yetki FROM kullanici WHERE kullanici_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["kullanici_yetki"];
    }


    //MicroWeb Count Total Users
    public function totalCount($tablename)
    {
        $sql = "SELECT * FROM $tablename";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
        return $count;
    }
    //Microweb Count Total Verified Users
    public function verified_users($status,$durum)
    {
        $durum = ($durum == "up") ? '>' : '<';
        $sql = "SELECT * FROM kullanici WHERE kullanici_yetki $durum :status";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['status' => $status]);
        $count = $stmt->rowCount();
        return $count;
    }
    // Mircoweb Count Site Hits
    public function activeModuleCount($table,$field,$condition)
    {
        $equal = ($condition == "yeni") ? ">" : "<";
        $sql = "SELECT * FROM ".$table." WHERE DATE(".$field.") ".$equal." CURDATE()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
        return $count;
    }
    // Mircoweb Count Site Hits
    public function activeModuleEqual($table,$field)
    {
        $sql = "SELECT * FROM ".$table." WHERE ".$field." <=> :fieldName";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fieldName' => null]);
        $count = $stmt->rowCount();
        return $count;
    }
    // MicroWeb fetch All tasks
    public function fetchAllTasks()
    {
            $sql = "SELECT olaylar.*,olayturu.olay_turu FROM olaylar JOIN olayturu on olayturu.olay_turu_id = olaylar.olay_turu_id ORDER BY olay_id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
     // MicroWeb fetch All Assignments
    public function fetchAllAssignments()
    {
            $sql = "SELECT gorevlendirmeler.*,gorevturu.gorev_turu_isim,personel.personel_isim FROM gorevlendirmeler JOIN gorevturu on gorevturu.gorev_turu_id = gorevlendirmeler.gorev_turu_id JOIN personel ON personel.personel_id = gorevlendirmeler.personel_id ORDER BY gorevlendirmeler.gorevlendirme_id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }     // MicroWeb fetch All Assignments
    public function fetchAllItems()
    {
            $sql = "SELECT malzemetakip.*,malzemetur.tur_isim,personel.personel_isim FROM malzemetakip JOIN malzemetur on malzemetur.tur_id = malzemetakip.tur_id JOIN personel ON personel.personel_id = malzemetakip.personel_id ORDER BY malzemetakip.takip_id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    // MicroWeb fetch All tasks
    public function fetchAllCeride($id)
    {
        $sql = "SELECT ceride.*,olaylar.olay_isim FROM ceride JOIN olaylar on olaylar.olay_id = ceride.olay_id WHERE ceride.olay_id = :id ORDER BY olay_id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    // MicroWeb Fetch Tasks
    public function fetchTask($id)
    {
        //$sql = "SELECT notification.id, notification.message, notification.created_at, users.name, users.email FROM notification INNER JOIN users ON notification.uid = users.id WHERE type = 'admin' ORDER BY notification.id DESC LIMIT 5";
        $sql = "SELECT * FROM olaylar WHERE olay_id = :newsID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['newsID' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    // MicroWeb Fetch Tasks
    public function fetchItem($id)
    {
        $sql = "SELECT malzemetakip.*,malzemetur.tur_isim,personel.personel_isim FROM malzemetakip JOIN malzemetur on malzemetur.tur_id = malzemetakip.tur_id JOIN personel ON personel.personel_id = malzemetakip.personel_id WHERE takip_id = :newsID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['newsID' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
     // MicroWeb Fetch Item
    public function fetchAssignment($id)
    {
        //$sql = "SELECT notification.id, notification.message, notification.created_at, users.name, users.email FROM notification INNER JOIN users ON notification.uid = users.id WHERE type = 'admin' ORDER BY notification.id DESC LIMIT 5";
        $sql = "SELECT gorevlendirmeler.*,gorevturu.gorev_turu_isim,personel.personel_isim FROM gorevlendirmeler JOIN gorevturu on gorevturu.gorev_turu_id = gorevlendirmeler.gorev_turu_id JOIN personel ON personel.personel_id = gorevlendirmeler.personel_id WHERE  gorevlendirme_id = :newsID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['newsID' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    // MicroWeb Fetch Ceride
    public function fetchCeride($id)
    {
        //$sql = "SELECT notification.id, notification.message, notification.created_at, users.name, users.email FROM notification INNER JOIN users ON notification.uid = users.id WHERE type = 'admin' ORDER BY notification.id DESC LIMIT 5";
        $sql = "SELECT * FROM ceride WHERE takip_id = :newsID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['newsID' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //MicroWebShow task categories
    public function getTaskCat()
    {
        $sql = "SELECT olay_turu_id,olay_turu FROM olayturu";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    //MicroWebShow Assignment Cats
    public function getAssignCat()
    {
        $sql = "SELECT gorev_turu_id,gorev_turu_isim FROM gorevturu";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    //MicroWebShow Assignment Cats
    public function getItemCat()
    {
        $sql = "SELECT tur_id,tur_isim FROM malzemetur";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    //MicroWebShow Assignment Cats
    public function getEmployees()
    {
        $sql = "SELECT * FROM personel";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
// MicroWeb add Task
    public function addTask($haber_baslik,$haber_icerik,$kategori_id,$ekip)
    {
        $sql = "INSERT INTO olaylar (olay_isim,olay_detay,olay_turu_id,olay_baslangic,olay_ekip) VALUES (:haber_baslik,:haber_icerik,:kategori_id,:olay_baslangic,:ekip)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['haber_baslik' => $haber_baslik,'haber_icerik' => $haber_icerik,'kategori_id' => $kategori_id,'olay_baslangic' => date('Y-m-d H:i:s'), 'ekip' => $ekip]);
        $id = $this->conn->lastInsertId();
        $sql = "INSERT INTO ceride (olay_id,takip_islem) VALUES (:olay_id,:haber_icerik)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['olay_id' => $id,'haber_icerik' => $haber_icerik]);
        return true;
    }
// MicroWeb add Task
    public function addAssignment($gorev_yeri,$kategori_id,$ekip,$gorev_basla,$gorev_bitir)
    {
        $sql = "INSERT INTO gorevlendirmeler (gorev_turu_id, gorevlendirme_baslangic, gorevlendirme_bitis,personel_id,gorev_yeri) VALUES (:kategori_id,:gorevlendirme_baslangic,:gorevlendirme_bitis,:personel_id,:gorev_yeri)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kategori_id' => $kategori_id,'gorevlendirme_baslangic' => $gorev_basla,'gorevlendirme_bitis' => $gorev_bitir,'personel_id' => $ekip, 'gorev_yeri' => $gorev_yeri]);
        return true;
    }
// MicroWeb add Task
    public function addItem($personel,$kategori_id,$gorev_bitir)
    {
        $sql = "INSERT INTO malzemetakip (tur_id,personel_id,takip_tarih) VALUES (:kategori_id,:personel_id,:gorev_bitir)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kategori_id' => $kategori_id, 'personel_id' => $personel, 'gorev_bitir' => $gorev_bitir]);
        return true;
    }
// MicroWeb add Task
    public function editAssignment($gorev_yeri,$kategori_id,$ekip,$gorev_basla,$gorev_bitir,$haber_id)
    {
        $sql = "UPDATE gorevlendirmeler SET gorev_turu_id = :gorev_turu_id, gorevlendirme_baslangic = :gorevlendirme_baslangic, gorevlendirme_bitis = :gorevlendirme_bitis, personel_id = :personel_id,gorev_yeri = :gorev_yeri WHERE gorevlendirme_id = :haber_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['gorev_turu_id' => $kategori_id,'gorevlendirme_baslangic' => $gorev_basla,'gorevlendirme_bitis' => $gorev_bitir,'personel_id' => $ekip, 'gorev_yeri' => $gorev_yeri, 'haber_id' => $haber_id]);
        return true;
    }
// MicroWeb add Task
    public function editItem($personel,$kategori_id,$gorev_bitir,$haber_id)
    {
        $sql = "UPDATE malzemetakip SET tur_id = :gorev_turu_id, takip_tarih = :gorevlendirme_bitis, personel_id = :personel_id WHERE takip_id = :haber_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['gorev_turu_id' => $kategori_id,'gorevlendirme_bitis' => $gorev_bitir,'personel_id' => $personel, 'haber_id' => $haber_id]);
        return true;
    }
// MicroWeb add Ceride
    public function addCeride($haber_icerik,$taskId)
    {
        $sql = "INSERT INTO ceride (olay_id,takip_islem) VALUES (:taskId,:haber_icerik)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['taskId' => $taskId,'haber_icerik' => $haber_icerik]);
        return true;
    }
// MicroWeb EditTask
    public function editTask($haber_id,$haber_baslik,$haber_icerik,$kategori_id,$olay_bitis)
    {
        $sql = "UPDATE olaylar SET olay_isim = :haber_baslik, olay_detay = :haber_icerik, olay_turu_id = :kategori_id, olay_bitis = :olay_bitis WHERE olay_id = :haber_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'haber_id' => intval($haber_id),
            'haber_baslik' => $haber_baslik,
            'haber_icerik' => $haber_icerik,
            'kategori_id' => $kategori_id,
            'olay_bitis' => $olay_bitis
        ]);
        return true;
    }
// MicroWeb Edit Ceride
    public function editCeride($haber_id,$haber_baslik)
    {
        $sql = "UPDATE ceride SET takip_islem = :haber_baslik WHERE takip_id = :haber_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'haber_id' => intval($haber_id),
            'haber_baslik' => $haber_baslik]);
        return true;
    }
    //MicroWeb Fetch Category Details by ID
    public function fetchCategoryDetailsByID($id,$tur)
    {
        switch ($tur) {
            case "olayturu":
                $getId="olay_turu_id";
                $getType = "olay_turu";
                break;
            case "malzemetur":
                $getId='tur_id';
                $getType = 'tur_isim';
                break;
            case "gorevturu":
                $getId='gorev_turu_id';
                $getType = 'gorev_turu_isim';
                break;
            default:
                echo "TurHata";
        }
        $sql = "SELECT * FROM $tur WHERE $getId = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //Show Kategories
    public function getCategories()
    {
        $sql = "SELECT kategori_id,kategori_ad FROM haber_kategori";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    //Count news added by user
    public function totalNews($userId)
    {
        $sql = "SELECT * FROM haberler WHERE uye_id=:uye_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uye_id' => $userId]);
        $count = $stmt->rowCount();
        return $count;
    }

    //Count Total Unverified Users
    public function unverified_users($status)
    {
        $sql = "SELECT * FROM uyeler WHERE uye_durum = :status";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['status' => $status]);
        $count = $stmt->rowCount();
        return $count;
    }



    //Gender Percentage
    public function genderPer()
    {
        $sql = "SELECT uye_cinsiyet, COUNT(*) AS number FROM uyeler WHERE uye_cinsiyet != '' GROUP BY uye_cinsiyet";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //User's Verified/Unverified Percentage
    public function isVerifiedPer()
    {
        $sql = "SELECT uye_durum, COUNT(*) AS number FROM uyeler GROUP BY uye_durum";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //Fetch All Registered Users
    public function fetchAllUsers()
    {
        $sql = "SELECT * FROM kullanici order by kullanici_id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //Fetch All Registered Users
    public function fetchAllCats($tur)
    {
        $sql = "SELECT * FROM $tur";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //Fetch All Registered Users
    public function fetchAllVideoNews()
    {
        $sql = "SELECT * FROM video_haber WHERE video_durum=1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //Fetch All News
    public function fetchAllNews($val,$userId)
    {
        $val = ($val == 0 ? '=0' : '>0');
        if ($userId ==0) {
            $sql = "SELECT haberler.*,haber_kategori.kategori_ad,uyeler.uye_ad FROM `haberler` JOIN haber_kategori on haber_kategori.kategori_id = haberler.kategori_id JOIN uyeler ON uyeler.uye_id = haberler.uye_id WHERE haber_durum $val ORDER BY haber_tarih ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
        } else {
            $sql = "SELECT haberler.*,haber_kategori.kategori_ad,uyeler.uye_ad FROM `haberler` JOIN haber_kategori on haber_kategori.kategori_id = haberler.kategori_id JOIN uyeler ON uyeler.uye_id = haberler.uye_id WHERE haberler.uye_id = :uye_id AND haber_durum $val ORDER BY haber_tarih ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['uye_id' => $userId]);
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //Fetch User Details by ID
    public function fetchUserDetailsByID($id)
    {
        $sql = "SELECT * FROM kullanici WHERE kullanici_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    //Fetch User Details by EMail
    public function fetchUserDetailsByEMail($id)
    {
        $sql = "SELECT * FROM uyeler WHERE uye_mail = :id AND uye_durum != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //Fetch Video Details by ID
    public function fetchVideoDetailsByID($id)
    {
        $sql = "SELECT * FROM video_haber WHERE video_id = :id AND video_durum != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //Fetch Site Details
    public function siteDetails()
    {
        $sql = "SELECT * FROM ayarlar WHERE ayar_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => 1]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkUniqueUsername($id)
    {
        $sql = "SELECT * FROM kullanici WHERE kullanici_mail = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $count = $stmt->rowCount();
        return $count;
    }

    public function checkLostPassword($id,$code)
    {
        $sql = "SELECT * FROM uyeler WHERE uye_mail = :id AND dogrulama_kodu= :code";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id, 'code' => $code]);
        $count = $stmt->rowCount();
        return $count;
    }

    // Delete a user
    public function userAction($id)
    {
        $sql = "DELETE FROM kullanici WHERE kullanici_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return true;
    }
    // Forgot password
    public function sendConfirmationCode($id,$createToken)
    {
        $sql = "UPDATE uyeler SET dogrulama_kodu = :dogrulama_kodu WHERE uye_mail = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id, 'dogrulama_kodu' => $createToken]);
        return true;
    }

    // Edit user details
    public function editUserDetails($uye_id,$uye_mail,$uye_ad,$uye_durum)
    {
        $sql = "UPDATE kullanici SET kullanici_mail = :uye_mail, kullanici_ad = :uye_ad, kullanici_yetki = :uye_durum WHERE kullanici_id = :uye_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uye_id' => $uye_id, 'uye_mail'=> $uye_mail, 'uye_ad' =>$uye_ad, 'uye_durum' =>$uye_durum]);
        return true;

    }
    // Edit user details
    public function changeUserPassword($uye_mail,$uye_id)
    {
        $sql = "UPDATE uyeler SET uye_parola = :uye_parola, dogrulama_kodu = :dogrulama_kodu WHERE uye_mail = :uye_mail";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uye_parola' => $uye_id, 'dogrulama_kodu'=> '', 'uye_mail' =>$uye_mail]);
        return true;

    }

    // Edit site details
    public function editSiteDetails($ayar_siteadi, $ayar_hakkimizda, $ayar_adres, $ayar_mail, $ayar_telefon, $ayar_facebook, $ayar_twitter, $ayar_youtube, $ayar_bilgilendirme)
    {
        $sql = "UPDATE ayarlar SET ayar_siteadi = :ayar_siteadi, ayar_hakkimizda = :ayar_hakkimizda, ayar_mail = :ayar_mail, ayar_adres = :ayar_adres, ayar_telefon = :ayar_telefon, ayar_facebook = :ayar_facebook, ayar_twitter = :ayar_twitter, ayar_youtube = :ayar_youtube, ayar_bilgilendirme = :ayar_bilgilendirme WHERE ayar_id = :ayar_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['ayar_siteadi' => $ayar_siteadi, 'ayar_hakkimizda'=> $ayar_hakkimizda, 'ayar_adres' =>$ayar_adres, 'ayar_mail' =>$ayar_mail, 'ayar_telefon' => $ayar_telefon, 'ayar_facebook'=> $ayar_facebook, 'ayar_twitter' =>$ayar_twitter, 'ayar_youtube' => $ayar_youtube, 'ayar_bilgilendirme'=> $ayar_bilgilendirme, 'ayar_id' =>1]);
        return true;

    }


    // Edit category details
    public function editCatDetails($cat_id,$kategori_ad,$tur)
    {
        switch ($tur) {
            case "olayturu":
                $getId='olay_turu_id';
                $getType = 'olay_turu';
                break;
            case "malzemetur":
                $getId='tur_id';
                $getType = 'tur_isim';
                break;
            case "gorevturu":
                $getId='gorev_turu_id';
                $getType = 'gorev_turu_isim';
                break;
            default:
                echo "TurHata";
        }
        $sql = "UPDATE $tur SET $getType = :kategori_ad WHERE $getId = :kategori_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kategori_ad' => $kategori_ad, 'kategori_id' =>$cat_id]);
        return true;

    }

    // Delete a news
    public function taskAction($id)
    {

       $sql = "DELETE FROM ceride WHERE olay_id = :id";
       $stmt = $this->conn->prepare($sql);
       $stmt->execute(['id' => $id]);
        $sql = "DELETE FROM olaylar WHERE olay_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return true;
    }
    // Delete a news
    public function assigmentAction($id)
    {
       $sql = "DELETE FROM gorevlendirmeler WHERE gorevlendirme_id = :id";
       $stmt = $this->conn->prepare($sql);
       $stmt->execute(['id' => $id]);
        return true;
    }
    // Delete a news
    public function cerideAction($id)
    {
       $sql = "DELETE FROM ceride WHERE takip_id = :id";
       $stmt = $this->conn->prepare($sql);
       $stmt->execute(['id' => $id]);
        return true;
    }

    // Delete a video news
    public function videoNewsAction($id, $val)
    {
        $sql = "UPDATE video_haber SET video_durum = '$val' WHERE video_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return true;
    }

    // Delete a category
    public function catAction($id,$tur)
    {
        switch ($tur) {
            case "olayturu":
                $getId='olay_turu_id';
                $getType = 'olay_turu';
                break;
            case "malzemetur":
                $getId='tur_id';
                $getType = 'tur_isim';
                break;
            case "gorevturu":
                $getId='gorev_turu_id';
                $getType = 'gorev_turu_isim';
                break;
            default:
                echo "TurHata";
        }
        $sql = "DELETE FROM $tur WHERE $getId = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return true;
    }

    //Export All users to excel
    public function exportAllUsers()
    {
        $sql = "SELECT * FROM kullanici";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    public function addNewUser($uye_ad,$uye_mail,$hpassword,$uye_durum)
    {
        $sql = "INSERT INTO kullanici (kullanici_ad,kullanici_mail,kullanici_parola,kullanici_yetki) VALUES (:uye_ad,:uye_mail,:uye_parola,:uye_durum)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uye_ad' => $uye_ad,'uye_mail' => $uye_mail,'uye_parola' => $hpassword,'uye_durum' => $uye_durum]);
        return true;
    }
    public function addNewVideo($uye_id,$video_isim,$video_key,$video_durum)
    {
        $sql = "INSERT INTO video_haber (uye_id, video_isim, video_key, video_durum) VALUES (:uye_id, :video_isim, :video_key, :video_durum)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uye_id' => $uye_id,'video_isim' => $video_isim,'video_key' => $video_key,'video_durum' => $video_durum]);
        return true;
    }

    public function addNewMessage($mesaj_isim,$mesaj_mail,$mesaj_icerik)
    {
        $sql = "INSERT INTO mesajlar (mesaj_isim,mesaj_mail,mesaj_icerik) VALUES (:mesaj_isim,:mesaj_mail,:mesaj_icerik)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['mesaj_isim' => $mesaj_isim,'mesaj_mail' => $mesaj_mail,'mesaj_icerik' => $mesaj_icerik]);
        return true;
    }

    public function editStaticPages($type,$staticBaslik,$staticIcerik)
    {
        $sql = "UPDATE statik SET sayfa_baslik = :sayfa_baslik, sayfa_icerik = :sayfa_icerik WHERE sayfa_isim = :sayfa_isim";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['sayfa_baslik' => $staticBaslik, 'sayfa_icerik'=> $staticIcerik, 'sayfa_isim' =>$type]);
        return true;
    }
    public function editVideoNews($video_id,$video_isim,$video_key,$video_durum)
    {
        $sql = "UPDATE video_haber SET video_isim = :video_isim, video_key = :video_key, video_durum = :video_durum WHERE video_id = :video_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['video_isim' => $video_isim, 'video_key'=> $video_key, 'video_durum' =>$video_durum, 'video_id' => $video_id]);
        return true;
    }
    //Fetch Static Page Details
    public function staticDetails($type)
    {
        $sql = "SELECT * FROM statik WHERE sayfa_isim = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $type]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function addNewCat($kategori_ad,$tur)
    {
        switch ($tur) {
            case "olayturu":
                $getId='olay_turu_id';
                $getType = 'olay_turu';
                break;
            case "malzemetur":
                $getId='tur_id';
                $getType = 'tur_isim';
                break;
            case "gorevturu":
                $getId='gorev_turu_id';
                $getType = 'gorev_turu_isim';
                break;
            default:
                echo "TurHata";
        }
        $sql = "INSERT INTO $tur ($getType) VALUES (:kategori_ad)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kategori_ad' => $kategori_ad]);
        return true;
    }

    public function addNews($haber_baslik,$haber_icerik,$kategori_id,$haber_manset,$uye_id,$haber_durum,$haber_gorsel)
    {
        $sql = "INSERT INTO haberler (haber_baslik,haber_icerik,kategori_id,haber_manset,uye_id,haber_durum,haber_gorsel) VALUES (:haber_baslik,:haber_icerik,:kategori_id,:haber_manset,:uye_id,:haber_durum,:haber_gorsel)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['haber_baslik' => $haber_baslik,'haber_icerik' => $haber_icerik,'kategori_id' => $kategori_id,'haber_manset' => $haber_manset,'uye_id' => $uye_id, 'haber_durum' => $haber_durum,'haber_gorsel' => $haber_gorsel]);
        return true;
    }
    public function editNews($haber_id,$haber_baslik,$haber_icerik,$kategori_id,$haber_manset,$uye_id,$haber_durum,$haber_gorsel)
    {
        $sql = "UPDATE haberler SET haber_baslik = :haber_baslik, haber_icerik = :haber_icerik, kategori_id = :kategori_id, haber_manset = :haber_manset,haber_durum = :haber_durum, haber_gorsel = :haber_gorsel, uye_id = :uye_id WHERE haber_id = :haber_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'haber_id' => intval($haber_id),
            'haber_baslik' => $haber_baslik,
            'haber_icerik' => $haber_icerik,
            'kategori_id' => $kategori_id,
            'uye_id' => $uye_id,
            'haber_manset' => $haber_manset,
            'haber_durum' => $haber_durum,
            'haber_gorsel' => $haber_gorsel
        ]);
        return true;
    }

    public function fetchNews($id)
    {
        //$sql = "SELECT notification.id, notification.message, notification.created_at, users.name, users.email FROM notification INNER JOIN users ON notification.uid = users.id WHERE type = 'admin' ORDER BY notification.id DESC LIMIT 5";
        $sql = "SELECT * FROM haberler WHERE haber_id = :newsID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['newsID' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getNewsDetailsbyId($id)
    {

        //$sql = "SELECT notification.id, notification.message, notification.created_at, users.name, users.email FROM notification INNER JOIN users ON notification.uid = users.id WHERE type = 'admin' ORDER BY notification.id DESC LIMIT 5";
        $sql = "SELECT haberler.*,haber_kategori.kategori_ad,uyeler.uye_ad FROM haberler JOIN haber_kategori on haber_kategori.kategori_id = haberler.kategori_id JOIN uyeler ON uyeler.uye_id = haberler.uye_id WHERE haber_durum = 1 AND haber_id = :newsID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['newsID' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getVideoNewsDetailsbyId($id)
    {
        $sql = "SELECT video_haber.*,uyeler.uye_ad FROM video_haber JOIN uyeler ON uyeler.uye_id = video_haber.uye_id WHERE video_durum = 1 AND video_id = :newsID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['newsID' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //Fetch all notes with user info
    public function fetchAllNotes()
    {
        $sql = "SELECT notes.id, notes.title, notes.note, notes.created_at, notes.updated_at, users.name, users.email FROM notes INNER JOIN users ON notes.uid = users.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //Delete a note of a user by admin
    public function deleteNoteOfUser($id)
    {
        $sql = "DELETE FROM notes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return true;
    }

    //Fetch all notification
    public function fetchNotification()
    {
        //$sql = "SELECT notification.id, notification.message, notification.created_at, users.name, users.email FROM notification INNER JOIN users ON notification.uid = users.id WHERE type = 'admin' ORDER BY notification.id DESC LIMIT 5";
        $sql = "SELECT * FROM mesajlar ORDER BY mesaj_id DESC LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function checkNotification()
    {
        //$sql = "SELECT notification.id, notification.message, notification.created_at, users.name, users.email FROM notification INNER JOIN users ON notification.uid = users.id WHERE type = 'admin' ORDER BY notification.id DESC LIMIT 5";
        $sql = "SELECT * FROM mesajlar WHERE mesaj_durum='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function inactiveNotification()
    {
        $sql = "UPDATE mesajlar SET mesaj_durum = '0'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return true;
    }

    //Remove notification
    public function removeNotification($id)
    {
        $sql = "DELETE FROM mesajlar WHERE mesaj_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return true;
    }

    // Fetch all feedback
    public function fetchFeedback()
    {
        //$sql = "SELECT feedback.id, feedback.subject, feedback.feedback, feedback.created_at, feedback.uid, users.name, users.email FROM feedback INNER JOIN users ON feedback.uid = users.id WHERE replied != 1 ORDER BY feedback.id DESC";
        $sql = "SELECT * FROM mesajlar ORDER BY mesaj_id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //Reply to user
    public function replyFeedback($uid, $message)
    {
        $sql = "INSERT INTO notification (uid,type,message) VALUES (:uid,'user',:message)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid' => $uid, 'message' => $message]);
        return true;
    }

    //Set Notification replied
    public function feedbackReplied($fid)
    {
        $sql = "UPDATE feedback SET replied = 1 WHERE id = :fid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fid' => $fid]);
        return true;
    }

    //Featured New at Frontend pages
    public function showNews($katId=0,$start,$end)
    {

        if ($katId ==0) {
            try {
                $limit = ' LIMIT ' . intval($start) . ', ' . intval($end);
                $sql = "SELECT haberler.*,haber_kategori.kategori_ad,uyeler.uye_ad FROM haberler JOIN haber_kategori on haber_kategori.kategori_id = haberler.kategori_id JOIN uyeler ON uyeler.uye_id = haberler.uye_id WHERE haber_durum = 1 ORDER BY haber_tarih DESC". $limit;
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
            } catch ( PDOException $e ){
                print $e->getMessage();
            }

        } else {
            $limit = ' LIMIT ' . intval($start) . ', ' . intval($end);
            $sql = "SELECT haberler.*,haber_kategori.kategori_ad,uyeler.uye_ad FROM `haberler` JOIN haber_kategori on haber_kategori.kategori_id = haberler.kategori_id JOIN uyeler ON uyeler.uye_id = haberler.uye_id WHERE haberler.kategori_id = :katId AND haber_durum = 1 ORDER BY haber_tarih DESC". $limit;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['katId' => intval($katId)]);
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    public function popularNews($katId=0,$start,$end)
    {

        if ($katId ==0) {
            try {
                $limit = ' LIMIT ' . intval($start) . ', ' . intval($end);
                $sql = "SELECT haberler.*,haber_kategori.kategori_ad,uyeler.uye_ad FROM haberler JOIN haber_kategori on haber_kategori.kategori_id = haberler.kategori_id JOIN uyeler ON uyeler.uye_id = haberler.uye_id WHERE haber_durum = 1 ORDER BY haber_goruntulenme DESC". $limit;
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
            } catch ( PDOException $e ){
                print $e->getMessage();
            }

        } else {
            $limit = ' LIMIT ' . intval($start) . ', ' . intval($end);
            $sql = "SELECT haberler.*,haber_kategori.kategori_ad,uyeler.uye_ad FROM `haberler` JOIN haber_kategori on haber_kategori.kategori_id = haberler.kategori_id JOIN uyeler ON uyeler.uye_id = haberler.uye_id WHERE haberler.kategori_id = :katId AND haber_durum = 1 ORDER BY haber_goruntulenme DESC". $limit;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['katId' => intval($katId)]);
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getVideoNews($start,$end)
    {

        $limit = ' LIMIT ' . intval($start) . ', ' . intval($end);
        $sql = "SELECT * FROM video_haber WHERE video_durum = 1 ORDER BY video_id DESC". $limit;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function setbackgroundcolor($id) {
        $colors=['primary', 'success', 'warning', 'danger', 'info'];
        if ($id>=count($colors)) {
            return $colors[$id%count($colors)];
        } else {
            return $colors[$id];
        }
    }

    function makeSeoFriendly($text){
        $find = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
        $degis = array("G","U","S","I","O","C","g","u","s","i","o","c");
        $text = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/"," ",$text);
        $text = preg_replace($find,$degis,$text);
        $text = preg_replace("/ +/"," ",$text);
        $text = preg_replace("/ /","-",$text);
        $text = preg_replace("/\s/","",$text);
        $text = strtolower($text);
        $text = preg_replace("/^-/","",$text);
        $text = preg_replace("/-$/","",$text);
        return $text;
    }
    //Count Total records
    public function totalNewsbyId($kategori_id)
    {
        $sql = "SELECT kategori_id FROM haberler WHERE haber_durum=1 AND kategori_id=:kategori_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kategori_id' => $kategori_id]);
        $count = $stmt->rowCount();
        return $count;
    }
    //Count Total records
    public function totalVideoNews()
    {
        $sql = "SELECT video_id FROM video_haber WHERE video_durum=1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
        return $count;
    }
   //Count Total search records
    public function totalNewsbyKeyword($keyword)
    {
        $sql = "SELECT haberler.*,haber_kategori.kategori_ad,uyeler.uye_ad FROM haberler JOIN haber_kategori on haber_kategori.kategori_id = haberler.kategori_id JOIN uyeler ON uyeler.uye_id = haberler.uye_id WHERE haber_icerik LIKE CONCAT('%', :keyword, '%')  OR haber_baslik LIKE CONCAT('%', :keyword, '%')";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['keyword' => $keyword]);
        $count = $stmt->rowCount();
        return $count;
    }

    public function redirectJavascript($url,$time=0) {
        $time = $time * 1000;
        ?>

        <script>
            //Using setTimeout to execute a function after 5 seconds.
            setTimeout(function () {
                //Redirect with JavaScript
                window.location.href= '<?php echo $url; ?>';
            }, <?php echo $time; ?>);
        </script>
<?php
    }
    public function searchInNews($keyword,$start,$end)
    {
        $limit = ' LIMIT ' . intval($start) . ', ' . intval($end);
        $sql = "SELECT haberler.*,haber_kategori.kategori_ad,uyeler.uye_ad FROM haberler JOIN haber_kategori on haber_kategori.kategori_id = haberler.kategori_id JOIN uyeler ON uyeler.uye_id = haberler.uye_id WHERE haber_icerik LIKE CONCAT('%', :keyword, '%')  OR haber_baslik LIKE CONCAT('%', :keyword, '%') ORDER BY haber_tarih DESC". $limit;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['keyword' => $keyword]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function updateCount($haber_id,$haber_goruntulenme)
    {
        $sql = "UPDATE haberler SET haber_goruntulenme = :haber_goruntulenme WHERE haber_id = :haber_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'haber_id' => intval($haber_id),
            'haber_goruntulenme' => $haber_goruntulenme + 1
        ]);
        return true;
    }

    /*Beni Hatirla*/
    public function deleteCookie($id)
    {
        $sql = "DELETE FROM beni_hatirla WHERE uye_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return true;
    }

    public function checkCookie($id,$browser,$timeValue)
    {
        $sql = "SELECT * FROM beni_hatirla WHERE token = :id AND tarayici = :tarayici AND gecerlilik_tarihi > :zaman";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id, 'tarayici' => $browser, 'zaman'=> $timeValue]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    public function addToken($uye_id,$newToken)
    {
        $timeValue = time()+604800;
        $browser = md5($_SERVER['HTTP_USER_AGENT']);
        $sql = "INSERT INTO beni_hatirla (uye_id, token, gecerlilik_tarihi,tarayici) VALUES (:uye_id, :token, :gecerlilik_tarihi, :tarayici)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uye_id' => $uye_id, 'token' => $newToken, 'gecerlilik_tarihi' => $timeValue, 'tarayici' => $browser]);
        return true;
    }
    /**/
    //Fetch all notes with user info
    public function showStaticPages($type)
    {
        $sql = "SELECT * FROM statik WHERE sayfa_isim = :sayfa_isim";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['sayfa_isim' => $type]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}





$admin = new Database();
