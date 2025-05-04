-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 04 May 2025, 14:51:06
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `mobilya`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `adminler`
--

CREATE TABLE `adminler` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) NOT NULL,
  `sifre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `adminler`
--

INSERT INTO `adminler` (`id`, `kullanici_adi`, `sifre`) VALUES
(1, 'admin', '$2y$10$jDxvlrVXYKY2YaDcPuXEAefpUrMaeXyUHYsFd9zerqaSR7UTT0a/O');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mobilyalar`
--

CREATE TABLE `mobilyalar` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL,
  `fiyat` decimal(10,2) NOT NULL,
  `resim_yolu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `mobilyalar`
--

INSERT INTO `mobilyalar` (`id`, `isim`, `fiyat`, `resim_yolu`) VALUES
(1, 'Abajur', 439.99, 'abajur1.jpg'),
(2, 'L koltuk', 19999.99, 'L_koltuk.jpg'),
(3, 'TV sehpası', 4999.99, 'tv_sehpası.jpg'),
(5, 'Tekli Koltuk', 2599.99, 'tekli_koltuk.jpg'),
(6, 'Dolap', 8999.99, 'dolap.jpg'),
(7, 'L Masa', 5999.99, 'L_masa.jpg'),
(8, 'Bar Masası', 4599.99, 'bar_masası.jpg'),
(9, 'Ayakkabı Dolabı', 1899.99, 'ayakkabı_dolabı.jpg');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `adminler`
--
ALTER TABLE `adminler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `mobilyalar`
--
ALTER TABLE `mobilyalar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `adminler`
--
ALTER TABLE `adminler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `mobilyalar`
--
ALTER TABLE `mobilyalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
