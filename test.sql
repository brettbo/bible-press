SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kutsalkitap`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookID` char(2) NOT NULL COMMENT '2-digit string',
  `longName` tinytext NOT NULL,
  `shortName` varchar(50) DEFAULT NULL,
  `latinLongName` varchar(100) DEFAULT NULL,
  `latinShortName` varchar(50) DEFAULT NULL,
  `category` varchar(6) DEFAULT NULL,
  `categoryLabel` varchar(12) DEFAULT NULL,
  `chapterCount` smallint(4) DEFAULT NULL,
  `chapterLabel` varchar(10) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stores data about each book of the Bible';

--
-- Dumping data for table `books`
--

INSERT INTO `books` VALUES('01', 'YARATILIŞ', 'Yar.', 'Yaratiliş', 'GEN', NULL, NULL, 50, NULL, NULL);
INSERT INTO `books` VALUES('02', 'MISIR\'DAN ÇIKIŞ', 'Çık.', 'Misir\'dan Çikiş', 'EXO', NULL, NULL, 40, NULL, NULL);
INSERT INTO `books` VALUES('03', 'LEVİLİLER', 'Lev.', 'Levililer', 'LEV', NULL, NULL, 27, NULL, NULL);
INSERT INTO `books` VALUES('04', 'ÇÖLDE SAYIM', 'Say.', 'Çölde Sayim', 'NUM', NULL, NULL, 36, NULL, NULL);
INSERT INTO `books` VALUES('05', 'YASA\'NIN TEKRARI', 'Yas.', 'Yasa\'nin Tekrari', 'DEU', NULL, NULL, 34, NULL, NULL);
INSERT INTO `books` VALUES('06', 'YEŞU', 'Yşu.', 'Yeşu', 'JOS', NULL, NULL, 24, NULL, NULL);
INSERT INTO `books` VALUES('07', 'HÂKİMLER', 'Hâk.', 'Hâkimler', 'JDG', NULL, NULL, 21, NULL, NULL);
INSERT INTO `books` VALUES('08', 'RUT', 'Rut.', 'Rut', 'RUT', NULL, NULL, 4, NULL, NULL);
INSERT INTO `books` VALUES('09', '1.SAMUEL', '1Sa.', '1.Samuel', '1SA', NULL, NULL, 31, NULL, NULL);
INSERT INTO `books` VALUES('10', '2.SAMUEL', '2Sa.', '2.Samuel', '2SA', NULL, NULL, 24, NULL, NULL);
INSERT INTO `books` VALUES('11', '1.KRALLAR', '1Kr.', '1.Krallar', '1KI', NULL, NULL, 22, NULL, NULL);
INSERT INTO `books` VALUES('12', '2.KRALLAR', '2Kr.', '2.Krallar', '2KI', NULL, NULL, 25, NULL, NULL);
INSERT INTO `books` VALUES('13', '1.TARİHLER', '1Ta.', '1.Tarihler', '1CH', NULL, NULL, 29, NULL, NULL);
INSERT INTO `books` VALUES('14', '2.TARİHLER', '2Ta.', '2.Tarihler', '2CH', NULL, NULL, 36, NULL, NULL);
INSERT INTO `books` VALUES('15', 'EZRA', 'Ezr.', 'Ezra', 'EZR', NULL, NULL, 10, NULL, NULL);
INSERT INTO `books` VALUES('16', 'NEHEMYA', 'Neh.', 'Nehemya', 'NEH', NULL, NULL, 13, NULL, NULL);
INSERT INTO `books` VALUES('17', 'ESTER', 'Est.', 'Ester', 'EST', NULL, NULL, 10, NULL, NULL);
INSERT INTO `books` VALUES('18', 'EYÜP', 'Eyü.', 'Eyüp', 'JOB', NULL, NULL, 42, NULL, NULL);
INSERT INTO `books` VALUES('19', 'MEZMURLAR', 'Mez.', 'Mezmurlar', 'PSA', NULL, NULL, 150, NULL, NULL);
INSERT INTO `books` VALUES('20', 'SÜLEYMAN\'IN ÖZDEYİŞLERİ', 'Özd.', 'Süleyman\'in Özdeyişleri', 'PRO', NULL, NULL, 31, NULL, NULL);
INSERT INTO `books` VALUES('21', 'VAİZ', 'Vai.', 'Vaiz', 'ECC', NULL, NULL, 12, NULL, NULL);
INSERT INTO `books` VALUES('22', 'EZGİLER EZGİSİ', 'Ezg.', 'Ezgiler Ezgisi', 'SOS', NULL, NULL, 8, NULL, NULL);
INSERT INTO `books` VALUES('23', 'YEŞAYA', 'Yşa.', 'Yeşaya', 'ISA', NULL, NULL, 66, NULL, NULL);
INSERT INTO `books` VALUES('24', 'YEREMYA', 'Yer.', 'Yeremya', 'JER', NULL, NULL, 52, NULL, NULL);
INSERT INTO `books` VALUES('25', 'AĞITLAR', 'Ağı.', 'Ağitlar', 'LAM', NULL, NULL, 5, NULL, NULL);
INSERT INTO `books` VALUES('26', 'HEZEKİEL', 'Hez.', 'Hezekiel', 'EZE', NULL, NULL, 48, NULL, NULL);
INSERT INTO `books` VALUES('27', 'DANİEL', 'Dan.', 'Daniel', 'DAN', NULL, NULL, 12, NULL, NULL);
INSERT INTO `books` VALUES('28', 'HOŞEA', 'Hoş.', 'Hoşea', 'HOS', NULL, NULL, 14, NULL, NULL);
INSERT INTO `books` VALUES('29', 'YOEL', 'Yoe.', 'Yoel', 'JOE', NULL, NULL, 3, NULL, NULL);
INSERT INTO `books` VALUES('30', 'AMOS', 'Amo.', 'Amos', 'AMO', NULL, NULL, 9, NULL, NULL);
INSERT INTO `books` VALUES('31', 'OVADYA', 'Ova.', 'Ovadya', 'OBA', NULL, NULL, 1, NULL, NULL);
INSERT INTO `books` VALUES('32', 'YUNUS', 'Yun.', 'Yunus', 'JON', NULL, NULL, 4, NULL, NULL);
INSERT INTO `books` VALUES('33', 'MİKA', 'Mik.', 'Mika', 'MIC', NULL, NULL, 7, NULL, NULL);
INSERT INTO `books` VALUES('34', 'NAHUM', 'Nah.', 'Nahum', 'NAH', NULL, NULL, 3, NULL, NULL);
INSERT INTO `books` VALUES('35', 'HABAKKUK', 'Hab.', 'Habakkuk', 'HAB', NULL, NULL, 3, NULL, NULL);
INSERT INTO `books` VALUES('36', 'SEFANYA', 'Sef', 'Sefanya', 'ZEP', NULL, NULL, 3, NULL, NULL);
INSERT INTO `books` VALUES('37', 'HAGAY', 'Hag.', 'Hagay', 'HAG', NULL, NULL, 2, NULL, NULL);
INSERT INTO `books` VALUES('38', 'ZEKERİYA', 'Zek.', 'Zekeriya', 'ZEC', NULL, NULL, 14, NULL, NULL);
INSERT INTO `books` VALUES('39', 'MALAKİ', 'Mal.', 'Malaki', 'MAL', NULL, NULL, 4, NULL, NULL);
INSERT INTO `books` VALUES('40', 'MATTA', 'Mat.', 'Matta', 'MAT', NULL, NULL, 28, NULL, NULL);
INSERT INTO `books` VALUES('41', 'MARKOS', 'Mar.', 'Markos', 'MAR', NULL, NULL, 16, NULL, NULL);
INSERT INTO `books` VALUES('42', 'LUKA', 'Luk.', 'Luka', 'LUK', NULL, NULL, 24, NULL, NULL);
INSERT INTO `books` VALUES('43', 'YUHANNA', 'Yu.', 'Yuhanna', 'JOH', NULL, NULL, 21, NULL, NULL);
INSERT INTO `books` VALUES('44', 'ELÇİLERİN İŞLERİ', 'Elç.', 'Elçilerin İşleri', 'ACT', NULL, NULL, 28, NULL, NULL);
INSERT INTO `books` VALUES('45', 'Pavlus\'tan ROMALILAR\'A MEKTUP', 'Rom', 'Romalilar', 'ROM', NULL, NULL, 16, NULL, NULL);
INSERT INTO `books` VALUES('46', 'Pavlus\'tan KORİNTLİLER\'E BİRİNCİ MEKTUP', '1Ko.', '1.Korintliler', '1CO', NULL, NULL, 16, NULL, NULL);
INSERT INTO `books` VALUES('47', 'Pavlus\'tan KORİNTLİLER\'E İKİNCİ MEKTUP', '2Ko.', '2.Korintliler', '2CO', NULL, NULL, 13, NULL, NULL);
INSERT INTO `books` VALUES('48', 'Pavlus\'tan GALATYALILAR\'A MEKTUP', 'Gal.', 'Galatyalilar', 'GAL', NULL, NULL, 6, NULL, NULL);
INSERT INTO `books` VALUES('49', 'Pavlus\'tan EFESLİLER\'E MEKTUP', 'Ef.', 'Efesliler', 'EPH', NULL, NULL, 6, NULL, NULL);
INSERT INTO `books` VALUES('50', 'Pavlus\'tan FİLİPİLİLER\'E MEKTUP', 'Flp.', 'Filipililer', 'PHP', NULL, NULL, 4, NULL, NULL);
INSERT INTO `books` VALUES('51', 'Pavlus\'tan KOLOSELİLER\'E MEKTUP', 'Kol.', 'Koloseliler', 'COL', NULL, NULL, 4, NULL, NULL);
INSERT INTO `books` VALUES('52', 'Pavlus\'tan SELANİKLİLER\'E BİRİNCİ MEKTUP', '1Se.', '1.Selanikliler', '1TH', NULL, NULL, 5, NULL, NULL);
INSERT INTO `books` VALUES('53', 'Pavlus\'tan SELANİKLİLER\'E İKİNCİ MEKTUP', '2Se.', '2.Selanikliler', '2TH', NULL, NULL, 3, NULL, NULL);
INSERT INTO `books` VALUES('54', 'Pavlus\'tan TİMOTEOS\'A BİRİNCİ MEKTUP', '1Ti.', '1.Timoteos', '1TI', NULL, NULL, 6, NULL, NULL);
INSERT INTO `books` VALUES('55', 'Pavlus\'tan TİMOTEOS\'A İKİNCİ MEKTUP', '2Ti.', '2.Timoteos', '2TI', NULL, NULL, 4, NULL, NULL);
INSERT INTO `books` VALUES('56', 'Pavlus\'tan TİTUS\'A MEKTUP', 'Tit.', 'Titus', 'TIT', NULL, NULL, 3, NULL, NULL);
INSERT INTO `books` VALUES('57', 'Pavlus\'tan FİLİMON\'A MEKTUP', 'Flm.', 'Filimon', 'PHM', NULL, NULL, 1, NULL, NULL);
INSERT INTO `books` VALUES('58', 'İBRANİLER\'E MEKTUP', 'İbr.', 'İbraniler', 'HEB', NULL, NULL, 13, NULL, NULL);
INSERT INTO `books` VALUES('59', 'YAKUP\'UN MEKTUBU', 'Yak.', 'Yakup', 'JAM', NULL, NULL, 5, NULL, NULL);
INSERT INTO `books` VALUES('60', 'PETRUS\'UN BİRİNCİ MEKTUBU', '1Pe.', '1.Petrus', '1PE', NULL, NULL, 5, NULL, NULL);
INSERT INTO `books` VALUES('61', 'PETRUS\'UN İKİNCİ MEKTUBU', '2Pe.', '2.Petrus', '2PE', NULL, NULL, 3, NULL, NULL);
INSERT INTO `books` VALUES('62', 'YUHANNA\'NIN BİRİNCİ MEKTUBU', '1Yu.', '1.Yuhanna', '1JO', NULL, NULL, 5, NULL, NULL);
INSERT INTO `books` VALUES('63', 'YUHANNA\'NIN İKİNCİ MEKTUBU', '2Yu.', '2.Yuhanna', '2JO', NULL, NULL, 1, NULL, NULL);
INSERT INTO `books` VALUES('64', 'YUHANNA\'NIN ÜÇÜNCÜ MEKTUBU', '3Yu.', '3.Yuhanna', '3JO', NULL, NULL, 1, NULL, NULL);
INSERT INTO `books` VALUES('65', 'YAHUDA\'NIN MEKTUBU', 'Yah.', 'Yahuda', 'JDE', NULL, NULL, 1, NULL, NULL);
INSERT INTO `books` VALUES('66', 'VAHİY', 'Va.', 'Vahiy', 'REV', NULL, NULL, 22, NULL, NULL);

COMMIT;