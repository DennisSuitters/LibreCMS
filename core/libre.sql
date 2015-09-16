-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 16, 2015 at 10:48 PM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `libre`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` bigint(20) unsigned NOT NULL,
  `iid` bigint(20) unsigned NOT NULL,
  `quantity` mediumint(20) unsigned NOT NULL,
  `cost` decimal(10,2) unsigned NOT NULL,
  `si` varchar(128) COLLATE utf8_bin NOT NULL,
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE IF NOT EXISTS `choices` (
  `id` bigint(20) unsigned NOT NULL,
  `uid` bigint(20) unsigned NOT NULL,
  `rid` bigint(20) unsigned NOT NULL,
  `contentType` varchar(16) COLLATE utf8_bin NOT NULL,
  `rank` int(4) unsigned NOT NULL,
  `icon` varchar(20) COLLATE utf8_bin NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `title` varchar(60) COLLATE utf8_bin NOT NULL,
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`id`, `uid`, `rid`, `contentType`, `rank`, `icon`, `url`, `title`, `ti`) VALUES
(1, 1, 1, 'social', 0, 'facebook', 'https://www.facebook.com/studiojunkyard', 'Facebook', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) unsigned NOT NULL,
  `contentType` varchar(16) COLLATE utf8_bin NOT NULL,
  `rid` bigint(20) unsigned NOT NULL,
  `uid` bigint(20) unsigned NOT NULL,
  `cid` bigint(20) unsigned NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `avatar` tinytext COLLATE utf8_bin NOT NULL,
  `gravatar` tinytext COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `name` varchar(40) COLLATE utf8_bin NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `status` varchar(16) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `tie` int(10) NOT NULL,
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` tinyint(1) unsigned NOT NULL,
  `options` varchar(32) COLLATE utf8_bin NOT NULL,
  `theme` varchar(16) COLLATE utf8_bin NOT NULL,
  `seoTitle` varchar(60) COLLATE utf8_bin NOT NULL,
  `seoDescription` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoCaption` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoKeywords` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoRSSTitle` tinytext COLLATE utf8_bin NOT NULL,
  `seoRSSNotes` text COLLATE utf8_bin NOT NULL,
  `seoRSSLink` varchar(256) COLLATE utf8_bin NOT NULL,
  `seoRSSAuthor` tinytext COLLATE utf8_bin NOT NULL,
  `seoRSSti` bigint(20) NOT NULL,
  `gaClientID` varchar(256) COLLATE utf8_bin NOT NULL,
  `business` varchar(40) COLLATE utf8_bin NOT NULL,
  `abn` varchar(32) COLLATE utf8_bin NOT NULL,
  `address` varchar(80) COLLATE utf8_bin NOT NULL,
  `suburb` varchar(40) COLLATE utf8_bin NOT NULL,
  `city` varchar(40) COLLATE utf8_bin NOT NULL,
  `state` varchar(40) COLLATE utf8_bin NOT NULL,
  `country` varchar(40) COLLATE utf8_bin NOT NULL,
  `postcode` mediumint(5) unsigned NOT NULL,
  `phone` varchar(14) COLLATE utf8_bin NOT NULL,
  `mobile` varchar(14) COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `vti` int(10) unsigned NOT NULL,
  `sti` int(10) unsigned NOT NULL,
  `dateFormat` varchar(64) COLLATE utf8_bin NOT NULL,
  `buttonType` varchar(8) COLLATE utf8_bin NOT NULL,
  `email_check` int(10) NOT NULL,
  `email_interval` int(10) NOT NULL,
  `language` varchar(8) COLLATE utf8_bin NOT NULL,
  `timezone` varchar(128) COLLATE utf8_bin NOT NULL,
  `orderPayti` int(10) unsigned NOT NULL,
  `orderEmailDefaultSubject` tinytext COLLATE utf8_bin NOT NULL,
  `orderEmailLayout` text COLLATE utf8_bin NOT NULL,
  `orderEmailNotes` text COLLATE utf8_bin NOT NULL,
  `bank` varchar(60) COLLATE utf8_bin NOT NULL,
  `bankAccountName` varchar(40) COLLATE utf8_bin NOT NULL,
  `bankAccountNumber` varchar(40) COLLATE utf8_bin NOT NULL,
  `bankBSB` varchar(16) COLLATE utf8_bin NOT NULL,
  `bankPayPal` varchar(60) COLLATE utf8_bin NOT NULL,
  `layoutAccounts` varchar(10) COLLATE utf8_bin NOT NULL,
  `layoutContent` varchar(10) COLLATE utf8_bin NOT NULL,
  `layoutBookings` varchar(10) COLLATE utf8_bin NOT NULL,
  `showItems` int(4) NOT NULL,
  `bti` int(10) unsigned NOT NULL,
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `options`, `theme`, `seoTitle`, `seoDescription`, `seoCaption`, `seoKeywords`, `seoRSSTitle`, `seoRSSNotes`, `seoRSSLink`, `seoRSSAuthor`, `seoRSSti`, `gaClientID`, `business`, `abn`, `address`, `suburb`, `city`, `state`, `country`, `postcode`, `phone`, `mobile`, `email`, `vti`, `sti`, `dateFormat`, `buttonType`, `email_check`, `email_interval`, `language`, `timezone`, `orderPayti`, `orderEmailDefaultSubject`, `orderEmailLayout`, `orderEmailNotes`, `bank`, `bankAccountName`, `bankAccountNumber`, `bankBSB`, `bankPayPal`, `layoutAccounts`, `layoutContent`, `layoutBookings`, `showItems`, `bti`, `ti`) VALUES
(1, '1111111100000000', 'default', 'LibreCMS', 'Default Site Description', 'Default Site Caption', 'Default Site Keywords', '', '', '', '', 1440940831, '', 'LibreCMS', '000 000 000', '', '', '', '', '', 0, '', '', 'info@studiojunkyard.com', 1406180963, 3600, 'M j, Y g:i A', 'icon', 1425893894, 3600, 'en', 'Australia/Hobart', 1209600, '{name}: Invoice: {order_number}', 'Hello {first},<br><br>Please find attached Order {order_number}<br>Note: {notes}', 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', '', '', '', '', '', 'cards', 'card', 'calendar', 20, 1404461417, 0);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` bigint(20) unsigned NOT NULL,
  `options` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT '00000000',
  `rank` int(4) NOT NULL,
  `rid` bigint(20) unsigned NOT NULL,
  `uid` bigint(20) unsigned NOT NULL,
  `login_user` varchar(128) COLLATE utf8_bin NOT NULL,
  `cid` bigint(20) unsigned NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `contentType` varchar(16) COLLATE utf8_bin NOT NULL,
  `schemaType` varchar(40) COLLATE utf8_bin NOT NULL,
  `keywords` varchar(255) COLLATE utf8_bin NOT NULL,
  `code` varchar(16) COLLATE utf8_bin NOT NULL,
  `brand` varchar(40) COLLATE utf8_bin NOT NULL,
  `title` varchar(60) COLLATE utf8_bin NOT NULL,
  `category_1` varchar(30) COLLATE utf8_bin NOT NULL,
  `category_2` varchar(30) COLLATE utf8_bin NOT NULL,
  `name` varchar(40) COLLATE utf8_bin NOT NULL,
  `url` varchar(256) COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `business` varchar(40) COLLATE utf8_bin NOT NULL,
  `address` varchar(80) COLLATE utf8_bin NOT NULL,
  `suburb` varchar(40) COLLATE utf8_bin NOT NULL,
  `city` varchar(40) COLLATE utf8_bin NOT NULL,
  `state` varchar(40) COLLATE utf8_bin NOT NULL,
  `postcode` mediumint(5) unsigned NOT NULL,
  `phone` varchar(14) COLLATE utf8_bin NOT NULL,
  `mobile` varchar(14) COLLATE utf8_bin NOT NULL,
  `thumb` varchar(128) COLLATE utf8_bin NOT NULL,
  `file` varchar(128) COLLATE utf8_bin NOT NULL,
  `fileURL` varchar(256) COLLATE utf8_bin NOT NULL,
  `attributionImageTitle` tinytext COLLATE utf8_bin NOT NULL,
  `attributionImageName` tinytext COLLATE utf8_bin NOT NULL,
  `attributionImageURL` varchar(256) COLLATE utf8_bin NOT NULL,
  `exifISO` varchar(4) COLLATE utf8_bin NOT NULL,
  `exifAperture` varchar(2) COLLATE utf8_bin NOT NULL,
  `exifFocalLength` varchar(8) COLLATE utf8_bin NOT NULL,
  `exifShutterSpeed` varchar(10) COLLATE utf8_bin NOT NULL,
  `exifCamera` tinytext COLLATE utf8_bin NOT NULL,
  `exifLens` tinytext COLLATE utf8_bin NOT NULL,
  `exifFilename` tinytext COLLATE utf8_bin NOT NULL,
  `exifti` int(10) NOT NULL,
  `cost` decimal(10,2) unsigned NOT NULL,
  `subject` varchar(60) COLLATE utf8_bin NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `attributionContentName` tinytext COLLATE utf8_bin NOT NULL,
  `attributionContentURL` varchar(256) COLLATE utf8_bin NOT NULL,
  `quantity` mediumint(20) unsigned NOT NULL,
  `tags` varchar(255) COLLATE utf8_bin NOT NULL,
  `caption` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` varchar(16) COLLATE utf8_bin NOT NULL,
  `service` bigint(20) unsigned NOT NULL,
  `internal` tinyint(1) unsigned NOT NULL,
  `featured` tinyint(1) unsigned NOT NULL,
  `bookable` tinyint(1) NOT NULL,
  `fti` int(10) unsigned NOT NULL,
  `assoc` varchar(128) COLLATE utf8_bin NOT NULL,
  `ord` bigint(20) unsigned NOT NULL,
  `views` bigint(20) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `pin` tinyint(1) NOT NULL,
  `tis` int(10) unsigned NOT NULL,
  `tie` int(10) unsigned NOT NULL,
  `lti` int(10) unsigned NOT NULL,
  `ti` int(10) unsigned NOT NULL,
  `eti` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `options`, `rank`, `rid`, `uid`, `login_user`, `cid`, `ip`, `contentType`, `schemaType`, `keywords`, `code`, `brand`, `title`, `category_1`, `category_2`, `name`, `url`, `email`, `business`, `address`, `suburb`, `city`, `state`, `postcode`, `phone`, `mobile`, `thumb`, `file`, `fileURL`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `exifISO`, `exifAperture`, `exifFocalLength`, `exifShutterSpeed`, `exifCamera`, `exifLens`, `exifFilename`, `exifti`, `cost`, `subject`, `notes`, `attributionContentName`, `attributionContentURL`, `quantity`, `tags`, `caption`, `status`, `service`, `internal`, `featured`, `bookable`, `fti`, `assoc`, `ord`, `views`, `active`, `pin`, `tis`, `tie`, `lti`, `ti`, `eti`) VALUES
(1, '01000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'blogPost', 'doctor who,game', '', '', 'The Long Game', 'Doctor Who', 'funny', '', '', '', '', '', '', '', '', 0, '', '', 'thumb_1.jpg', 'file_1.jpg', '', '', '', '', '', '', '', '', ' ', '', 'rainbow roland-1600.jpg', 0, 0.00, '', '<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<h2>The Parting of the Ways</h2>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels.</p>\r\n<h3>The Impossible Astronaut</h3>\r\n<p>Saving the world with meals on wheels. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<h4>The Beast Below</h4>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<h5>Voyage of the Damned</h5>\r\n<p>You''ve swallowed a planet! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', '', '', 0, 'doctor who,game', '', 'published', 0, 0, 1, 0, 0, '', 93, 0, 1, 0, 0, 1436975186, 0, 1429270672, 1441552137),
(2, '10000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'inventory', 'Product', '', '', '', 'Inventory', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 10.00, '', '<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<h2>The Parting of the Ways</h2>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels.</p>\r\n<h3>The Impossible Astronaut</h3>\r\n<p>Saving the world with meals on wheels. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<h4>The Beast Below</h4>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<h5>Voyage of the Damned</h5>\r\n<p>You''ve swallowed a planet! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 0, 1430371748, 1441886663),
(3, '10000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'service', '', '', '', '', 'Services 3', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 20.00, '', '<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<h2>The Parting of the Ways</h2>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels.</p>\r\n<h3>The Impossible Astronaut</h3>\r\n<p>Saving the world with meals on wheels. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<h4>The Beast Below</h4>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<h5>Voyage of the Damned</h5>\r\n<p>You''ve swallowed a planet! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', '', '', 0, '', '', 'unpublished', 0, 0, 0, 1, 0, '', 2, 0, 1, 0, 0, 0, 0, 1430371800, 1441552048),
(4, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'CreativeWork', '', '', '', 'Portfolio 4', 'Doctor Who', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 9, 0, 1, 0, 0, 0, 0, 1432698738, 1440854643),
(5, '00000000', 0, 0, 1, 'Kenika Suitters', 1, '', 'article', 'CreativeWork', '', '', '', 'Proofs 5', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1ds35359.jpg', 1431224195, 0.00, '', '', '', '', 0, '', '', 'unpublished', 0, 0, 0, 0, 0, '', 92, 0, 1, 0, 0, 0, 0, 1432698854, 1440854689),
(6, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'gallery', 'ImageGallery', '', '', '', 'Machu Picchu', 'Doctor Who', '', '', '', '', '', '', '', '', '', 0, '', '', 'thumb_6.jpg', 'file_6.jpg', 'https://download.unsplash.com/photo-1429547584745-d8bec594c82e', 'Machu Picchu', 'John Kutcher', 'https://unsplash.com/jmkutcher', '', '', '', '', '', '', '', 0, 0.00, '', '', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 11, 0, 1, 0, 0, 0, 0, 1432706432, 1441085845),
(7, '01000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'event', 'Event', '', '', '', 'Events 7', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 0, 1432789439, 1432789446),
(8, '00000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'news', 'NewsArticle', '', '', '', 'News 8', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 0, 1432789481, 1432789486);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` bigint(20) unsigned NOT NULL,
  `options` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT '00000000',
  `username` varchar(128) COLLATE utf8_bin NOT NULL,
  `password` varchar(256) COLLATE utf8_bin NOT NULL,
  `cover` varchar(60) COLLATE utf8_bin NOT NULL,
  `coverURL` varchar(256) COLLATE utf8_bin NOT NULL,
  `attributionImageTitle` tinytext COLLATE utf8_bin NOT NULL,
  `attributionImageName` tinytext COLLATE utf8_bin NOT NULL,
  `attributionImageURL` varchar(256) COLLATE utf8_bin NOT NULL,
  `avatar` varchar(60) COLLATE utf8_bin NOT NULL,
  `gravatar` varchar(256) COLLATE utf8_bin NOT NULL,
  `business` varchar(40) COLLATE utf8_bin NOT NULL,
  `name` varchar(40) COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `emailPassword` tinytext COLLATE utf8_bin NOT NULL,
  `email_check` int(10) NOT NULL,
  `url` varchar(256) COLLATE utf8_bin NOT NULL,
  `address` varchar(80) COLLATE utf8_bin NOT NULL,
  `suburb` varchar(40) COLLATE utf8_bin NOT NULL,
  `city` varchar(40) COLLATE utf8_bin NOT NULL,
  `state` varchar(40) COLLATE utf8_bin NOT NULL,
  `postcode` mediumint(5) unsigned NOT NULL,
  `abn` varchar(32) COLLATE utf8_bin NOT NULL,
  `phone` varchar(14) COLLATE utf8_bin NOT NULL,
  `mobile` varchar(14) COLLATE utf8_bin NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `status` varchar(16) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `activate` varchar(255) COLLATE utf8_bin NOT NULL,
  `adminCategory_1` varchar(30) COLLATE utf8_bin NOT NULL,
  `adminCategory_2` varchar(30) COLLATE utf8_bin NOT NULL,
  `adminCategory_ti` int(10) unsigned NOT NULL,
  `language` varchar(8) COLLATE utf8_bin NOT NULL,
  `timezone` varchar(128) COLLATE utf8_bin NOT NULL,
  `rank` int(4) unsigned NOT NULL,
  `discount` varchar(4) COLLATE utf8_bin NOT NULL,
  `lti` int(10) NOT NULL,
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `options`, `username`, `password`, `cover`, `coverURL`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `avatar`, `gravatar`, `business`, `name`, `email`, `emailPassword`, `email_check`, `url`, `address`, `suburb`, `city`, `state`, `postcode`, `abn`, `phone`, `mobile`, `notes`, `status`, `active`, `activate`, `adminCategory_1`, `adminCategory_2`, `adminCategory_ti`, `language`, `timezone`, `rank`, `discount`, `lti`, `ti`) VALUES
(1, '11111111', 'admin', '$2y$10$cb/MtTJA/9L5HxQE6G8WLO18Ye7AWTCWIy9ql1xa12BmvMpySFNSS', 'cover_1.jpg', '', '', 'rebecca johnston', 'https://unsplash.com/rebecca_jane', 'avatar_1.jpg', '', 'Studio Junkyard', 'Kenika Suitters', 'dennis@studiojunkyard.com', '', 0, '', '', '', '', '', 0, '', '', '', '', 'unpublished', 1, '', '', '', 0, 'en', 'Australia/Hobart', 1000, '', 0, 1402746479);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `rid` bigint(20) NOT NULL,
  `view` varchar(16) COLLATE utf8_bin NOT NULL,
  `contentType` varchar(16) COLLATE utf8_bin NOT NULL,
  `refTable` varchar(16) COLLATE utf8_bin NOT NULL,
  `refColumn` varchar(16) COLLATE utf8_bin NOT NULL,
  `oldda` longblob NOT NULL,
  `newda` longblob NOT NULL,
  `action` tinytext COLLATE utf8_bin NOT NULL,
  `ti` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  `eti` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `uid`, `login_user`, `title`, `seoTitle`, `cover`, `coverURL`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `contentType`, `schemaType`, `seoKeywords`, `seoDescription`, `seoCaption`, `menu`, `notes`, `ord`, `active`, `eti`) VALUES
