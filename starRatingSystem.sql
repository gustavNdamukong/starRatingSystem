-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Gegenereerd op: 14 aug 2020 om 14:55
-- Serverversie: 5.7.26
-- PHP-versie: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `starRatingSystem`
--
CREATE DATABASE IF NOT EXISTS `starRatingSystem` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `starRatingSystem`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_description` text NOT NULL,
  `product_date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_description`, `product_date_created`, `product_date_updated`) VALUES
(1, 'Rolex watch', 'Superb product from Switzerland', '2020-07-01 12:21:11', '2020-07-01 12:21:11'),
(2, 'Tennis shoes', 'Ideal for outdoors and running', '2020-07-01 12:21:11', '2020-07-01 12:21:11');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ratings`
--

CREATE TABLE `ratings` (
  `ratings_id` int(11) NOT NULL,
  `ratings_client_name` varchar(200) NOT NULL,
  `ratings_rating` int(10) NOT NULL,
  `ratings_comment` text NOT NULL,
  `products_id` int(10) NOT NULL,
  `ratings_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `ratings`
--

INSERT INTO `ratings` (`ratings_id`, `ratings_client_name`, `ratings_rating`, `ratings_comment`, `products_id`, `ratings_date`) VALUES
(3, 'Gustav', 4, 'Test Score rating', 1, '2020-06-30 13:51:13'),
(4, 'John', 5, 'Good product', 1, '2020-07-01 09:17:46'),
(5, 'Peter', 2, 'A rating of two', 1, '2020-07-01 11:07:05'),
(6, 'Kim', 3, 'Rating score of three', 1, '2020-07-01 11:15:40'),
(7, 'Henry', 3, 'Not too bad.', 2, '2020-07-01 12:27:27'),
(8, 'Kingsley', 4, 'Pretty satisfied with it', 2, '2020-08-02 10:32:47'),
(9, 'Long', 4, 'Nice', 2, '2020-08-02 10:33:38'),
(10, 'Long Doe', 4, 'Sweet', 2, '2020-08-02 10:34:23'),
(11, 'Susan Doe', 4, 'Neat product', 2, '2020-08-02 10:35:12');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexen voor tabel `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`ratings_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `ratings`
--
ALTER TABLE `ratings`
  MODIFY `ratings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
