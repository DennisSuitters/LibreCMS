-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 02, 2015 at 11:03 AM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

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

INSERT INTO `config` (`id`, `options`, `theme`, `seoTitle`, `seoDescription`, `seoCaption`, `seoKeywords`, `business`, `abn`, `address`, `suburb`, `city`, `state`, `country`, `postcode`, `phone`, `mobile`, `email`, `vti`, `sti`, `dateFormat`, `language`, `timezone`, `itemCount`, `orderPayti`, `orderEmailDefaultSubject`, `orderEmailLayout`, `orderEmailNotes`, `bank`, `bankAccountName`, `bankAccountNumber`, `bankBSB`, `bankPayPal`, `bti`, `ti`) VALUES
(1, '11111111', 'default', 'LibreCMS', 'Default Site Description', 'Default Site Caption', 'Default Site Keywords', '', '', '', '', '', '', '', 0, '', '', '', 1406180963, 3600, 'M j, Y g:i A', 'en', 'Australia/Hobart', 4, 1209600, '{name}: Invoice: {order_number}', 'Hello {first},<br><br>Please find attached Order {order_number}<br>Note: {notes}', 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', '', '', '', '', '', 1404461417, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `options` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT '00000000',
  `username` varchar(128) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `avatar` varchar(60) COLLATE utf8_bin NOT NULL,
  `gravatar` varchar(60) COLLATE utf8_bin NOT NULL,
  `business` varchar(40) COLLATE utf8_bin NOT NULL,
  `name` varchar(40) COLLATE utf8_bin NOT NULL,
  `email` varchar(60) COLLATE utf8_bin NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `options`, `username`, `password`, `avatar`, `gravatar`, `business`, `name`, `email`, `url`, `address`, `suburb`, `city`, `state`, `postcode`, `abn`, `phone`, `mobile`, `notes`, `status`, `active`, `activate`, `adminCategory_1`, `adminCategory_2`, `adminCategory_ti`, `language`, `timezone`, `rank`, `ti`) VALUES
