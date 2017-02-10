<?php
namespace SEOstats\Helper;
class Url{
  public static function parseHost($url){$url=@parse_url('http://'.preg_replace('#^https?://#','',$url));return(isset($url['host'])&&!empty($url['host']))?$url['host']:false;}
  public static function isRfc($url){if(isset($url)&&1<strlen($url)){$host=self::parseHost($url);$scheme=strtolower(parse_url($url,PHP_URL_SCHEME));if(false!==$host&&($scheme=='http'||$scheme=='https')){$pattern='([A-Za-z][A-Za-z0-9+.-]{1,120}:[A-Za-z0-9/](([A-Za-z0-9$_.+!*,;/?:@&~=-])|%[A-Fa-f0-9]{2}){1,333}(#([a-zA-Z0-9][a-zA-Z0-9$_.+!*,;/?:@&~=%-]{0,1000}))?)';return(bool)preg_match($pattern,$url);}}return false;}
}
