-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 18, 2014 at 02:25 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`id`, `uid`, `rid`, `contentType`, `rank`, `icon`, `url`, `title`, `ti`) VALUES
(1, 1, 0, '', 0, 'facebook-square', 'http://www.facebook.com/studiojunkyard', '', 0),
(2, 1, 0, '', 0, 'google-plus-square', 'https://plus.google.com/u/0/', '', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `contentType`, `rid`, `uid`, `cid`, `ip`, `email`, `name`, `notes`, `status`, `active`, `ti`) VALUES
(7, 'article', 1, 0, 1, '127.0.0.1', 'dennis@studiojunkyard.com', 'Adam Wyatt', 'asd asdf asdfg sfg sdfg dsfhg sd dfh sdfh sdfh sdfh sdfh sdfhs dfhsdfh sdfhsdfhsdfh sdfh hsdfh sdh sdh sdhs dfh sdh sdhfsdfhh df f dfg sfgs fsdfg f fg fg gsdgsdgf gfsgs sdfgfdg fgsf fg asd asdf asdfg sfg sdfg dsfhg sd dfh sdfh sdfh sdfh sdfh sdfhs dfhsdfh sdfhsdfhsdfh sdfh hsdfh sdh sdh sdhs dfh sdh sdhfsdfhh df f dfg sfgs fsdfg f fg fg gsdgsdgf gfsgs sdfgfdg fgsf fg', 'approved', 0, 1414736206),
(8, 'article', 1, 0, 0, '127.0.0.1', 'info@studiojunkyard.com', 'Adam Wyatt', 'asdfhgdfghdfgh', 'approved', 0, 1414736222);

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
  `geoLocation` varchar(128) COLLATE utf8_bin NOT NULL,
  `geoReference` varchar(128) COLLATE utf8_bin NOT NULL,
  `business` varchar(40) COLLATE utf8_bin NOT NULL,
  `abn` varchar(32) COLLATE utf8_bin NOT NULL,
  `url` varchar(128) COLLATE utf8_bin NOT NULL,
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
  `orderPayti` int(10) unsigned NOT NULL,
  `orderEmailDefaultSubject` tinytext COLLATE utf8_bin NOT NULL,
  `orderEmailLayout` text COLLATE utf8_bin NOT NULL,
  `orderEmailNotes` text COLLATE utf8_bin NOT NULL,
  `bank` varchar(60) COLLATE utf8_bin NOT NULL,
  `bankAccountName` varchar(40) COLLATE utf8_bin NOT NULL,
  `bankAccountNumber` varchar(40) COLLATE utf8_bin NOT NULL,
  `bankBSB` varchar(16) COLLATE utf8_bin NOT NULL,
  `bankPayPal` varchar(60) COLLATE utf8_bin NOT NULL,
  `seoGoogleVerification` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoGoogleTracking` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoGoogleDomain` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoBingVerification` varchar(255) COLLATE utf8_bin NOT NULL,
  `seoPinterestVerification` varchar(255) COLLATE utf8_bin NOT NULL,
  `PHP` varchar(255) COLLATE utf8_bin NOT NULL,
  `PHPFile` varchar(255) COLLATE utf8_bin NOT NULL,
  `PHPQuickLink` varchar(255) COLLATE utf8_bin NOT NULL,
  `bti` int(10) unsigned NOT NULL,
  `ti` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `options`, `theme`, `seoTitle`, `seoDescription`, `seoCaption`, `seoKeywords`, `geoLocation`, `geoReference`, `business`, `abn`, `url`, `address`, `suburb`, `city`, `state`, `country`, `postcode`, `phone`, `mobile`, `email`, `vti`, `sti`, `dateFormat`, `language`, `timezone`, `orderPayti`, `orderEmailDefaultSubject`, `orderEmailLayout`, `orderEmailNotes`, `bank`, `bankAccountName`, `bankAccountNumber`, `bankBSB`, `bankPayPal`, `seoGoogleVerification`, `seoGoogleTracking`, `seoGoogleDomain`, `seoBingVerification`, `seoPinterestVerification`, `PHP`, `PHPFile`, `PHPQuickLink`, `bti`, `ti`) VALUES
(1, '11111111', 'default', 'Libr8', '', '', '', '', '', 'Libr8', '', '/super/', '128 Cradle Mountain Road', 'Wilmot', 'Wilmot', 'Tasmania', 'Australia', 7310, '0364921418', '0364921418', 'dennis@studiojunkyard.com', 1406180963, 3600, 'M j, Y g:i A', 'en', 'Australia/Hobart', 1209600, '{name}: Invoice: {order_number}', 'Hello {first},<br><br>Please find attached Order {order_number}<br>Note: {notes}', 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', 'Westpac', 'Angelina Suitters', '0000 0000 0000 0000', '000000', '', '', '', '', '', '', '', '', '', 1404461417, 0);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `options` varchar(8) COLLATE utf8_bin NOT NULL,
  `rank` int(4) NOT NULL,
  `rid` bigint(20) unsigned NOT NULL,
  `uid` bigint(20) unsigned NOT NULL,
  `cid` bigint(20) unsigned NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `contentType` varchar(16) COLLATE utf8_bin NOT NULL,
  `schemaType` varchar(40) COLLATE utf8_bin NOT NULL,
  `keywords` varchar(255) COLLATE utf8_bin NOT NULL,
  `geoLocation` varchar(128) COLLATE utf8_bin NOT NULL,
  `geoReference` varchar(128) COLLATE utf8_bin NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=24 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `options`, `rank`, `rid`, `uid`, `cid`, `ip`, `contentType`, `schemaType`, `keywords`, `geoLocation`, `geoReference`, `code`, `brand`, `title`, `category_1`, `category_2`, `name`, `url`, `email`, `business`, `address`, `suburb`, `city`, `state`, `postcode`, `phone`, `thumb`, `file`, `cost`, `subject`, `notes`, `quantity`, `tags`, `caption`, `status`, `service`, `internal`, `featured`, `bookable`, `fti`, `assoc`, `ord`, `views`, `active`, `tis`, `tie`, `lti`, `ti`) VALUES
(1, '01000000', 0, 0, 1, 0, '', 'article', 'blogPost', 'test,blah,bleh,blue', '', '', '', '', 'Article Test 123', 'Category 1', 'Category 2', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p style="margin-bottom: 14px; padding: 0px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ante nunc, ornare ut odio eget, interdum viverra mauris. Vestibulum ut magna non libero sagittis fringilla. Suspendisse ullamcorper augue ipsum, sit amet molestie risus luctus sed. Suspendisse congue rhoncus purus, ac venenatis augue tristique ut. Ut id vestibulum neque, eget eleifend nisl. In hac habitasse platea dictumst. Cras vehicula tempus mauris. Suspendisse potenti. Nam dapibus eu leo a facilisis. Aenean vestibulum fermentum augue, id luctus erat fermentum aliquam. Integer eget lorem sit amet nibh ullamcorper dapibus quis in massa. Morbi at nisi vel urna ornare vulputate vel quis ligula. Proin scelerisque vel magna at consequat. In a neque ut est aliquam luctus. Nunc eget justo quis orci sollicitudin venenatis et nec sem. Etiam neque nibh, suscipit id arcu vitae, placerat pulvinar est.</p><p style="margin-bottom: 14px; padding: 0px;">Maecenas vitae dolor et libero sagittis faucibus sit amet sit amet leo. Proin ornare sed urna et posuere. Nulla facilisi. Mauris varius nisl tincidunt magna facilisis sagittis. Duis facilisis vehicula turpis, ut pulvinar enim. Donec vel neque et ligula placerat pretium. Phasellus pharetra sem ac nisl mollis auctor. Vivamus elementum, lacus ac viverra interdum, ex odio efficitur nisi, a vehicula lorem nisi quis velit. Nunc eget justo non leo dapibus mollis. In hac habitasse platea dictumst. Pellentesque ullamcorper suscipit tempor. Pellentesque neque metus, venenatis dapibus volutpat pulvinar, convallis ut tellus. Morbi egestas dolor quam, a semper justo pellentesque sit amet. Donec at mauris vitae quam tempor lacinia. Nam eros lectus, molestie vitae aliquam sed, efficitur non ex. Praesent auctor efficitur quam.</p><p style="margin-bottom: 14px; padding: 0px;">Aenean convallis lectus nec urna accumsan elementum. Vivamus tincidunt eros sit amet ipsum vulputate, vel pharetra neque dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc pharetra eleifend ligula vitae iaculis. Donec gravida ante urna, vitae ornare orci gravida id. Etiam viverra aliquam pulvinar. Aliquam commodo blandit diam eget bibendum. Vivamus ultrices cursus ante at tempor. Suspendisse quis justo metus. Nunc mollis massa nec sem placerat, sit amet sodales felis finibus. Quisque varius bibendum ante et pharetra. Nulla convallis, est et elementum luctus, leo ipsum vehicula mi, condimentum rutrum elit odio ut arcu. Sed augue arcu, luctus id turpis sed, consequat convallis tortor. Sed nisi libero, tincidunt non tortor vitae, porta eleifend nunc.</p><p style="margin-bottom: 14px; padding: 0px;">Etiam non ipsum augue. Mauris pharetra ipsum id dapibus tristique. Vestibulum leo magna, placerat sit amet ante a, euismod sagittis eros. Etiam velit arcu, ullamcorper sed lobortis vitae, venenatis ac purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut laoreet tincidunt enim. Nam metus lacus, sodales eget enim eu, dignissim pretium lorem.</p><p style="margin-bottom: 14px; padding: 0px;">Maecenas sit amet aliquet risus. Suspendisse luctus a turpis id dapibus. Cras in odio pulvinar, commodo dui sed, volutpat ipsum. Praesent viverra risus ornare sapien laoreet dictum. Phasellus tempor consequat congue. Morbi bibendum felis non vulputate sagittis. Morbi aliquam quam in libero volutpat condimentum. Nulla mattis orci justo, eget volutpat odio feugiat non. Nulla facilisi.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ante nunc, ornare ut odio eget, interdum viverra mauris. Vestibulum ut magna non libero sagittis fringilla. Suspendisse ullamcorper augue ipsum, sit amet molestie risus luctus sed. Suspendisse congue rhoncus purus, ac venenatis augue tristique ut. Ut id vestibulum neque, eget eleifend nisl. In hac habitasse platea dictumst. Cras vehicula tempus mauris. Suspendisse potenti. Nam dapibus eu leo a facilisis. Aenean vestibulum fermentum augue, id luctus erat fermentum aliquam. Integer eget lorem sit amet nibh ullamcorper dapibus quis in massa. Morbi at nisi vel urna ornare vulputate vel quis ligula. Proin scelerisque vel magna at consequat. In a neque ut est aliquam luctus. Nunc eget justo quis orci sollicitudin venenatis et nec sem. Etiam neque nibh, suscipit id arcu vitae, placerat pulvinar est.</p><p style="margin-bottom: 14px; padding: 0px;">Maecenas vitae dolor et libero sagittis faucibus sit amet sit amet leo. Proin ornare sed urna et posuere. Nulla facilisi. Mauris varius nisl tincidunt magna facilisis sagittis. Duis facilisis vehicula turpis, ut pulvinar enim. Donec vel neque et ligula placerat pretium. Phasellus pharetra sem ac nisl mollis auctor. Vivamus elementum, lacus ac viverra interdum, ex odio efficitur nisi, a vehicula lorem nisi quis velit. Nunc eget justo non leo dapibus mollis. In hac habitasse platea dictumst. Pellentesque ullamcorper suscipit tempor. Pellentesque neque metus, venenatis dapibus volutpat pulvinar, convallis ut tellus. Morbi egestas dolor quam, a semper justo pellentesque sit amet. Donec at mauris vitae quam tempor lacinia. Nam eros lectus, molestie vitae aliquam sed, efficitur non ex. Praesent auctor efficitur quam.</p><p style="margin-bottom: 14px; padding: 0px;">Aenean convallis lectus nec urna accumsan elementum. Vivamus tincidunt eros sit amet ipsum vulputate, vel pharetra neque dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc pharetra eleifend ligula vitae iaculis. Donec gravida ante urna, vitae ornare orci gravida id. Etiam viverra aliquam pulvinar. Aliquam commodo blandit diam eget bibendum. Vivamus ultrices cursus ante at tempor. Suspendisse quis justo metus. Nunc mollis massa nec sem placerat, sit amet sodales felis finibus. Quisque varius bibendum ante et pharetra. Nulla convallis, est et elementum luctus, leo ipsum vehicula mi, condimentum rutrum elit odio ut arcu. Sed augue arcu, luctus id turpis sed, consequat convallis tortor. Sed nisi libero, tincidunt non tortor vitae, porta eleifend nunc.</p><p style="margin-bottom: 14px; padding: 0px;">Etiam non ipsum augue. Mauris pharetra ipsum id dapibus tristique. Vestibulum leo magna, placerat sit amet ante a, euismod sagittis eros. Etiam velit arcu, ullamcorper sed lobortis vitae, venenatis ac purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut laoreet tincidunt enim. Nam metus lacus, sodales eget enim eu, dignissim pretium lorem.</p><p style="margin-bottom: 14px; padding: 0px;">Maecenas sit amet aliquet risus. Suspendisse luctus a turpis id dapibus. Cras in odio pulvinar, commodo dui sed, volutpat ipsum. Praesent viverra risus ornare sapien laoreet dictum. Phasellus tempor consequat congue. Morbi bibendum felis non vulputate sagittis. Morbi aliquam quam in libero volutpat condimentum. Nulla mattis orci justo, eget volutpat odio feugiat non. Nulla facilisi.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ante nunc, ornare ut odio eget, interdum viverra mauris. Vestibulum ut magna non libero sagittis fringilla. Suspendisse ullamcorper augue ipsum, sit amet molestie risus luctus sed. Suspendisse congue rhoncus purus, ac venenatis augue tristique ut. Ut id vestibulum neque, eget eleifend nisl. In hac habitasse platea dictumst. Cras vehicula tempus mauris. Suspendisse potenti. Nam dapibus eu leo a facilisis. Aenean vestibulum fermentum augue, id luctus erat fermentum aliquam. Integer eget lorem sit amet nibh ullamcorper dapibus quis in massa. Morbi at nisi vel urna ornare vulputate vel quis ligula. Proin scelerisque vel magna at consequat. In a neque ut est aliquam luctus. Nunc eget justo quis orci sollicitudin venenatis et nec sem. Etiam neque nibh, suscipit id arcu vitae, placerat pulvinar est.</p><p style="margin-bottom: 14px; padding: 0px;">Maecenas vitae dolor et libero sagittis faucibus sit amet sit amet leo. Proin ornare sed urna et posuere. Nulla facilisi. Mauris varius nisl tincidunt magna facilisis sagittis. Duis facilisis vehicula turpis, ut pulvinar enim. Donec vel neque et ligula placerat pretium. Phasellus pharetra sem ac nisl mollis auctor. Vivamus elementum, lacus ac viverra interdum, ex odio efficitur nisi, a vehicula lorem nisi quis velit. Nunc eget justo non leo dapibus mollis. In hac habitasse platea dictumst. Pellentesque ullamcorper suscipit tempor. Pellentesque neque metus, venenatis dapibus volutpat pulvinar, convallis ut tellus. Morbi egestas dolor quam, a semper justo pellentesque sit amet. Donec at mauris vitae quam tempor lacinia. Nam eros lectus, molestie vitae aliquam sed, efficitur non ex. Praesent auctor efficitur quam.</p><p style="margin-bottom: 14px; padding: 0px;">Aenean convallis lectus nec urna accumsan elementum. Vivamus tincidunt eros sit amet ipsum vulputate, vel pharetra neque dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc pharetra eleifend ligula vitae iaculis. Donec gravida ante urna, vitae ornare orci gravida id. Etiam viverra aliquam pulvinar. Aliquam commodo blandit diam eget bibendum. Vivamus ultrices cursus ante at tempor. Suspendisse quis justo metus. Nunc mollis massa nec sem placerat, sit amet sodales felis finibus. Quisque varius bibendum ante et pharetra. Nulla convallis, est et elementum luctus, leo ipsum vehicula mi, condimentum rutrum elit odio ut arcu. Sed augue arcu, luctus id turpis sed, consequat convallis tortor. Sed nisi libero, tincidunt non tortor vitae, porta eleifend nunc.</p><p style="margin-bottom: 14px; padding: 0px;">Etiam non ipsum augue. Mauris pharetra ipsum id dapibus tristique. Vestibulum leo magna, placerat sit amet ante a, euismod sagittis eros. Etiam velit arcu, ullamcorper sed lobortis vitae, venenatis ac purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut laoreet tincidunt enim. Nam metus lacus, sodales eget enim eu, dignissim pretium lorem.</p><p style="margin-bottom: 14px; padding: 0px;">Maecenas sit amet aliquet risus. Suspendisse luctus a turpis id dapibus. Cras in odio pulvinar, commodo dui sed, volutpat ipsum. Praesent viverra risus ornare sapien laoreet dictum. Phasellus tempor consequat congue. Morbi bibendum felis non vulputate sagittis. Morbi aliquam quam in libero volutpat condimentum. Nulla mattis orci justo, eget volutpat odio feugiat non. Nulla facilisi.</p>', 0, 'test,tasmania', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1407816988),
(2, '00000000', 0, 0, 1, 0, '', 'article', 'blogPost', '', '', '', '', '', 'Article Test 2', '', '', 'Kenika Suitters', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. \nSuspendisse aliquam, augue vitae pulvinar feugiat, magna ipsum varius tellus, quis lobortis est nulla nec ligula. \nAenean cursus enim sit amet tortor rutrum lobortis. \nVestibulum mattis mauris fringilla mauris volutpat, in euismod arcu ultricies. \nNunc eget hendrerit lectus. Proin rutrum elit ut orci fringilla, sit amet ornare turpis molestie. \nProin nec neque eget nulla scelerisque rhoncus sit amet vitae augue. \nVivamus ipsum eros, sodales sed enim ac, malesuada iaculis mi. \nMorbi ut orci sit amet tellus posuere convallis. \nCras rhoncus tincidunt ultrices.', 0, '', '', 'unpublished', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 1407816988),
(5, '00000000', 0, 0, 0, 0, '', 'inventory', 'Product', '', '', '', '', '', 'Inventory 5', '', '', '', '', '', '', '', '', '', '', 0, '', '', '5.jpg', 0.00, '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. \nSuspendisse aliquam, augue vitae pulvinar feugiat, magna ipsum varius tellus, quis lobortis est nulla nec ligula. \nAenean cursus enim sit amet tortor rutrum lobortis. \nVestibulum mattis mauris fringilla mauris volutpat, in euismod arcu ultricies. \nNunc eget hendrerit lectus. Proin rutrum elit ut orci fringilla, sit amet ornare turpis molestie. \nProin nec neque eget nulla scelerisque rhoncus sit amet vitae augue. \nVivamus ipsum eros, sodales sed enim ac, malesuada iaculis mi. \nMorbi ut orci sit amet tellus posuere convallis. \nCras rhoncus tincidunt ultrices.', 0, '', '', 'published', 0, 1, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 1407973908),
(6, '10000000', 0, 0, 0, 0, '', 'inventory', 'Product', '', '', '', '', '', 'Inventory 6', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_6.jpg', 'file_6.jpg', 0.00, '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. \r\nSuspendisse aliquam, augue vitae pulvinar feugiat, magna ipsum varius tellus, quis lobortis est nulla nec ligula. \r\nAenean cursus enim sit amet tortor rutrum lobortis. \r\nVestibulum mattis mauris fringilla mauris volutpat, in euismod arcu ultricies. \r\nNunc eget hendrerit lectus. Proin rutrum elit ut orci fringilla, sit amet ornare turpis molestie. \r\nProin nec neque eget nulla scelerisque rhoncus sit amet vitae augue. \r\nVivamus ipsum eros, sodales sed enim ac, malesuada iaculis mi. \r\nMorbi ut orci sit amet tellus posuere convallis. \r\nCras rhoncus tincidunt ultrices.', 0, '', '', 'published', 0, 0, 1, 0, 0, '', 1, 0, 1, 0, 0, 0, 1407973971),
(7, '10000000', 0, 0, 0, 0, '', 'inventory', 'Product', '', '', '', '', '', 'Inventory 7', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_7.jpg', 'file_7.jpg', 0.00, '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse aliquam, augue vitae pulvinar feugiat, magna ipsum varius tellus, quis lobortis est nulla nec ligula. Aenean cursus enim sit amet tortor rutrum lobortis. Vestibulum mattis mauris fringilla mauris volutpat, in euismod arcu ultricies. Nunc eget hendrerit lectus. Proin rutrum elit ut orci fringilla, sit amet ornare turpis molestie. Proin nec neque eget nulla scelerisque rhoncus sit amet vitae augue. Vivamus ipsum eros, sodales sed enim ac, malesuada iaculis mi. Morbi ut orci sit amet tellus posuere convallis. Cras rhoncus tincidunt ultrices.', 0, '', '', 'published', 0, 0, 1, 0, 0, '', 7, 0, 1, 0, 0, 0, 1408014261),
(8, '10000000', 0, 0, 0, 0, '', 'inventory', 'Product', '', '', '', 'INV001', 'Samsung', 'Inventory 8', 'Category 1', 'Category 2', '', '', '', '', '', '', '', '', 0, '', '', '', 10.00, '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse aliquam, augue vitae pulvinar feugiat, magna ipsum varius tellus, quis lobortis est nulla nec ligula. Aenean cursus enim sit amet tortor rutrum lobortis. Vestibulum mattis mauris fringilla mauris volutpat, in euismod arcu ultricies. Nunc eget hendrerit lectus. Proin rutrum elit ut orci fringilla, sit amet ornare turpis molestie. Proin nec neque eget nulla scelerisque rhoncus sit amet vitae augue. Vivamus ipsum eros, sodales sed enim ac, malesuada iaculis mi. Morbi ut orci sit amet tellus posuere convallis. Cras rhoncus tincidunt ultrices.', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 1408014276),
(14, '00000000', 0, 0, 1, 0, '', 'portfolio', 'CreativeWork', '', '', '', '', '', 'Portfolio 14', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 1411032222),
(15, '00000000', 0, 0, 1, 0, '', 'events', 'Event', '', '', '', '', '', 'Events 15', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse aliquam, augue vitae pulvinar feugiat, magna ipsum varius tellus, quis lobortis est nulla nec ligula.<br></p>', 0, '', '', 'published', 0, 0, 1, 0, 0, '', 0, 0, 1, 1412866800, 0, 0, 1411032261),
(16, '00000000', 0, 0, 1, 0, '', 'news', 'NewsArticle', '', '', '', '', '', 'News 16', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse aliquam, augue vitae pulvinar feugiat, magna ipsum varius tellus, quis lobortis est nulla nec ligula.<br></p>', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 1411032279),
(17, '00000000', 0, 0, 1, 0, '', 'services', '', '', '', '', '', '', 'Services 17', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '', 0, '', '', 'published', 0, 0, 0, 1, 0, '', 0, 0, 1, 0, 0, 0, 1411032311),
(18, '00000000', 0, 0, 1, 0, '', 'gallery', 'ImageGallery', '', '', '', '', '', 'Gallery 18', 'Category 2', 'Category 2', '', '', '', '', '', '', '', '', 0, '', 'thumb_18.jpg', 'file_18.jpg', 0.00, '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 3, 0, 1, 0, 0, 0, 1411032323),
(19, '00000000', 0, 0, 1, 2, '', 'proofs', 'CreativeWork', '', '', '', '', '', 'Proofs 19', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_19.jpg', 'file_19.jpg', 0.00, '', '', 0, '', '', 'unpublished', 0, 0, 0, 0, 0, '', 2, 0, 1, 0, 0, 0, 1411093580),
(20, '00000000', 0, 0, 1, 0, '', 'testimonials', 'Review', '', '', '', '', '', 'Testimonials 20', '', '', 'Kenika Suitters', '', 'dennis@studiojunkyard.com', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p>This is a testimonial</p>', 0, '', '', 'unpublished', 0, 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, 1411345793),
(21, '00000000', 0, 0, 1, 0, '', 'gallery', 'ImageGallery', '', '', '', '', '', 'Gallery 21', 'Category 1', 'Category 3', '', '', '', '', '', '', '', '', 0, '', 'thumb_21.jpg', 'file_21.jpg', 0.00, '', '', 0, '', '', 'published', 0, 0, 1, 0, 0, '', 4, 0, 1, 0, 0, 0, 1411351357),
(22, '00000000', 0, 0, 1, 0, '', 'gallery', 'ImageGallery', '', '', '', '', '', 'Gallery 22', 'Category 2', 'Category 2', '', '', '', '', '', '', '', '', 0, '', 'thumb_22.jpg', 'file_22.jpg', 0.00, '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 5, 0, 1, 0, 0, 0, 1411351375),
(23, '00000000', 0, 0, 1, 0, '', 'gallery', 'ImageGallery', '', '', '', '', '', 'Gallery 23', 'Category 1', 'Category 2', '', '', '', '', '', '', '', '', 0, '', 'thumb_23.jpg', 'file_23.jpg', 0.00, '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 6, 0, 1, 0, 0, 0, 1411351396);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `options` varchar(8) COLLATE utf8_bin NOT NULL,
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
(1, '11111111', 'admin', '$2y$10$dYvrhTGiUhWjHYgXWgg/muDXisNfS7z5y5AQ72dJAelV0YezL/gY6', '', 'dennis@studiojunkyard.com', 'StudioJunkyard', 'Kenika Suitters', 'dennis@studiojunkyard.com', 'www.studiojunkyard.com', '128 Cradle Mtn Road', '', 'Wilmot', 'Tasmania', 7310, '', '0364921418', '', 'Being of a creative mind, and getting my hands into the creative process, I like to do many things which involve thinking along with doing things manually. Such as, Wood Turning, Wood Work, Photography, Gardening, Growing Vege, and Managing the Property where I live in Tasmania, Australia.', '', 1, '', '', '', 0, 'en', 'Australia/Hobart', 1000, 1402746479),
(2, '', 'test', '$2y$10$2VexmuSztvLmN0Oqxv8pyO22ayeDQ1C0np5t5VqhqrZclZsYxKYoq', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 1, '', '', '', 0, '', 'Australia/Hobart', 300, 1410919706);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `title`, `seoTitle`, `contentType`, `schemaType`, `seoKeywords`, `seoDescription`, `seoCaption`, `menu`, `notes`, `ord`, `active`) VALUES
(1, 'Home', '', 'index', '', '', '', '', 'head', '', 0, 1),
(2, 'Blog', '', 'article', '', '', '', '', 'head', '', 1, 1),
(3, 'Portfolio', '', 'portfolio', '', '', '', '', 'head', '', 2, 1),
(4, 'Bookings', '', 'bookings', '', '', '', '', 'head', '', 3, 1),
(5, 'Events', '', 'events', '', '', '', '', 'head', '', 4, 1),
(6, 'News', '', 'news', '', '', '', '', 'head', '', 5, 1),
(7, 'Testimonials', '', 'testimonials', '', '', '', '', 'head', '', 6, 1),
(8, 'Inventory', '', 'inventory', '', '', '', '', 'head', '', 7, 1),
(9, 'Services', '', 'services', '', '', '', '', 'head', '', 8, 1),
(10, 'Gallery', '', 'gallery', '', '', '', '', 'head', '', 9, 1),
(11, 'Contact', '', 'contactus', '', '', '', '', 'head', '', 10, 1),
(12, 'Cart', '', 'cart', '', '', '', '', 'head', '', 11, 1),
(13, 'Terms of Service', 'Terms of Service', 'tos', '', '', '', '', 'footer', '<h2 style="font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; color: rgb(51, 51, 51);">Terms and Conditions Regulating Email Collection</h2><h4 style="font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; color: rgb(51, 51, 51);">TERMS AND CONDITIONS OF USE</h4><p>The website from which you accessed this agreement ("studiojunkyard.com/") is provided to you subject to the following conditions. These terms are in addition to any other terms governing access to the Website. By visiting (in any manner) the Website you accept these terms and conditions (the "Terms of Service"). Please read them carefully.</p><p>Any Non-Human Visitors to the Website shall be considered agents of the individual(s) who controls, authors or otherwise makes use of them. These individuals shall ultimately be responsible for the behavior of their Non-Human Visitor agents and are liable for violations of the Terms of Service.</p><h4 style="font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; color: rgb(51, 51, 51);">SPECIAL LICENSE RESTRICTIONS FOR NON-HUMAN VISITORS</h4><p>Special restrictions on a visitor''s license to access the Website apply to Non-Human Visitors. Non-Human Visitors include, but are not limited to, web spiders, bots, indexers, robots, crawlers, harvesters, or any other computer programs designed to access, read, compile or gather content from the Website automatically. Non-Human Visitors are restricted from taxing the resources of the Website beyond what would be typical of a human visitor.</p><p>Furthermore, as specified by the "no-email-collection" flag in the header pages within the Website and/or the contents of the robots.txt file, email addresses on this site are considered proprietary intellectual property of the author of the Website. It is recognized that these email addresses are provided for human visitors alone, and have value in part because they are accessible only to said human visitors. By continuing to access the Website, You acknowledge and agree that each email address the Website contains has a value not less than US $500 derived from their relative secrecy. You further agree that the compilation, storage, and potential distribution of these addresses by Non-Human Visitors substantially diminish the value of these addresses. Intentional collection, harvesting, gathering, or storing email addresses by Non-Human Visitors is recognized under this agreement as a violation of this agreement and expressly prohibited.</p><h4 style="font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; color: rgb(51, 51, 51);">APPLICABLE LAW AND JURISDICTION</h4><p>Each party agrees that any suit, action or proceeding brought by such party against the other in connection with or arising from the Terms of Service ("Judicial Action") shall be governed by the law of the state of residence of the registered Administrative Contact (the "Admin State") for the Website as such laws are applied to agreements between Admin State residents entered into and performed entirely within the Admin State. The visitor to the Website consents to the jurisdiction of federal and state courts within the Admin State. The visitor to the Website consents to the venue in any action brought against him in connection with breaches of these Terms of Service. The visitor to the Website consents to electronic service of process regarding actions under the above agreement.</p><h4 style="font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; color: rgb(51, 51, 51);">NON-TRANSFERABLITIY</h4><p>The access rights granted to you under the Terms of Service are non-transferable without the express written permission of the owner of the Website.</p><h4 style="font-family: ''Helvetica Neue'', Helvetica, Arial, sans-serif; color: rgb(51, 51, 51);">RECORDS OF VISITOR USE AND ABUSE</h4><p>As a visitor to the Website, you consent to having your Internet Protocol address recorded. An email address may appear immediately below (the "Identifier") if we suspect potential abuse. The Identifier is uniquely matched to your Internet Protocol address. Visitors agree not to use this address for any reason.</p><p>VISITORS AGREE THAT HARVESTING, GATHERING, STORING, TRANSFERRING TO A THIRD PARTY OR SENDING ANY MESSAGE(S) TO THE IDENTIFIER CONSTITUTES AN ACCEPTANCE AND SUBSEQUENT BREACH OF THESE TERMS OF SERVICE.</p><p>For more information, please visitÂ <a href="http://www.unspam.com/">www.unspam.com</a>Â orÂ <a href="http://www.projecthoneypot.org/">Project Honey Pot</a>.<span></span><span></span></p>', 0, 1),
(14, 'Search', 'Search', 'search', '', '', '', '', 'footer', '', 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=35 ;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `oid`, `iid`, `title`, `quantity`, `cost`, `status`, `ti`) VALUES
(20, 1, 8, 'Inventory 8', 2, 10.00, '', 1415232310),
(21, 1, 8, 'Inventory 8', 2, 10.00, '', 1415232310),
(34, 1, 15, 'Events 15', 2, 10.00, '', 1415269179);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `cid`, `uid`, `qid`, `qid_ti`, `iid`, `iid_ti`, `did`, `did_ti`, `aid`, `aid_ti`, `due_ti`, `notes`, `status`, `recurring`, `ti`) VALUES
(1, 1, 1, '', 0, 'I141009000001', 1412822138, '', 0, '', 0, 1414636538, 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', 'pending', 0, 0),
(2, 1, 1, '', 0, 'I141009000002', 1412822574, '', 0, '', 0, 1414032174, 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', 'pending', 0, 0);

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
-- Table structure for table `tracker`
--

CREATE TABLE IF NOT EXISTS `tracker` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vid` bigint(20) unsigned NOT NULL,
  `contentType` varchar(16) COLLATE utf8_bin NOT NULL,
  `ip` varchar(20) COLLATE utf8_bin NOT NULL,
  `pageName` varchar(255) COLLATE utf8_bin NOT NULL,
  `queryString` varchar(255) COLLATE utf8_bin NOT NULL,
  `hostname` varchar(255) COLLATE utf8_bin NOT NULL,
  `httpReferrer` varchar(255) COLLATE utf8_bin NOT NULL,
  `httpUserAgent` varchar(255) COLLATE utf8_bin NOT NULL,
  `bot` varchar(16) COLLATE utf8_bin NOT NULL,
  `browser` varchar(16) COLLATE utf8_bin NOT NULL,
  `os` varchar(16) COLLATE utf8_bin NOT NULL,
  `ti` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