(1, '11111111', 'admin', '$2y$10$dYvrhTGiUhWjHYgXWgg/muDXisNfS7z5y5AQ72dJAelV0YezL/gY6', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 1, '', '', '', 0, 'en', 'Australia/Hobart', 1000, 1402746479);

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
(1, 0, '', 'Home', '', 'index', '', '', '', '', 'head', '', 0, 1, 1422800072),
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
(13, 0, '', 'Terms of Service', 'Terms of Service', 'tos', '', '', '', '', 'footer', '<h2 style="font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; color: rgb(51, 51, 51);">Terms and Conditions Regulating Email Collection</h2><h4 style="font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; color: rgb(51, 51, 51);">TERMS AND CONDITIONS OF USE</h4><p>The website from which you accessed this agreement ("studiojunkyard.com/") is provided to you subject to the following conditions. These terms are in addition to any other terms governing access to the Website. By visiting (in any manner) the Website you accept these terms and conditions (the "Terms of Service"). Please read them carefully.</p><p>Any Non-Human Visitors to the Website shall be considered agents of the individual(s) who controls, authors or otherwise makes use of them. These individuals shall ultimately be responsible for the behavior of their Non-Human Visitor agents and are liable for violations of the Terms of Service.</p><h4 style="font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; color: rgb(51, 51, 51);">SPECIAL LICENSE RESTRICTIONS FOR NON-HUMAN VISITORS</h4><p>Special restrictions on a visitor''s license to access the Website apply to Non-Human Visitors. Non-Human Visitors include, but are not limited to, web spiders, bots, indexers, robots, crawlers, harvesters, or any other computer programs designed to access, read, compile or gather content from the Website automatically. Non-Human Visitors are restricted from taxing the resources of the Website beyond what would be typical of a human visitor.</p><p>Furthermore, as specified by the "no-email-collection" flag in the header pages within the Website and/or the contents of the robots.txt file, email addresses on this site are considered proprietary intellectual property of the author of the Website. It is recognized that these email addresses are provided for human visitors alone, and have value in part because they are accessible only to said human visitors. By continuing to access the Website, You acknowledge and agree that each email address the Website contains has a value not less than US $500 derived from their relative secrecy. You further agree that the compilation, storage, and potential distribution of these addresses by Non-Human Visitors substantially diminish the value of these addresses. Intentional collection, harvesting, gathering, or storing email addresses by Non-Human Visitors is recognized under this agreement as a violation of this agreement and expressly prohibited.</p><h4 style="font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; color: rgb(51, 51, 51);">APPLICABLE LAW AND JURISDICTION</h4><p>Each party agrees that any suit, action or proceeding brought by such party against the other in connection with or arising from the Terms of Service ("Judicial Action") shall be governed by the law of the state of residence of the registered Administrative Contact (the "Admin State") for the Website as such laws are applied to agreements between Admin State residents entered into and performed entirely within the Admin State. The visitor to the Website consents to the jurisdiction of federal and state courts within the Admin State. The visitor to the Website consents to the venue in any action brought against him in connection with breaches of these Terms of Service. The visitor to the Website consents to electronic service of process regarding actions under the above agreement.</p><h4 style="font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; color: rgb(51, 51, 51);">NON-TRANSFERABLITIY</h4><p>The access rights granted to you under the Terms of Service are non-transferable without the express written permission of the owner of the Website.</p><h4 style="font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; color: rgb(51, 51, 51);">RECORDS OF VISITOR USE AND ABUSE</h4><p>As a visitor to the Website, you consent to having your Internet Protocol address recorded. An email address may appear immediately below (the "Identifier") if we suspect potential abuse. The Identifier is uniquely matched to your Internet Protocol address. Visitors agree not to use this address for any reason.</p><p>VISITORS AGREE THAT HARVESTING, GATHERING, STORING, TRANSFERRING TO A THIRD PARTY OR SENDING ANY MESSAGE(S) TO THE IDENTIFIER CONSTITUTES AN ACCEPTANCE AND SUBSEQUENT BREACH OF THESE TERMS OF SERVICE.</p><p>For more information, please visitÂ <a href="http://www.unspam.com/">www.unspam.com</a>Â orÂ <a href="http://www.projecthoneypot.org/">Project Honey Pot</a>.<span></span><span></span></p>', 0, 1, 0),
(14, 0, '', 'Search', 'Search', 'search', '', '', '', '', 'footer', '', 1, 1, 0);

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
  `seo_title` tinytext COLLATE utf8_bin NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `eti` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

--
-- Dumping data for table `seo`
--

INSERT INTO `seo` (`id`, `uid`, `login_user`, `seo_title`, `notes`, `eti`) VALUES
(1, 0, '', 'Title', 'This is some notes on Title&#39;s for SEO', 0),
(2, 0, '', 'Schema Type', 'LibreCMS chooses the appropriate SchemaType when adding Content as defined by <a target="_blank" href="http://www.schema.org/">www.schema.org</a>.', 1422508311),
(3, 0, '', 'Author', 'Author in SEO', 0),
(4, 0, '', 'Images', 'Images for SEO', 0),
(5, 0, '', 'Categories', 'Categories and SEO', 0),
(6, 0, '', 'Keywords', 'Keywords and SEO', 0),
(7, 0, '', 'Tags', 'Tags and SEO', 0),
(8, 0, '', 'Caption', 'Captions and SEO', 0),
(9, 0, '', 'Comments', 'Comments and SEO', 0),
(10, 0, '', 'Notes', 'Notes and SEO', 0),
(11, 0, '', 'SEO Title', 'Notes for SEO Title', 0),
(12, 0, '', 'SEO Caption', 'Notes for SEO Caption', 0),
(13, 0, '', 'SEO Description', 'Notes for SEO Description', 0),
(14, 0, '', 'SEO Keywords', 'Notes for SEO Keywords', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;
