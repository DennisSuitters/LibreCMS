<?php
namespace SEOstats;
if(!ini_get('date.timezone')&&function_exists('date_default_timezone_set'))date_default_timezone_set('UTC');
if(version_compare(PHP_VERSION,'5.3','<'))exit('SEOstats requires PHP version 5.3.0 or greater, but yours is '.PHP_VERSION);
if(version_compare(PHP_VERSION,'5.4','>=')&&gc_enabled())gc_disable();
require_once realpath(__DIR__.'/Common/AutoLoader.php');
$autoloader=new \SEOstats\Common\AutoLoader(__NAMESPACE__,dirname(__DIR__));
$autoloader->register();
