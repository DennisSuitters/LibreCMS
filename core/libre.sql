-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2016 at 06:28 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `libre`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` bigint(20) unsigned NOT NULL,
  `uid` bigint(20) NOT NULL,
  `login_user` varchar(128) COLLATE utf8_bin NOT NULL,
  `title` varchar(60) COLLATE utf8_bin NOT NULL,
  `seoTitle` varchar(60) COLLATE utf8_bin NOT NULL,
  `file` tinytext COLLATE utf8_bin NOT NULL,
  `cover` varchar(128) COLLATE utf8_bin NOT NULL,
  `coverURL` varchar(256) COLLATE utf8_bin NOT NULL,
  `attributionImageTitle` tinytext COLLATE utf8_bin NOT NULL,
  `attributionImageName` tinytext COLLATE utf8_bin NOT NULL,
  `attributionImageURL` varchar(256) COLLATE utf8_bin NOT NULL,
  `contentType` varchar(16) COLLATE utf8_bin NOT NULL,
  `schemaType` varchar(40) COLLATE utf8_bin NOT NULL,
  `seoKeywords` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoDescription` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoCaption` varchar(255) COLLATE utf8_bin NOT NULL,
  `menu` varchar(16) COLLATE utf8_bin NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `ord` bigint(20) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `views` bigint(20) NOT NULL,
  `eti` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `uid`, `login_user`, `title`, `seoTitle`, `file`, `cover`, `coverURL`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `contentType`, `schemaType`, `seoKeywords`, `seoDescription`, `seoCaption`, `menu`, `notes`, `ord`, `active`, `views`, `eti`) VALUES
(1, 1, 'root', 'Home', '', '', '', '', '', '', '', 'index', '', '', '', '', 'head', '', 0, 1, 0, 0),
(2, 1, 'Kenika Suitters', 'Blog', '', 'article', '', '', '', '', '', 'article', '', '', '', '', 'head', '', 5, 1, 0, 0),
(3, 1, 'Kenika Suitters', 'Portfolio', '', 'portfolio', '', '', '', '', '', 'portfolio', '', '', '', '', 'head', '', 8, 0, 0, 0),
(4, 1, 'Kenika Suitters', 'Bookings', '', 'bookings', '', '', '', '', '', 'bookings', '', '', '', '', 'head', '', 9, 1, 0, 0),
(5, 1, 'Kenika Suitters', 'Events', '', 'events', '', '', '', '', '', 'event', '', '', '', '', 'head', '', 7, 0, 0, 0),
(6, 1, 'Kenika Suitters', 'News', '', 'news', '', '', '', '', '', 'news', '', '', '', '', 'head', '', 6, 0, 0, 0),
(7, 1, 'Kenika Suitters', 'Testimonials', '', 'testimonials', '', '', '', '', '', 'testimonial', '', '', '', '', 'head', '', 4, 1, 0, 0),
(8, 1, 'Kenika Suitters', 'Inventory', '', 'inventory', '', '', '', '', '', 'inventory', '', '', '', '', 'head', '', 3, 0, 0, 0),
(9, 1, 'root', 'Services', '', 'services', '', '', '', '', '', 'service', '', '', '', '', 'head', '', 2, 1, 0, 0),
(10, 1, 'Kenika Suitters', 'Gallery', '', 'gallery', '', '', '', '', '', 'gallery', '', '', '', '', 'head', '', 1, 0, 0, 0),
(11, 1, 'root', 'Contact', '', 'contactus', '', '', '', '', '', 'contactus', '', '', '', '', 'head', '', 10, 1, 0, 0),
(12, 1, 'Kenika Suitters', 'Cart', '', 'cart', '', '', '', '', '', 'cart', '', '', '', '', 'head', '', 11, 0, 0, 0),
(13, 1, 'Kenika Suitters', 'Terms of Service', '', 'tos', '', '', '', '', '', 'tos', '', '', '', '', 'footer', '', 13, 0, 0, 0),
(14, 1, 'Kenika Suitters', 'Search', '', 'search', '', '', '', '', '', 'search', '', '', '', '', 'footer', '', 12, 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
