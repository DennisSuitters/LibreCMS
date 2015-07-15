-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 15, 2015 at 04:47 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
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
  `bti` int(10) unsigned NOT NULL,
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `options`, `theme`, `seoTitle`, `seoDescription`, `seoCaption`, `seoKeywords`, `seoRSSTitle`, `seoRSSNotes`, `seoRSSLink`, `seoRSSAuthor`, `seoRSSti`, `gaClientID`, `business`, `abn`, `address`, `suburb`, `city`, `state`, `country`, `postcode`, `phone`, `mobile`, `email`, `vti`, `sti`, `dateFormat`, `buttonType`, `email_check`, `email_interval`, `language`, `timezone`, `orderPayti`, `orderEmailDefaultSubject`, `orderEmailLayout`, `orderEmailNotes`, `bank`, `bankAccountName`, `bankAccountNumber`, `bankBSB`, `bankPayPal`, `layoutAccounts`, `layoutContent`, `layoutBookings`, `bti`, `ti`) VALUES
(1, '1111111100000000', 'default', 'LibreCMS', 'Default Site Description', 'Default Site Caption', 'Default Site Keywords', 'My new copywriting podcast', '<p>Iâ€™m super excited to announce my new copywriting podcas [&#8230;]</p>\n<p>The post <a rel="nofollow" href="https://www.katetooncopywriter.com.au/the-hot-copy-copywriting-podcast/">My new copywriting podcast</a> appeared first on <a rel="nofollow" href="https://www.katetooncopywriter.com.au">Kate Toon Copywriter</a>.</p>\n', 'https://www.katetooncopywriter.com.au/the-hot-copy-copywriting-podcast/', 'katetoon', 1436973216, '', 'LibreCMS', '000 000 000', '', '', '', '', '', 0, '', '', 'info@studiojunkyard.com', 1406180963, 3600, 'M j, Y g:i A', 'icon', 1425893894, 3600, 'en', 'Australia/Hobart', 1209600, '{name}: Invoice: {order_number}', 'Hello {first},<br><br>Please find attached Order {order_number}<br>Note: {notes}', 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', '', '', '', '', '', 'cards', 'cards', 'calendar', 1404461417, 0);

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
  `thumb` varchar(128) COLLATE utf8_bin NOT NULL,
  `file` varchar(128) COLLATE utf8_bin NOT NULL,
  `fileURL` varchar(256) COLLATE utf8_bin NOT NULL,
  `attributionImageTitle` tinytext COLLATE utf8_bin NOT NULL,
  `attributionImageName` tinytext COLLATE utf8_bin NOT NULL,
  `attributionImageURL` varchar(256) COLLATE utf8_bin NOT NULL,
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
  `tis` int(10) unsigned NOT NULL,
  `tie` int(10) unsigned NOT NULL,
  `lti` int(10) unsigned NOT NULL,
  `ti` int(10) unsigned NOT NULL,
  `eti` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `options`, `rank`, `rid`, `uid`, `login_user`, `cid`, `ip`, `contentType`, `schemaType`, `keywords`, `code`, `brand`, `title`, `category_1`, `category_2`, `name`, `url`, `email`, `business`, `address`, `suburb`, `city`, `state`, `postcode`, `phone`, `thumb`, `file`, `fileURL`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `cost`, `subject`, `notes`, `attributionContentName`, `attributionContentURL`, `quantity`, `tags`, `caption`, `status`, `service`, `internal`, `featured`, `bookable`, `fti`, `assoc`, `ord`, `views`, `active`, `tis`, `tie`, `lti`, `ti`, `eti`) VALUES
