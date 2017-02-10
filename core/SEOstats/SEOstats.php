<?php
namespace SEOstats;
use SEOstats\Common\SEOstatsException as E;
use SEOstats\Config as Config;
use SEOstats\Helper as Helper;
use SEOstats\Services as Service;
if(!function_exists('curl_init')){
  throw new E('SEOstats requires the PHP CURL extension.');
  exit();
}
if(1==ini_get('safe_mode')||'on'===strtolower(ini_get('safe_mode'))){
  throw new E('Because some SEOstats functions require the CURLOPT_FOLLOWLOCATION flag, you must not run PHP in safe mode! (This flag can not be set in safe mode.)');
  exit();
}
class SEOstats{
  const BUILD_NO=Config\Package::VERSION_CODE;
  protected static$_url,$_host,$_lastHtml,$_lastLoadedUrl=false;
  public function __construct($url=false){if(false!==$url)self::setUrl($url);}
  public function Alexa(){return new Service\Alexa;}
  public function Google(){return new Service\Google;}
  public function Mozscape(){return new Service\Mozscape;}
  public function OpenSiteExplorer(){return new Service\OpenSiteExplorer;}
  public function SEMRush(){return new Service\SemRush;}
  public function Sistrix(){return new Service\Sistrix;}
  public function Social(){return new Service\Social;}
  public static function getLastLoadedHtml(){return self::$_lastHtml;}
  public static function getLastLoadedUrl(){return self::$_lastLoadedUrl;}
  public static function getUrl($url=false){$url=false!==$url?$url:self::$_url;return$url;}
  public function setUrl($url){if(false!==Helper\Url::isRfc($url)){self::$_url=$url;self::$_host=Helper\Url::parseHost($url);}else{throw new E('Invalid URL!');exit();}return true;}
  public static function getHost($url=false){return Helper\Url::parseHost(self::getUrl($url));}
  public static function getDomain($url=false){return'http://'.self::getHost($url=false);}
  protected static function _getDOMDocument($html){$doc=new \DOMDocument;@$doc->loadHtml($html);return$doc;}
  protected static function _getDOMXPath($doc){$xpath=new \DOMXPath($doc);return$xpath;}
  protected static function _getPage($url){$url=self::getUrl($url);if(self::getLastLoadedUrl()==$url){return self::getLastLoadedHtml();}$html=Helper\HttpRequest::sendRequest($url);if($html){self::$_lastLoadedUrl=$url;self::_setHtml($html);return$html;}else{self::noDataDefaultValue();}}
  protected static function _setHtml($str){self::$_lastHtml=$str;}
  protected static function noDataDefaultValue(){return Config\DefaultSettings::DEFAULT_RETURN_NO_DATA;}
}
