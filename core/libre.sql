-- phpMyAdmin SQL Dump
-- version 4.2.9.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2015 at 02:05 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `super`
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `iid`, `quantity`, `cost`, `si`, `ti`) VALUES
(1, 2, 1, 10.00, 'puml32eshrobm417ncd49asdc7', 1432262620);

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
(1, 1, 1, '', 0, 'brand-facebook', 'https://www.facebook.com/studiojunkyard', 'Facebook', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `contentType`, `rid`, `uid`, `cid`, `ip`, `avatar`, `gravatar`, `email`, `name`, `notes`, `status`, `active`, `ti`) VALUES
(1, 'article', 1, 1, 1, '127.0.0.1', 'avatar_1.jpg', '', 'dennis@studiojunkyard.com', 'Dennis J Suitters', 'This is a working comment', '', 0, 1431598476),
(2, 'article', 1, 1, 1, '127.0.0.1', '', '', 'dennis@studiojunkyard.com', 'Dennis J Suitters', 'This is another working comment', '', 0, 1431601103),
(7, 'article', 1, 0, 0, '127.0.0.1', '', '', 'info@studiojunkyard.com', 'devel', 'fsdfgsdfg', '', 0, 1431836887),
(8, 'article', 1, 1, 0, '127.0.0.1', 'avatar_1.jpg', '', 'dennis@studiojunkyard.com', 'Dennis J Suitters', 'asdfsadf', '', 0, 1431837035);

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
`id` tinyint(1) unsigned NOT NULL,
  `options` varchar(8) COLLATE utf8_bin NOT NULL,
  `theme` varchar(16) COLLATE utf8_bin NOT NULL,
  `seoTitle` varchar(60) COLLATE utf8_bin NOT NULL,
  `seoDescription` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoCaption` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoKeywords` varchar(255) COLLATE utf8_bin NOT NULL,
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
  `email_check` int(10) NOT NULL,
  `email_interval` int(10) NOT NULL,
  `language` varchar(8) COLLATE utf8_bin NOT NULL,
  `timezone` varchar(128) COLLATE utf8_bin NOT NULL,
  `itemCount` int(4) NOT NULL,
  `orderPayti` int(10) unsigned NOT NULL,
  `orderEmailDefaultSubject` tinytext COLLATE utf8_bin NOT NULL,
  `orderEmailLayout` text COLLATE utf8_bin NOT NULL,
  `orderEmailNotes` text COLLATE utf8_bin NOT NULL,
  `bank` varchar(60) COLLATE utf8_bin NOT NULL,
  `bankAccountName` varchar(40) COLLATE utf8_bin NOT NULL,
  `bankAccountNumber` varchar(40) COLLATE utf8_bin NOT NULL,
  `bankBSB` varchar(16) COLLATE utf8_bin NOT NULL,
  `bankPayPal` varchar(60) COLLATE utf8_bin NOT NULL,
  `bti` int(10) unsigned NOT NULL,
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `options`, `theme`, `seoTitle`, `seoDescription`, `seoCaption`, `seoKeywords`, `business`, `abn`, `address`, `suburb`, `city`, `state`, `country`, `postcode`, `phone`, `mobile`, `email`, `vti`, `sti`, `dateFormat`, `email_check`, `email_interval`, `language`, `timezone`, `itemCount`, `orderPayti`, `orderEmailDefaultSubject`, `orderEmailLayout`, `orderEmailNotes`, `bank`, `bankAccountName`, `bankAccountNumber`, `bankBSB`, `bankPayPal`, `bti`, `ti`) VALUES
(1, '11111101', 'default', 'Studio Junkyard', 'Default Site Description', 'Default Site Caption', 'Default Site Keywords', 'Studio Junkyard', '000 000 000', '128 Wilmot Road', 'Wilmot', 'Wilmot', 'Tasmania', 'Australia', 7310, '0364921418', '0364921418', 'info@studiojunkyard.com', 1406180963, 3600, 'M j, Y g:i A', 1425893894, 3600, 'en', 'Australia/Hobart', 4, 1209600, '{name}: Invoice: {order_number}', 'Hello {first},<br><br>Please find attached Order {order_number}<br>Note: {notes}', 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', '', '', '', '', '', 1404461417, 0);

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
  `url` varchar(128) COLLATE utf8_bin NOT NULL,
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
  `cost` decimal(10,2) unsigned NOT NULL,
  `subject` varchar(60) COLLATE utf8_bin NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `options`, `rank`, `rid`, `uid`, `login_user`, `cid`, `ip`, `contentType`, `schemaType`, `keywords`, `code`, `brand`, `title`, `category_1`, `category_2`, `name`, `url`, `email`, `business`, `address`, `suburb`, `city`, `state`, `postcode`, `phone`, `thumb`, `file`, `cost`, `subject`, `notes`, `quantity`, `tags`, `caption`, `status`, `service`, `internal`, `featured`, `bookable`, `fti`, `assoc`, `ord`, `views`, `active`, `tis`, `tie`, `lti`, `ti`, `eti`) VALUES
