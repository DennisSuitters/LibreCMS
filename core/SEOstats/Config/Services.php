<?php
namespace SEOstats\Config;
interface Services{
  const PROVIDER='["alexa","google","ose","semrush","mozscape","sistrix","social"]';
  const ALEXA_SITEINFO_URL='http://www.alexa.com/siteinfo/%s';
  const ALEXA_GRAPH_URL='http://traffic.alexa.com/graph?&o=f&c=1&y=%s&b=ffffff&n=666666&w=%s&h=%s&r=%sm&u=%s';
  const SISTRIX_VI_URL='http://www.sichtbarkeitsindex.de/%s';
  const SISTRIX_API_VI_URL='http://api.sistrix.net/domain.sichtbarkeitsindex?api_key=%s&domain=%s&country=%s&format=json';
  const SISTRIX_API_CREDITS_URL='http://api.sistrix.net/credits?api_key=%s&format=json';
  const SEMRUSH_BE_URL='http://%s.backend.semrush.com/?action=report&type=%s&domain=%s';
  const SEMRUSH_GRAPH_URL='http://semrush.com/archive/graphs.php?domain=%s&db=%s&type=%s&w=%s&h=%s&lc=%s&dc=%s&l=%s';
  const SEMRUSH_WIDGET_URL='http://widget.semrush.com/widget.php?action=report&type=%s&db=%s&domain=%s';
  const MOZSCAPE_API_URL='http://lsapi.seomoz.com/linkscape/url-metrics/%s?Cols=%s&AccessID=%s&Expires=%s&Signature=%s';
  const GOOGLE_APISEARCH_URL='http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=%s&q=%s';
  const GOOGLE_PAGESPEED_URL='https://www.googleapis.com/pagespeedonline/v1/runPagespeed?url=%s&key=%s';
  const GOOGLE_PLUSONE_URL='https://plusone.google.com/u/0/_/+1/fastbutton?count=true&url=%s';
  const OPENSITEEXPLORER_URL='http://www.opensiteexplorer.org/%s?group=0&page=%s&site=%s&sort=';
  const FB_LINKSTATS_URL='https://api.facebook.com/method/fql.query?query=%s&format=json';
  const TWEETCOUNT_URL='http://cdn.api.twitter.com/1/urls/count.json?url=%s';
  const DELICIOUS_INFO_URL='http://feeds.delicious.com/v2/json/urlinfo/data?url=%s';
  const DIGG_INFO_URL='http://widgets.digg.com/buttons/count?url=%s&cb=_';
  const LINKEDIN_INFO_URL='http://www.linkedin.com/countserv/count/share?url=%s&callback=_';
  const PINTEREST_INFO_URL='http://api.pinterest.com/v1/urls/count.json?url=%s&callback=_';
  const STUMBLEUPON_INFO_URL='http://www.stumbleupon.com/services/1.01/badge.getinfo?url=%s';
  const VKONTAKTE_INFO_URL='http://vk.com/share.php?act=count&index=1&url=%s';
  const XING_SHAREBUTTON_URL='https://www.xing-share.com/app/share?op=get_share_button;counter=top;url=%s';
}