(1, 1, 'Kenika Suitters', 'Home', '', 'page_cover_1.jpg', '', '', '', '', 'index', '', '', '', '', 'head', '', 0, 1, 1442403238),
(2, 1, 'Kenika Suitters', 'Blog', '', '', '', '', '', '', 'article', '', '', '', '', 'head', '', 7, 1, 1442403238),
(3, 1, 'Kenika Suitters', 'Portfolio', '', '', '', '', '', '', 'portfolio', '', '', '', '', 'head', '', 10, 1, 1442403238),
(4, 1, 'Kenika Suitters', 'Bookings', '', '', '', '', '', '', 'bookings', '', '', '', '', 'head', '', 11, 1, 1442403238),
(5, 1, 'Kenika Suitters', 'Events', '', '', '', '', '', '', 'event', '', '', '', '', 'head', '', 9, 1, 1442403238),
(6, 1, 'Kenika Suitters', 'News', '', '', '', '', '', '', 'news', '', '', '', '', 'head', '', 8, 1, 1442403238),
(7, 1, 'Kenika Suitters', 'Testimonials', '', '', '', '', '', '', 'testimonial', '', '', '', '', 'head', '', 6, 1, 1442403238),
(8, 1, 'Kenika Suitters', 'Inventory', '', '', '', '', '', '', 'inventory', '', '', '', '', 'head', '', 3, 1, 1442403238),
(9, 1, 'Kenika Suitters', 'Services', '', '', '', '', '', '', 'service', '', '', '', '', 'head', '', 1, 1, 1442403238),
(10, 1, 'Kenika Suitters', 'Gallery', '', '', '', '', '', '', 'gallery', '', '', '', '', 'head', '', 2, 1, 1442403238),
(11, 1, 'Kenika Suitters', 'Contact', '', '', '', '', '', '', 'contactus', '', '', '', '', 'head', '', 4, 1, 1442403238),
(12, 1, 'Kenika Suitters', 'Cart', '', '', '', '', '', '', 'cart', '', '', '', '', 'head', '', 5, 1, 1442403238),
(13, 1, 'Kenika Suitters', 'Terms of Service', 'Terms of Service', '', '', '', '', '', 'tos', '', '', '', '', 'footer', '', 13, 1, 1442403238),
(14, 1, 'Kenika Suitters', 'Search', 'Search', '', '', '', '', '', 'search', '', '', '', '', 'footer', '', 12, 1, 1442403238);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `mid` text COLLATE utf8_bin NOT NULL,
  `rmid` bigint(20) NOT NULL,
  `folder` varchar(16) COLLATE utf8_bin NOT NULL,
  `to_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `to_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `from_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `from_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `subject` tinytext COLLATE utf8_bin NOT NULL,
  `status` tinytext COLLATE utf8_bin NOT NULL,
  `starred` int(1) NOT NULL,
  `important` int(1) NOT NULL,
  `notes_raw` text COLLATE utf8_bin NOT NULL,
  `notes_raw_mime` tinytext COLLATE utf8_bin NOT NULL,
  `notes_html` text COLLATE utf8_bin NOT NULL,
  `notes_html_mime` tinytext COLLATE utf8_bin NOT NULL,
  `attachments` text COLLATE utf8_bin NOT NULL,
  `email_date` int(10) NOT NULL,
  `size` bigint(20) NOT NULL,
  `ti` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE IF NOT EXISTS `orderitems` (
  `id` bigint(20) NOT NULL,
  `oid` bigint(20) unsigned NOT NULL,
  `iid` bigint(20) unsigned NOT NULL,
  `title` varchar(60) COLLATE utf8_bin NOT NULL,
  `quantity` mediumint(9) unsigned NOT NULL,
  `cost` decimal(10,2) unsigned NOT NULL,
  `status` varchar(16) COLLATE utf8_bin NOT NULL,
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) NOT NULL,
  `cid` bigint(20) unsigned NOT NULL,
  `uid` bigint(20) unsigned NOT NULL,
  `contentType` varchar(16) COLLATE utf8_bin NOT NULL,
  `qid` varchar(20) COLLATE utf8_bin NOT NULL,
  `qid_ti` int(10) unsigned NOT NULL,
  `iid` varchar(20) COLLATE utf8_bin NOT NULL,
  `iid_ti` int(10) unsigned NOT NULL,
  `did` varchar(20) COLLATE utf8_bin NOT NULL,
  `did_ti` int(10) unsigned NOT NULL,
  `aid` varchar(20) COLLATE utf8_bin NOT NULL,
  `aid_ti` int(10) unsigned NOT NULL,
  `due_ti` int(10) unsigned NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `status` varchar(16) COLLATE utf8_bin NOT NULL,
  `recurring` tinyint(1) unsigned NOT NULL,
  `ti` int(10) unsigned NOT NULL,
  `eti` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `id` bigint(20) unsigned NOT NULL,
  `search` varchar(64) COLLATE utf8_bin NOT NULL,
  `views` bigint(20) unsigned NOT NULL,
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `seo`
--

