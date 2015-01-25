-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 25, 2015 at 01:56 PM
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
(1, '11111111', 'default', 'LibreCMS', 'Default Site Description', 'Default Site Caption', 'Default Site Keywords', 'Studio Junkyard', '000 000 000', '128 Cradle Mtn Road', 'Wilmot', 'Wilmot', 'Tasmania', 'Australia', 7310, '0364921418', '0364921418', 'info@studiojunkyard.com', 1406180963, 3600, 'M j, Y g:i A', 'en', 'Australia/Hobart', 4, 1209600, '{name}: Invoice: {order_number}', 'Hello {first},<br><br>Please find attached Order {order_number}<br>Note: {notes}', 'Services are considered to be in a <b>Grace Period</b> for a total of <b>14 days</b> whilst this invoice is outstanding. If no payment or contact to make payment arrangements has been forthcoming during the <b>14 Day Grace Period</b>, any unpaid accounts will be <b>suspended</b>, unless other arrangements have been made by contacting us (Details at the top of the Invoice). If <b>30 days</b> without payment or contact has lapsed, we will <b>at our discretion</b> consider <b>terminating</b>Â services, upon which you will be charged for the following full month as a termination fee. Following another 30 days (60 days or 2 months) from this Order Date, if no contact or resolution has been settled, we will remove/delete any data from our servers at our discretion.', '', '', '', '', '', 1404461417, 0);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=21 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `options`, `rank`, `rid`, `uid`, `cid`, `ip`, `contentType`, `schemaType`, `keywords`, `code`, `brand`, `title`, `category_1`, `category_2`, `name`, `url`, `email`, `business`, `address`, `suburb`, `city`, `state`, `postcode`, `phone`, `thumb`, `file`, `cost`, `subject`, `notes`, `quantity`, `tags`, `caption`, `status`, `service`, `internal`, `featured`, `backgroundColor`, `bookable`, `fti`, `assoc`, `ord`, `views`, `active`, `tis`, `tie`, `lti`, `ti`) VALUES
(1, '00000000', 0, 0, 1, 0, '', 'article', 'blogPost', 'doctor who,sorry,rotmeister,spaceship', '', '', 'Article 1', 'Category 1.1', 'Category 2.1', '', '', '', '', '', '', '', '', 0, '', 'thumb_1.jpg', 'file_1.jpg', 0.00, '', '<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. You know how I sometimes have really brilliant ideas? It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do!</p>\r\n<p>No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? You hit me with a cricket bat. The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant.</p>\r\n<p>You''ve swallowed a planet! I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I hate yogurt. It''s just stuff with bits in. Did I mention we have comfy chairs? Noâ€¦ It''s a thing; it''s like a plan, but with more greatness.</p>\r\n<p>You''ve swallowed a planet! No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. I hate yogurt. It''s just stuff with bits in. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? You''ve swallowed a planet!</p>\r\n<p>It''s a fez. I wear a fez now. Fezes are cool. Saving the world with meals on wheels. Saving the world with meals on wheels. No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister.</p>\r\n<p>Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. You hate me; you want to kill me! Well, go on! Kill me! KILL ME! I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. Sorry, checking all the water in this area; there''s an escaped fish. You hate me; you want to kill me! Well, go on! Kill me! KILL ME! Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you?</p>\r\n<p>All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you? I am the Doctor, and you are the Daleks! I am the last of my species, and I know how that weighs on the heart so don''t lie to me! I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why.</p>\r\n<p>You hate me; you want to kill me! Well, go on! Kill me! KILL ME! Heh-haa! Super squeaky bum time! You''ve swallowed a planet! Aw, you''re all Mr. Grumpy Face today. Aw, you''re all Mr. Grumpy Face today. Heh-haa! Super squeaky bum time!</p>\r\n<p>The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant. All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? You hit me with a cricket bat. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? You know how I sometimes have really brilliant ideas?</p>\r\n<p>Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. Saving the world with meals on wheels. *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Heh-haa! Super squeaky bum time!</p>', 0, 'doctor who,sorry,rotmeister,spaceship', 'Saving the world with meals on wheels.', 'published', 0, 0, 0, '', 0, 0, '', 6, 0, 1, 0, 0, 0, 1420126241),
(2, '00000000', 0, 0, 1, 0, '', 'article', 'blogPost', '', '', '', 'Article 2', 'Category 1.1', 'Category 2.2', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p><img src="http://localhost/LibreCMS/media/a28aa3f26f3ad78c5988dc8ab9426d94.jpg" style="width: 526px; float: left;">Aw, you''re all Mr. Grumpy Face today. I am the Doctor, and you are the Daleks! *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Did I mention we have comfy chairs?</p>\r\n<p>Heh-haa! Super squeaky bum time! I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Sorry, checking all the water in this area; there''s an escaped fish. You''ve swallowed a planet! I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. They''re not aliens, they''re Earthâ€¦liens!</p>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. You know how I sometimes have really brilliant ideas? I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship.</p>\r\n<p>Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. Did I mention we have comfy chairs? I am the Doctor, and you are the Daleks! Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<p>I am the Doctor, and you are the Daleks! I hate yogurt. It''s just stuff with bits in. It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! Did I mention we have comfy chairs? You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister.</p>', 0, '', '', 'published', 0, 0, 0, '', 0, 0, '', 0, 0, 1, 0, 0, 0, 1420126329),
(3, '00000000', 0, 0, 1, 0, '', 'article', 'blogPost', '', '', '', 'Article 3', 'Category 1.2', 'Category 2.1', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p>Heh-haa! Super squeaky bum time! No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant. I am the Doctor, and you are the Daleks! It''s a fez. I wear a fez now. Fezes are cool. *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do!</p>\r\n<p>I hate yogurt. It''s just stuff with bits in. It''s a fez. I wear a fez now. Fezes are cool. *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Aw, you''re all Mr. Grumpy Face today. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<p>I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you? I am the last of my species, and I know how that weighs on the heart so don''t lie to me! *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! I am the Doctor, and you are the Daleks! I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship.</p>\r\n<p>I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do!</p>\r\n<p>I am the Doctor, and you are the Daleks! The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>', 0, '', '', 'published', 0, 0, 0, '', 0, 0, '', 0, 0, 1, 0, 0, 0, 1420126371),
(4, '00000000', 0, 0, 1, 0, '', 'article', 'blogPost', 'Article 4 Keywords', '', '', 'Article 4', 'Category 1.1', 'Category 2.1', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p>You know how I sometimes have really brilliant ideas? I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Noâ€¦ It''s a thing; it''s like a plan, but with more greatness.</p>\r\n<p>They''re not aliens, they''re Earthâ€¦liens! Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. I am the Doctor, and you are the Daleks! I hate yogurt. It''s just stuff with bits in. The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant.</p>\r\n<p>I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. Aw, you''re all Mr. Grumpy Face today. I hate yogurt. It''s just stuff with bits in. I am the last of my species, and I know how that weighs on the heart so don''t lie to me!</p>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! You''ve swallowed a planet! You hate me; you want to kill me! Well, go on! Kill me! KILL ME! Aw, you''re all Mr. Grumpy Face today.</p>\r\n<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister.</p>', 0, '', '', 'published', 0, 0, 1, '#fa573c', 0, 0, '', 0, 0, 1, 0, 0, 0, 1420126407),
(5, '00000000', 0, 0, 1, 0, '', 'portfolio', 'CreativeWork', '', '', '', 'Portfolio 5', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p>You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. Aw, you''re all Mr. Grumpy Face today. It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''!</p>\r\n<p>You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. Stop talking, brain thinking. Hush. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why.</p>\r\n<p>Heh-haa! Super squeaky bum time! *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! You hit me with a cricket bat. Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? I am the last of my species, and I know how that weighs on the heart so don''t lie to me!</p>\r\n<p>All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! You''ve swallowed a planet! Did I mention we have comfy chairs? They''re not aliens, they''re Earthâ€¦liens!</p>\r\n<p>You know how I sometimes have really brilliant ideas? I am the Doctor, and you are the Daleks! You hate me; you want to kill me! Well, go on! Kill me! KILL ME! I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship.</p>', 0, '', '', 'published', 0, 0, 0, '', 0, 0, '', 0, 0, 1, 0, 0, 0, 1420127622),
(6, '00000000', 0, 0, 1, 0, '', 'portfolio', 'CreativeWork', '', '', '', 'Portfolio 6', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p>Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''!</p>\r\n<p>It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! You know how I sometimes have really brilliant ideas? All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong?</p>\r\n<p>I am the Doctor, and you are the Daleks! I am the Doctor, and you are the Daleks! I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Stop talking, brain thinking. Hush.</p>\r\n<p>You''ve swallowed a planet! I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. Sorry, checking all the water in this area; there''s an escaped fish.</p>\r\n<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you? I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>', 0, '', '', 'published', 0, 0, 0, '', 0, 0, '', 0, 0, 1, 0, 0, 0, 1420127661),
(7, '00000000', 0, 0, 1, 0, '', 'portfolio', 'CreativeWork', '', '', '', 'Portfolio 7', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_7.png', 'file_7.png', 0.00, '', '<p>You know how I sometimes have really brilliant ideas? Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you? Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. You hate me; you want to kill me! Well, go on! Kill me! KILL ME! *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do!</p>\r\n<p>I am the last of my species, and I know how that weighs on the heart so don''t lie to me! Heh-haa! Super squeaky bum time! Aw, you''re all Mr. Grumpy Face today.</p>\r\n<p>Heh-haa! Super squeaky bum time! Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>\r\n<p>No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. Saving the world with meals on wheels. I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship.</p>\r\n<p>You''ve swallowed a planet! *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship.</p>', 0, '', '', 'published', 0, 0, 0, '#b3dc6c', 0, 0, '', 9, 0, 1, 0, 0, 0, 1420127703),
(8, '00000000', 0, 0, 1, 0, '', 'portfolio', 'CreativeWork', '', '', '', 'Portfolio 8', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_8.jpg', 'file_8.jpg', 0.00, '', '<p>I am the Doctor, and you are the Daleks! Did I mention we have comfy chairs? Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why.</p>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. Did I mention we have comfy chairs?</p>\r\n<p>All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant.</p>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Aw, you''re all Mr. Grumpy Face today. Sorry, checking all the water in this area; there''s an escaped fish. I am the Doctor, and you are the Daleks! Aw, you''re all Mr. Grumpy Face today.</p>\r\n<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! It''s a fez. I wear a fez now. Fezes are cool. You''ve swallowed a planet! I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. Saving the world with meals on wheels.</p>', 0, '', '', 'published', 0, 0, 0, '', 0, 0, '', 7, 0, 1, 0, 0, 0, 1420127737),
(9, '00000000', 0, 0, 1, 0, '', 'testimonials', 'Review', '', '', '', 'Testimonials 9', '', '', 'Kenika Suitters', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', 'This is a test Testimonial', 0, '', '', 'published', 0, 0, 0, '', 0, 0, '', 0, 0, 1, 0, 0, 0, 1420952512),
(10, '10000000', 0, 0, 1, 0, '', 'inventory', 'Product', '', '', '', 'Inventory 10', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_10.jpg', 'file_10.jpg', 10.00, '', '<p>You''ve swallowed a planet! Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you? Sorry, checking all the water in this area; there''s an escaped fish. I am the Doctor, and you are the Daleks! You''ve swallowed a planet! I am the last of my species, and I know how that weighs on the heart so don''t lie to me!</p>\r\n<p>Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''!</p>\r\n<p>Stop talking, brain thinking. Hush. It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! It''s a fez. I wear a fez now. Fezes are cool. Heh-haa! Super squeaky bum time!</p>\r\n<p>All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? I am the Doctor, and you are the Daleks! Sorry, checking all the water in this area; there''s an escaped fish. Sorry, checking all the water in this area; there''s an escaped fish. It''s a fez. I wear a fez now. Fezes are cool.</p>\r\n<p>Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant. No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister.</p>', 5, '', '', 'published', 0, 0, 1, '#a47ae2', 0, 0, '', 2, 0, 1, 0, 0, 0, 1421063363),
(11, '00000000', 0, 0, 1, 0, '', 'gallery', 'ImageGallery', '', '', '', 'Gallery 11', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_11.png', 'file_11.png', 0.00, '', '<p>No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? You know how I sometimes have really brilliant ideas? Aw, you''re all Mr. Grumpy Face today.</p>\r\n<p>Did I mention we have comfy chairs? You hate me; you want to kill me! Well, go on! Kill me! KILL ME! You hate me; you want to kill me! Well, go on! Kill me! KILL ME! I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<p>I am the last of my species, and I know how that weighs on the heart so don''t lie to me! Aw, you''re all Mr. Grumpy Face today. Heh-haa! Super squeaky bum time! Heh-haa! Super squeaky bum time! No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. I am the Doctor, and you are the Daleks!</p>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! I am the last of my species, and I know how that weighs on the heart so don''t lie to me!</p>\r\n<p>Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you? Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why.</p>\r\n<p>You''ve swallowed a planet! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels. You know how I sometimes have really brilliant ideas?</p>\r\n<p>You hate me; you want to kill me! Well, go on! Kill me! KILL ME! Sorry, checking all the water in this area; there''s an escaped fish. *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship.</p>\r\n<p>I hate yogurt. It''s just stuff with bits in. Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you? Sorry, checking all the water in this area; there''s an escaped fish. Heh-haa! Super squeaky bum time!</p>\r\n<p>I am the last of my species, and I know how that weighs on the heart so don''t lie to me! I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister.</p>\r\n<p>You hit me with a cricket bat. It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! Heh-haa! Super squeaky bum time! You''ve swallowed a planet! Heh-haa! Super squeaky bum time!</p>', 0, '', 'This is the caption for Gallery 11', 'published', 0, 0, 0, '', 0, 0, '', 5, 0, 1, 0, 0, 0, 1421238674),
(12, '00000000', 0, 0, 1, 0, '', 'inventory', 'Product', '', '', '', 'Inventory 12', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p>You hit me with a cricket bat. You hit me with a cricket bat. The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant. Aw, you''re all Mr. Grumpy Face today.</p>\r\n<p>You hate me; you want to kill me! Well, go on! Kill me! KILL ME! I am the Doctor, and you are the Daleks! You hate me; you want to kill me! Well, go on! Kill me! KILL ME! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? It''s a fez. I wear a fez now. Fezes are cool. You''ve swallowed a planet!</p>\r\n<p>Saving the world with meals on wheels. Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself.</p>\r\n<p>I am the last of my species, and I know how that weighs on the heart so don''t lie to me! It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! I am the last of my species, and I know how that weighs on the heart so don''t lie to me! The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant.</p>\r\n<p>Did I mention we have comfy chairs? I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister.</p>\r\n<p>I am the last of my species, and I know how that weighs on the heart so don''t lie to me! Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. You''ve swallowed a planet! You know how I sometimes have really brilliant ideas? Aw, you''re all Mr. Grumpy Face today.</p>\r\n<p>You''ve swallowed a planet! It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you? *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do!</p>\r\n<p>I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? I hate yogurt. It''s just stuff with bits in. I hate yogurt. It''s just stuff with bits in.</p>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. You hit me with a cricket bat. Did I mention we have comfy chairs?</p>\r\n<p>It''s a fez. I wear a fez now. Fezes are cool. *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! You''ve swallowed a planet! Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. Heh-haa! Super squeaky bum time! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong?</p>', 0, '', '', 'published', 0, 0, 0, '', 0, 0, '', 0, 0, 1, 0, 0, 0, 1421722302),
(13, '00000000', 0, 0, 1, 0, '', 'inventory', 'Product', '', '', '', 'Inventory 13', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p>Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you? Sorry, checking all the water in this area; there''s an escaped fish. *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do!</p>\r\n<p>They''re not aliens, they''re Earthâ€¦liens! Aw, you''re all Mr. Grumpy Face today. You hit me with a cricket bat.</p>\r\n<p>No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. You know how I sometimes have really brilliant ideas? You know how I sometimes have really brilliant ideas?</p>\r\n<p>I am the last of my species, and I know how that weighs on the heart so don''t lie to me! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? It''s a fez. I wear a fez now. Fezes are cool. Aw, you''re all Mr. Grumpy Face today. You hit me with a cricket bat. Saving the world with meals on wheels.</p>\r\n<p>Saving the world with meals on wheels. It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister.</p>\r\n<p>You know how I sometimes have really brilliant ideas? You hit me with a cricket bat. Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? You hit me with a cricket bat. Sorry, checking all the water in this area; there''s an escaped fish.</p>\r\n<p>You know how I sometimes have really brilliant ideas? Heh-haa! Super squeaky bum time! I hate yogurt. It''s just stuff with bits in.</p>\r\n<p>Saving the world with meals on wheels. I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. Did I mention we have comfy chairs?</p>\r\n<p>All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant. No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. Saving the world with meals on wheels.</p>\r\n<p>Heh-haa! Super squeaky bum time! I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. You know how I sometimes have really brilliant ideas? It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''!</p>', 0, '', '', 'published', 0, 0, 0, '', 0, 0, '', 0, 0, 1, 0, 0, 0, 1421722362),
(14, '00000000', 0, 0, 1, 0, '', 'inventory', 'Product', '', '', '', 'Inventory 14', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p>All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant. Did I mention we have comfy chairs? Saving the world with meals on wheels.</p>\r\n<p>It''s a fez. I wear a fez now. Fezes are cool. It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Noâ€¦ It''s a thing; it''s like a plan, but with more greatness.</p>\r\n<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Noâ€¦ It''s a thing; it''s like a plan, but with more greatness.</p>\r\n<p>No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! You know how I sometimes have really brilliant ideas? Heh-haa! Super squeaky bum time!</p>\r\n<p>You hit me with a cricket bat. Aw, you''re all Mr. Grumpy Face today. You''ve swallowed a planet! I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. Saving the world with meals on wheels.</p>\r\n<p>I am the Doctor, and you are the Daleks! I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. You hit me with a cricket bat. Saving the world with meals on wheels. Did I mention we have comfy chairs? All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong?</p>\r\n<p>Saving the world with meals on wheels. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<p>Heh-haa! Super squeaky bum time! Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. Did I mention we have comfy chairs? All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong?</p>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. Sorry, checking all the water in this area; there''s an escaped fish. You hate me; you want to kill me! Well, go on! Kill me! KILL ME!</p>\r\n<p>I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Aw, you''re all Mr. Grumpy Face today. It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''!</p>', 0, '', '', 'published', 0, 0, 0, '', 0, 0, '', 0, 0, 1, 0, 0, 0, 1421722406),
(15, '00000000', 0, 0, 1, 0, '', 'services', '', '', '', '', 'Services 15', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '<p>You hate me; you want to kill me! Well, go on! Kill me! KILL ME! Sorry, checking all the water in this area; there''s an escaped fish. Noâ€¦ It''s a thing; it''s like a plan, but with more greatness.</p>\r\n<p>No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. Heh-haa! Super squeaky bum time! It''s a fez. I wear a fez now. Fezes are cool. I hate yogurt. It''s just stuff with bits in.</p>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? You know how I sometimes have really brilliant ideas? You hate me; you want to kill me! Well, go on! Kill me! KILL ME!</p>\r\n<p>You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Aw, you''re all Mr. Grumpy Face today. I hate yogurt. It''s just stuff with bits in. It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''!</p>\r\n<p>Saving the world with meals on wheels. You''ve swallowed a planet! I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. You know how I sometimes have really brilliant ideas? You hit me with a cricket bat.</p>\r\n<p>Saving the world with meals on wheels. They''re not aliens, they''re Earthâ€¦liens! No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Heh-haa! Super squeaky bum time!</p>\r\n<p>Did I mention we have comfy chairs? *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Heh-haa! Super squeaky bum time! Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. Sorry, checking all the water in this area; there''s an escaped fish. Did I mention we have comfy chairs?</p>\r\n<p>You''ve swallowed a planet! Aw, you''re all Mr. Grumpy Face today. It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! You hit me with a cricket bat.</p>\r\n<p>I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. You know how I sometimes have really brilliant ideas? You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<p>You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Did I mention we have comfy chairs? You''ve swallowed a planet! No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister.</p>', 0, '', '', 'published', 0, 0, 0, '', 1, 0, '', 0, 0, 1, 0, 0, 0, 1421722472),
(16, '10000000', 0, 0, 1, 0, '', 'services', '', '', '', '', 'Services 16', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 20.00, '', '<p>Saving the world with meals on wheels. Saving the world with meals on wheels. You hate me; you want to kill me! Well, go on! Kill me! KILL ME! Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you? I am the Doctor, and you are the Daleks! You hit me with a cricket bat.</p>\r\n<p>Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. Sorry, checking all the water in this area; there''s an escaped fish. I am the last of my species, and I know how that weighs on the heart so don''t lie to me!</p>\r\n<p>You''ve swallowed a planet! Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. You hit me with a cricket bat. I hate yogurt. It''s just stuff with bits in. I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. You hate me; you want to kill me! Well, go on! Kill me! KILL ME!</p>\r\n<p>Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. It''s a fez. I wear a fez now. Fezes are cool. Did I mention we have comfy chairs? You''ve swallowed a planet! Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<p>I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. You hit me with a cricket bat. You hit me with a cricket bat. You know how I sometimes have really brilliant ideas? I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why.</p>\r\n<p>It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant. All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Heh-haa! Super squeaky bum time! Sorry, checking all the water in this area; there''s an escaped fish. I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship.</p>\r\n<p>No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. Aw, you''re all Mr. Grumpy Face today. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! You hit me with a cricket bat. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Heh-haa! Super squeaky bum time!</p>\r\n<p>All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Sorry, checking all the water in this area; there''s an escaped fish. You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<p>You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? You know how I sometimes have really brilliant ideas? You hit me with a cricket bat. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. The way I see it, every life is a pile of good things and bad things.â€¦hey.â€¦the good things don''t always soften the bad things; but vice-versa the bad things don''t necessarily spoil the good things and make them unimportant.</p>\r\n<p>It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! You''ve swallowed a planet! Did I mention we have comfy chairs?</p>', 0, '', 'This is the Caption for Services 16', 'published', 0, 0, 0, '', 1, 0, '', 0, 0, 1, 0, 0, 0, 1421722507),
(17, '00000000', 0, 0, 1, 0, '', 'gallery', 'ImageGallery', '', '', '', 'Gallery 17', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_17.png', 'file_17.png', 0.00, '', '<p>Heh-haa! Super squeaky bum time! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Saving the world with meals on wheels. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. Heh-haa! Super squeaky bum time! You know how I sometimes have really brilliant ideas?</p>\r\n<p>You hate me; you want to kill me! Well, go on! Kill me! KILL ME! Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you? It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why.</p>\r\n<p>All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Sorry, checking all the water in this area; there''s an escaped fish. Heh-haa! Super squeaky bum time! All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong?</p>\r\n<p>You hit me with a cricket bat. I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. You hate me; you want to kill me! Well, go on! Kill me! KILL ME! Did I mention we have comfy chairs? Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Father Christmas. Santa Claus. Or as I''ve always known him: Jeff. Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. You hate me; you want to kill me! Well, go on! Kill me! KILL ME! Noâ€¦ It''s a thing; it''s like a plan, but with more greatness.</p>\r\n<p>All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Aw, you''re all Mr. Grumpy Face today. Aw, you''re all Mr. Grumpy Face today.</p>\r\n<p>I hate yogurt. It''s just stuff with bits in. I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. *Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. You''ve swallowed a planet! You know how I sometimes have really brilliant ideas? You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better?</p>\r\n<p>I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. You hit me with a cricket bat. It''s a fez. I wear a fez now. Fezes are cool. You hit me with a cricket bat.</p>\r\n<p>You know how I sometimes have really brilliant ideas? All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? You hate me; you want to kill me! Well, go on! Kill me! KILL ME! No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. Saving the world with meals on wheels.</p>', 0, '', '', 'published', 0, 0, 0, '', 0, 0, '', 4, 0, 1, 0, 0, 0, 1421722688);
INSERT INTO `content` (`id`, `options`, `rank`, `rid`, `uid`, `cid`, `ip`, `contentType`, `schemaType`, `keywords`, `code`, `brand`, `title`, `category_1`, `category_2`, `name`, `url`, `email`, `business`, `address`, `suburb`, `city`, `state`, `postcode`, `phone`, `thumb`, `file`, `cost`, `subject`, `notes`, `quantity`, `tags`, `caption`, `status`, `service`, `internal`, `featured`, `backgroundColor`, `bookable`, `fti`, `assoc`, `ord`, `views`, `active`, `tis`, `tie`, `lti`, `ti`) VALUES
(18, '00000000', 0, 0, 1, 0, '', 'gallery', 'ImageGallery', '', '', '', 'Gallery 18', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_18.png', 'file_18.png', 0.00, '', '<p>You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Sorry, checking all the water in this area; there''s an escaped fish. I am the Doctor, and you are the Daleks! I hate yogurt. It''s just stuff with bits in. Father Christmas. Santa Claus. Or as I''ve always known him: Jeff.</p>\r\n<p>Aw, you''re all Mr. Grumpy Face today. Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. You know how I sometimes have really brilliant ideas?</p>\r\n<p>Saving the world with meals on wheels. It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''! You know when grown-ups tell you ''everything''s going to be fine'' and you think they''re probably lying to make you feel better? Saving the world with meals on wheels. Annihilate? No. No violence. I won''t stand for it. Not now, not ever, do you understand me?! I''m the Doctor, the Oncoming Storm - and you basically meant beat them in a football match, didn''t you? No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister.</p>\r\n<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! Did I mention we have comfy chairs? I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why.</p>\r\n<p>I am the last of my species, and I know how that weighs on the heart so don''t lie to me! You know how I sometimes have really brilliant ideas? Did I mention we have comfy chairs? It''s art! A statement on modern society, ''Oh Ain''t Modern Society Awful?''!</p>\r\n<p>Heh-haa! Super squeaky bum time! You hate me; you want to kill me! Well, go on! Kill me! KILL ME! You hit me with a cricket bat.</p>\r\n<p>*Insistently* Bow ties are cool! Come on Amy, I''m a normal bloke, tell me what normal blokes do! You hit me with a cricket bat. No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. I''m the Doctor, I''m worse than everyone''s aunt. *catches himself* And that is not how I''m introducing myself. I am the last of my species, and I know how that weighs on the heart so don''t lie to me! I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship.</p>\r\n<p>I''m nobody''s taxi service; I''m not gonna be there to catch you every time you feel like jumping out of a spaceship. I''m the Doctor. Well, they call me the Doctor. I don''t know why. I call me the Doctor too. I still don''t know why. You hit me with a cricket bat. You''ve swallowed a planet! Heh-haa! Super squeaky bum time! You hit me with a cricket bat.</p>\r\n<p>No, I''ll fix it. I''m good at fixing rot. Call me the Rotmeister. No, I''m the Doctor. Don''t call me the Rotmeister. All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. You hate me; you want to kill me! Well, go on! Kill me! KILL ME!</p>\r\n<p>All I''ve got to do is pass as an ordinary human being. Simple. What could possibly go wrong? Did I mention we have comfy chairs? Noâ€¦ It''s a thing; it''s like a plan, but with more greatness. Heh-haa! Super squeaky bum time!</p>', 0, '', 'This is a Caption for Gallery 18', 'published', 0, 0, 1, '#7bd148', 0, 0, '', 3, 0, 1, 0, 0, 0, 1421722733),
(19, '00000000', 0, 0, 1, 0, '', 'events', 'Event', '', '', '', 'Events 19', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0.00, '', '', 0, '', '', 'published', 0, 0, 0, '', 0, 0, '', 0, 0, 1, 0, 0, 0, 1421905194),
(20, '00000000', 0, 0, 1, 2, '', 'proofs', 'CreativeWork', '', '', '', 'Proofs 20', '', '', '', '', '', '', '', '', '', '', 0, '', 'thumb_20.jpg', 'file_20.jpg', 0.00, '', '', 0, '', '', 'unpublished', 0, 0, 0, '', 0, 0, '', 10, 0, 1, 0, 0, 0, 1421905263);

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
(1, '11111111', 'admin', '$2y$10$dYvrhTGiUhWjHYgXWgg/muDXisNfS7z5y5AQ72dJAelV0YezL/gY6', '', 'dennis@studiojunkyard.com', 'StudioJunkyard', 'Kenika Suitters', 'dennis@studiojunkyard.com', 'www.studiojunkyard.com', '128 Cradle Mtn Road', '', 'Wilmot', 'Tasmania', 7310, '', '0364921418', '', 'Being of a creative mind, and getting my hands into the creative process, I like to do many things which involve thinking along with doing things manually. Such as, Wood Turning, Wood Work, Photography, Gardening, Growing Vege, and Managing the Property where I live in Tasmania, Australia.', '', 1, '', '', '', 0, 'en', 'Australia/Hobart', 1000, 1402746479),
(2, '01111111', 'test', '$2y$10$2VexmuSztvLmN0Oqxv8pyO22ayeDQ1C0np5t5VqhqrZclZsYxKYoq', '', '', '', '', 'info@studiojunkyard.com', '', '', '', '', '', 0, '', '', '', '', '', 1, '', '', '', 0, '', 'Australia/Hobart', 400, 1410919706);

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
(1, 'Home', 'Home', 'index', '', 'Home Page Keywords', 'Home Page Description', 'Home Page Caption', 'head', '', 0, 1),
(2, 'Blog', 'Blog Page Title', 'article', '', 'Blog Page Keywords', 'Blog Page Description', 'Blog Page Caption', 'head', '', 1, 1),
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