(1, '01000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'article', 'blogPost', 'doctor who,game', '', '', 'The Long Game', 'Doctor Who', 'funny', '', '', '', '', '', '', '', '', 0, '', 'thumb_1.jpg', 'file_1.jpg', 0.00, '', '<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<h2>The Parting of the Ways</h2>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels.</p>\r\n<h3>The Impossible Astronaut</h3>\r\n<p>Saving the world with meals on wheels. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<h4>The Beast Below</h4>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<h5>Voyage of the Damned</h5>\r\n<p>You''ve swallowed a planet! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', 0, 'doctor who,game', '', 'published', 0, 0, 1, 0, 0, '', 1, 0, 1, 0, 0, 0, 1429270672, 1430380473),
(2, '10000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'inventory', 'Product', '', '', '', 'Inventory 2', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 10.00, '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 1430371748, 1430371760),
(3, '10000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'services', '', '', '', '', 'Services 3', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_3.jpg', 'file_3.jpg', 20.00, '', '<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<h2>The Parting of the Ways</h2>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels.</p>\r\n<h3>The Impossible Astronaut</h3>\r\n<p>Saving the world with meals on wheels. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<h4>The Beast Below</h4>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<h5>Voyage of the Damned</h5>\r\n<p>You''ve swallowed a planet! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', 0, '', '', 'published', 0, 0, 1, 1, 0, '', 2, 0, 1, 0, 0, 0, 1430371800, 1430540113);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
`id` bigint(20) unsigned NOT NULL,
  `options` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT '00000000',
  `username` varchar(128) COLLATE utf8_bin NOT NULL,
  `password` varchar(2048) COLLATE utf8_bin NOT NULL,
  `avatar` varchar(60) COLLATE utf8_bin NOT NULL,
  `gravatar` varchar(60) COLLATE utf8_bin NOT NULL,
  `business` varchar(40) COLLATE utf8_bin NOT NULL,
  `name` varchar(40) COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `email_check` int(10) NOT NULL,
  `url` varchar(128) COLLATE utf8_bin NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `options`, `username`, `password`, `avatar`, `gravatar`, `business`, `name`, `email`, `email_check`, `url`, `address`, `suburb`, `city`, `state`, `postcode`, `abn`, `phone`, `mobile`, `notes`, `status`, `active`, `activate`, `adminCategory_1`, `adminCategory_2`, `adminCategory_ti`, `language`, `timezone`, `rank`, `ti`) VALUES