CREATE TABLE IF NOT EXISTS `seo` (
  `id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `login_user` varchar(128) COLLATE utf8_bin NOT NULL,
  `seo_name` varchar(128) COLLATE utf8_bin NOT NULL,
  `seo_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `seo_title` tinytext COLLATE utf8_bin NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `eti` int(10) NOT NULL,
  `views` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `seo`
--

INSERT INTO `seo` (`id`, `uid`, `login_user`, `seo_name`, `seo_url`, `seo_title`, `notes`, `eti`, `views`) VALUES
(1, 1, '', '', '', 'Title', 'This is some notes on Title''s for SEO', 0, 0),
(2, 1, '', '', '', 'Schema Type', 'LibreCMS chooses the appropriate SchemaType when adding Content as defined by <a target="_blank" href="http://www.schema.org/">www.schema.org</a>.', 0, 0),
(3, 1, '', '', '', 'Author', 'Author in SEO', 0, 0),
(4, 1, '', '', '', 'Images', 'Images for SEO', 0, 0),
(5, 1, '', '', '', 'Categories', 'Categories and SEO', 0, 0),
(6, 1, '', '', '', 'Keywords', 'Keywords and SEO', 0, 0),
(7, 1, '', '', '', 'Tags', 'Tags and SEO', 0, 0),
(8, 1, '', '', '', 'Caption', 'Captions and SEO', 0, 0),
(9, 1, '', '', '', 'Comments', 'Comments and SEO', 0, 0),
(10, 1, '', '', '', 'Notes', 'Notes and SEO', 0, 0),
(11, 1, '', '', '', 'SEO Title', 'Notes for SEO Title', 0, 0),
(12, 1, '', '', '', 'SEO Caption', 'Notes for SEO Caption', 0, 0),
(13, 1, '', '', '', 'SEO Description', 'Notes for SEO Description', 0, 0),
(14, 1, '', '', '', 'SEO Keywords', 'Notes for SEO Keywords', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tracker`
--

CREATE TABLE IF NOT EXISTS `tracker` (
  `id` bigint(20) NOT NULL,
  `vid` bigint(20) NOT NULL,
  `contentType` tinytext COLLATE utf8_bin NOT NULL,
  `ip` text COLLATE utf8_bin NOT NULL,
  `pageName` text COLLATE utf8_bin NOT NULL,
  `queryString` text COLLATE utf8_bin NOT NULL,
  `hostname` text COLLATE utf8_bin NOT NULL,
  `httpReferer` text COLLATE utf8_bin NOT NULL,
  `httpUserAgent` text COLLATE utf8_bin NOT NULL,
  `bot` tinytext COLLATE utf8_bin NOT NULL,
  `browser` tinytext COLLATE utf8_bin NOT NULL,
  `os` tinytext COLLATE utf8_bin NOT NULL,
  `ti` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `search`
--
ALTER TABLE `search`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seo`
--
ALTER TABLE `seo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracker`
--
ALTER TABLE `tracker`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `search`
--
ALTER TABLE `search`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `seo`
--
ALTER TABLE `seo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `tracker`
--
ALTER TABLE `tracker`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;