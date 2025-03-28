-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 02 Eki 2024, 22:48:52
-- Sunucu sürümü: 5.7.44-cll-lve
-- PHP Sürümü: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `aretemuhendislik_main`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sitestock`
--

CREATE TABLE `sitestock` (
  `id` int(11) NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  `stock_name` text,
  `stock_in` decimal(10,2) DEFAULT NULL,
  `stock_out` decimal(10,2) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `exit_date` date DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `createdAt` date DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `transfer` int(11) NOT NULL,
  `site_from` int(11) NOT NULL,
  `connection` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Tablo döküm verisi `sitestock`
--

INSERT INTO `sitestock` (`id`, `site_id`, `stock_name`, `stock_in`, `stock_out`, `unit`, `notes`, `arrival_date`, `exit_date`, `parent_id`, `createdAt`, `createdBy`, `transfer`, `site_from`, `connection`) VALUES
(131, 5, 'Konteyner 3x7', 1.00, NULL, 'adet', 'Mavi Renk Boş Konteyner. Satın alındı.', '2024-08-27', NULL, NULL, '2024-09-03', 1, 0, 0, 0),
(132, 5, 'Yemekhane Çadırı 4 x 6', 1.00, NULL, 'adet', 'Yemekhane ve sosyal alan için tedarik edildi.', '2024-08-03', NULL, NULL, '2024-09-03', 1, 0, 0, 0),
(133, 5, 'WC+Duş Kabini', 1.00, NULL, 'adet', 'Kütüphane şantiyesinden sökülerek getirildi', '2024-08-29', NULL, NULL, '2024-09-03', 1, 0, 0, 0),
(134, 5, 'Kl pro tork ', 1.00, NULL, 'Adet', 'Kütüphane şantiyesinden gelen', '2024-08-30', NULL, NULL, '2024-09-03', 7, 0, 0, 0),
(136, 5, 'Ara Kablosu 50mt', 4.00, NULL, 'Adet', 'Kalıpçı ekibine teslim edildi', '2024-08-30', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(137, 5, 'Ranza', 6.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(138, 5, 'Yatak', 13.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(139, 5, 'Nevresim Takımı (Battaniye ve yastık dahil)', 13.00, NULL, 'Takım', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(140, 5, 'Plastik Masa', 2.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(141, 5, 'Plastik Sandayle', 12.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(142, 5, 'Plastik Tabure', 2.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(143, 5, 'Panel Isıtıcı', 1.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(144, 5, 'Elektrikli Isıtıcı', 1.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(145, 5, 'Fanlı Isıtıcı', 1.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(146, 5, 'Elektrikli Isıtıcı', 4.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(147, 5, 'Mini Fırın', 1.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(148, 5, 'Çay Ocağı', 1.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(149, 5, 'Çiroz (Kilit)', 421.00, NULL, 'Adet', 'Buhara Baharat şantiyesinden geldi', '2024-09-01', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(150, 5, 'Çamaşır Makinası', 1.00, NULL, 'Adet', 'Satın alındı', '2024-09-03', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(151, 5, 'Buzdolabı', 1.00, NULL, 'Adet', 'Satın alındı', '2024-09-03', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(152, 5, 'Demlik', 2.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-29', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(153, 5, 'Banyo Konteyner', 1.00, NULL, 'Adet', 'Satın alındı', '2024-09-03', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(154, 5, 'Beton Vibratörü', 1.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-20', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(155, 5, 'Handset Alpha (30*100)', 1.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-20', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(156, 5, 'Handset Alpha (90*100)', 1.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-20', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(157, 5, 'Handset Alpha (30*120)', 4.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-20', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(158, 5, 'Handset Alpha (90*100)', 1.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-09-19', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(159, 5, 'Handset Alpha (60*120)', 17.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-20', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(160, 5, 'Handset Alpha (90*120)', 2.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-20', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(161, 5, 'Handset Alpha (30*300)', 4.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-20', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(162, 5, 'Handset Alpha (60*300)', 40.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-20', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(163, 5, 'Handset Alpha (90*300)', 36.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-20', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(164, 5, 'Handset Alpha (Köşe)', 5.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-08-20', NULL, NULL, '2024-09-05', 7, 0, 0, 0),
(165, 5, 'Süpürge/Faraş', 1.00, NULL, 'Takım', 'Satın alındı', '2024-09-06', NULL, NULL, '2024-09-06', 7, 0, 0, 0),
(166, 5, 'Bez Halat', 2.00, NULL, 'Adet', '1 tonluk 3 metre ', '2024-09-06', NULL, NULL, '2024-09-06', 7, 0, 0, 0),
(167, 5, 'Elektrikli Şofben ', 1.00, NULL, 'Adet', 'Satın alındı ', '2024-09-07', NULL, NULL, '2024-09-08', 7, 0, 0, 0),
(168, 5, 'Beton Vibratörü', 1.00, NULL, 'Adet', 'Satın alındı', '2024-09-09', NULL, NULL, '2024-09-09', 7, 0, 0, 0),
(169, 5, '10x10 Kereste 3M', 10.00, NULL, 'M³', 'Acarkondan yeni temin edildi ', '2024-09-10', NULL, NULL, '2024-09-11', 1, 0, 0, 0),
(170, 5, '10x10 Kereste 2M', 2.00, NULL, 'M³', 'Acarkondan yeni temin edildi', '2024-09-10', NULL, NULL, '2024-09-11', 1, 0, 0, 0),
(171, 5, '5x10 Kavak 3m ', 3.00, NULL, 'M³', 'Acarkondan temin edildi', '2024-09-10', NULL, NULL, '2024-09-11', 1, 0, 0, 0),
(172, 5, 'Epoksi Tabancası', 1.00, NULL, 'Adet', 'Demirciden gelen', '2024-09-11', NULL, NULL, '2024-09-11', 7, 0, 0, 0),
(173, 5, '120L Çöp Kovası', 1.00, NULL, 'Adet', 'Satın Alındı', '2024-09-11', NULL, NULL, '2024-09-11', 7, 0, 0, 0),
(174, 5, 'Epoksi Tabancası', 1.00, NULL, 'Adet', 'Kütüphane şantiyesinden geldi', '2024-09-12', NULL, NULL, '2024-09-12', 7, 0, 0, 0),
(175, 5, NULL, NULL, 1.00, NULL, 'Kütüphaneye gönderildi', NULL, '2024-09-17', 174, '2024-09-17', 7, 0, 0, 0),
(176, 5, NULL, NULL, 335.00, NULL, 'Meram Yakaya gönderildi.', NULL, '2024-09-24', 149, '2024-09-24', 7, 0, 0, 0),
(177, 5, 'Nevresim Takımı (Samsunlu Ekip) ', 12.00, NULL, 'Adet', 'Satın alındı', '2024-09-10', NULL, NULL, '2024-09-24', 7, 0, 0, 0),
(178, 5, 'Yastık (Samsunlu Ekip)', 4.00, NULL, 'Adet', 'Satın alındı', '2024-09-24', NULL, NULL, '2024-09-24', 7, 0, 0, 0),
(179, 5, 'Transpalet ', 1.00, NULL, 'Adet', 'Kütüphane şantiyesinden gelen', '2024-10-04', NULL, NULL, '2024-09-28', 7, 0, 0, 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `sitestock`
--
ALTER TABLE `sitestock`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `sitestock`
--
ALTER TABLE `sitestock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
