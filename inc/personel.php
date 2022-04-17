<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Rıdvan BİLGİN">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ana Sayfa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<?php
include '../mainClass.php';
$personel=array();
$personel[]='ONURCAN;KOPAN';
$personel[]='SARUHAN;GÖRMELİ';
$personel[]='DEMET;GÖKTAŞ';
$personel[]='YUSUF KENAN;MUMCUOĞLU';
$personel[]='BAKİ;OZAT';
$personel[]='SABRİ;KARAKOYUNLU';
$personel[]='TÜMAY;YAVUZ';
$personel[]='İKLİL;DALGIÇ';
$personel[]='MAHMUT EMRE;TAY';
$personel[]='AYCAN;ÖZDEN UYAN';
$personel[]='ÖMER GÖKHAN;ŞALGALI';
$personel[]='ARDA;BELDEK';
$personel[]='KEVSER;ÇARPAN';
$personel[]='ÜNSAL;ÇINKIR';
$personel[]='GÜNEŞ;ALTINDAŞ';
$personel[]='MUTLU;KAHRAMAN';
$personel[]='ONUR ATEŞ;BUDAK';
$personel[]='KERİME RUMEYSA;BEREKET';
$personel[]='SAYGIN;ÇOKER';
$personel[]='İKRAM;BAKIR';
$personel[]='GÜLBÜKE;TOLA';
$personel[]='NAZAN;ARIKAN YORGUN';
$personel[]='SAADET NİLAY;GİNİŞ';
$personel[]='EFE;SERVET';
$personel[]='MUKADDER;ŞENCAN';
$personel[]='ZELAL;KÜTÜKOĞLU';
$personel[]='GÖZDEM;ACARBULUT';
$personel[]='AHMET SERCAN;OSHAN';
$personel[]='FERHAN;ÇALIŞ';
$personel[]='MÜGE;BELGEMEN';
$personel[]='YILMAZ;DANÇ';
$personel[]='TUBA;GAYRETLİ';
$personel[]='TAYLAN;KÜÇÜKDEMİRTAŞ';
$personel[]='SÜREYYA;KESER';
$personel[]='DİLARA;SİPAHİ';
$personel[]='CELAL;BATUR';
$personel[]='NECLA;DÜZEL';
$personel[]='AHMET BURAK;AKARSU';
$personel[]='SERAY;AKDAĞ';
$personel[]='YUSUF;TAMER';
$personel[]='AYŞEGÜL;KÜÇÜKÇİL';
$personel[]='ÇİLE;URFALI';
$personel[]='SABİHA;BAHA';
$personel[]='BEYHAN;BUMİN';
$personel[]='AHMET;COŞAR';
$personel[]='MANSUR;GÜMÜŞBAŞ';
$personel[]='HALİME;İNANÇ';
$personel[]='SEMANUR;KURBAN';
$personel[]='ONURHAN;YACI';
$personel[]='CEMİLE;CANKURTARAN';
$personel[]='TAMER;AYDINKAL';
$personel[]='TAHA;SARIKAHRAMAN';
$personel[]='AYSU;SATIK';
$personel[]='SEYFULLAH;ÖTEBAŞ';
$personel[]='UĞUR;ÖDEN';
$personel[]='ZEKİ;TOZUN';
$personel[]='NAZLI HİLAL;ŞEYHANLI';
$personel[]='CİHAN;GÜLDAMLA';
$personel[]='SELAHATTİN;TEZER';
$personel[]='İBRAHİM;HALİL;TOKSARI';
$personel[]='NEŞE;AYAN';
$personel[]='GÜLFİDAN;ERGİNEL';
$personel[]='BİLGE MERVE;TAŞLI';
$personel[]='RANA;ELMA';
$personel[]='BETÜL;BİLGİ';
$personel[]='ATAHAN;ZEYBEK';
$personel[]='SİMENDER;ERSOLAK';
$personel[]='SONGÜL;ARMUTCU';
$personel[]='ADNAN;ALPASLAN';
$personel[]='SEVİM;CANDEMİR';
$personel[]='KÜBRA;KINDIR';
$personel[]='SAKİNE;KADAK';
$personel[]='ENES TAHİR;OKKAN';
$personel[]='FATİH AVNİ;DEMİRAĞ';
$personel[]='KURTULUŞ;ALKIŞ';
$personel[]='DERMAN;AKHUN';
$personel[]='MÜSLİM;TUNAOĞLU';
$personel[]='ORÇUN;BOSTANCIOĞLU';
$personel[]='HİKMET;TUĞCUGİL';
$personel[]='MUHAMMET MURAT;GÖRDÜK';
$personel[]='MEHMETCAN;YEŞİL';
$personel[]='METE CAN;DÜZCE';
$personel[]='MUAMMER HAYRİ;HAVAS';
$personel[]='EFTAL MURAT;KASAL';
$personel[]='MERİH;OCAKTAN';
$personel[]='YAREN;ŞATANA';
$personel[]='HİCRAN;UÇAN';
$personel[]='FAİK;KENAR';
$personel[]='EBUBEKİR ONUR;DADLI';
$personel[]='EMİRHAN;ALICILAR';
$personel[]='TURGAY;KONAR';
$personel[]='MELİSA;SANDAL';
$personel[]='RECEP GANİ;ÇUKURLUÖZ';
$personel[]='ESİN;EVLER';
$personel[]='SEFA;ERÇEN';
$personel[]='YONCA;ZENGİNDEMİR';
$personel[]='ENGİN;PARASIZ';
$personel[]='UMUTCAN;KARACAN';
$personel[]='İLKİM;SARGIN';
$personel[]='ESMERALDA;LAĞARLI';
$personel[]='ALİ;SAİP;TAVİL';
$personel[]='SEBAHAT;EKER';
$personel[]='ABDULLAH ARİF;BAŞMAN';
$personel[]='MAZLUM;YÜZER';
$personel[]='SAFFET;KARNAS';
$personel[]='CEREN BUĞLEM;AZAR';
$personel[]='MELİHA;SONCU';
$personel[]='FEHMİ;ATİLA';
$personel[]='NESLİHAN;ÖĞREDEN';
$personel[]='TUNA;AMİROVA UÇAN';
$personel[]='SEDA;UTLU';
$personel[]='ASLIHAN;KISA';
$personel[]='PELİN;ŞEN GÖKÇEİMAM';
$personel[]='SIRRI;SAKALLIOĞLU';
$personel[]='SELMA;ALPER';
$personel[]='EVRİM;BAŞCI';
$personel[]='SİNAN;MEMİŞOĞLU';
$personel[]='SELİN;ULUTAŞ';
$personel[]='BİROL;TOYRAN';
$personel[]='TÜRKAN;MERTOL';
$personel[]='KENAN SELÇUK;YOZGAT';
$personel[]='KAMERCAN;ÇAVAK';
$personel[]='LARA;ALBAŞ';
$personel[]='ZÜRBİYE;KALE';
$personel[]='RABİA;CANSEVER';
$personel[]='GÖKMEN ALPASLAN;ÖLÇÜCÜ';
$personel[]='ECENAZ;ATILGAN';
$personel[]='UYGAR;HELVACI';
$personel[]='EMİNE AYÇA;ALTUNYAPRAK';
$personel[]='MİNA;DERİN';
$personel[]='SERRA;ERSOY';
$personel[]='TARIK;ALDİNÇ';
$personel[]='ÖZGÜL;AHUNBAY';
$personel[]='MÜNEVVER;YILDIZ BULUT';
$personel[]='TAHSİN;GÜNEŞ';
$personel[]='NAGEHAN;ELDEM';
$personel[]='EMRECAN;ARSAL';
$admin = new Database();
function strtolower_turkce($metin){
		$bul 	= array("I","Ğ","Ü","Ş","İ","Ö","Ç");
		$degis  = array("ı","ğ","ü","ş","i","ö","ç");
		$metin	= str_replace($bul, $degis, $metin);
		$metin	= strtolower($metin);
		return $metin;
	}
function ucwords_tr($str) {
return ltrim(mb_convert_case(str_replace(array('i','I'), array('İ','ı'),mb_strtolower($str)), MB_CASE_TITLE, 'UTF-8'));
}
function tr_ucwords ($a) {
  $a = strtolower(strtr($a,'ĞÜŞIİÖÇ','ğüşıiöç'));
  $a = ucwords(strtr($a,'ĞÜŞIİÖÇ','ğüşıiöç'));
  $t = array(' ğ', ' ü', ' ş', ' ı', ' i', ' ö', ' ç');
  $d = array(' Ğ', ' Ü', ' Ş', ' I', ' İ', ' Ö', ' Ç');
  $a = str_replace($t,$d,$a);
  return $a;
}
	$sayac = 1654;
foreach ($personel as $person) {
	$sayac++;
	$parcala=explode(';',$person);
	echo  $sayac. ": ". $parcala[0] . " " . $parcala[1] . "<br>";
	$isimm=tr_ucwords(strtolower_turkce($parcala[0])) . " " . $parcala[1];
	$admin->addNewPerson($isimm,$sayac,"Birlik Müdürlüğü");
}
?>
</body>

</html>