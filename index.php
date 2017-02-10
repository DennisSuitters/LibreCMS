<?php
/**
 * LibreCMS is an Open Source Content Management System
 *
 * for PHP version 5.6+
 *
 * LICENSE: By downloading and using LibreCMS you hereby agree not to hold
 * Studio Junkyard liable for any damages that your usage of LibreCMS may
 * cause to your system, or persons. Damages may infer such things as
 * Data Loss, Aural or Visual Impairment, Server Crashes, Alien Abduction,
 * Coding nightmare's, Alien Implants, or Visiting Alternate Realities.
 * LibreCMS is Licensed under GPLv3. We request that if you modify, and
 * hopefully enhance LibreCMS, that you take part in maintaining, and
 * contributing to it's code base at GitHub.
 *
 * @category   Content Management System
 * @package    LibreCMS
 * @author     Original Author <dennis@studiojunkyard.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.html  GPLv3
 * @link       https://github.com/StudioJunkyard/LibreCMS
 */
ini_set('session.use_trans_sid',0);
ini_set('session.use_cookies',1);
ini_set('session.use_only_cookies',1);
session_name('develsess');
session_start();
require'core/core.php';
