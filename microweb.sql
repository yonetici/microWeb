-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 17 Nis 2022, 02:28:02
-- Sunucu sürümü: 10.4.17-MariaDB
-- PHP Sürümü: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `microweb`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `beni_hatirla`
--

CREATE TABLE `beni_hatirla` (
  `id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `gecerlilik_tarihi` varchar(255) NOT NULL,
  `tarayici` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `beni_hatirla`
--

INSERT INTO `beni_hatirla` (`id`, `uye_id`, `token`, `gecerlilik_tarihi`, `tarayici`) VALUES
(3, 1, '7882aff2e296500a102b3603715e97fcff5ccb2b', '1650759509', '09af53e829b1687c5db16483617c3ced');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ceride`
--

CREATE TABLE `ceride` (
  `takip_id` int(11) NOT NULL,
  `olay_id` int(11) NOT NULL,
  `takip_zaman` datetime NOT NULL DEFAULT current_timestamp(),
  `takip_islem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `ceride`
--

INSERT INTO `ceride` (`takip_id`, `olay_id`, `takip_zaman`, `takip_islem`) VALUES
(2, 7, '2022-04-16 00:08:22', 'NOSAB\'ta gaz sızıntısı var'),
(8, 9, '2022-04-16 01:35:01', '<p>112\'den alınan ihbarda Dudaklı k&ouml;y&uuml;nde sel olduğu bilgisi verildi. N&ouml;bet&ccedil;i ekip sevk edildi.</p>'),
(12, 9, '2022-04-17 02:21:16', 'İl Müdürü bilgilendirilerek Valilik Koordinasyona mesaj çekildi.'),
(13, 10, '2022-04-17 02:34:50', '112\'den alınan ihbarda Demirkapı mahallesi Kızlar Caddesi No 32\'de bulunan binanın yıkılma riski bildirildi'),
(14, 10, '2022-04-17 02:35:18', 'Müdür bey bilgilendirildi, Ekibe çıkış talimatı verildi.'),
(15, 10, '2022-04-17 02:35:37', 'Valilik koordinasyona bilgi notu mesaj olarak iletildi.'),
(16, 10, '2022-04-17 02:38:57', 'Ekip bölgeye gittiğinde Çevre ŞEhircilik İl Müdürlüğü yetkilileri ile yapılan görüşmede olay onlara devredildi. Ekip dönüşe geçti.');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gorevlendirmeler`
--

CREATE TABLE `gorevlendirmeler` (
  `gorevlendirme_id` int(11) NOT NULL,
  `gorev_turu_id` int(11) DEFAULT NULL,
  `gorevlendirme_baslangic` datetime NOT NULL,
  `gorevlendirme_bitis` datetime NOT NULL,
  `personel_id` int(11) NOT NULL,
  `gorev_yeri` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `gorevlendirmeler`
--

INSERT INTO `gorevlendirmeler` (`gorevlendirme_id`, `gorev_turu_id`, `gorevlendirme_baslangic`, `gorevlendirme_bitis`, `personel_id`, `gorev_yeri`) VALUES
(3, 2, '2022-04-27 00:00:00', '2022-04-30 00:00:00', 11, 'Balıkesir'),
(5, 1, '2022-04-17 00:00:00', '2022-04-21 00:00:00', 15, 'Karaman'),
(6, 2, '2022-04-17 00:00:00', '2022-04-29 00:00:00', 4, 'Bartın'),
(8, 2, '2022-04-19 00:00:00', '2022-04-29 00:00:00', 1, 'Yurtdışı'),
(9, 3, '2022-04-27 00:00:00', '2022-05-11 00:00:00', 14, 'Gümüşhane');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gorevturu`
--

CREATE TABLE `gorevturu` (
  `gorev_turu_id` int(11) NOT NULL,
  `gorev_turu_isim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `gorevturu`
--

INSERT INTO `gorevturu` (`gorev_turu_id`, `gorev_turu_isim`) VALUES
(1, 'Eğitim'),
(2, 'Görev'),
(3, 'Tatbikat');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `kullanici_id` int(11) NOT NULL,
  `kullanici_ad` varchar(255) NOT NULL,
  `kullanici_mail` varchar(255) NOT NULL,
  `kullanici_parola` varchar(100) NOT NULL,
  `kullanici_yetki` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`kullanici_id`, `kullanici_ad`, `kullanici_mail`, `kullanici_parola`, `kullanici_yetki`) VALUES
(1, 'Rıdvan BİLGİN', 'iletisim@live.com', 'd88ea461adab9a5d6d2d760f82bbd6b1ba81452e', 2),
(2, 'Deniz Cem GÜRSOY', 'aadym@microweb.com', 'd88ea461adab9a5d6d2d760f82bbd6b1ba81452e', 3),
(3, 'Nihat YETİŞ', 'sosyal@microweb.com', 'd88ea461adab9a5d6d2d760f82bbd6b1ba81452e', 4),
(4, 'Sıddık YILDIRIM', 'sar@microweb.com', 'd88ea461adab9a5d6d2d760f82bbd6b1ba81452e', 5),
(6, 'Test User', 'testuser@turkwm.com', 'd88ea461adab9a5d6d2d760f82bbd6b1ba81452e', 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `malzemetakip`
--

CREATE TABLE `malzemetakip` (
  `takip_id` int(11) NOT NULL,
  `tur_id` int(11) NOT NULL,
  `personel_id` int(11) NOT NULL,
  `takip_tarih` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `malzemetakip`
--

INSERT INTO `malzemetakip` (`takip_id`, `tur_id`, `personel_id`, `takip_tarih`) VALUES
(1, 11, 18, '2022-04-05 00:00:00'),
(2, 7, 16, '2022-04-04 00:00:00'),
(3, 6, 19, '2022-04-17 00:00:00'),
(4, 8, 19, '2022-04-17 00:00:00'),
(5, 18, 13, '2022-04-04 00:00:00'),
(6, 6, 17, '2022-04-19 00:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `malzemetur`
--

CREATE TABLE `malzemetur` (
  `tur_id` int(11) NOT NULL,
  `tur_stok` int(255) NOT NULL,
  `tur_isim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `malzemetur`
--

INSERT INTO `malzemetur` (`tur_id`, `tur_stok`, `tur_isim`) VALUES
(2, 0, 'Baret'),
(3, 0, 'Kışlık Parka'),
(4, 0, 'Kışlık Pantolon'),
(5, 0, 'Kışlık Mont'),
(6, 0, 'El Feneri'),
(7, 0, 'Düdük'),
(8, 0, 'Sırt Çantası'),
(9, 0, 'Softshell Pantolon'),
(10, 0, 'Tişört'),
(11, 0, 'Yazlık Pantolon'),
(12, 0, 'Yazlık Mont'),
(13, 0, 'Yazlık Ayakkabı'),
(14, 0, 'Bot'),
(15, 0, 'Kampet'),
(16, 0, 'Uyku Tulumu'),
(17, 0, 'Tozluk'),
(18, 0, 'Çakı'),
(19, 0, 'Yelek'),
(20, 0, 'Uyku Matı');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `olaylar`
--

CREATE TABLE `olaylar` (
  `olay_id` int(11) NOT NULL,
  `olay_turu_id` int(11) DEFAULT NULL,
  `olay_isim` varchar(255) NOT NULL,
  `olay_ekip` varchar(255) NOT NULL,
  `olay_detay` text NOT NULL,
  `olay_baslangic` datetime NOT NULL,
  `olay_bitis` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `olaylar`
--

INSERT INTO `olaylar` (`olay_id`, `olay_turu_id`, `olay_isim`, `olay_ekip`, `olay_detay`, `olay_baslangic`, `olay_bitis`) VALUES
(7, 3, 'Gaz Sızıntısı', '6', '&lt;p&gt;NOSAB\'ta gaz sızıntısı ihbari&lt;/p&gt;', '2022-04-15 23:08:22', NULL),
(9, 6, 'Dudaklı Köyü sel felaketi', '2', '<p>Başkanlık AADYM\'den alınan ihbarda Dudaklı köyünde sel olduğu bilgisi verildi. Nöbetçi ekip sevk edildi.</p>', '2022-04-16 00:35:01', '2022-04-17 00:08:48'),
(10, 9, 'Metrup Bina Yıkılması', '3', '112\'den alınan ihbarda Demirkapı mahallesi Kızlar Caddesi No 32\'de bulunan binanın yıkılma riski bildirildi', '2022-04-17 01:34:50', '2022-04-17 01:39:10');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `olayturu`
--

CREATE TABLE `olayturu` (
  `olay_turu_id` int(11) NOT NULL,
  `olay_turu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `olayturu`
--

INSERT INTO `olayturu` (`olay_turu_id`, `olay_turu`) VALUES
(4, 'Boğulma'),
(8, 'Çığ'),
(7, 'Deprem'),
(5, 'Heyelan'),
(2, 'Kaybolma'),
(3, 'KBRN'),
(6, 'Sel-Taşkın'),
(1, 'Trafik Kazası'),
(9, 'Yapısal Riskler');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personel`
--

CREATE TABLE `personel` (
  `personel_id` int(11) NOT NULL,
  `personel_isim` varchar(255) NOT NULL,
  `personel_sicil` int(11) NOT NULL,
  `personel_birim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `personel`
--

INSERT INTO `personel` (`personel_id`, `personel_isim`, `personel_sicil`, `personel_birim`) VALUES
(1, 'Rıdvan BİLGİN', 1655, 'Birlik Müdürlüğü'),
(2, 'Saruhan GÖRMELİ', 1656, 'Birlik Müdürlüğü'),
(3, 'Demet GÖKTAŞ', 1657, 'Birlik Müdürlüğü'),
(4, 'Yusuf Kenan MUMCUOĞLU', 1658, 'Birlik Müdürlüğü'),
(5, 'Baki OZAT', 1659, 'Birlik Müdürlüğü'),
(6, 'Sabri KARAKOYUNLU', 1660, 'Birlik Müdürlüğü'),
(7, 'Tümay YAVUZ', 1661, 'Birlik Müdürlüğü'),
(8, 'Hande DALGIÇ', 1662, 'Birlik Müdürlüğü'),
(9, 'Mahmut Emre TAY', 1663, 'Birlik Müdürlüğü'),
(10, 'Aycan ÖZDEN UYAN', 1664, 'Birlik Müdürlüğü'),
(11, 'Ömer Gökhan ŞALGALI', 1665, 'Birlik Müdürlüğü'),
(12, 'Arda BELDEK', 1666, 'Birlik Müdürlüğü'),
(13, 'Kevser ÇARPAN', 1667, 'Birlik Müdürlüğü'),
(14, 'Ünsal ÇINKIR', 1668, 'Birlik Müdürlüğü'),
(15, 'Güneş ALTINDAŞ', 1669, 'Birlik Müdürlüğü'),
(16, 'Mutlu KAHRAMAN', 1670, 'Birlik Müdürlüğü'),
(17, 'Onur Ateş BUDAK', 1671, 'Birlik Müdürlüğü'),
(18, 'Kerime Rumeysa BEREKET', 1672, 'Birlik Müdürlüğü'),
(19, 'Saygın ÇOKER', 1673, 'Birlik Müdürlüğü'),
(20, 'İkram BAKIR', 1674, 'Birlik Müdürlüğü'),
(21, 'Gülbüke TOLA', 1675, 'Birlik Müdürlüğü'),
(22, 'Nazan ARIKAN YORGUN', 1676, 'Birlik Müdürlüğü'),
(23, 'Saadet Nilay GİNİŞ', 1677, 'Birlik Müdürlüğü'),
(24, 'Efe SERVET', 1678, 'Birlik Müdürlüğü'),
(25, 'Mukadder ŞENCAN', 1679, 'Birlik Müdürlüğü'),
(26, 'Zelal KÜTÜKOĞLU', 1680, 'Birlik Müdürlüğü'),
(27, 'Gözdem ACARBULUT', 1681, 'Birlik Müdürlüğü'),
(28, 'Ahmet Sercan OSHAN', 1682, 'Birlik Müdürlüğü'),
(29, 'Ferhan ÇALIŞ', 1683, 'Birlik Müdürlüğü'),
(30, 'Müge BELGEMEN', 1684, 'Birlik Müdürlüğü'),
(31, 'Yılmaz DANÇ', 1685, 'Birlik Müdürlüğü'),
(32, 'Tuba GAYRETLİ', 1686, 'Birlik Müdürlüğü'),
(33, 'Taylan KÜÇÜKDEMİRTAŞ', 1687, 'Birlik Müdürlüğü'),
(34, 'Süreyya KESER', 1688, 'Birlik Müdürlüğü'),
(35, 'Dilara SİPAHİ', 1689, 'Birlik Müdürlüğü'),
(36, 'Celal BATUR', 1690, 'Birlik Müdürlüğü'),
(37, 'Necla DÜZEL', 1691, 'Birlik Müdürlüğü'),
(38, 'Ahmet Burak AKARSU', 1692, 'Birlik Müdürlüğü'),
(39, 'Seray AKDAĞ', 1693, 'Birlik Müdürlüğü'),
(40, 'Yusuf TAMER', 1694, 'Birlik Müdürlüğü'),
(41, 'Ayşegül KÜÇÜKÇİL', 1695, 'Birlik Müdürlüğü'),
(42, 'Çiğdem URFALI', 1696, 'Birlik Müdürlüğü'),
(43, 'Sabiha BAHA', 1697, 'Birlik Müdürlüğü'),
(44, 'Beyhan BUMİN', 1698, 'Birlik Müdürlüğü'),
(45, 'Ahmet COŞAR', 1699, 'Birlik Müdürlüğü'),
(46, 'Mansur GÜMÜŞBAŞ', 1700, 'Birlik Müdürlüğü'),
(47, 'Halime İNANÇ', 1701, 'Birlik Müdürlüğü'),
(48, 'Semanur KURBAN', 1702, 'Birlik Müdürlüğü'),
(49, 'Onurhan YACI', 1703, 'Birlik Müdürlüğü'),
(50, 'Cemile CANKURTARAN', 1704, 'Birlik Müdürlüğü'),
(51, 'Tamer AYDINKAL', 1705, 'Birlik Müdürlüğü'),
(52, 'Taha SARIKAHRAMAN', 1706, 'Birlik Müdürlüğü'),
(53, 'Aysu SATIK', 1707, 'Birlik Müdürlüğü'),
(54, 'Seyfullah ÖTEBAŞ', 1708, 'Birlik Müdürlüğü'),
(55, 'Uğur ÖDEN', 1709, 'Birlik Müdürlüğü'),
(56, 'Zeki TOZUN', 1710, 'Birlik Müdürlüğü'),
(57, 'Nazlı Hilal ŞEYHANLI', 1711, 'Birlik Müdürlüğü'),
(58, 'Cihan GÜLDAMLA', 1712, 'Birlik Müdürlüğü'),
(59, 'Selahattin TEZER', 1713, 'Birlik Müdürlüğü'),
(60, 'Ibrahim HALİL', 1714, 'Birlik Müdürlüğü'),
(61, 'Neşe AYAN', 1715, 'Birlik Müdürlüğü'),
(62, 'Gülfidan ERGİNEL', 1716, 'Birlik Müdürlüğü'),
(63, 'Bilge Merve TAŞLI', 1717, 'Birlik Müdürlüğü'),
(64, 'Rana ELMA', 1718, 'Birlik Müdürlüğü'),
(65, 'Betül BİLGİ', 1719, 'Birlik Müdürlüğü'),
(66, 'Atahan ZEYBEK', 1720, 'Birlik Müdürlüğü'),
(67, 'Simender ERSOLAK', 1721, 'Birlik Müdürlüğü'),
(68, 'Songül ARMUTCU', 1722, 'Birlik Müdürlüğü'),
(69, 'Adnan ALPASLAN', 1723, 'Birlik Müdürlüğü'),
(70, 'Sevim CANDEMİR', 1724, 'Birlik Müdürlüğü'),
(71, 'Kübra KINDIR', 1725, 'Birlik Müdürlüğü'),
(72, 'Sakine KADAK', 1726, 'Birlik Müdürlüğü'),
(73, 'Enes Tahir OKKAN', 1727, 'Birlik Müdürlüğü'),
(74, 'Fatih Avni DEMİRAĞ', 1728, 'Birlik Müdürlüğü'),
(75, 'Kurtuluş ALKIŞ', 1729, 'Birlik Müdürlüğü'),
(76, 'Derman AKHUN', 1730, 'Birlik Müdürlüğü'),
(77, 'Müslim TUNAOĞLU', 1731, 'Birlik Müdürlüğü'),
(78, 'Orçun BOSTANCIOĞLU', 1732, 'Birlik Müdürlüğü'),
(79, 'Hikmet TUĞCUGİL', 1733, 'Birlik Müdürlüğü'),
(80, 'Muhammet Murat GÖRDÜK', 1734, 'Birlik Müdürlüğü'),
(81, 'Mehmetcan YEŞİL', 1735, 'Birlik Müdürlüğü'),
(82, 'Mete Can DÜZCE', 1736, 'Birlik Müdürlüğü'),
(83, 'Muammer Hayri HAVAS', 1737, 'Birlik Müdürlüğü'),
(84, 'Eftal Murat KASAL', 1738, 'Birlik Müdürlüğü'),
(85, 'Merih OCAKTAN', 1739, 'Birlik Müdürlüğü'),
(86, 'Yaren ŞATANA', 1740, 'Birlik Müdürlüğü'),
(87, 'Hicran UÇAN', 1741, 'Birlik Müdürlüğü'),
(88, 'Faik KENAR', 1742, 'Birlik Müdürlüğü'),
(89, 'Ebubekir Onur DADLI', 1743, 'Birlik Müdürlüğü'),
(90, 'Emirhan ALICILAR', 1744, 'Birlik Müdürlüğü'),
(91, 'Turgay KONAR', 1745, 'Birlik Müdürlüğü'),
(92, 'Melisa SANDAL', 1746, 'Birlik Müdürlüğü'),
(93, 'Recep Gani ÇUKURLUÖZ', 1747, 'Birlik Müdürlüğü'),
(94, 'Esin EVLER', 1748, 'Birlik Müdürlüğü'),
(95, 'Sefa ERÇEN', 1749, 'Birlik Müdürlüğü'),
(96, 'Yonca ZENGİNDEMİR', 1750, 'Birlik Müdürlüğü'),
(97, 'Engin PARASIZ', 1751, 'Birlik Müdürlüğü'),
(98, 'Umutcan KARACAN', 1752, 'Birlik Müdürlüğü'),
(99, 'İlkim SARGIN', 1753, 'Birlik Müdürlüğü'),
(100, 'Esmeralda LAĞARLI', 1754, 'Birlik Müdürlüğü'),
(101, 'Ali SAİP', 1755, 'Birlik Müdürlüğü'),
(102, 'Sebahat EKER', 1756, 'Birlik Müdürlüğü'),
(103, 'Abdullah Arif BAŞMAN', 1757, 'Birlik Müdürlüğü'),
(104, 'Mazlum YÜZER', 1758, 'Birlik Müdürlüğü'),
(105, 'Saffet KARNAS', 1759, 'Birlik Müdürlüğü'),
(106, 'Ceren Buğlem AZAR', 1760, 'Birlik Müdürlüğü'),
(107, 'Meliha SONCU', 1761, 'Birlik Müdürlüğü'),
(108, 'Fehmi ATİLA', 1762, 'Birlik Müdürlüğü'),
(109, 'Neslihan ÖĞREDEN', 1763, 'Birlik Müdürlüğü'),
(110, 'Tuna AMİROVA UÇAN', 1764, 'Birlik Müdürlüğü'),
(111, 'Seda UTLU', 1765, 'Birlik Müdürlüğü'),
(112, 'Aslıhan KISA', 1766, 'Birlik Müdürlüğü'),
(113, 'Pelin ŞEN GÖKÇEİMAM', 1767, 'Birlik Müdürlüğü'),
(114, 'Sırrı SAKALLIOĞLU', 1768, 'Birlik Müdürlüğü'),
(115, 'Selma ALPER', 1769, 'Birlik Müdürlüğü'),
(116, 'Evrim BAŞCI', 1770, 'Birlik Müdürlüğü'),
(117, 'Sinan MEMİŞOĞLU', 1771, 'Birlik Müdürlüğü'),
(118, 'Selin ULUTAŞ', 1772, 'Birlik Müdürlüğü'),
(119, 'Birol TOYRAN', 1773, 'Birlik Müdürlüğü'),
(120, 'Türkan MERTOL', 1774, 'Birlik Müdürlüğü'),
(121, 'Kenan Selçuk YOZGAT', 1775, 'Birlik Müdürlüğü'),
(122, 'Kamercan ÇAVAK', 1776, 'Birlik Müdürlüğü'),
(123, 'Lara ALBAŞ', 1777, 'Birlik Müdürlüğü'),
(124, 'Zürbiye KALE', 1778, 'Birlik Müdürlüğü'),
(125, 'Rabia CANSEVER', 1779, 'Birlik Müdürlüğü'),
(126, 'Gökmen Alpaslan ÖLÇÜCÜ', 1780, 'Birlik Müdürlüğü'),
(127, 'Ecenaz ATILGAN', 1781, 'Birlik Müdürlüğü'),
(128, 'Uygar HELVACI', 1782, 'Birlik Müdürlüğü'),
(129, 'Emine Ayça ALTUNYAPRAK', 1783, 'Birlik Müdürlüğü'),
(130, 'Mina DERİN', 1784, 'Birlik Müdürlüğü'),
(131, 'Serra ERSOY', 1785, 'Birlik Müdürlüğü'),
(132, 'Tarık ALDİNÇ', 1786, 'Birlik Müdürlüğü'),
(133, 'Özgül AHUNBAY', 1787, 'Birlik Müdürlüğü'),
(134, 'Münevver YILDIZ BULUT', 1788, 'Birlik Müdürlüğü'),
(135, 'Tahsin GÜNEŞ', 1789, 'Birlik Müdürlüğü'),
(136, 'Nagehan ELDEM', 1790, 'Birlik Müdürlüğü'),
(137, 'Emrecan ARSAL', 1791, 'Birlik Müdürlüğü');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `beni_hatirla`
--
ALTER TABLE `beni_hatirla`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ceride`
--
ALTER TABLE `ceride`
  ADD PRIMARY KEY (`takip_id`),
  ADD KEY `ceride_fk0` (`olay_id`);

--
-- Tablo için indeksler `gorevlendirmeler`
--
ALTER TABLE `gorevlendirmeler`
  ADD PRIMARY KEY (`gorevlendirme_id`),
  ADD KEY `gorevlendirmeler_fk0` (`gorev_turu_id`),
  ADD KEY `gorevlendirmeler_fk1` (`personel_id`);

--
-- Tablo için indeksler `gorevturu`
--
ALTER TABLE `gorevturu`
  ADD PRIMARY KEY (`gorev_turu_id`),
  ADD UNIQUE KEY `gorev_turu_isim` (`gorev_turu_isim`);

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`kullanici_id`),
  ADD UNIQUE KEY `kullanici_mail` (`kullanici_mail`);

--
-- Tablo için indeksler `malzemetakip`
--
ALTER TABLE `malzemetakip`
  ADD PRIMARY KEY (`takip_id`),
  ADD KEY `malzemeTakip_fk0` (`tur_id`),
  ADD KEY `malzemeTakip_fk1` (`personel_id`);

--
-- Tablo için indeksler `malzemetur`
--
ALTER TABLE `malzemetur`
  ADD PRIMARY KEY (`tur_id`);

--
-- Tablo için indeksler `olaylar`
--
ALTER TABLE `olaylar`
  ADD PRIMARY KEY (`olay_id`),
  ADD KEY `olaylar_fk0` (`olay_turu_id`);

--
-- Tablo için indeksler `olayturu`
--
ALTER TABLE `olayturu`
  ADD PRIMARY KEY (`olay_turu_id`),
  ADD UNIQUE KEY `olay_turu` (`olay_turu`);

--
-- Tablo için indeksler `personel`
--
ALTER TABLE `personel`
  ADD PRIMARY KEY (`personel_id`),
  ADD UNIQUE KEY `personel_isim` (`personel_isim`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `beni_hatirla`
--
ALTER TABLE `beni_hatirla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `ceride`
--
ALTER TABLE `ceride`
  MODIFY `takip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `gorevlendirmeler`
--
ALTER TABLE `gorevlendirmeler`
  MODIFY `gorevlendirme_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `gorevturu`
--
ALTER TABLE `gorevturu`
  MODIFY `gorev_turu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `malzemetakip`
--
ALTER TABLE `malzemetakip`
  MODIFY `takip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `malzemetur`
--
ALTER TABLE `malzemetur`
  MODIFY `tur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Tablo için AUTO_INCREMENT değeri `olaylar`
--
ALTER TABLE `olaylar`
  MODIFY `olay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `olayturu`
--
ALTER TABLE `olayturu`
  MODIFY `olay_turu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `personel`
--
ALTER TABLE `personel`
  MODIFY `personel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `ceride`
--
ALTER TABLE `ceride`
  ADD CONSTRAINT `ceride_fk0` FOREIGN KEY (`olay_id`) REFERENCES `olaylar` (`olay_id`);

--
-- Tablo kısıtlamaları `gorevlendirmeler`
--
ALTER TABLE `gorevlendirmeler`
  ADD CONSTRAINT `gorevlendirmeler_fk0` FOREIGN KEY (`gorev_turu_id`) REFERENCES `gorevturu` (`gorev_turu_id`),
  ADD CONSTRAINT `gorevlendirmeler_fk1` FOREIGN KEY (`personel_id`) REFERENCES `personel` (`personel_id`);

--
-- Tablo kısıtlamaları `malzemetakip`
--
ALTER TABLE `malzemetakip`
  ADD CONSTRAINT `malzemeTakip_fk0` FOREIGN KEY (`tur_id`) REFERENCES `malzemetur` (`tur_id`),
  ADD CONSTRAINT `malzemeTakip_fk1` FOREIGN KEY (`personel_id`) REFERENCES `personel` (`personel_id`);

--
-- Tablo kısıtlamaları `olaylar`
--
ALTER TABLE `olaylar`
  ADD CONSTRAINT `olaylar_fk0` FOREIGN KEY (`olay_turu_id`) REFERENCES `olayturu` (`olay_turu_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
