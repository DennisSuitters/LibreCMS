-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2015 at 09:42 PM
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
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iid` bigint(20) unsigned NOT NULL,
  `quantity` mediumint(20) unsigned NOT NULL,
  `cost` decimal(10,2) unsigned NOT NULL,
  `si` varchar(128) COLLATE utf8_bin NOT NULL,
  `ti` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE IF NOT EXISTS `choices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL,
  `rid` bigint(20) unsigned NOT NULL,
  `contentType` varchar(16) COLLATE utf8_bin NOT NULL,
  `rank` int(4) unsigned NOT NULL,
  `icon` varchar(20) COLLATE utf8_bin NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `title` varchar(60) COLLATE utf8_bin NOT NULL,
  `ti` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `contentType` varchar(16) COLLATE utf8_bin NOT NULL,
  `rid` bigint(20) unsigned NOT NULL,
  `uid` bigint(20) unsigned NOT NULL,
  `cid` bigint(20) unsigned NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
  `name` varchar(40) COLLATE utf8_bin NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `status` varchar(16) COLLATE utf8_bin NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `ti` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
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
  `ti` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

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
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `backgroundColor` varchar(8) COLLATE utf8_bin NOT NULL,
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
  `eti` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `options`, `rank`, `rid`, `uid`, `login_user`, `cid`, `ip`, `contentType`, `schemaType`, `keywords`, `code`, `brand`, `title`, `category_1`, `category_2`, `name`, `url`, `email`, `business`, `address`, `suburb`, `city`, `state`, `postcode`, `phone`, `thumb`, `file`, `cost`, `subject`, `notes`, `quantity`, `tags`, `caption`, `status`, `service`, `internal`, `featured`, `backgroundColor`, `bookable`, `fti`, `assoc`, `ord`, `views`, `active`, `tis`, `tie`, `lti`, `ti`, `eti`) VALUES
(1, '00000000', 0, 0, 1, 'Dennis J Suitters', 0, '', 'article', 'blogPost', 'doctor who,game', '', '', 'The Long Game', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_1.jpg', 'file_1.jpg', 0.00, '', '<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<h2>The Parting of the Ways</h2>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels.</p>\r\n<h3>The Impossible Astronaut</h3>\r\n<p>Saving the world with meals on wheels. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<h4>The Beast Below</h4>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<h5>Voyage of the Damned</h5>\r\n<p>You''ve swallowed a planet! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', 0, 'doctor who,game', '', 'published', 0, 0, 1, '#ffffff', 0, 0, '', 1, 0, 1, 0, 0, 0, 1429270672, 1429277196);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `ti` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `options`, `username`, `password`, `avatar`, `gravatar`, `business`, `name`, `email`, `email_check`, `url`, `address`, `suburb`, `city`, `state`, `postcode`, `abn`, `phone`, `mobile`, `notes`, `status`, `active`, `activate`, `adminCategory_1`, `adminCategory_2`, `adminCategory_ti`, `language`, `timezone`, `rank`, `ti`) VALUES
(1, '11111111', 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ecc7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'avatar_1.png', '', '', 'Dennis J Suitters', 'dennis@studiojunkyard.com', 0, '', '128 Cradle Mountain Road', 'Wilmot', 'Wilmot', 'Tasmania', 7310, '', '', '', '', '', 1, '', '', '', 0, 'en', 'Australia/Hobart', 1000, 1402746479);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `eti` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

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
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `ti` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

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
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `oid` bigint(20) unsigned NOT NULL,
  `iid` bigint(20) unsigned NOT NULL,
  `title` varchar(60) COLLATE utf8_bin NOT NULL,
  `quantity` mediumint(9) unsigned NOT NULL,
  `cost` decimal(10,2) unsigned NOT NULL,
  `status` varchar(16) COLLATE utf8_bin NOT NULL,
  `ti` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `eti` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `search` varchar(64) COLLATE utf8_bin NOT NULL,
  `views` bigint(20) unsigned NOT NULL,
  `ti` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `seo`
--

CREATE TABLE IF NOT EXISTS `seo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) NOT NULL,
  `login_user` varchar(128) COLLATE utf8_bin NOT NULL,
  `seo_name` varchar(128) COLLATE utf8_bin NOT NULL,
  `seo_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `seo_title` tinytext COLLATE utf8_bin NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `eti` int(10) NOT NULL,
  `views` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

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
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `ti` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