(1, '01000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'article', 'blogPost', 'doctor who,game', '', '', 'The Long Game', 'Doctor Who', 'funny', '', '', '', '', '', '', '', '', 0, '', '', '', 'https://download.unsplash.com/photo-1433838552652-f9a46b332c40', 'test', 'Daniela Cuevas', 'https://unsplash.com/danielacuevas', 0.00, '', '<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<h2>The Parting of the Ways</h2>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels.</p>\r\n<h3>The Impossible Astronaut</h3>\r\n<p>Saving the world with meals on wheels. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<h4>The Beast Below</h4>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<h5>Voyage of the Damned</h5>\r\n<p>You''ve swallowed a planet! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', '', '', 0, 'doctor who,game', '', 'published', 0, 0, 1, 0, 0, '', 17, 0, 1, 0, 0, 0, 1429270672, 1436886907),
(2, '10000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'article', 'Product', '', '', '', 'Inventory 2', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 'https://download.unsplash.com/photo-1429308755210-25a272addeb3', '', 'Demi DeHerrera', 'https://unsplash.com/demidearest', 10.00, '', '<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<h2>The Parting of the Ways</h2>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels.</p>\r\n<h3>The Impossible Astronaut</h3>\r\n<p>Saving the world with meals on wheels. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<h4>The Beast Below</h4>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<h5>Voyage of the Damned</h5>\r\n<p>You''ve swallowed a planet! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 1430371748, 1436624549),
(3, '10000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'article', '', '', '', '', 'Services 3', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_3.jpg', 'file_3.jpg', 'https://download.unsplash.com/photo-1430866880825-336a7d7814eb', '', 'Damir Kotoric', 'https://unsplash.com/damirkotoric', 20.00, '', '<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<h2>The Parting of the Ways</h2>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels.</p>\r\n<h3>The Impossible Astronaut</h3>\r\n<p>Saving the world with meals on wheels. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<h4>The Beast Below</h4>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<h5>Voyage of the Damned</h5>\r\n<p>You''ve swallowed a planet! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 1, 0, '', 2, 0, 1, 0, 0, 0, 1430371800, 1436624805),
(4, '00000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'article', 'CreativeWork', '', '', '', 'Portfolio 4', 'Doctor Who', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_4.jpg', 'file_4.jpg', 'https://download.unsplash.com/photo-1429547584745-d8bec594c82e', '', 'John Kutcher', 'https://unsplash.com/jmkutcher', 0.00, '', '', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 9, 0, 1, 0, 0, 0, 1432698738, 1436628148),
(5, '00000000', 0, 0, 1, 'Dennis J Suitters', 1, '', 'proofs', 'CreativeWork', '', '', '', 'Proofs 5', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_5.jpg', 'file_5.jpg', '', '', '', '', 0.00, '', '', '', '', 0, '', '', 'unpublished', 0, 0, 0, 0, 0, '', 10, 0, 1, 0, 0, 0, 1432698854, 1432698932),
(6, '00000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'gallery', 'ImageGallery', '', '', '', 'Machu Picchu', 'Doctor Who', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_6.jpg', 'file_6.jpg', 'https://download.unsplash.com/photo-1429547584745-d8bec594c82e', 'Machu Picchu', 'John Kutcher', 'https://unsplash.com/jmkutcher', 0.00, '', '', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 11, 0, 1, 0, 0, 0, 1432706432, 1436887281),
(7, '01000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'events', 'Event', '', '', '', 'Events 7', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0.00, '', '', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 1432789439, 1432789446),
(8, '00000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'news', 'NewsArticle', '', '', '', 'News 8', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0.00, '', '', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 1432789481, 1432789486),
(9, '00000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'testimonials', 'Review', '', '', '', 'Testimonials 9', '', '', 'Paul Wyatt', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0.00, '', 'This is a little information to be displayed for this Testimonial', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 1432789501, 1435102663),
(19, '00000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'portfolio', 'CreativeWork', '', '', '', 'Portfolio 19', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0.00, '', '', '', '', 0, '', '', 'unpublished', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 1435651232, 1435651232);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` bigint(20) unsigned NOT NULL,
  `options` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT '00000000',
  `username` varchar(128) COLLATE utf8_bin NOT NULL,
  `password` varchar(2048) COLLATE utf8_bin NOT NULL,
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
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `options`, `username`, `password`, `cover`, `coverURL`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `avatar`, `gravatar`, `business`, `name`, `email`, `email_check`, `url`, `address`, `suburb`, `city`, `state`, `postcode`, `abn`, `phone`, `mobile`, `notes`, `status`, `active`, `activate`, `adminCategory_1`, `adminCategory_2`, `adminCategory_ti`, `language`, `timezone`, `rank`, `ti`) VALUES
(1, '11111111', 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ecc7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', '', 'https://download.unsplash.com/photo-1430916273432-273c2db881a0', '', 'rebecca johnston', 'https://unsplash.com/rebecca_jane', 'avatar_1.jpg', 'http://s.gravatar.com/avatar/3a435c03ed08ca31445419e88617f7d4?s=80', '', '', 'dennis@studiojunkyard.com', 0, '', '', '', '', '', 0, '', '', '', '', 'unpublished', 1, '', '', '', 0, 'en', 'Australia/Hobart', 1000, 1402746479);

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

INSERT INTO `menu` (`id`, `uid`, `login_user`, `title`, `seoTitle`, `contentType`, `schemaType`, `seoKeywords`, `seoDescription`, `seoCaption`, `menu`, `notes`, `ord`, `active`, `eti`) VALUES
(1, 1, 'Dennis J Suitters', 'Home', '', 'index', '', '', '', '', 'head', '', 0, 1, 1435312927),
(2, 0, '', 'Blog', '', 'article', '', '', '', '', 'head', '', 1, 1, 0),
(3, 0, '', 'Portfolio', '', 'portfolio', '', '', '', '', 'head', '', 2, 1, 0),
(4, 0, '', 'Bookings', '', 'bookings', '', '', '', '', 'head', '', 3, 1, 0),
(5, 0, '', 'Events', '', 'events', '', '', '', '', 'head', '', 4, 1, 0),
(6, 0, '', 'News', '', 'news', '', '', '', '', 'head', '', 5, 1, 0),
(7, 0, '', 'Testimonials', '', 'testimonials', '', '', '', '', 'head', '', 6, 1, 0),
(8, 0, '', 'Inventory', '', 'inventory', '', '', '', '', 'head', '', 7, 1, 0),
(9, 0, '', 'Services', '', 'services', '', '', '', '', 'head', '', 8, 1, 0),
(10, 0, '', 'Gallery', '', 'gallery', '', '', '', '', 'head', '', 9, 1, 0),
(11, 0, '', 'Contact', '', 'contactus', '', '', '', '', 'head', '', 10, 1, 0),
(12, 0, '', 'Cart', '', 'cart', '', '', '', '', 'head', '', 11, 1, 0),
(13, 0, '', 'Terms of Service', 'Terms of Service', 'tos', '', '', '', '', 'footer', '', 0, 1, 0),
(14, 0, '', 'Search', 'Search', 'search', '', '', '', '', 'footer', '', 1, 1, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `oid`, `iid`, `title`, `quantity`, `cost`, `status`, `ti`) VALUES
(1, 1, 2, 'Inventory 2', 3, 10.00, '', 1432777126),
(34, 4, 2, 'Inventory 2', 2, 20.00, '', 1434970755),
(41, 4, 7, 'Events 7', 1, 15.00, '', 1435043497),
(42, 4, 0, '', 1, 0.00, '', 1435043503),
(43, 4, 0, '', 1, 0.00, '', 1435043601);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) NOT NULL,
  `cid` bigint(20) unsigned NOT NULL,
  `uid` bigint(20) unsigned NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `cid`, `uid`, `qid`, `qid_ti`, `iid`, `iid_ti`, `did`, `did_ti`, `aid`, `aid_ti`, `due_ti`, `notes`, `status`, `recurring`, `ti`, `eti`) VALUES
(1, 2, 0, 'Q150528000001', 1432777126, '', 0, '', 0, 'A150528000002', 1432777227, 1433986726, 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', 'archived', 0, 1432777126, 0),
(4, 1, 0, 'Q150528000004', 1432790192, '', 0, '', 0, '', 0, 1471842992, 'Services are considered to be in a Grace Period for a total of 14 days whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the 14 Day Grace Period, any unpaid accounts will be suspended, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If 30 days without payment or contact has lapsed, we will at our discretion consider terminatingÂ services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', 'pending', 0, 1432790192, 0);

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
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
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