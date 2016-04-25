<?php
error_reporting(0);
define('DS',DIRECTORY_SEPARATOR);
include_once dirname(__FILE__).DS.'elFinderConnector.class.php';
include_once dirname(__FILE__).DS.'elFinder.class.php';
include_once dirname(__FILE__).DS.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DS.'elFinderVolumeLocalFileSystem.class.php';
$settings=parse_ini_file('..'.DS.'..'.DS.'..'.DS.'core'.DS.'config.ini',TRUE);
if((!empty($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')||$_SERVER['SERVER_PORT']==443)
    define('PROTOCOL','https://');
else
    define('PROTOCOL','http://');
define('URL',PROTOCOL.$_SERVER['HTTP_HOST'].$settings['system']['url'].'/');
function access($attr,$path,$data,$volume){
    return strpos(basename($path),'.')===0?!($attr=='read'||$attr=='write'):null;
}
$opts=array(
    'roots'=>array(
        array(
            'driver'=>'LocalFileSystem',
            'path'=>$_SERVER["DOCUMENT_ROOT"].DS.$settings['system']['url'].DS.'media'.DS,
            'URL'=>URL.'media/',
            'uploadDeny'=>array(
                'all'
            ),
            'uploadAllow'=>array(
                'image',
                'text/plain'
            ),
            'uploadOrder'=>array(
                'deny',
                'allow'
            ),
            'accessControl'=>'access',
            'attributes'=>array(
                array(
                    'pattern'=>'',
                    'pattern'=>'!^/orders|backup|avatar!',
                    'hidden'=>true
                )
            )
        )
    )
);
$connector=new elFinderConnector(new elFinder($opts));
$connector->run();
