-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 25, 2016 at 03:58 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  `idleTime` int(6) NOT NULL,
  `bti` int(10) unsigned NOT NULL,
  `backup_ti` int(10) NOT NULL,
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `maintenance`, `options`, `theme`, `seoTitle`, `seoDescription`, `seoCaption`, `seoKeywords`, `seoRSSTitle`, `seoRSSNotes`, `seoRSSLink`, `seoRSSAuthor`, `seoRSSti`, `business`, `abn`, `address`, `suburb`, `city`, `state`, `country`, `postcode`, `phone`, `mobile`, `email`, `vti`, `sti`, `dateFormat`, `buttonType`, `email_check`, `email_interval`, `language`, `timezone`, `orderPayti`, `orderEmailDefaultSubject`, `orderEmailLayout`, `orderEmailNotes`, `bank`, `bankAccountName`, `bankAccountNumber`, `bankBSB`, `bankPayPal`, `layoutAccounts`, `layoutContent`, `layoutBookings`, `showItems`, `idleTime`, `bti`, `backup_ti`, `ti`) VALUES
(1, 0, '1111111110000000', 'default-bootstrap3', 'LibreCMS', 'Default SEO Description', 'Default SEO Caption', 'Default SEO Keywords', '', '', '', '', 1440940831, 'LibreCMS', '000 000 000', '', '', '', '', '', 0, '', '', 'info@studiojunkyard.com', 1406180963, 3600, 'M j, Y g:i A', 'icon', 1425893894, 3600, 'en-AU', 'Australia/Hobart', 1209600, '{name}: Invoice: {order_number}', 'Hello {first},<br><br>Please find attached Order {order_number}<br>Note: {notes}', 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', '', '', '', '', '', 'card', 'card', 'calendar', 10, 24, 1404461417, 0, 0);

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
  `eti` int(10) NOT NULL,
  `pti` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `options`, `rank`, `rid`, `uid`, `login_user`, `cid`, `ip`, `contentType`, `schemaType`, `keywords`, `barcode`, `fccid`, `code`, `brand`, `title`, `category_1`, `category_2`, `name`, `url`, `email`, `business`, `address`, `suburb`, `city`, `state`, `postcode`, `phone`, `mobile`, `thumb`, `file`, `fileURL`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `exifISO`, `exifAperture`, `exifFocalLength`, `exifShutterSpeed`, `exifCamera`, `exifLens`, `exifFilename`, `exifti`, `cost`, `subject`, `notes`, `attributionContentName`, `attributionContentURL`, `quantity`, `tags`, `caption`, `status`, `service`, `internal`, `featured`, `bookable`, `fti`, `assoc`, `ord`, `views`, `active`, `pin`, `tis`, `tie`, `lti`, `ti`, `eti`, `pti`) VALUES
