<?php
namespace SEOstats\Helper;
class Json{
  public static function decode($str,$assoc=false){if(!function_exists('json_decode')){$j=self::getJsonService();return$j->decode($str);}else return$assoc?json_decode($str,true):json_decode($str);}
  public static function encode($var){if(!function_exists('json_encode')){$j=self::getJsonService();return$j->encode($var);}else return json_encode($var);}
  private static function getJsonService(){return new \Services_JSON();}
}
