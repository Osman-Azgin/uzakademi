-- phpMyAdmin SQL Dump
-- version 4.3.11.1
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 21 May 2015, 13:08:37
-- Sunucu sürümü: 5.6.23
-- PHP Sürümü: 5.6.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `neduzaka_uzakakademi17`
--

--
-- Tablo döküm verisi `ogrenciuye`
--

INSERT INTO `ogrenciuye` (`uyeid`, `yetki`, `brans`, `uyeadi`, `uyesoyadi`, `user`, `foto`, `pass`, `eposta`) VALUES
(1, 1, 'Bilişim', 'Osman', 'Azgin', 'OsmanAzgin', 'http://localhost/uzakademi.org/usersHOME/profileIMAGES/osman1.jpg', 'osmanmehmet', 'osman_83_3152@hotmail.com'),
(2, 0, '', 'Mehmet', 'Azgin', 'MehmetAzgin', 'asdada', 'memo115', 'memo@hm.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
