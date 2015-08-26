-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 26, 2015 at 08:15 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `contentType`, `rid`, `uid`, `cid`, `ip`, `avatar`, `gravatar`, `email`, `name`, `notes`, `status`, `active`, `tie`, `ti`) VALUES
(1, 'article', 1, 1, 1, '127.0.0.1', '', '', 'dennis@studiojunkyard.com', 'Kenika Suitters', 'kjhgkjhg', 'approved', 0, 0, 1439396263);

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
(1, '1111111100000000', 'default', 'LibreCMS', 'Default Site Description', 'Default Site Caption', 'Default Site Keywords', 'Five good reasons to update your website', '<p>and one really bad one &#160; Iâ€™ll admit Iâ€™ve been putt [&#8230;]</p>\n<p>The post <a rel="nofollow" href="https://www.katetooncopywriter.com.au/five-good-reasons-to-update-your-website/">Five good reasons to update your website</a> appeared first on <a rel="nofollow" href="https://www.katetooncopywriter.com.au">Kate Toon Copywriter</a>.</p>\n', 'https://www.katetooncopywriter.com.au/five-good-reasons-to-update-your-website/', 'katetoon', 1440662108, '', 'LibreCMS', '000 000 000', '', '', '', '', '', 0, '', '', 'info@studiojunkyard.com', 1406180963, 3600, 'M j, Y g:i A', 'icon', 1425893894, 3600, 'en', 'Australia/Hobart', 1209600, '{name}: Invoice: {order_number}', 'Hello {first},<br><br>Please find attached Order {order_number}<br>Note: {notes}', 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', '', '', '', '', '', 'cards', 'cards', 'calendar', 20, 1404461417, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `options`, `rank`, `rid`, `uid`, `login_user`, `cid`, `ip`, `contentType`, `schemaType`, `keywords`, `code`, `brand`, `title`, `category_1`, `category_2`, `name`, `url`, `email`, `business`, `address`, `suburb`, `city`, `state`, `postcode`, `phone`, `mobile`, `thumb`, `file`, `fileURL`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `exifISO`, `exifAperture`, `exifFocalLength`, `exifShutterSpeed`, `exifCamera`, `exifLens`, `exifFilename`, `exifti`, `cost`, `subject`, `notes`, `attributionContentName`, `attributionContentURL`, `quantity`, `tags`, `caption`, `status`, `service`, `internal`, `featured`, `bookable`, `fti`, `assoc`, `ord`, `views`, `active`, `pin`, `tis`, `tie`, `lti`, `ti`, `eti`) VALUES
(1, '01000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'blogPost', 'doctor who,game', '', '', 'The Long Game', 'Doctor Who', 'funny', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<h2>The Parting of the Ways</h2>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels.</p>\r\n<h3>The Impossible Astronaut</h3>\r\n<p>Saving the world with meals on wheels. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<h4>The Beast Below</h4>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<h5>Voyage of the Damned</h5>\r\n<p>You''ve swallowed a planet! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', '', '', 0, 'doctor who,game', '', 'published', 0, 0, 1, 0, 0, '', 17, 0, 1, 0, 0, 1436975186, 0, 1429270672, 1440575856),
(2, '10000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'Product', '', '', '', 'Inventory 5', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', 'https://download.unsplash.com/photo-1429308755210-25a272addeb3', '', 'Demi DeHerrera', 'https://unsplash.com/demidearest', '', '', '', '', '', '', '', 0, 10.00, '', '<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<h2>The Parting of the Ways</h2>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels.</p>\r\n<h3>The Impossible Astronaut</h3>\r\n<p>Saving the world with meals on wheels. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<h4>The Beast Below</h4>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<h5>Voyage of the Damned</h5>\r\n<p>You''ve swallowed a planet! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 0, 1430371748, 1440381288),
(3, '10000000', 0, 0, 1, 'admin', 0, '', 'article', '', '', '', '', 'Services 3', '', '', '', '', '', '', '', '', '', '', 0, '', '', 'thumb_3.jpg', 'file_3.jpg', 'https://download.unsplash.com/photo-1430866880825-336a7d7814eb', '', 'Damir Kotoric', 'https://unsplash.com/damirkotoric', '', '', '', '', '', '', '', 0, 20.00, '', '<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<h2>The Parting of the Ways</h2>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels.</p>\r\n<h3>The Impossible Astronaut</h3>\r\n<p>Saving the world with meals on wheels. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<h4>The Beast Below</h4>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<h5>Voyage of the Damned</h5>\r\n<p>You''ve swallowed a planet! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 1, 0, '', 2, 0, 1, 0, 0, 0, 0, 1430371800, 1439110171),
(4, '00000000', 0, 0, 1, 'admin', 0, '', 'article', 'CreativeWork', '', '', '', 'Portfolio 4', 'Doctor Who', '', '', '', '', '', '', '', '', '', 0, '', '', 'thumb_4.jpg', 'file_4.jpg', 'https://download.unsplash.com/photo-1429547584745-d8bec594c82e', '', 'John Kutcher', 'https://unsplash.com/jmkutcher', '', '', '', '', '', '', '', 0, 0.00, '', '', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 9, 0, 1, 0, 0, 0, 0, 1432698738, 1439110174),
(5, '00000000', 0, 0, 1, 'Kenika Suitters', 1, '', 'article', 'CreativeWork', '', '', '', 'Proofs 5', '', '', '', '', '', '', '', '', '', '', 0, '', '', 'thumb_5.jpg', 'file_5.jpg', '', '', '', '', '100', 'F1', '28mm', '1/50 sec', 'Canon EOS-1Ds Mark III', '', '1ds35359.jpg', 1431224195, 0.00, '', '', '', '', 0, '', '', 'unpublished', 0, 0, 0, 0, 0, '', 92, 0, 1, 0, 0, 0, 0, 1432698854, 1440424619),
(6, '00000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'gallery', 'ImageGallery', '', '', '', 'Machu Picchu', 'Doctor Who', '', '', '', '', '', '', '', '', '', 0, '', '', 'thumb_6.jpg', 'file_6.jpg', 'https://download.unsplash.com/photo-1429547584745-d8bec594c82e', 'Machu Picchu', 'John Kutcher', 'https://unsplash.com/jmkutcher', '', '', '', '', '', '', '', 0, 0.00, '', '', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 11, 0, 1, 0, 0, 0, 0, 1432706432, 1436887281),
(7, '01000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'event', 'Event', '', '', '', 'Events 7', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 0, 1432789439, 1432789446),
(8, '00000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'news', 'NewsArticle', '', '', '', 'News 8', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 0, 1432789481, 1432789486),
(9, '00000000', 0, 3, 1, 'Kenika Suitters', 1, '', 'booking', '', '', '', '', '', '', '', 'Kenika Suitters', '', 'dennis@studiojunkyard.com', 'Studio Junkyard', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '', '', '', 0, '', '', 'confirmed', 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 1439397714, 1439992800, 0, 1439397714, 1439536697),
(11, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'booking', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '', '', '', 0, '', '', 'confirmed', 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 1439398355, 0, 0, 1439398355, 1439486455);

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
(1, '11111111', 'admin', '$2y$10$cb/MtTJA/9L5HxQE6G8WLO18Ye7AWTCWIy9ql1xa12BmvMpySFNSS', '', 'https://download.unsplash.com/photo-1430916273432-273c2db881a0', '', 'rebecca johnston', 'https://unsplash.com/rebecca_jane', '', 'http://s.gravatar.com/avatar/3a435c03ed08ca31445419e88617f7d4?s=80', 'Studio Junkyard', 'Kenika Suitters', 'dennis@studiojunkyard.com', '', 0, '', '', '', '', '', 0, '', '', '', '', 'unpublished', 1, '', '', '', 0, 'en', 'Australia/Hobart', 1000, '', 0, 1402746479);

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
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `uid`, `rid`, `view`, `contentType`, `refTable`, `refColumn`, `oldda`, `newda`, `action`, `ti`) VALUES
(1, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439260407),
(2, 1, 1, 'article', 'article', 'content', 'status', 0x7075626c6973686564, 0x64656c657465, 'delete', 1439295786),
(3, 1, 1, 'article', 'article', 'content', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439295789),
(4, 1, 1, '', '', 'login', 'name', '', 0x4b656e696b61205375697474657273, 'update', 1439306124),
(5, 1, 1, '', '', 'login', 'status', 0x756e7075626c6973686564, 0x64656c657465, 'delete', 1439311675),
(6, 1, 1, '', '', 'login', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439311677),
(7, 1, 1, '', '', 'config', 'layoutAccounts', 0x6361726473, 0x7461626c65, 'update', 1439311686),
(8, 1, 1, '', '', 'config', 'layoutAccounts', 0x7461626c65, 0x6361726473, 'update', 1439311690),
(9, 1, 1, '', '', 'login', 'business', '', 0x53747564696f204a756e6b79617264, 'update', 1439312069),
(10, 1, 1, '', '', 'login', 'business', 0x53747564696f204a756e6b79617264, 0x53747564696f204a756e6b79617264, 'update', 1439312072),
(11, 1, 1, '', '', 'login', 'status', 0x756e7075626c6973686564, 0x64656c657465, 'delete', 1439312370),
(12, 1, 1, '', '', 'login', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439312373),
(13, 1, 1, 'article', 'article', 'content', 'status', 0x756e7075626c6973686564, 0x64656c657465, 'delete', 1439312379),
(14, 1, 1, 'article', 'article', 'content', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439312380),
(15, 1, 1, 'article', 'article', 'content', 'status', 0x756e7075626c6973686564, 0x7075626c6973686564, 'update', 1439312385),
(16, 1, 1, '', '', 'login', 'status', 0x756e7075626c6973686564, 0x64656c657465, 'delete', 1439312477),
(17, 1, 1, '', '', 'login', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439312485),
(18, 1, 1, '', '', 'config', 'layoutContent', 0x7461626c65, 0x6361726473, 'update', 1439312547),
(19, 1, 1, 'article', 'article', 'content', 'status', 0x7075626c6973686564, 0x64656c657465, 'delete', 1439312558),
(20, 1, 1, 'article', 'article', 'content', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439312560),
(21, 1, 1, 'article', 'article', 'content', 'status', 0x756e7075626c6973686564, 0x7075626c6973686564, 'update', 1439312570),
(22, 1, 1, 'article', 'article', 'content', 'status', 0x7075626c6973686564, 0x64656c657465, 'delete', 1439312925),
(23, 1, 1, 'article', 'article', 'content', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439312928),
(24, 1, 1, '', '', 'login', 'status', 0x756e7075626c6973686564, 0x64656c657465, 'delete', 1439312937),
(25, 1, 1, '', '', 'login', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439312941),
(26, 1, 1, '', '', 'config', 'layoutAccounts', 0x6361726473, 0x7461626c65, 'update', 1439313198),
(27, 1, 1, '', '', 'config', 'layoutAccounts', 0x7461626c65, 0x6361726473, 'update', 1439313200),
(28, 1, 1, '', '', 'config', 'layoutAccounts', 0x6361726473, 0x7461626c65, 'update', 1439313207),
(29, 1, 1, '', '', 'config', 'layoutAccounts', 0x7461626c65, 0x6361726473, 'update', 1439313214),
(30, 1, 1, '', '', 'config', 'layoutAccounts', 0x6361726473, 0x7461626c65, 'update', 1439335384),
(31, 1, 1, '', '', 'config', 'layoutAccounts', 0x7461626c65, 0x7461626c65, 'update', 1439335387),
(32, 1, 1, '', '', 'login', 'status', 0x756e7075626c6973686564, 0x64656c657465, 'delete', 1439336030),
(33, 1, 1, '', '', 'login', 'status', 0x64656c657465, '', 'update', 1439336033),
(34, 1, 1, '', '', 'config', 'layoutAccounts', 0x7461626c65, 0x6361726473, 'update', 1439336051),
(35, 1, 1, '', '', 'login', 'status', '', 0x64656c657465, 'delete', 1439336471),
(36, 1, 1, '', '', 'login', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439336473),
(37, 1, 2, '', '', 'login', 'status', '', 0x64656c657465, 'delete', 1439336761),
(38, 1, 2, '', '', 'login', 'all', 0x327c30303030303030307c5573657220327c7c7c7c7c7c7c7c7c7c7c7c7c307c7c7c7c7c7c307c7c7c7c7c64656c6574657c317c7c7c7c307c7c7c307c7c307c313433393333363535367c7c, '', 'purge', 1439336765),
(39, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439336952),
(40, 1, 1, '', '', 'login', 'status', 0x756e7075626c6973686564, 0x64656c657465, 'delete', 1439355611),
(41, 1, 1, '', '', 'login', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439355614),
(42, 1, 1, '', '', 'login', 'avatar', '', '', 'update', 1439390249),
(43, 1, 1, '', '', 'login', 'avatar', '', '', 'update', 1439390251),
(44, 1, 1, '', '', 'login', 'avatar', '', '', 'update', 1439390260),
(45, 1, 1, '', '', 'login', 'avatar', '', '', 'update', 1439391550),
(46, 1, 1, 'article', 'article', 'content', 'status', 0x756e7075626c6973686564, 0x64656c657465, 'delete', 1439391896),
(47, 1, 1, 'article', 'article', 'content', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439391898),
(48, 1, 1, 'article', 'article', 'content', 'status', 0x756e7075626c6973686564, 0x7075626c6973686564, 'update', 1439391908),
(49, 1, 1, 'article', 'article', 'content', 'status', 0x7075626c6973686564, 0x64656c657465, 'delete', 1439394460),
(50, 1, 1, 'article', 'article', 'content', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439394463),
(51, 1, 1, 'article', 'article', 'content', 'status', 0x756e7075626c6973686564, 0x7075626c6973686564, 'update', 1439394469),
(52, 1, 1, 'article', 'article', 'comments', 'status', 0x756e617070726f766564, 0x617070726f766564, 'update', 1439397232),
(53, 1, 9, 'bookings', 'booking', 'content', 'all', '', '', 'create', 1439397714),
(54, 1, 10, 'bookings', 'booking', 'content', 'all', '', '', 'create', 1439397743),
(55, 1, 11, 'bookings', 'booking', 'content', 'all', '', '', 'create', 1439398355),
(56, 1, 1, '', '', 'config', 'layoutBookings', 0x63616c656e646172, 0x7461626c65, 'update', 1439398759),
(57, 1, 10, 'bookings', 'booking', 'content', 'status', 0x756e636f6e6669726d6564, 0x64656c657465, 'delete', 1439399483),
(58, 1, 10, 'booking', 'booking', 'content', 'all', 0x31307c30303030303030307c307c307c317c4b656e696b612053756974746572737c307c7c626f6f6b696e677c7c7c7c7c7c7c7c7c7c7c7c7c7c7c7c307c7c7c7c7c7c7c7c302e30307c7c7c7c7c307c7c7c64656c6574657c307c307c307c307c307c7c307c307c307c307c313433393339373734337c307c307c313433393339373734337c313433393339393438337c, '', 'purge', 1439399487),
(59, 1, 1, '', '', 'config', 'layoutBookings', 0x7461626c65, 0x63616c656e646172, 'update', 1439400234),
(60, 1, 1, '', '', 'config', 'layoutBookings', 0x63616c656e646172, 0x7461626c65, 'update', 1439438422),
(61, 1, 1, '', '', 'config', 'layoutBookings', 0x7461626c65, 0x7461626c65, 'update', 1439438424),
(62, 1, 1, '', '', 'config', 'layoutAccounts', 0x6361726473, 0x7461626c65, 'update', 1439439255),
(63, 1, 1, '', '', 'config', 'layoutAccounts', 0x7461626c65, 0x6361726473, 'update', 1439439258),
(64, 1, 5, 'proof', 'proof', 'content', 'status', 0x756e7075626c6973686564, 0x64656c657465, 'delete', 1439439522),
(65, 1, 5, 'proof', 'proof', 'content', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439439533),
(66, 1, 1, '', '', 'config', 'layoutContent', 0x6361726473, 0x7461626c65, 'update', 1439483067),
(67, 1, 11, 'bookings', 'booking', 'content', 'status', 0x756e636f6e6669726d6564, 0x64656c657465, 'delete', 1439483553),
(68, 1, 11, 'bookings', 'booking', 'content', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439483555),
(69, 1, 11, 'bookings', 'booking', 'content', 'status', 0x756e7075626c6973686564, 0x64656c657465, 'delete', 1439483663),
(70, 1, 11, 'bookings', 'booking', 'content', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439483667),
(71, 1, 9, 'bookings', 'booking', 'content', 'status', 0x756e636f6e6669726d6564, 0x636f6e6669726d6564, 'update', 1439483937),
(72, 1, 11, 'bookings', 'booking', 'content', 'status', 0x756e7075626c6973686564, 0x636f6e6669726d6564, 'update', 1439483942),
(73, 1, 9, 'bookings', 'booking', 'content', 'status', 0x636f6e6669726d6564, 0x756e636f6e6669726d6564, 'update', 1439483946),
(74, 1, 11, 'bookings', 'booking', 'content', 'status', 0x636f6e6669726d6564, 0x756e636f6e6669726d6564, 'update', 1439483948),
(75, 1, 9, 'bookings', 'booking', 'content', 'status', 0x756e636f6e6669726d6564, 0x64656c657465, 'delete', 1439483951),
(76, 1, 11, 'bookings', 'booking', 'content', 'status', 0x756e636f6e6669726d6564, 0x636f6e6669726d6564, 'update', 1439483958),
(77, 1, 9, 'bookings', 'booking', 'content', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439483962),
(78, 1, 9, 'bookings', 'booking', 'content', 'status', 0x756e7075626c6973686564, 0x636f6e6669726d6564, 'update', 1439483968),
(79, 1, 9, 'bookings', 'booking', 'content', 'status', 0x636f6e6669726d6564, 0x64656c657465, 'delete', 1439483971),
(80, 1, 9, 'bookings', 'booking', 'content', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1439483977),
(81, 1, 11, 'bookings', 'booking', 'content', 'status', 0x636f6e6669726d6564, 0x756e636f6e6669726d6564, 'update', 1439484040),
(82, 1, 1, 'article', 'article', 'content', 'title', 0x546865204c6f6e672047616d652032, 0x546865204c6f6e672047616d65, 'update', 1439485336),
(83, 1, 1, 'article', 'article', 'content', 'title', 0x546865204c6f6e672047616d65, 0x546865204c6f6e672047616d65, 'update', 1439485340),
(84, 1, 9, 'bookings', 'booking', 'content', 'status', 0x756e7075626c6973686564, 0x636f6e6669726d6564, 'update', 1439485356),
(85, 1, 9, 'bookings', 'booking', 'content', 'email', '', 0x64656e6e69734073747564696f6a756e6b796172642e636f6d, 'update', 1439485739),
(86, 1, 9, 'bookings', 'booking', 'content', 'name', '', 0x44656e6e6973204a205375697474657273, 'update', 1439485746),
(87, 1, 11, 'bookings', 'booking', 'content', 'status', 0x756e636f6e6669726d6564, 0x636f6e6669726d6564, 'update', 1439486455),
(88, 1, 9, 'bookings', 'booking', 'content', 'tie', 0x30, 0x31352d30382d32302030303a3030, 'update', 1439511528),
(89, 1, 1, '', '', 'config', 'layoutBookings', 0x7461626c65, 0x63616c656e646172, 'update', 1439517894),
(90, 1, 9, 'bookings', 'booking', 'content', 'rid', 0x30, 0x33, 'update', 1439536697),
(91, 1, 1, '', '', 'orders', 'status', 0x64656c657465, '', 'update', 1439557211),
(92, 1, 1, '', '', 'orders', 'status', '', 0x64656c657465, 'delete', 1439557217),
(93, 1, 1, '', '', 'orders', 'status', 0x64656c657465, '', 'update', 1439557223),
(94, 1, 1, '', '', 'orders', 'status', '', 0x64656c657465, 'delete', 1439557227),
(95, 1, 1, '', '', 'orders', 'status', 0x64656c657465, '', 'update', 1439557231),
(96, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439653128),
(97, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x626c61636b6f7574, 'update', 1439653970),
(98, 1, 1, '', '', 'config', 'theme', 0x626c61636b6f7574, 0x64656661756c74, 'update', 1439653978),
(99, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x626c61636b6f7574, 'update', 1439654117),
(100, 1, 1, '', '', 'config', 'theme', 0x626c61636b6f7574, 0x64656661756c74, 'update', 1439654122),
(101, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x626c61636b6f7574, 'update', 1439654575),
(102, 1, 1, '', '', 'config', 'theme', 0x626c61636b6f7574, 0x64656661756c74, 'update', 1439654577),
(103, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439654597),
(104, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439654695),
(105, 1, 1, '', '', 'config', 'layoutBookings', 0x63616c656e646172, 0x7461626c65, 'update', 1439657723),
(106, 1, 1, '', '', 'config', 'layoutBookings', 0x7461626c65, 0x63616c656e646172, 'update', 1439657727),
(107, 1, 1, '', '', 'config', 'layoutContent', 0x7461626c65, 0x6361726473, 'update', 1439657741),
(108, 1, 1, '', '', 'config', 'layoutContent', 0x6361726473, 0x7461626c65, 'update', 1439828269),
(109, 1, 1, '', '', 'config', 'layoutContent', 0x7461626c65, 0x7461626c65, 'update', 1439828271),
(110, 1, 1, '', '', 'config', 'layoutContent', 0x7461626c65, 0x6361726473, 'update', 1439828870),
(111, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439832376),
(112, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439832377),
(113, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439832378),
(114, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439832378),
(115, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439863125),
(116, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439863126),
(117, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439863178),
(118, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439863189),
(119, 1, 1, '', '', 'config', 'theme', 0x64656661756c74, 0x64656661756c74, 'update', 1439863190),
(120, 1, 1, '', '', 'config', 'layoutContent', 0x6361726473, 0x7461626c65, 'update', 1440381219),
(121, 1, 1, '', '', 'config', 'layoutContent', 0x7461626c65, 0x7461626c65, 'update', 1440381221),
(122, 1, 2, 'article', 'article', 'content', 'status', 0x7075626c6973686564, 0x64656c657465, 'delete', 1440381267),
(123, 1, 2, 'article', 'article', 'content', 'status', 0x64656c657465, 0x756e7075626c6973686564, 'update', 1440381271),
(124, 1, 2, 'article', 'article', 'content', 'status', 0x756e7075626c6973686564, 0x7075626c6973686564, 'update', 1440381288),
(125, 1, 1, '', '', 'config', 'layoutContent', 0x7461626c65, 0x6361726473, 'update', 1440389075),
(126, 1, 1, 'article', 'article', 'content', 'exifCamera', '', 0x43616e6f6e, 'update', 1440417080),
(127, 1, 1, 'article', 'article', 'content', 'exifCamera', 0x43616e6f6e, '', 'update', 1440417085),
(128, 1, 5, 'proof', 'proof', 'content', 'contentType', 0x70726f6f66, 0x706f7274666f6c696f, 'update', 1440423504),
(129, 1, 5, 'portfolio', 'portfolio', 'content', 'contentType', 0x706f7274666f6c696f, 0x61727469636c65, 'update', 1440423506),
(130, 1, 5, 'article', 'article', 'content', 'exifCamera', 0x20, '', 'update', 1440424603),
(131, 1, 5, 'article', 'article', 'content', 'exifCamera', '', '', 'update', 1440424605),
(132, 1, 5, 'article', 'article', 'content', 'exifAperture', '', '', 'update', 1440424610),
(133, 1, 5, 'article', 'article', 'content', 'exifAperture', '', '', 'update', 1440424611),
(134, 1, 5, 'article', 'article', 'content', 'exifLens', '', '', 'update', 1440424617),
(135, 1, 5, 'article', 'article', 'content', 'exifAperture', '', '', 'update', 1440424619),
(136, 1, 1, 'article', 'article', 'content', 'attributionImage', 0x74657374, '', 'update', 1440575837),
(137, 1, 1, 'article', 'article', 'content', 'attributionImage', 0x44616e69656c6120437565766173, '', 'update', 1440575842),
(138, 1, 1, 'article', 'article', 'content', 'attributionImage', 0x68747470733a2f2f756e73706c6173682e636f6d2f64616e69656c61637565766173, '', 'update', 1440575846),
(139, 1, 1, 'article', 'article', 'content', 'attributionImage', '', '', 'update', 1440575856);

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
(1, 1, 'admin', 'Home', 'Boo', 'index', '', '', '', '', 'head', '', 0, 1, 1437150031),
(2, 0, '', 'Blog', '', 'article', '', '', '', '', 'head', '', 1, 1, 0),
(3, 0, '', 'Portfolio', '', 'portfolio', '', '', '', '', 'head', '', 2, 1, 0),
(4, 0, '', 'Bookings', '', 'bookings', '', '', '', '', 'head', '', 3, 1, 0),
(5, 0, '', 'Events', '', 'event', '', '', '', '', 'head', '', 4, 1, 0),
(6, 0, '', 'News', '', 'news', '', '', '', '', 'head', '', 5, 1, 0),
(7, 0, '', 'Testimonials', '', 'testimonial', '', '', '', '', 'head', '', 6, 1, 0),
(8, 0, '', 'Inventory', '', 'inventory', '', '', '', '', 'head', '', 7, 1, 0),
(9, 0, '', 'Services', '', 'service', '', '', '', '', 'head', '', 8, 1, 0),
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `cid`, `uid`, `contentType`, `qid`, `qid_ti`, `iid`, `iid_ti`, `did`, `did_ti`, `aid`, `aid_ti`, `due_ti`, `notes`, `status`, `recurring`, `ti`, `eti`) VALUES
(1, 0, 1, '', 'Q150802000001', 1438444877, '', 0, '', 0, '', 0, 1438444877, 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', 'overdue', 0, 0, 0),
(2, 0, 1, '', 'Q150811000002', 1439265701, '', 0, '', 0, '', 0, 1440475301, 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', 'overdue', 0, 0, 0);

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
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=140;
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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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