(1, '11111111', 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ecc7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'avatar_1.jpg', '', '', 'Dennis J Suitters', 'dennis@studiojunkyard.com', 0, '', '128 Cradle Mountain Road', 'Wilmot', 'Wilmot', 'Tasmania', 7310, '', '', '', 'Being of a creative mind, and getting my hands into the creative process, I like to do many things which involve thinking along with doing things manually. Such as, Wood Turning, Wood Work, Photography, Gardening, Growing Vege, and Managing the Property where I live in Tasmania, Australia.', '', 1, '', '', '', 0, 'en', 'Australia/Hobart', 1000, 1402746479);

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
(1, 1, 'Dennis J Suitters', 'Home', '', 'index', '', '', '', '', 'head', '', 0, 1, 1429322563),
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `uid`, `mid`, `rmid`, `folder`, `to_email`, `to_name`, `from_email`, `from_name`, `subject`, `status`, `starred`, `important`, `notes_raw`, `notes_raw_mime`, `notes_html`, `notes_html_mime`, `attachments`, `email_date`, `size`, `ti`) VALUES
(1, 0, '', 0, 'INBOX', 'info@studiojunkyard.com', 'Studio Junkyard', 'dennis@studiojunkyard.com', '', 'Test', 'read', 0, 0, 'test message', '', '', '', '', 0, 0, 1430132595),
(2, 0, '', 0, 'INBOX', 'info@studiojunkyard.com', 'Studio Junkyard', 'dennis@studiojunkyard.com', '', 'Test', 'unread', 0, 0, 'test message', '', '', '', '', 0, 0, 1430132619),
(3, 0, '', 0, 'INBOX', 'info@studiojunkyard.com', 'Studio Junkyard', 'dennis@studiojunkyard.com', '', 'Any old subject', 'unread', 0, 0, 'Test', '', '', '', '', 0, 0, 1430135321),
(4, 0, '', 0, 'INBOX', 'info@studiojunkyard.com', 'Studio Junkyard', 'dennis@studiojunkyard.com', '', 'Any old subject', 'unread', 0, 0, 'Test', '', '', '', '', 0, 0, 1430135388),
(5, 0, '', 0, 'INBOX', 'info@studiojunkyard.com', 'Studio Junkyard', 'dennis@studiojunkyard.com', 'Dennis J Suitters', 'Any old subject', 'unread', 0, 0, 'asdf', '', '', '', '', 0, 0, 1430135437);

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
) ENGINE=InnoDB AUTO_INCREMENT=778 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tracker`
--

INSERT INTO `tracker` (`id`, `vid`, `contentType`, `ip`, `pageName`, `queryString`, `hostname`, `httpReferer`, `httpUserAgent`, `bot`, `browser`, `os`, `ti`) VALUES
(1, 13, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359576),
(2, 13, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359576),
(3, 13, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359578),
(4, 13, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359578),
(5, 13, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359590),
(6, 13, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359590),
(7, 13, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359600),
(8, 13, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359600),
(9, 13, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359601),
(10, 13, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359601),
(11, 13, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/%3Cprint%20content=linktitle%3E', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359605),
(12, 13, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359605),
(13, 13, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359607),
(14, 13, 'contactus', '127.0.0.1', 'contactus', 'url=contactus', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359608),
(15, 13, 'bookings', '127.0.0.1', 'bookings', 'url=bookings', '', 'http://localhost/LibreCMS/contactus', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359610),
(16, 13, 'events', '127.0.0.1', 'events', 'url=events', '', 'http://localhost/LibreCMS/bookings', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359614),
(17, 13, 'news', '127.0.0.1', 'news', 'url=news', '', 'http://localhost/LibreCMS/events', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359615),
(18, 13, 'testimonials', '127.0.0.1', 'testimonials', 'url=testimonials', '', 'http://localhost/LibreCMS/news', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359615),
(19, 13, 'article', '127.0.0.1', 'article', 'url=article/the-long-game', '', 'http://localhost/LibreCMS/testimonials', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359616),
(20, 13, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359616),
(21, 13, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359619),
(22, 13, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359619),
(23, 13, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359990),
(24, 13, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359990),
(25, 13, 'article', '127.0.0.1', 'article', 'url=article/the-long-game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359992),
(26, 13, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430359992),
(27, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361665),
(28, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361665),
(29, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361667),
(30, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361667),
(31, 14, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361669),
(32, 14, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361669),
(33, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361672),
(34, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361672),
(35, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361674),
(36, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361674),
(37, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361677),
(38, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361677),
(39, 14, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361679),
(40, 14, 'contactus', '127.0.0.1', 'contactus', 'url=contactus', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361680),
(41, 14, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/contactus', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361681),
(42, 14, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361681),
(43, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361685),
(44, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361685),
(45, 14, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361689),
(46, 14, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361689),
(47, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361691),
(48, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361691),
(49, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361972),
(50, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361972),
(51, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361975),
(52, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430361975),
(53, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362040),
(54, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362040),
(55, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362051),
(56, 14, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362051),
(57, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362057),
(58, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362352),
(59, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362354),
(60, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362354),
(61, 14, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362360),
(62, 14, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362360),
(63, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362363),
(64, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362363),
(65, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362430),
(66, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362430),
(67, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362432),
(68, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362432),
(69, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362491),
(70, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362491),
(71, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362588),
(72, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362588),
(73, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362635),
(74, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362685),
(75, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362685),
(76, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362706),
(77, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362706),
(78, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362711),
(79, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362711),
(80, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362813),
(81, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362813),
(82, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362814),
(83, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362814),
(84, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362815),
(85, 14, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362815),
(86, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362892),
(87, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362892),
(88, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362893),
(89, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362893),
(90, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362896),
(91, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362896),
(92, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362985),
(93, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362985),
(94, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430362993),
(95, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363139),
(96, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363150),
(97, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363150),
(98, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363153),
(99, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363173),
(100, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363203),
(101, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363203),
(102, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363207),
(103, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363321),
(104, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363324),
(105, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363324),
(106, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363347),
(107, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363347),
(108, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363350),
(109, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363350),
(110, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363394),
(111, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363394),
(112, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/%3Cprint%20content=linktitle%3E', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363426),
(113, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363426),
(114, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363440),
(115, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363440),
(116, 14, 'article', '127.0.0.1', 'article', 'url=article/the-long-game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363441),
(117, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363441),
(118, 14, 'article', '127.0.0.1', 'article', 'url=article/the-long-game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363508),
(119, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363508),
(120, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363510),
(121, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363510),
(122, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363519),
(123, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363519),
(124, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363525),
(125, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363525),
(126, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363548),
(127, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363548),
(128, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363549),
(129, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363549),
(130, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363550),
(131, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363550),
(132, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363552),
(133, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363552),
(134, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363574),
(135, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363574),
(136, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363575),
(137, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363575),
(138, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363576),
(139, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363576),
(140, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363576),
(141, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363576),
(142, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363576),
(143, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363577),
(144, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363580),
(145, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363673),
(146, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363718),
(147, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363718),
(148, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363721),
(149, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430363863),
(150, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430366020),
(151, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430366020),
(152, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430366022),
(153, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430366022),
(154, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430366089),
(155, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430366117),
(156, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430366117),
(157, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430366118),
(158, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430366118),
(159, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430367539),
(160, 14, 'error', '127.0.0.1', 'error', 'url=<print content=thumb>', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430367539),
(161, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368222),
(162, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368224),
(163, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368224),
(164, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368225),
(165, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368340),
(166, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368340),
(167, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368341),
(168, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368503),
(169, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368503),
(170, 14, 'article', '127.0.0.1', 'article', 'url=article/the-long-game', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368516),
(171, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368516),
(172, 14, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368517),
(173, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368518),
(174, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368520),
(175, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368520),
(176, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368523),
(177, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368526),
(178, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368526),
(179, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368528),
(180, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368600),
(181, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368600),
(182, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368602),
(183, 14, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368684),
(184, 14, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368684),
(185, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368689),
(186, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368903),
(187, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368903),
(188, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368906),
(189, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430368926),
(190, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430369161);
INSERT INTO `tracker` (`id`, `vid`, `contentType`, `ip`, `pageName`, `queryString`, `hostname`, `httpReferer`, `httpUserAgent`, `bot`, `browser`, `os`, `ti`) VALUES
(191, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430369161),
(192, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430369195),
(193, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430369195),
(194, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430369200),
(195, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430370093),
(196, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430370093),
(197, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430370094),
(198, 14, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371696),
(199, 14, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371696),
(200, 14, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371697),
(201, 14, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371697),
(202, 14, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371707),
(203, 14, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/admin/add/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371764),
(204, 14, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371764),
(205, 14, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371773),
(206, 14, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371776),
(207, 14, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371780),
(208, 14, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371782),
(209, 15, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371825),
(210, 16, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371827),
(211, 16, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371829),
(212, 16, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371829),
(213, 16, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371837),
(214, 16, 'bookings', '127.0.0.1', 'bookings', 'url=bookings', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371838),
(215, 16, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/bookings', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371840),
(216, 16, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371849),
(217, 16, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371852),
(218, 16, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371853),
(219, 16, 'error', '127.0.0.1', 'error', 'url=<print content=bookservice>', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371859),
(220, 16, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/%3Cprint%20content=bookservice%3E', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371862),
(221, 16, 'inventory', '127.0.0.1', 'inventory', 'url=inventory/Inventory-2', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371866),
(222, 16, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/inventory/Inventory-2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430371888),
(223, 16, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372049),
(224, 16, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372049),
(225, 16, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372051),
(226, 16, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372052),
(227, 16, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372053),
(228, 16, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372062),
(229, 16, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372063),
(230, 16, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372064),
(231, 16, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372064),
(232, 16, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372066),
(233, 16, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/admin/content', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372105),
(234, 16, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372105),
(235, 17, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372108),
(236, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372146),
(237, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372304),
(238, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372304),
(239, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372310),
(240, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372310),
(241, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372315),
(242, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372315),
(243, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372322),
(244, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372322),
(245, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372328),
(246, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372328),
(247, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372333),
(248, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372334),
(249, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372407),
(250, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372409),
(251, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430372409),
(252, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430373380),
(253, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430373387),
(254, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430373387),
(255, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430373504),
(256, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430373504),
(257, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430373511),
(258, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430373785),
(259, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430373785),
(260, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430373789),
(261, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430373959),
(262, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430373959),
(263, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430373962),
(264, 17, 'inventory', '127.0.0.1', 'inventory', 'url=inventory/inventory-2', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430377110),
(265, 17, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/inventory/inventory-2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430377114),
(266, 17, 'services', '127.0.0.1', 'services', 'url=services/services-3', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430377117),
(267, 17, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/services/services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430377118),
(268, 17, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430377120),
(269, 17, 'inventory', '127.0.0.1', 'inventory', 'url=inventory/inventory-2', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430377121),
(270, 17, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/inventory/inventory-2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430377123),
(271, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430377124),
(272, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430377125),
(273, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430377125),
(274, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430377850),
(275, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430378030),
(276, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430378030),
(277, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430378032),
(278, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430378066),
(279, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430378066),
(280, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430378067),
(281, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430378369),
(282, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430378369),
(283, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430378371),
(284, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430378594),
(285, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430378594),
(286, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430378596),
(287, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430379975),
(288, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430379975),
(289, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430379977),
(290, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430379979),
(291, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430379979),
(292, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430379980),
(293, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380095),
(294, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380096),
(295, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380097),
(296, 17, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380098),
(297, 17, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380098),
(298, 17, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380103),
(299, 17, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380103),
(300, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380107),
(301, 17, 'search', '127.0.0.1', 'search', 'url=search/doctor who', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380221),
(302, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/search/doctor%20who', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380225),
(303, 17, 'search', '127.0.0.1', 'search', 'url=search/game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380227),
(304, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/search/game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380231),
(305, 17, 'search', '127.0.0.1', 'search', 'url=search/game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380233),
(306, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/search/game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380237),
(307, 17, 'search', '127.0.0.1', 'search', 'url=search/doctor who', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380282),
(308, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/search/doctor%20who', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380285),
(309, 17, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/admin/content/edit/1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380357),
(310, 17, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380357),
(311, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380360),
(312, 17, 'search', '127.0.0.1', 'search', 'url=search/doctor-who', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380432),
(313, 17, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/search/game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380438),
(314, 18, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380475),
(315, 18, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380481),
(316, 18, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380482),
(317, 18, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380482),
(318, 18, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380488),
(319, 18, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380494),
(320, 18, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380494),
(321, 18, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380495),
(322, 18, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380499),
(323, 18, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380500),
(324, 18, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380502),
(325, 18, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article/Doctor-Who', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380962),
(326, 18, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380962),
(327, 18, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380963),
(328, 18, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380978),
(329, 18, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380980),
(330, 18, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380980),
(331, 18, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380981),
(332, 18, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380983),
(333, 18, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380983),
(334, 18, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430380984),
(335, 18, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430381252),
(336, 18, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430381252),
(337, 18, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430381254),
(338, 19, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430446834),
(339, 19, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430446834),
(340, 19, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430446841),
(341, 19, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430446841),
(342, 19, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430446846),
(343, 20, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430450884),
(344, 20, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430451484),
(345, 20, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430451484),
(346, 20, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430451520),
(347, 20, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430451520),
(348, 20, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430451522),
(349, 20, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430451633),
(350, 20, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430451633),
(351, 20, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430451728),
(352, 20, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430451728),
(353, 20, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452071),
(354, 20, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452071),
(355, 20, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452074),
(356, 20, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452075),
(357, 20, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452075),
(358, 20, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452076),
(359, 20, 'bookings', '127.0.0.1', 'bookings', 'url=bookings', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452077),
(360, 20, 'events', '127.0.0.1', 'events', 'url=events', '', 'http://localhost/LibreCMS/bookings', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452078),
(361, 20, 'news', '127.0.0.1', 'news', 'url=news', '', 'http://localhost/LibreCMS/events', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452079),
(362, 20, 'testimonials', '127.0.0.1', 'testimonials', 'url=testimonials', '', 'http://localhost/LibreCMS/news', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452080),
(363, 20, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/testimonials', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452080),
(364, 20, 'inventory', '127.0.0.1', 'inventory', 'url=inventory/Inventory-2', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452087),
(365, 20, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/inventory/Inventory-2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452096),
(366, 20, 'services', '127.0.0.1', 'services', 'url=services/Services-3', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452097),
(367, 20, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/services/Services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452100),
(368, 20, 'inventory', '127.0.0.1', 'inventory', 'url=inventory/Inventory-2', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452101),
(369, 20, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory/Inventory-2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452280),
(370, 20, 'error', '127.0.0.1', 'error', 'url=includes/update.php&id=1&t=cart&c=quantity&da=0', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452295),
(371, 20, 'testimonials', '127.0.0.1', 'testimonials', 'url=testimonials', '', 'http://localhost/LibreCMS/includes/update.php?id=1&t=cart&c=quantity&da=0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452314),
(372, 20, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/testimonials', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452315),
(373, 20, 'inventory', '127.0.0.1', 'inventory', 'url=inventory/Inventory-2', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452316),
(374, 20, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452451),
(375, 20, 'inventory', '127.0.0.1', 'inventory', 'url=inventory/Inventory-2', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452454),
(376, 20, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory/Inventory-2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452636),
(377, 20, 'error', '127.0.0.1', 'error', 'url=includes/update.php&id=1&t=cart&c=quantity&da=2', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452651),
(378, 20, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/includes/update.php?id=1&t=cart&c=quantity&da=2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452760),
(379, 20, 'bookings', '127.0.0.1', 'bookings', 'url=bookings', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452780),
(380, 20, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/bookings', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452781);
INSERT INTO `tracker` (`id`, `vid`, `contentType`, `ip`, `pageName`, `queryString`, `hostname`, `httpReferer`, `httpUserAgent`, `bot`, `browser`, `os`, `ti`) VALUES
(381, 20, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452782),
(382, 20, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452782),
(383, 20, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452783),
(384, 20, 'article', '127.0.0.1', 'article', 'url=article/the-long-game', '', 'http://localhost/LibreCMS/article/doctor-who/funny', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452794),
(385, 20, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452794),
(386, 20, 'inventory', '127.0.0.1', 'inventory', 'url=inventory/inventory-2', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452795),
(387, 20, 'services', '127.0.0.1', 'services', 'url=services/services-3', '', 'http://localhost/LibreCMS/inventory/inventory-2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452797),
(388, 20, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/services/services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452798),
(389, 20, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452799),
(390, 20, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452801),
(391, 20, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452810),
(392, 20, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452810),
(393, 20, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452958),
(394, 20, 'article', '127.0.0.1', 'article', 'url=article/the-long-game', '', 'http://localhost/LibreCMS/article/doctor-who', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452966),
(395, 20, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430452966),
(396, 20, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/the-long-game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430453090),
(397, 20, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430453151),
(398, 20, 'error', '127.0.0.1', 'error', 'url=images/noavatar.jpg', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430453151),
(399, 20, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430453513),
(400, 21, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430455511),
(401, 21, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/admin/content/edit/1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430458115),
(402, 21, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430458115),
(403, 22, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430458122),
(404, 23, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430458146),
(405, 23, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430458151),
(406, 23, 'inventory', '127.0.0.1', 'inventory', 'url=inventory/Inventory-2', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430458152),
(407, 23, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/inventory/Inventory-2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430458154),
(408, 23, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430458155),
(409, 23, 'inventory', '127.0.0.1', 'inventory', 'url=inventory/inventory-2', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430460554),
(410, 23, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/inventory/inventory-2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430460556),
(411, 23, 'inventory', '127.0.0.1', 'inventory', 'url=inventory/Inventory-2', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430460558),
(412, 23, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/inventory/Inventory-2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430460560),
(413, 23, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430460561),
(414, 23, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430460564),
(415, 23, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430460584),
(416, 23, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430460584),
(417, 23, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430460585),
(418, 23, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430460587),
(419, 23, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430462063),
(420, 24, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430470513),
(421, 24, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430470515),
(422, 24, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430470640),
(423, 24, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430470714),
(424, 24, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430471616),
(425, 24, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430471617),
(426, 24, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430471634),
(427, 24, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430471636),
(428, 24, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430471712),
(429, 24, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430471716),
(430, 24, 'error', '127.0.0.1', 'error', 'url=includes/add_data.php', '', 'http://localhost/LibreCMS/admin/accounts/edit/1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430473982),
(431, 24, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/admin/accounts/edit/1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474053),
(432, 24, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474053),
(433, 24, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474054),
(434, 24, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474055),
(435, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474066),
(436, 25, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474068),
(437, 25, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474070),
(438, 25, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474329),
(439, 25, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474330),
(440, 25, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474467),
(441, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474475),
(442, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474475),
(443, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474633),
(444, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474633),
(445, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474701),
(446, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474701),
(447, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474725),
(448, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474725),
(449, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474739),
(450, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474739),
(451, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474752),
(452, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474752),
(453, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474761),
(454, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474761),
(455, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474783),
(456, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474783),
(457, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474785),
(458, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474785),
(459, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474797),
(460, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474797),
(461, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474818),
(462, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474818),
(463, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474868),
(464, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474868),
(465, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474877),
(466, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474877),
(467, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474889),
(468, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474889),
(469, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474908),
(470, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474908),
(471, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474919),
(472, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474919),
(473, 25, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430474929),
(474, 25, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430475052),
(475, 25, 'inventory', '127.0.0.1', 'inventory', 'url=inventory/Inventory-2', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430475054),
(476, 25, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/inventory/Inventory-2', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430475056),
(477, 25, 'services', '127.0.0.1', 'services', 'url=services/Services-3', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430475058),
(478, 25, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/services/Services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430475059),
(479, 25, 'error', '127.0.0.1', 'error', 'url=<print content=bookservice>', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430475060),
(480, 25, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/%3Cprint%20content=bookservice%3E', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430475067),
(481, 25, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430475074),
(482, 25, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430475234),
(483, 25, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430475234),
(484, 26, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430536366),
(485, 26, 'error', '127.0.0.1', 'error', 'url=<print content=file>', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430536366),
(486, 26, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430536669),
(487, 26, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430536846),
(488, 26, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430536970),
(489, 26, 'testimonials', '127.0.0.1', 'testimonials', 'url=testimonials', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430536976),
(490, 26, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/testimonials', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430536977),
(491, 26, 'bookings', '127.0.0.1', 'bookings', 'url=bookings', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430539324),
(492, 26, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/bookings', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430539499),
(493, 26, 'services', '127.0.0.1', 'services', 'url=services/Services-3', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430539500),
(494, 26, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/services/Services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430539503),
(495, 26, 'services', '127.0.0.1', 'services', 'url=services/Services-3', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430539507),
(496, 26, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/services/Services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430539510),
(497, 26, 'services', '127.0.0.1', 'services', 'url=services/Services-3', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430540049),
(498, 26, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/admin/content/edit/3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430540124),
(499, 26, 'services', '127.0.0.1', 'services', 'url=services/Services-3', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430540158),
(500, 26, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/services/Services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430540170),
(501, 26, 'bookings', '127.0.0.1', 'bookings', 'url=bookings/http:/localhost/LibreCMS/bookings/3', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430540176),
(502, 26, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/bookings', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430540188),
(503, 26, 'services', '127.0.0.1', 'services', 'url=services/Services-3', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430540243),
(504, 26, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/services/Services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430540288),
(505, 26, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430540969),
(506, 26, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430540987),
(507, 27, 'services', '127.0.0.1', 'services', 'url=services/Services-3', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430541011),
(508, 27, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/services/Services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430541017),
(509, 27, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430541019),
(510, 27, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430541021),
(511, 28, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430555582),
(512, 28, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430555600),
(513, 29, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430559480),
(514, 29, 'bookings', '127.0.0.1', 'bookings', 'url=bookings/http:/localhost/LibreCMS/bookings/3', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430559492),
(515, 29, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/bookings/http://localhost/LibreCMS/bookings/3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430561155),
(516, 29, 'bookings', '127.0.0.1', 'bookings', 'url=bookings/http:/localhost/LibreCMS/bookings/3', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430561644),
(517, 29, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/bookings/http://localhost/LibreCMS/bookings/3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430561771),
(518, 29, 'bookings', '127.0.0.1', 'bookings', 'url=bookings/3', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430561774),
(519, 29, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/bookings/3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430562154),
(520, 29, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430562155),
(521, 29, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430562157),
(522, 29, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430562521),
(523, 30, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430697321),
(524, 31, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1430727785),
(525, 32, 'index', '192.168.0.3', 'index', '', '', 'http://192.168.0.6/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0', 'visitor', 'Firefox', 'linux', 1430732335),
(526, 32, 'article', '192.168.0.3', 'article', 'url=article', '', 'http://192.168.0.6/LibreCMS/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0', 'visitor', 'Firefox', 'linux', 1430732360),
(527, 32, 'article', '192.168.0.3', 'article', 'url=article/The-Long-Game', '', 'http://192.168.0.6/LibreCMS/article', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0', 'visitor', 'Firefox', 'linux', 1430732365),
(528, 32, 'index', '192.168.0.3', 'index', '', '', 'http://192.168.0.6/LibreCMS/admin/statistics', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0', 'visitor', 'Firefox', 'linux', 1430732520),
(529, 32, 'settings', '192.168.0.3', 'settings', 'url=settings', '', 'http://192.168.0.6/LibreCMS/', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0', 'visitor', 'Firefox', 'linux', 1430732525),
(530, 32, 'proofs', '192.168.0.3', 'proofs', 'url=proofs', '', 'http://192.168.0.6/LibreCMS/settings', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0', 'visitor', 'Firefox', 'linux', 1430732537),
(531, 33, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431335759),
(532, 34, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431342681),
(533, 35, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431401540),
(534, 35, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431401549),
(535, 35, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431403364),
(536, 35, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431403501),
(537, 35, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431403503),
(538, 35, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431404055),
(539, 35, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431404139),
(540, 35, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431404332),
(541, 35, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431404639),
(542, 35, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431404792),
(543, 35, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431406123),
(544, 35, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431407001),
(545, 35, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431407010),
(546, 35, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431408372),
(547, 35, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431408750),
(548, 35, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431408935),
(549, 35, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431408938),
(550, 35, 'services', '127.0.0.1', 'services', 'url=services/Services-3', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431410305),
(551, 35, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/services/Services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431410310),
(552, 36, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431418973),
(553, 36, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431419350),
(554, 36, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431419354),
(555, 36, 'testimonials', '127.0.0.1', 'testimonials', 'url=testimonials', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431419356),
(556, 36, 'bookings', '127.0.0.1', 'bookings', 'url=bookings', '', 'http://localhost/LibreCMS/testimonials', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431419357),
(557, 36, 'events', '127.0.0.1', 'events', 'url=events', '', 'http://localhost/LibreCMS/bookings', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431419359),
(558, 36, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/events', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431419360),
(559, 36, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431419363),
(560, 36, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431419365),
(561, 36, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431419453),
(562, 36, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431419467),
(563, 36, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431420138),
(564, 36, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431420263),
(565, 36, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431420267),
(566, 36, 'bookings', '127.0.0.1', 'bookings', 'url=bookings', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431420268),
(567, 36, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/bookings', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431420269),
(568, 36, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431420270),
(569, 36, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431420389),
(570, 36, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431420595),
(571, 36, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431420597),
(572, 36, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431420662),
(573, 36, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431420663),
(574, 36, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431420732),
(575, 36, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421119),
(576, 36, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421124),
(577, 36, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421133);
INSERT INTO `tracker` (`id`, `vid`, `contentType`, `ip`, `pageName`, `queryString`, `hostname`, `httpReferer`, `httpUserAgent`, `bot`, `browser`, `os`, `ti`) VALUES
(578, 36, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421133),
(579, 36, 'bookings', '127.0.0.1', 'bookings', 'url=bookings', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421135),
(580, 36, 'events', '127.0.0.1', 'events', 'url=events', '', 'http://localhost/LibreCMS/bookings', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421136),
(581, 36, 'news', '127.0.0.1', 'news', 'url=news', '', 'http://localhost/LibreCMS/events', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421137),
(582, 36, 'testimonials', '127.0.0.1', 'testimonials', 'url=testimonials', '', 'http://localhost/LibreCMS/news', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421138),
(583, 36, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/testimonials', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421138),
(584, 36, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421140),
(585, 36, 'gallery', '127.0.0.1', 'gallery', 'url=gallery', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421141),
(586, 36, 'contactus', '127.0.0.1', 'contactus', 'url=contactus', '', 'http://localhost/LibreCMS/gallery', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421143),
(587, 36, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/contactus', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421979),
(588, 36, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431421981),
(589, 36, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431422047),
(590, 37, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431428759),
(591, 38, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431431712),
(592, 38, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431433613),
(593, 38, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431433753),
(594, 38, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431434053),
(595, 38, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431434059),
(596, 38, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431434061),
(597, 38, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431434065),
(598, 38, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431434595),
(599, 38, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431434599),
(600, 38, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431435573),
(601, 38, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431436456),
(602, 38, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431436509),
(603, 38, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431439139),
(604, 39, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431501947),
(605, 39, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431501949),
(606, 40, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431508592),
(607, 40, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431508593),
(608, 41, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431559926),
(609, 41, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431559928),
(610, 41, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431559930),
(611, 41, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431560070),
(612, 41, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431560072),
(613, 41, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431560588),
(614, 42, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431567715),
(615, 43, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431577036),
(616, 44, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431583756),
(617, 45, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431598097),
(618, 46, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431599290),
(619, 46, 'error', '127.0.0.1', 'error', 'url=></div><div class=', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431600333),
(620, 46, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431600468),
(621, 46, 'error', '127.0.0.1', 'error', 'url=></div><div class=', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431600468),
(622, 46, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431600471),
(623, 46, 'error', '127.0.0.1', 'error', 'url=includes/images/noavatar.jpg', '', 'http://localhost/LibreCMS/admin/content/edit/1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601088),
(624, 46, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601108),
(625, 46, 'error', '127.0.0.1', 'error', 'url=core/images/noavatar.jpg', '', 'http://localhost/LibreCMS/admin/content/edit/1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601112),
(626, 46, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601116),
(627, 46, 'error', '127.0.0.1', 'error', 'url=core/images/noavatar.jpg', '', 'http://localhost/LibreCMS/admin/content/edit/1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601124),
(628, 46, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601126),
(629, 46, 'error', '127.0.0.1', 'error', 'url=core/images/noavatar.jpg', '', 'http://localhost/LibreCMS/admin/content/edit/1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601718),
(630, 46, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601723),
(631, 46, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/admin/content/edit/1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601967),
(632, 46, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601971),
(633, 46, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601977),
(634, 47, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601984),
(635, 47, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431601985),
(636, 47, 'error', '127.0.0.1', 'error', 'url=core/images/noavatar.jpg', '', 'http://localhost/LibreCMS/admin/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431602008),
(637, 47, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431602022),
(638, 48, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431602027),
(639, 49, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431609476),
(640, 49, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431610945),
(641, 49, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431610947),
(642, 49, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431610983),
(643, 49, 'services', '127.0.0.1', 'services', 'url=services/Services-3', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431610988),
(644, 49, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/services/Services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431610994),
(645, 49, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431610995),
(646, 50, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431643721),
(647, 50, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431643722),
(648, 50, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431643724),
(649, 50, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431643731),
(650, 51, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431660990),
(651, 52, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431671159),
(652, 52, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431671163),
(653, 52, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431671168),
(654, 52, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431671170),
(655, 52, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431672162),
(656, 52, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431672164),
(657, 52, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431672170),
(658, 52, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431672194),
(659, 53, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431674820),
(660, 54, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431685979),
(661, 55, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431688882),
(662, 55, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431690695),
(663, 55, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431690762),
(664, 55, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431690809),
(665, 55, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431690821),
(666, 55, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431691422),
(667, 55, 'services', '127.0.0.1', 'services', 'url=services/Services-3', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431691423),
(668, 55, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/services/Services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431691481),
(669, 55, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431691482),
(670, 55, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431692041),
(671, 55, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431692370),
(672, 55, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431692394),
(673, 55, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431692411),
(674, 55, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431692829),
(675, 55, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431692830),
(676, 55, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431692832),
(677, 55, 'bookings', '127.0.0.1', 'bookings', 'url=bookings', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431692832),
(678, 55, 'events', '127.0.0.1', 'events', 'url=events', '', 'http://localhost/LibreCMS/bookings', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431692833),
(679, 55, 'news', '127.0.0.1', 'news', 'url=news', '', 'http://localhost/LibreCMS/events', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431692834),
(680, 55, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/news', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431692835),
(681, 55, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431692836),
(682, 56, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431742161),
(683, 56, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431742163),
(684, 56, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431742164),
(685, 56, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431743042),
(686, 56, 'services', '127.0.0.1', 'services', 'url=services/Services-3', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431743045),
(687, 56, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/services/Services-3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431743136),
(688, 56, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431743138),
(689, 57, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431824485),
(690, 57, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431824486),
(691, 57, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431824488),
(692, 58, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431830459),
(693, 58, 'error', '127.0.0.1', 'error', 'url=core/images/noavatar.jpg', '', 'http://localhost/LibreCMS/admin/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431830471),
(694, 58, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/admin/content/edit/1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431830490),
(695, 59, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431830500),
(696, 60, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431836480),
(697, 61, 'error', '127.0.0.1', 'error', 'url=core/images/noavatar.jpg', '', 'http://localhost/LibreCMS/admin/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431841199),
(698, 61, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431841225),
(699, 61, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431841234),
(700, 61, 'proofs', '127.0.0.1', 'proofs', 'url=proofs', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431841235),
(701, 62, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/logout', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431841381),
(702, 62, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431841383),
(703, 63, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431850815),
(704, 63, 'bookings', '127.0.0.1', 'bookings', 'url=bookings', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431850819),
(705, 63, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/LibreCMS/bookings', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431850821),
(706, 64, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431859473),
(707, 65, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431914134),
(708, 65, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431914137),
(709, 66, 'article', '127.0.0.1', 'article', 'url=article/The-Long-Game', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431922582),
(710, 66, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431925722),
(711, 67, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431938959),
(712, 67, 'portfolio', '127.0.0.1', 'portfolio', 'url=portfolio', '', 'http://localhost/LibreCMS/article/The-Long-Game', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431938971),
(713, 67, 'contactus', '127.0.0.1', 'contactus', 'url=contactus', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431938974),
(714, 67, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/contactus', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431938980),
(715, 67, 'contactus', '127.0.0.1', 'contactus', 'url=contactus', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431938981),
(716, 67, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/contactus', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431939089),
(717, 67, 'contactus', '127.0.0.1', 'contactus', 'url=contactus', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431939133),
(718, 67, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/contactus', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431939154),
(719, 67, 'contactus', '127.0.0.1', 'contactus', 'url=contactus', '', 'http://localhost/LibreCMS/portfolio', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431939155),
(720, 67, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/contactus', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1431939279),
(721, 68, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432001131),
(722, 68, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432001133),
(723, 69, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432032727),
(724, 69, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432032833),
(725, 69, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432032836),
(726, 69, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432033130),
(727, 69, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432033133),
(728, 70, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432043241),
(729, 70, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432043935),
(730, 70, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432043937),
(731, 70, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432046240),
(732, 70, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432046244),
(733, 71, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432075276),
(734, 71, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432075280),
(735, 71, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432075284),
(736, 71, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432075286),
(737, 71, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432075289),
(738, 72, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432086570),
(739, 72, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432086573),
(740, 72, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432086575),
(741, 72, 'error', '127.0.0.1', 'error', 'url=core/updatecart.php&act=quantity&id=5&t=cart&c=quantity&da=0', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432086651),
(742, 72, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432086654),
(743, 73, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432092603),
(744, 74, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432104974),
(745, 74, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432106115),
(746, 74, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432106117),
(747, 74, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432106179),
(748, 74, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432106182),
(749, 74, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432106257),
(750, 74, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432106259),
(751, 74, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432106302),
(752, 74, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432106304),
(753, 74, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432108760),
(754, 74, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432108763),
(755, 74, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432108768),
(756, 74, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432108770),
(757, 74, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432109122),
(758, 74, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432109123),
(759, 74, 'services', '127.0.0.1', 'services', 'url=services', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432109125),
(760, 74, 'bookings', '127.0.0.1', 'bookings', 'url=bookings/3', '', 'http://localhost/LibreCMS/services', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432109127),
(761, 74, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/bookings/3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432109132),
(762, 74, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432110448),
(763, 74, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432110450),
(764, 74, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432110735),
(765, 74, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432110738),
(766, 75, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432117383),
(767, 75, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432117386),
(768, 76, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432117756),
(769, 76, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432117760),
(770, 76, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432117764),
(771, 77, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432207748),
(772, 77, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432207749),
(773, 78, 'index', '127.0.0.1', 'index', '', '', 'http://localhost/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432262614);
INSERT INTO `tracker` (`id`, `vid`, `contentType`, `ip`, `pageName`, `queryString`, `hostname`, `httpReferer`, `httpUserAgent`, `bot`, `browser`, `os`, `ti`) VALUES
(774, 78, 'article', '127.0.0.1', 'article', 'url=article', '', 'http://localhost/LibreCMS/', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432262616),
(775, 78, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/article', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432262618),
(776, 78, 'inventory', '127.0.0.1', 'inventory', 'url=inventory', '', 'http://localhost/LibreCMS/cart', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432262619),
(777, 78, 'cart', '127.0.0.1', 'cart', 'url=cart', '', 'http://localhost/LibreCMS/inventory', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36', 'visitor', 'Chrome', 'linux', 1432262622);

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
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
MODIFY `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
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
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=778;