(1, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'blogPost', '', '', '', '', '', 'Article 1', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '155976.jpg', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eu lectus quis massa malesuada posuere. Vestibulum id ex quis purus placerat suscipit in at sem. Nunc ac dui in turpis volutpat molestie vel sit amet diam. In tristique hendrerit ipsum, ac rhoncus sem efficitur sit amet. Nam non mauris nisi. Phasellus placerat, lectus vitae ultricies semper, augue eros tristique turpis, eget mattis tellus quam sit amet dui. Aliquam bibendum laoreet tellus a semper.</p>', '', '', 0, '', '', 'published', 0, 0, 1, 0, 0, '', 0, 9, 1, 1, 1457874018, 0, 0, 1349619450, 1458574976, 1457902800),
(2, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'blogPost', '', '', '', '', '', 'Article 2', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eu lectus quis massa malesuada posuere. Vestibulum id ex quis purus placerat suscipit in at sem. Nunc ac dui in turpis volutpat molestie vel sit amet diam. In tristique hendrerit ipsum, ac rhoncus sem efficitur sit amet. Nam non mauris nisi. Phasellus placerat, lectus vitae ultricies semper, augue eros tristique turpis, eget mattis tellus quam sit amet dui. Aliquam bibendum laoreet tellus a semper.</p><p>Vestibulum ac justo nec urna scelerisque sagittis sed quis tortor. Suspendisse scelerisque interdum metus, et commodo tellus dignissim nec. Etiam ultrices varius libero, non elementum turpis dictum a. Maecenas rhoncus sapien id eros dictum auctor. Praesent consectetur, felis eget gravida commodo, magna est mattis orci, et consectetur ante odio tincidunt lacus. Cras non urna commodo, commodo eros et, maximus est. Integer a porttitor nunc. Duis pharetra at massa sed facilisis. Curabitur ipsum erat, semper sit amet libero sit amet, eleifend pretium metus. Proin fringilla maximus scelerisque. Morbi id quam quis ligula posuere auctor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer facilisis nisl id ex rutrum, in porttitor est aliquam. Proin porttitor imperdiet fringilla. Nullam mattis dolor enim, a egestas erat egestas sit amet. Vestibulum porttitor nisi vitae metus pellentesque blandit.</p><p>Ut sem justo, tempus ac odio in, maximus pharetra elit. Vivamus at tortor vel lorem ultricies faucibus. Cras vitae ultrices tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque semper et justo id fringilla. Nam vestibulum aliquet ante vel tincidunt. Nulla quam eros, rhoncus nec pulvinar sagittis, egestas non massa. Cras ut libero sit amet sem lacinia auctor ut quis libero.</p><p>Sed lobortis tellus gravida finibus dignissim. Donec a sem nec tortor efficitur vestibulum. Sed consectetur est at mauris feugiat cursus eget sed orci. Quisque vitae fermentum felis, vel viverra nulla. Ut ut vehicula leo, ut aliquam leo. Suspendisse vitae nulla luctus, euismod eros at, auctor lorem. Aliquam interdum nunc mauris, ac varius lorem euismod in. Vivamus urna nisl, maximus sit amet arcu id, interdum maximus ante. Maecenas mi leo, tincidunt scelerisque dui id, pulvinar volutpat orci. Praesent sapien dolor, efficitur tincidunt nibh id, lacinia volutpat enim. Aenean a gravida lacus. Morbi sit amet mauris sit amet libero laoreet commodo quis venenatis mauris. Vivamus mattis, erat vitae blandit posuere, enim elit interdum quam, sit amet consequat mauris velit venenatis felis. Vestibulum at metus malesuada, accumsan dui in, pulvinar tortor.</p><p>Donec consectetur eu nulla quis tincidunt. Vestibulum suscipit eu est non auctor. Nulla non est ac orci mollis luctus. Quisque tincidunt turpis sit amet quam fringilla, id iaculis purus laoreet. Suspendisse accumsan venenatis lectus nec volutpat. Quisque id placerat ex. Fusce ac sagittis urna, sit amet hendrerit enim. Sed libero purus, dignissim sed dolor nec, sagittis rutrum tortor. Sed ac volutpat lectus, at commodo tellus.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 3, 1, 0, 0, 0, 0, 1432984875, 1457679814, 2001600),
(3, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'blogPost', '', '', '', '', '', 'Article 3', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eu lectus quis massa malesuada posuere. Vestibulum id ex quis purus placerat suscipit in at sem. Nunc ac dui in turpis volutpat molestie vel sit amet diam. In tristique hendrerit ipsum, ac rhoncus sem efficitur sit amet. Nam non mauris nisi. Phasellus placerat, lectus vitae ultricies semper, augue eros tristique turpis, eget mattis tellus quam sit amet dui. Aliquam bibendum laoreet tellus a semper.</p><p>Vestibulum ac justo nec urna scelerisque sagittis sed quis tortor. Suspendisse scelerisque interdum metus, et commodo tellus dignissim nec. Etiam ultrices varius libero, non elementum turpis dictum a. Maecenas rhoncus sapien id eros dictum auctor. Praesent consectetur, felis eget gravida commodo, magna est mattis orci, et consectetur ante odio tincidunt lacus. Cras non urna commodo, commodo eros et, maximus est. Integer a porttitor nunc. Duis pharetra at massa sed facilisis. Curabitur ipsum erat, semper sit amet libero sit amet, eleifend pretium metus. Proin fringilla maximus scelerisque. Morbi id quam quis ligula posuere auctor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer facilisis nisl id ex rutrum, in porttitor est aliquam. Proin porttitor imperdiet fringilla. Nullam mattis dolor enim, a egestas erat egestas sit amet. Vestibulum porttitor nisi vitae metus pellentesque blandit.</p><p>Ut sem justo, tempus ac odio in, maximus pharetra elit. Vivamus at tortor vel lorem ultricies faucibus. Cras vitae ultrices tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque semper et justo id fringilla. Nam vestibulum aliquet ante vel tincidunt. Nulla quam eros, rhoncus nec pulvinar sagittis, egestas non massa. Cras ut libero sit amet sem lacinia auctor ut quis libero.</p><p>Sed lobortis tellus gravida finibus dignissim. Donec a sem nec tortor efficitur vestibulum. Sed consectetur est at mauris feugiat cursus eget sed orci. Quisque vitae fermentum felis, vel viverra nulla. Ut ut vehicula leo, ut aliquam leo. Suspendisse vitae nulla luctus, euismod eros at, auctor lorem. Aliquam interdum nunc mauris, ac varius lorem euismod in. Vivamus urna nisl, maximus sit amet arcu id, interdum maximus ante. Maecenas mi leo, tincidunt scelerisque dui id, pulvinar volutpat orci. Praesent sapien dolor, efficitur tincidunt nibh id, lacinia volutpat enim. Aenean a gravida lacus. Morbi sit amet mauris sit amet libero laoreet commodo quis venenatis mauris. Vivamus mattis, erat vitae blandit posuere, enim elit interdum quam, sit amet consequat mauris velit venenatis felis. Vestibulum at metus malesuada, accumsan dui in, pulvinar tortor.</p><p>Donec consectetur eu nulla quis tincidunt. Vestibulum suscipit eu est non auctor. Nulla non est ac orci mollis luctus. Quisque tincidunt turpis sit amet quam fringilla, id iaculis purus laoreet. Suspendisse accumsan venenatis lectus nec volutpat. Quisque id placerat ex. Fusce ac sagittis urna, sit amet hendrerit enim. Sed libero purus, dignissim sed dolor nec, sagittis rutrum tortor. Sed ac volutpat lectus, at commodo tellus.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 16, 1, 0, 0, 0, 0, 1421382304, 1455872986, 0),
(4, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'blogPost', '', '', '', '', '', 'Article 4', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eu lectus quis massa malesuada posuere. Vestibulum id ex quis purus placerat suscipit in at sem. Nunc ac dui in turpis volutpat molestie vel sit amet diam. In tristique hendrerit ipsum, ac rhoncus sem efficitur sit amet. Nam non mauris nisi. Phasellus placerat, lectus vitae ultricies semper, augue eros tristique turpis, eget mattis tellus quam sit amet dui. Aliquam bibendum laoreet tellus a semper.</p><p>Vestibulum ac justo nec urna scelerisque sagittis sed quis tortor. Suspendisse scelerisque interdum metus, et commodo tellus dignissim nec. Etiam ultrices varius libero, non elementum turpis dictum a. Maecenas rhoncus sapien id eros dictum auctor. Praesent consectetur, felis eget gravida commodo, magna est mattis orci, et consectetur ante odio tincidunt lacus. Cras non urna commodo, commodo eros et, maximus est. Integer a porttitor nunc. Duis pharetra at massa sed facilisis. Curabitur ipsum erat, semper sit amet libero sit amet, eleifend pretium metus. Proin fringilla maximus scelerisque. Morbi id quam quis ligula posuere auctor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer facilisis nisl id ex rutrum, in porttitor est aliquam. Proin porttitor imperdiet fringilla. Nullam mattis dolor enim, a egestas erat egestas sit amet. Vestibulum porttitor nisi vitae metus pellentesque blandit.</p><p>Ut sem justo, tempus ac odio in, maximus pharetra elit. Vivamus at tortor vel lorem ultricies faucibus. Cras vitae ultrices tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque semper et justo id fringilla. Nam vestibulum aliquet ante vel tincidunt. Nulla quam eros, rhoncus nec pulvinar sagittis, egestas non massa. Cras ut libero sit amet sem lacinia auctor ut quis libero.</p><p>Sed lobortis tellus gravida finibus dignissim. Donec a sem nec tortor efficitur vestibulum. Sed consectetur est at mauris feugiat cursus eget sed orci. Quisque vitae fermentum felis, vel viverra nulla. Ut ut vehicula leo, ut aliquam leo. Suspendisse vitae nulla luctus, euismod eros at, auctor lorem. Aliquam interdum nunc mauris, ac varius lorem euismod in. Vivamus urna nisl, maximus sit amet arcu id, interdum maximus ante. Maecenas mi leo, tincidunt scelerisque dui id, pulvinar volutpat orci. Praesent sapien dolor, efficitur tincidunt nibh id, lacinia volutpat enim. Aenean a gravida lacus. Morbi sit amet mauris sit amet libero laoreet commodo quis venenatis mauris. Vivamus mattis, erat vitae blandit posuere, enim elit interdum quam, sit amet consequat mauris velit venenatis felis. Vestibulum at metus malesuada, accumsan dui in, pulvinar tortor.</p><p>Donec consectetur eu nulla quis tincidunt. Vestibulum suscipit eu est non auctor. Nulla non est ac orci mollis luctus. Quisque tincidunt turpis sit amet quam fringilla, id iaculis purus laoreet. Suspendisse accumsan venenatis lectus nec volutpat. Quisque id placerat ex. Fusce ac sagittis urna, sit amet hendrerit enim. Sed libero purus, dignissim sed dolor nec, sagittis rutrum tortor. Sed ac volutpat lectus, at commodo tellus.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 1, 1, 0, 0, 0, 0, 1417939651, 1455872995, 0),
(5, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'blogPost', '', '', '', '', '', 'Article 5', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eu lectus quis massa malesuada posuere. Vestibulum id ex quis purus placerat suscipit in at sem. Nunc ac dui in turpis volutpat molestie vel sit amet diam. In tristique hendrerit ipsum, ac rhoncus sem efficitur sit amet. Nam non mauris nisi. Phasellus placerat, lectus vitae ultricies semper, augue eros tristique turpis, eget mattis tellus quam sit amet dui. Aliquam bibendum laoreet tellus a semper.</p><p>Vestibulum ac justo nec urna scelerisque sagittis sed quis tortor. Suspendisse scelerisque interdum metus, et commodo tellus dignissim nec. Etiam ultrices varius libero, non elementum turpis dictum a. Maecenas rhoncus sapien id eros dictum auctor. Praesent consectetur, felis eget gravida commodo, magna est mattis orci, et consectetur ante odio tincidunt lacus. Cras non urna commodo, commodo eros et, maximus est. Integer a porttitor nunc. Duis pharetra at massa sed facilisis. Curabitur ipsum erat, semper sit amet libero sit amet, eleifend pretium metus. Proin fringilla maximus scelerisque. Morbi id quam quis ligula posuere auctor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer facilisis nisl id ex rutrum, in porttitor est aliquam. Proin porttitor imperdiet fringilla. Nullam mattis dolor enim, a egestas erat egestas sit amet. Vestibulum porttitor nisi vitae metus pellentesque blandit.</p><p>Ut sem justo, tempus ac odio in, maximus pharetra elit. Vivamus at tortor vel lorem ultricies faucibus. Cras vitae ultrices tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque semper et justo id fringilla. Nam vestibulum aliquet ante vel tincidunt. Nulla quam eros, rhoncus nec pulvinar sagittis, egestas non massa. Cras ut libero sit amet sem lacinia auctor ut quis libero.</p><p>Sed lobortis tellus gravida finibus dignissim. Donec a sem nec tortor efficitur vestibulum. Sed consectetur est at mauris feugiat cursus eget sed orci. Quisque vitae fermentum felis, vel viverra nulla. Ut ut vehicula leo, ut aliquam leo. Suspendisse vitae nulla luctus, euismod eros at, auctor lorem. Aliquam interdum nunc mauris, ac varius lorem euismod in. Vivamus urna nisl, maximus sit amet arcu id, interdum maximus ante. Maecenas mi leo, tincidunt scelerisque dui id, pulvinar volutpat orci. Praesent sapien dolor, efficitur tincidunt nibh id, lacinia volutpat enim. Aenean a gravida lacus. Morbi sit amet mauris sit amet libero laoreet commodo quis venenatis mauris. Vivamus mattis, erat vitae blandit posuere, enim elit interdum quam, sit amet consequat mauris velit venenatis felis. Vestibulum at metus malesuada, accumsan dui in, pulvinar tortor.</p><p>Donec consectetur eu nulla quis tincidunt. Vestibulum suscipit eu est non auctor. Nulla non est ac orci mollis luctus. Quisque tincidunt turpis sit amet quam fringilla, id iaculis purus laoreet. Suspendisse accumsan venenatis lectus nec volutpat. Quisque id placerat ex. Fusce ac sagittis urna, sit amet hendrerit enim. Sed libero purus, dignissim sed dolor nec, sagittis rutrum tortor. Sed ac volutpat lectus, at commodo tellus.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 1, 1, 0, 0, 0, 0, 1349469061, 1455873002, 0),
(6, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'blogPost', '', '', '', '', '', 'Article 6', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eu lectus quis massa malesuada posuere. Vestibulum id ex quis purus placerat suscipit in at sem. Nunc ac dui in turpis volutpat molestie vel sit amet diam. In tristique hendrerit ipsum, ac rhoncus sem efficitur sit amet. Nam non mauris nisi. Phasellus placerat, lectus vitae ultricies semper, augue eros tristique turpis, eget mattis tellus quam sit amet dui. Aliquam bibendum laoreet tellus a semper.</p><p>Vestibulum ac justo nec urna scelerisque sagittis sed quis tortor. Suspendisse scelerisque interdum metus, et commodo tellus dignissim nec. Etiam ultrices varius libero, non elementum turpis dictum a. Maecenas rhoncus sapien id eros dictum auctor. Praesent consectetur, felis eget gravida commodo, magna est mattis orci, et consectetur ante odio tincidunt lacus. Cras non urna commodo, commodo eros et, maximus est. Integer a porttitor nunc. Duis pharetra at massa sed facilisis. Curabitur ipsum erat, semper sit amet libero sit amet, eleifend pretium metus. Proin fringilla maximus scelerisque. Morbi id quam quis ligula posuere auctor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer facilisis nisl id ex rutrum, in porttitor est aliquam. Proin porttitor imperdiet fringilla. Nullam mattis dolor enim, a egestas erat egestas sit amet. Vestibulum porttitor nisi vitae metus pellentesque blandit.</p><p>Ut sem justo, tempus ac odio in, maximus pharetra elit. Vivamus at tortor vel lorem ultricies faucibus. Cras vitae ultrices tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque semper et justo id fringilla. Nam vestibulum aliquet ante vel tincidunt. Nulla quam eros, rhoncus nec pulvinar sagittis, egestas non massa. Cras ut libero sit amet sem lacinia auctor ut quis libero.</p><p>Sed lobortis tellus gravida finibus dignissim. Donec a sem nec tortor efficitur vestibulum. Sed consectetur est at mauris feugiat cursus eget sed orci. Quisque vitae fermentum felis, vel viverra nulla. Ut ut vehicula leo, ut aliquam leo. Suspendisse vitae nulla luctus, euismod eros at, auctor lorem. Aliquam interdum nunc mauris, ac varius lorem euismod in. Vivamus urna nisl, maximus sit amet arcu id, interdum maximus ante. Maecenas mi leo, tincidunt scelerisque dui id, pulvinar volutpat orci. Praesent sapien dolor, efficitur tincidunt nibh id, lacinia volutpat enim. Aenean a gravida lacus. Morbi sit amet mauris sit amet libero laoreet commodo quis venenatis mauris. Vivamus mattis, erat vitae blandit posuere, enim elit interdum quam, sit amet consequat mauris velit venenatis felis. Vestibulum at metus malesuada, accumsan dui in, pulvinar tortor.</p><p>Donec consectetur eu nulla quis tincidunt. Vestibulum suscipit eu est non auctor. Nulla non est ac orci mollis luctus. Quisque tincidunt turpis sit amet quam fringilla, id iaculis purus laoreet. Suspendisse accumsan venenatis lectus nec volutpat. Quisque id placerat ex. Fusce ac sagittis urna, sit amet hendrerit enim. Sed libero purus, dignissim sed dolor nec, sagittis rutrum tortor. Sed ac volutpat lectus, at commodo tellus.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 1, 1, 0, 0, 0, 0, 1417909749, 1455873002, 0),
(7, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'blogPost', '', '', '', '', '', 'Article 7', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eu lectus quis massa malesuada posuere. Vestibulum id ex quis purus placerat suscipit in at sem. Nunc ac dui in turpis volutpat molestie vel sit amet diam. In tristique hendrerit ipsum, ac rhoncus sem efficitur sit amet. Nam non mauris nisi. Phasellus placerat, lectus vitae ultricies semper, augue eros tristique turpis, eget mattis tellus quam sit amet dui. Aliquam bibendum laoreet tellus a semper.</p><p>Vestibulum ac justo nec urna scelerisque sagittis sed quis tortor. Suspendisse scelerisque interdum metus, et commodo tellus dignissim nec. Etiam ultrices varius libero, non elementum turpis dictum a. Maecenas rhoncus sapien id eros dictum auctor. Praesent consectetur, felis eget gravida commodo, magna est mattis orci, et consectetur ante odio tincidunt lacus. Cras non urna commodo, commodo eros et, maximus est. Integer a porttitor nunc. Duis pharetra at massa sed facilisis. Curabitur ipsum erat, semper sit amet libero sit amet, eleifend pretium metus. Proin fringilla maximus scelerisque. Morbi id quam quis ligula posuere auctor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer facilisis nisl id ex rutrum, in porttitor est aliquam. Proin porttitor imperdiet fringilla. Nullam mattis dolor enim, a egestas erat egestas sit amet. Vestibulum porttitor nisi vitae metus pellentesque blandit.</p><p>Ut sem justo, tempus ac odio in, maximus pharetra elit. Vivamus at tortor vel lorem ultricies faucibus. Cras vitae ultrices tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque semper et justo id fringilla. Nam vestibulum aliquet ante vel tincidunt. Nulla quam eros, rhoncus nec pulvinar sagittis, egestas non massa. Cras ut libero sit amet sem lacinia auctor ut quis libero.</p><p>Sed lobortis tellus gravida finibus dignissim. Donec a sem nec tortor efficitur vestibulum. Sed consectetur est at mauris feugiat cursus eget sed orci. Quisque vitae fermentum felis, vel viverra nulla. Ut ut vehicula leo, ut aliquam leo. Suspendisse vitae nulla luctus, euismod eros at, auctor lorem. Aliquam interdum nunc mauris, ac varius lorem euismod in. Vivamus urna nisl, maximus sit amet arcu id, interdum maximus ante. Maecenas mi leo, tincidunt scelerisque dui id, pulvinar volutpat orci. Praesent sapien dolor, efficitur tincidunt nibh id, lacinia volutpat enim. Aenean a gravida lacus. Morbi sit amet mauris sit amet libero laoreet commodo quis venenatis mauris. Vivamus mattis, erat vitae blandit posuere, enim elit interdum quam, sit amet consequat mauris velit venenatis felis. Vestibulum at metus malesuada, accumsan dui in, pulvinar tortor.</p><p>Donec consectetur eu nulla quis tincidunt. Vestibulum suscipit eu est non auctor. Nulla non est ac orci mollis luctus. Quisque tincidunt turpis sit amet quam fringilla, id iaculis purus laoreet. Suspendisse accumsan venenatis lectus nec volutpat. Quisque id placerat ex. Fusce ac sagittis urna, sit amet hendrerit enim. Sed libero purus, dignissim sed dolor nec, sagittis rutrum tortor. Sed ac volutpat lectus, at commodo tellus.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 1, 1, 0, 0, 0, 0, 1394846241, 1455873002, 0),
(8, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'blogPost', '', '', '', '', '', 'Article 8', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eu lectus quis massa malesuada posuere. Vestibulum id ex quis purus placerat suscipit in at sem. Nunc ac dui in turpis volutpat molestie vel sit amet diam. In tristique hendrerit ipsum, ac rhoncus sem efficitur sit amet. Nam non mauris nisi. Phasellus placerat, lectus vitae ultricies semper, augue eros tristique turpis, eget mattis tellus quam sit amet dui. Aliquam bibendum laoreet tellus a semper.</p><p>Vestibulum ac justo nec urna scelerisque sagittis sed quis tortor. Suspendisse scelerisque interdum metus, et commodo tellus dignissim nec. Etiam ultrices varius libero, non elementum turpis dictum a. Maecenas rhoncus sapien id eros dictum auctor. Praesent consectetur, felis eget gravida commodo, magna est mattis orci, et consectetur ante odio tincidunt lacus. Cras non urna commodo, commodo eros et, maximus est. Integer a porttitor nunc. Duis pharetra at massa sed facilisis. Curabitur ipsum erat, semper sit amet libero sit amet, eleifend pretium metus. Proin fringilla maximus scelerisque. Morbi id quam quis ligula posuere auctor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer facilisis nisl id ex rutrum, in porttitor est aliquam. Proin porttitor imperdiet fringilla. Nullam mattis dolor enim, a egestas erat egestas sit amet. Vestibulum porttitor nisi vitae metus pellentesque blandit.</p><p>Ut sem justo, tempus ac odio in, maximus pharetra elit. Vivamus at tortor vel lorem ultricies faucibus. Cras vitae ultrices tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque semper et justo id fringilla. Nam vestibulum aliquet ante vel tincidunt. Nulla quam eros, rhoncus nec pulvinar sagittis, egestas non massa. Cras ut libero sit amet sem lacinia auctor ut quis libero.</p><p>Sed lobortis tellus gravida finibus dignissim. Donec a sem nec tortor efficitur vestibulum. Sed consectetur est at mauris feugiat cursus eget sed orci. Quisque vitae fermentum felis, vel viverra nulla. Ut ut vehicula leo, ut aliquam leo. Suspendisse vitae nulla luctus, euismod eros at, auctor lorem. Aliquam interdum nunc mauris, ac varius lorem euismod in. Vivamus urna nisl, maximus sit amet arcu id, interdum maximus ante. Maecenas mi leo, tincidunt scelerisque dui id, pulvinar volutpat orci. Praesent sapien dolor, efficitur tincidunt nibh id, lacinia volutpat enim. Aenean a gravida lacus. Morbi sit amet mauris sit amet libero laoreet commodo quis venenatis mauris. Vivamus mattis, erat vitae blandit posuere, enim elit interdum quam, sit amet consequat mauris velit venenatis felis. Vestibulum at metus malesuada, accumsan dui in, pulvinar tortor.</p><p>Donec consectetur eu nulla quis tincidunt. Vestibulum suscipit eu est non auctor. Nulla non est ac orci mollis luctus. Quisque tincidunt turpis sit amet quam fringilla, id iaculis purus laoreet. Suspendisse accumsan venenatis lectus nec volutpat. Quisque id placerat ex. Fusce ac sagittis urna, sit amet hendrerit enim. Sed libero purus, dignissim sed dolor nec, sagittis rutrum tortor. Sed ac volutpat lectus, at commodo tellus.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 1, 1, 0, 0, 0, 0, 1328077217, 1455873002, 0),
(9, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'blogPost', '', '', '', '', '', 'Article 9', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eu lectus quis massa malesuada posuere. Vestibulum id ex quis purus placerat suscipit in at sem. Nunc ac dui in turpis volutpat molestie vel sit amet diam. In tristique hendrerit ipsum, ac rhoncus sem efficitur sit amet. Nam non mauris nisi. Phasellus placerat, lectus vitae ultricies semper, augue eros tristique turpis, eget mattis tellus quam sit amet dui. Aliquam bibendum laoreet tellus a semper.</p><p>Vestibulum ac justo nec urna scelerisque sagittis sed quis tortor. Suspendisse scelerisque interdum metus, et commodo tellus dignissim nec. Etiam ultrices varius libero, non elementum turpis dictum a. Maecenas rhoncus sapien id eros dictum auctor. Praesent consectetur, felis eget gravida commodo, magna est mattis orci, et consectetur ante odio tincidunt lacus. Cras non urna commodo, commodo eros et, maximus est. Integer a porttitor nunc. Duis pharetra at massa sed facilisis. Curabitur ipsum erat, semper sit amet libero sit amet, eleifend pretium metus. Proin fringilla maximus scelerisque. Morbi id quam quis ligula posuere auctor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer facilisis nisl id ex rutrum, in porttitor est aliquam. Proin porttitor imperdiet fringilla. Nullam mattis dolor enim, a egestas erat egestas sit amet. Vestibulum porttitor nisi vitae metus pellentesque blandit.</p><p>Ut sem justo, tempus ac odio in, maximus pharetra elit. Vivamus at tortor vel lorem ultricies faucibus. Cras vitae ultrices tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque semper et justo id fringilla. Nam vestibulum aliquet ante vel tincidunt. Nulla quam eros, rhoncus nec pulvinar sagittis, egestas non massa. Cras ut libero sit amet sem lacinia auctor ut quis libero.</p><p>Sed lobortis tellus gravida finibus dignissim. Donec a sem nec tortor efficitur vestibulum. Sed consectetur est at mauris feugiat cursus eget sed orci. Quisque vitae fermentum felis, vel viverra nulla. Ut ut vehicula leo, ut aliquam leo. Suspendisse vitae nulla luctus, euismod eros at, auctor lorem. Aliquam interdum nunc mauris, ac varius lorem euismod in. Vivamus urna nisl, maximus sit amet arcu id, interdum maximus ante. Maecenas mi leo, tincidunt scelerisque dui id, pulvinar volutpat orci. Praesent sapien dolor, efficitur tincidunt nibh id, lacinia volutpat enim. Aenean a gravida lacus. Morbi sit amet mauris sit amet libero laoreet commodo quis venenatis mauris. Vivamus mattis, erat vitae blandit posuere, enim elit interdum quam, sit amet consequat mauris velit venenatis felis. Vestibulum at metus malesuada, accumsan dui in, pulvinar tortor.</p><p>Donec consectetur eu nulla quis tincidunt. Vestibulum suscipit eu est non auctor. Nulla non est ac orci mollis luctus. Quisque tincidunt turpis sit amet quam fringilla, id iaculis purus laoreet. Suspendisse accumsan venenatis lectus nec volutpat. Quisque id placerat ex. Fusce ac sagittis urna, sit amet hendrerit enim. Sed libero purus, dignissim sed dolor nec, sagittis rutrum tortor. Sed ac volutpat lectus, at commodo tellus.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 1, 1, 0, 0, 0, 0, 1406449121, 1455873002, 0),
(10, '00000000', 0, 0, 1, 'Kenika Suitters', 0, '', 'article', 'blogPost', '', '', '', '', '', 'Article 10', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eu lectus quis massa malesuada posuere. Vestibulum id ex quis purus placerat suscipit in at sem. Nunc ac dui in turpis volutpat molestie vel sit amet diam. In tristique hendrerit ipsum, ac rhoncus sem efficitur sit amet. Nam non mauris nisi. Phasellus placerat, lectus vitae ultricies semper, augue eros tristique turpis, eget mattis tellus quam sit amet dui. Aliquam bibendum laoreet tellus a semper.</p><p>Vestibulum ac justo nec urna scelerisque sagittis sed quis tortor. Suspendisse scelerisque interdum metus, et commodo tellus dignissim nec. Etiam ultrices varius libero, non elementum turpis dictum a. Maecenas rhoncus sapien id eros dictum auctor. Praesent consectetur, felis eget gravida commodo, magna est mattis orci, et consectetur ante odio tincidunt lacus. Cras non urna commodo, commodo eros et, maximus est. Integer a porttitor nunc. Duis pharetra at massa sed facilisis. Curabitur ipsum erat, semper sit amet libero sit amet, eleifend pretium metus. Proin fringilla maximus scelerisque. Morbi id quam quis ligula posuere auctor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer facilisis nisl id ex rutrum, in porttitor est aliquam. Proin porttitor imperdiet fringilla. Nullam mattis dolor enim, a egestas erat egestas sit amet. Vestibulum porttitor nisi vitae metus pellentesque blandit.</p><p>Ut sem justo, tempus ac odio in, maximus pharetra elit. Vivamus at tortor vel lorem ultricies faucibus. Cras vitae ultrices tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque semper et justo id fringilla. Nam vestibulum aliquet ante vel tincidunt. Nulla quam eros, rhoncus nec pulvinar sagittis, egestas non massa. Cras ut libero sit amet sem lacinia auctor ut quis libero.</p><p>Sed lobortis tellus gravida finibus dignissim. Donec a sem nec tortor efficitur vestibulum. Sed consectetur est at mauris feugiat cursus eget sed orci. Quisque vitae fermentum felis, vel viverra nulla. Ut ut vehicula leo, ut aliquam leo. Suspendisse vitae nulla luctus, euismod eros at, auctor lorem. Aliquam interdum nunc mauris, ac varius lorem euismod in. Vivamus urna nisl, maximus sit amet arcu id, interdum maximus ante. Maecenas mi leo, tincidunt scelerisque dui id, pulvinar volutpat orci. Praesent sapien dolor, efficitur tincidunt nibh id, lacinia volutpat enim. Aenean a gravida lacus. Morbi sit amet mauris sit amet libero laoreet commodo quis venenatis mauris. Vivamus mattis, erat vitae blandit posuere, enim elit interdum quam, sit amet consequat mauris velit venenatis felis. Vestibulum at metus malesuada, accumsan dui in, pulvinar tortor.</p><p>Donec consectetur eu nulla quis tincidunt. Vestibulum suscipit eu est non auctor. Nulla non est ac orci mollis luctus. Quisque tincidunt turpis sit amet quam fringilla, id iaculis purus laoreet. Suspendisse accumsan venenatis lectus nec volutpat. Quisque id placerat ex. Fusce ac sagittis urna, sit amet hendrerit enim. Sed libero purus, dignissim sed dolor nec, sagittis rutrum tortor. Sed ac volutpat lectus, at commodo tellus.</p>', '', '', 0, '', '', 'published', 0, 0, 0, 0, 0, '', 0, 1, 1, 0, 0, 0, 0, 1349730719, 1455873002, 0),
(11, '00000000', 0, 0, 1, 'Kenika Suitters', 1, '', 'booking', '', '', '', '', '', '', '', '', '', 'Kenika Suitters', '', 'dennis@studiojunkyard.com', 'Studio Junkyard', '128 Cradle Mountain Road', 'Wilmot', 'Wilmot', 'Tasmania', 0, '0364921418', '0364921418', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0.00, '', '', '', '', 0, '', '', 'confirmed', 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 1459116000, 0, 0, 1458811127, 1458811968, 0);

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
  `layoutAccounts` varchar(10) COLLATE utf8_bin NOT NULL,
  `layoutContent` varchar(10) COLLATE utf8_bin NOT NULL,
  `layoutBookings` varchar(10) COLLATE utf8_bin NOT NULL,
  `lti` int(10) NOT NULL,
  `ti` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `options`, `username`, `password`, `cover`, `coverURL`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `avatar`, `gravatar`, `business`, `name`, `email`, `emailPassword`, `email_check`, `url`, `address`, `suburb`, `city`, `state`, `postcode`, `abn`, `phone`, `mobile`, `notes`, `status`, `active`, `activate`, `adminCategory_1`, `adminCategory_2`, `adminCategory_ti`, `language`, `timezone`, `rank`, `discount`, `layoutAccounts`, `layoutContent`, `layoutBookings`, `lti`, `ti`) VALUES
(1, '11111111', 'root', '$2y$10$6SkCJ1NRcNDgElDfHjw7SOvQxAcoIRUmossH1gfj1yy2xscW3q8PC', '', '', '', '', '', 'avatar_1.jpg', '', 'Studio Junkyard', 'Kenika Suitters', 'dennis@studiojunkyard.com', '', 0, 'http://www.facebook.com/studiojunkyard', '128 Cradle Mountain Road', 'Wilmot', 'Wilmot', 'Tasmania', 0, '', '0364921418', '0364921418', '', 'unpublished', 1, '', '', '', 0, 'en-AU', 'Australia/Hobart', 1000, '', 'card', 'list', 'calendar', 0, 1402746479),
(2, '00000000', 'green', '$2y$10$NdVkcQ502edSVkQayBKkFOCiRqye9dHLNtQMS4ogzPurEs5icqDh.', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', '', 1, '', '', '', 0, '', '', 0, '', '', '', '', 0, 1455888199),
(3, '00000000', 'blue', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', '', '', '', 1, '', '', '', 0, '', '', 0, '', '', '', '', 0, 1455888219);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `uid`, `rid`, `view`, `contentType`, `refTable`, `refColumn`, `oldda`, `newda`, `action`, `ti`) VALUES
(1, 1, 11, 'bookings', 'booking', 'content', 'tis', 0x31343538383131313237, 0x31343539313136303030, 'update', 1458811144),
(2, 1, 11, 'bookings', 'booking', 'content', 'status', 0x756e636f6e6669726d6564, 0x636f6e6669726d6564, 'update', 1458811151),
(3, 1, 11, 'bookings', 'booking', 'content', 'notes', '', '', 'update', 1458811740),
(4, 1, 11, 'bookings', 'booking', 'content', 'notes', '', '', 'update', 1458811948),
(5, 1, 11, 'bookings', 'booking', 'content', 'notes', '', '', 'update', 1458811968),
(6, 1, 1, 'index', 'index', 'menu', 'cover', 0x706167655f636f7665725f312e6a7067, '', 'update', 1458866345),
(7, 1, 1, '', '', 'login', 'layoutContent', 0x63617264, 0x6c697374, 'update', 1458866702);

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
  `eti` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `uid`, `login_user`, `title`, `seoTitle`, `file`, `cover`, `coverURL`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `contentType`, `schemaType`, `seoKeywords`, `seoDescription`, `seoCaption`, `menu`, `notes`, `ord`, `active`, `eti`) VALUES
(1, 1, 'Kenika Suitters', 'Home', '', '', 'page_cover_1.jpg', '', '', '', '', 'index', '', 'Default home page keywords', 'Default home page description', 'Default home page caption', 'head', '', 0, 1, 1458866345),
(2, 1, 'Kenika Suitters', 'Blog', '', 'article', 'page_cover_2.jpg', '', '', '', '', 'article', '', '', '', '', 'head', '', 5, 1, 1458787523),
(3, 1, 'Kenika Suitters', 'Portfolio', '', 'portfolio', '', '', '', '', '', 'portfolio', '', '', '', '', 'head', '', 8, 1, 1458787523),
(4, 1, 'Kenika Suitters', 'Bookings', '', 'bookings', '', '', '', '', '', 'bookings', '', '', '', '', 'head', '', 9, 1, 1458787523),
(5, 1, 'Kenika Suitters', 'Events', '', 'events', '', '', '', '', '', 'event', '', '', '', '', 'head', '', 7, 1, 1458787523),
(6, 1, 'Kenika Suitters', 'News', '', 'news', '', '', '', '', '', 'news', '', '', '', '', 'head', '', 6, 1, 1458787523),
(7, 1, 'Kenika Suitters', 'Testimonials', '', 'testimonials', '', '', '', '', '', 'testimonial', '', '', '', '', 'head', '', 4, 1, 1458787523),
(8, 1, 'Kenika Suitters', 'Inventory', '', 'inventory', '', '', '', '', '', 'inventory', '', '', '', '', 'head', '', 3, 1, 1458787523),
(9, 1, 'Kenika Suitters', 'Services', '', 'services', 'page_cover_9.jpg', '', '', '', '', 'service', '', 'Default Services SEO Keywords', 'Default Services SEO Description', 'Default Services SEO Caption', 'head', '', 2, 1, 1458787523),
(10, 1, 'Kenika Suitters', 'Gallery', '', 'gallery', '', '', '', '', '', 'gallery', '', 'Default Gallery SEO Keywords', 'Default Gallery SEO Description', 'Default Gallery SEO Caption', 'head', '', 1, 1, 1458787523),
(11, 1, 'Kenika Suitters', 'Contact', '', 'contactus', '', '', '', '', '', 'contactus', '', '', '', '', 'head', '', 10, 1, 1458787523),
(12, 1, 'Kenika Suitters', 'Cart', '', 'cart', '', '', '', '', '', 'cart', '', '', '', '', 'head', '', 11, 1, 1458787523),
(13, 1, 'Kenika Suitters', 'Terms of Service', 'Terms of Service', 'tos', '', '', '', '', '', 'tos', '', '', '', '', 'footer', '', 13, 1, 1458787523),
(14, 1, 'Kenika Suitters', 'Search', 'Search', 'search', '', '', '', '', '', 'search', '', '', '', '', 'footer', '', 12, 1, 1458787523);

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
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
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
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
