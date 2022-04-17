<?php
class Database
{
    const USERNAME = 'your_email_id';
    const PASSWORD = 'password';

        private $dsn = "mysql:host=localhost;dbname=habermerkezi";

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

    //Admin Login
    public function admin_login($username, $password)
    {
        $sql = "SELECT uye_mail,uye_parola,uye_id FROM uyeler WHERE uye_mail = :username AND uye_parola = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
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


    //Count Total Users
    public function totalCount($tablename)
    {
        $sql = "SELECT * FROM $tablename";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
        return $count;
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

    //Count Total Verified Users
    public function verified_users($status)
    {
        $sql = "SELECT * FROM uyeler WHERE uye_durum >= :status";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['status' => $status]);
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

    //Count Site Hits
    public function site_hits()
    {
        $sql = "SELECT sum(haber_goruntulenme) as hits FROM haberler";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $count = $stmt->fetch(PDO::FETCH_ASSOC);
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
    public function fetchAllUsers($val)
    {
        $val = ($val == 0 ? '="0"' : '>"0"');
        $sql = "SELECT * FROM uyeler WHERE uye_durum $val order by uye_id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    //Fetch All Registered Users
    public function fetchAllCats()
    {
        $sql = "SELECT * FROM haber_kategori";
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
        $sql = "SELECT * FROM uyeler WHERE uye_id = :id AND uye_durum != 0";
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
        $sql = "SELECT * FROM uyeler WHERE uye_mail = :id";
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
      //Fetch Category Details by ID
    public function fetchCategoryDetailsByID($id)
    {
        $sql = "SELECT * FROM haber_kategori WHERE kategori_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function checkUserStatus($id)
    {
        $sql = "SELECT uye_durum FROM uyeler WHERE uye_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["uye_durum"];
    }

    // Delete a user
    public function userAction($id, $val)
    {
        $sql = "UPDATE uyeler SET uye_durum = '$val' WHERE uye_id = :id";
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
    public function editUserDetails($uye_id,$uye_mail,$uye_ad,$uye_durum,$uye_cinsiyet)
    {
        $sql = "UPDATE uyeler SET uye_mail = :uye_mail, uye_ad = :uye_ad, uye_durum = :uye_durum, uye_cinsiyet = :uye_cinsiyet WHERE uye_id = :uye_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uye_id' => $uye_id, 'uye_mail'=> $uye_mail, 'uye_ad' =>$uye_ad, 'uye_durum' =>$uye_durum, 'uye_cinsiyet' => $uye_cinsiyet]);
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
    public function editCatDetails($cat_id,$kategori_ad,$kategori_detay)
    {
        $sql = "UPDATE haber_kategori SET kategori_ad = :kategori_ad, kategori_detay = :kategori_detay WHERE kategori_id = :kategori_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kategori_ad' => $kategori_ad, 'kategori_detay'=> $kategori_detay, 'kategori_id' =>$cat_id]);
        return true;

    }

    // Delete a news
    public function newsAction($id, $val)
    {
        $sql = "UPDATE haberler SET haber_durum = '$val' WHERE haber_id = :id";
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
    public function catAction($id)
    {
        $sql = "DELETE FROM haber_kategori WHERE kategori_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return true;
    }

    //Export All users to excel
    public function exportAllUsers()
    {
        $sql = "SELECT * FROM uyeler";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    public function addNewUser($uye_ad,$uye_mail,$uye_parola,$uye_durum,$uye_cinsiyet)
    {
        $sql = "INSERT INTO uyeler (uye_ad,uye_mail,uye_parola,uye_durum,uye_cinsiyet) VALUES (:uye_ad,:uye_mail,:uye_parola,:uye_durum,:uye_cinsiyet)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uye_ad' => $uye_ad,'uye_mail' => $uye_mail,'uye_parola' => $uye_parola,'uye_durum' => $uye_durum,'uye_cinsiyet' => $uye_cinsiyet]);
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
    public function addNewCat($kategori_ad,$kategori_detay)
    {
        $sql = "INSERT INTO haber_kategori (kategori_ad, kategori_detay) VALUES (:kategori_ad,:kategori_detay)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kategori_ad' => $kategori_ad,'kategori_detay' => $kategori_detay]);
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
