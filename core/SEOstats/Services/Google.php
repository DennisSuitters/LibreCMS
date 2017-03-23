<?php
namespace SEOstats\Services;
use SEOstats\Common\SEOstatsException as E;
use SEOstats\SEOstats as SEOstats;
use SEOstats\Config as Config;
use SEOstats\Helper as Helper;
function env($config,$default){
  $config_value=getenv($config);
  if(is_string($config_value)&&(strlen(trim($config_value))>0)){
    return$config_value;
  }else{
    return$default;
  }
}
class Google extends SEOstats{
  public static function getPageRank($url=false){if(!class_exists('\GTB_PageRank'))require_once realpath(__DIR__.'/3rdparty/GTB_PageRank.php');$gtb=new \GTB_PageRank(parent::getUrl($url));$result=$gtb->getPageRank();return$result!=""?$result:static::noDataDefaultValue();}
  public static function getSiteindexTotal($url=false){$url=parent::getUrl($url);$query=urlencode("site:{$url}");return self::getSearchResultsTotal($query);}
  public static function getBacklinksTotal($url=false){$url=parent::getUrl($url);$query=urlencode("link:{$url}");return self::getSearchResultsTotal($query);}
  public static function getSearchResultsTotal($url=false){$url=parent::getUrl($url);$url=sprintf(Config\Services::GOOGLE_APISEARCH_URL,1,$url);$ret=static::_getPage($url);$obj=Helper\Json::decode($ret);return!isset($obj->responseData->cursor->estimatedResultCount)?parent::noDataDefaultValue():intval($obj->responseData->cursor->estimatedResultCount);}
  public static function getPagespeedAnalysis($url=false){if(''==Config\ApiKeys::GOOGLE_SIMPLE_API_ACCESS_KEY){throw new E('In order to use the PageSpeed API, you must obtain and set an API key first (see SEOstats\Config\ApiKeys.php).');exit(0);}$url=parent::getUrl($url);$url=sprintf(Config\Services::GOOGLE_PAGESPEED_URL,$url, Config\ApiKeys::GOOGLE_SIMPLE_API_ACCESS_KEY);$ret=static::_getPage($url);return Helper\Json::decode($ret);}
  public static function getPagespeedScore($url=false){$url=parent::getUrl($url);$ret=self::getPagespeedAnalysis($url);return!isset($ret->score)||!$ret->score?parent::noDataDefaultValue():intval($ret->score);}
  public static function getSerps($query,$maxResults=100,$domain=false){return Google\Search::getSerps($query,$maxResults,$domain);}
}
