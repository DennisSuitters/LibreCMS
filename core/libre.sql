-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 15, 2016 at 01:27 AM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `libre`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
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

DROP TABLE IF EXISTS `choices`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
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

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `id` tinyint(1) unsigned NOT NULL,
  `maintenance` int(1) NOT NULL,
  `options` varchar(32) COLLATE utf8_bin NOT NULL,
  `theme` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoTitle` varchar(60) COLLATE utf8_bin NOT NULL,
  `seoDescription` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoCaption` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoKeywords` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoRSSTitle` tinytext COLLATE utf8_bin NOT NULL,
  `seoRSSNotes` text COLLATE utf8_bin NOT NULL,
  `seoRSSLink` varchar(256) COLLATE utf8_bin NOT NULL,
  `seoRSSAuthor` tinytext COLLATE utf8_bin NOT NULL,
  `seoRSSti` bigint(20) NOT NULL,
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
  `orderPayti` int(10) unsigned NOT NULL,
  `orderEmailSubject` tinytext COLLATE utf8_bin NOT NULL,
  `orderEmailLayout` text COLLATE utf8_bin NOT NULL,
  `orderEmailNotes` text COLLATE utf8_bin NOT NULL,
  `passwordResetLayout` text COLLATE utf8_bin NOT NULL,
  `passwordResetSubject` tinytext COLLATE utf8_bin NOT NULL,
  `accountActivationSubject` tinytext COLLATE utf8_bin NOT NULL,
  `accountActivationLayout` text COLLATE utf8_bin NOT NULL,
  `bookingEmailSubject` tinytext COLLATE utf8_bin NOT NULL,
  `bookingEmailLayout` text COLLATE utf8_bin NOT NULL,
  `bookingAutoReplySubject` tinytext COLLATE utf8_bin NOT NULL,
  `bookingAutoReplyLayout` text COLLATE utf8_bin NOT NULL,
  `contactAutoReplySubject` tinytext COLLATE utf8_bin NOT NULL,
  `contactAutoReplyLayout` text COLLATE utf8_bin NOT NULL,
  `bank` varchar(60) COLLATE utf8_bin NOT NULL,
  `bankAccountName` varchar(40) COLLATE utf8_bin NOT NULL,
  `bankAccountNumber` varchar(40) COLLATE utf8_bin NOT NULL,
  `bankBSB` varchar(16) COLLATE utf8_bin NOT NULL,
  `bankPayPal` varchar(60) COLLATE utf8_bin NOT NULL,
  `showItems` int(4) NOT NULL,
  `idleTime` int(6) NOT NULL,
  `git_commits` longblob NOT NULL,
  `git_ti` int(10) NOT NULL,
  `ga_clientID` varchar(128) COLLATE utf8_bin NOT NULL,
  `ga_tracking` text COLLATE utf8_bin NOT NULL,
  `ga_verification` tinytext COLLATE utf8_bin NOT NULL,
  `bti` int(10) unsigned NOT NULL,
  `backup_ti` int(10) NOT NULL,
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `maintenance`, `options`, `theme`, `seoTitle`, `seoDescription`, `seoCaption`, `seoKeywords`, `seoRSSTitle`, `seoRSSNotes`, `seoRSSLink`, `seoRSSAuthor`, `seoRSSti`, `business`, `abn`, `address`, `suburb`, `city`, `state`, `country`, `postcode`, `phone`, `mobile`, `email`, `vti`, `sti`, `dateFormat`, `email_check`, `email_interval`, `language`, `timezone`, `orderPayti`, `orderEmailSubject`, `orderEmailLayout`, `orderEmailNotes`, `passwordResetLayout`, `passwordResetSubject`, `accountActivationSubject`, `accountActivationLayout`, `bookingEmailSubject`, `bookingEmailLayout`, `bookingAutoReplySubject`, `bookingAutoReplyLayout`, `contactAutoReplySubject`, `contactAutoReplyLayout`, `bank`, `bankAccountName`, `bankAccountNumber`, `bankBSB`, `bankPayPal`, `showItems`, `idleTime`, `git_commits`, `git_ti`, `ga_clientID`, `ga_tracking`, `ga_verification`, `bti`, `backup_ti`, `ti`) VALUES
(1, 0, '1111111110000000', 'animeexcess', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', 0, '', '', '', 0, 3600, 'M j, Y g:i A', 1425893894, 3600, 'en-AU', 'Australia/Hobart', 1209600, '', 'Hello {first},<br><br>Please find attached Order {order_number}<br>Note: {notes}', 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b> services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', '<p>Hi {name},</p><p>A Password Reset was requested, it is now: {password}</p><p>We recommend changing the above password after logging in.</p>', '', '', '<p>Hi {username},</p><p>This is your activation link, and password.</p><p>Activation Link: {activation_link}</p><p>NOTE: You won''t be able to login until you activate your account.</p><p>Password: {password}</p><p>We recommend changing the password after logging in.</p>', '', '', '', '', '{business} Contact Confirmation on {date}', '<p>Hi {first],</p><p>Thank you for contacting {business}, someone will get back to you ASAP.</p><p>Kind Regards,</p><p>{business}</p><p><br></p>', '', '', '', '', '', 10, 24, '', 0, '', '', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
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
  `seoKeywords` varchar(255) COLLATE utf8_bin NOT NULL,
  `barcode` varchar(128) COLLATE utf8_bin NOT NULL,
  `fccid` varchar(20) COLLATE utf8_bin NOT NULL,
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
  `cost` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `subject` varchar(60) COLLATE utf8_bin NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `attributionContentName` tinytext COLLATE utf8_bin NOT NULL,
  `attributionContentURL` varchar(256) COLLATE utf8_bin NOT NULL,
  `quantity` mediumint(20) unsigned NOT NULL,
  `tags` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoCaption` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoDescription` varchar(255) COLLATE utf8_bin NOT NULL,
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
  `eti` int(10) NOT NULL,
  `pti` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
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

INSERT INTO `login` (`id`, `options`, `username`, `password`, `cover`, `coverURL`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `avatar`, `gravatar`, `business`, `name`, `email`, `emailPassword`, `email_check`, `url`, `address`, `suburb`, `city`, `state`, `postcode`, `abn`, `phone`, `mobile`, `notes`, `status`, `active`, `activate`, `language`, `timezone`, `rank`, `discount`, `lti`, `ti`) VALUES
(1, '11111111', 'root', '$2y$10$l2zExmUgh8.L2sGfpHkA0.9gBEvrgViOBBC9TXDulA04iFCInmmFO', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', '', 1, '', 'en-AU', 'Australia/Hobart', 1000, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
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

DROP TABLE IF EXISTS `menu`;
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `uid`, `login_user`, `title`, `seoTitle`, `file`, `cover`, `coverURL`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `contentType`, `schemaType`, `seoKeywords`, `seoDescription`, `seoCaption`, `menu`, `notes`, `ord`, `active`, `views`, `eti`) VALUES
(1, 1, '', 'Home', '', '', '', '', '', '', '', 'index', '', '', '', '', 'head', '', 0, 1, 57, 0),
(2, 1, '', 'Blog', '', 'article', '', '', '', '', '', 'article', '', '', '', '', 'head', '', 3, 1, 4, 0),
(3, 1, '', 'Portfolio', '', 'portfolio', '', '', '', '', '', 'portfolio', '', '', '', '', 'head', '', 8, 0, 0, 0),
(4, 1, '', 'Bookings', '', 'bookings', '', '', '', '', '', 'bookings', '', '', '', '', 'head', '', 9, 0, 0, 0),
(5, 1, '', 'Events', '', 'events', '', '', '', '', '', 'event', '', '', '', '', 'head', '', 7, 0, 0, 0),
(6, 1, '', 'News', '', 'news', '', '', '', '', '', 'news', '', '', '', '', 'head', '', 6, 0, 0, 0),
(7, 1, '', 'Testimonials', '', 'testimonials', '', '', '', '', '', 'testimonials', '', '', '', '', 'head', '', 4, 0, 0, 0),
(8, 1, 'root', 'Products', '', 'inventory', '', '', '', '', '', 'inventory', '', '', '', '', 'head', '', 1, 1, 6, 1462448976),
(9, 1, '', 'Services', '', 'services', '', '', '', '', '', 'service', '', '', '', '', 'head', '', 2, 0, 0, 0),
(10, 1, '', 'Gallery', '', 'gallery', '', '', '', '', '', 'gallery', '', '', '', '', 'head', '', 1, 0, 0, 0),
(11, 1, 'root', 'Contact Us', '', 'contactus', '', '', '', '', '', 'contactus', '', '', '', '', 'head', '', 4, 1, 4, 1462449065),
(12, 1, 'root', 'Cart', '', 'cart', '', '', '', '', '', 'cart', '', '', '', '', 'footer', '', 5, 1, 0, 1462449035),
(13, 1, '', 'Terms of Service', '', 'tos', '', '', '', '', '', 'tos', '', '', '', '', 'footer', '', 13, 0, 0, 0),
(14, 1, '', 'Search', '', 'search', '', '', '', '', '', 'search', '', '', '', '', 'footer', '', 6, 1, 0, 0),
(15, 1, 'root', 'About', '', 'aboutus', '', '', '', '', '', 'aboutus', '', '', '', '', 'head', '', 2, 1, 4, 1462449005);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
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
  `from_business` tinytext COLLATE utf8_bin NOT NULL,
  `from_phone` tinytext COLLATE utf8_bin NOT NULL,
  `from_mobile` tinytext COLLATE utf8_bin NOT NULL,
  `from_address` tinytext COLLATE utf8_bin NOT NULL,
  `from_suburb` tinytext COLLATE utf8_bin NOT NULL,
  `from_city` tinytext COLLATE utf8_bin NOT NULL,
  `from_state` tinytext COLLATE utf8_bin NOT NULL,
  `from_postcode` tinytext COLLATE utf8_bin NOT NULL,
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

DROP TABLE IF EXISTS `orderitems`;
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

DROP TABLE IF EXISTS `orders`;
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
  `recurring` int(1) NOT NULL,
  `ti` int(10) unsigned NOT NULL,
  `eti` bigint(20) NOT NULL
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
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
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