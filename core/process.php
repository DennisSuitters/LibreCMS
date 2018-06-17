<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
require 'core' . DS . 'db.php';
$config = $this -> getconfig($db);
$theme = parse_ini_file(THEME . DS . 'theme.ini', TRUE);
$ti = time();
$show = '';
$html = '';
$head = '';
$content = '';
$foot = '';
$css = THEME . DS . 'css' . DS;
$favicon = FAVICON;
$shareImage = FAVICON;
$noimage = NOIMAGE;
$noavatar = NOAVATAR;
if ($view == 'page') {
  $sp = $db -> prepare("SELECT * FROM menu WHERE contentType=:contentType AND LOWER(title)=LOWER(:title)");
  $sp -> execute(
    array(
      ':contentType' => $view,
      ':title'       => str_replace('-', ' ', $args[0])
    )
  );
} else {
  $sp = $db -> prepare("SELECT * FROM menu WHERE contentType=:contentType");
  $sp -> execute(array(':contentType' => $view));
}
$page = $sp -> fetch(PDO::FETCH_ASSOC);
$pu = $db -> prepare("UPDATE menu SET views=views+1 WHERE id=:id");
$pu -> execute(array(':id' => $page['id']));
if (isset($act) && $act == 'logout')
  require 'core' . DS . 'login.php';
require 'core' . DS . 'cart_quantity.php';
if (isset($_SESSON['rank']) && $_SESSION['rank'] > 699)
  $status = "%";
else
  $status = "published";
$content = '';
if ($config['maintenance']{0} == 1 && (isset($_SESSION['rank']) && $_SESSION['rank'] < 400)) {
  if (file_exists(THEME . DS . 'maintenance.html'))
    $template = file_get_contents(THEME . DS . 'maintenance.html');
  else {
  	require 'core' . DS . 'layout' . DS . 'maintenance.php';
    die();
  }
} elseif(file_exists(THEME . DS . $view . '.html'))
  $template = file_get_contents(THEME . DS . $view . '.html');
elseif (file_exists(THEME . DS . 'default.html'))
  $template = file_get_contents(THEME . DS . 'default.html');
else
  $template = file_get_contents(THEME . DS . 'content.html');
$newDom = new DOMDocument();
@$newDom -> loadHTML($template);
$tag = $newDom -> getElementsByTagName('block');
foreach ($tag as $tag1){
  $include = $tag1 -> getAttribute('include');
  $inbed = $tag1 -> getAttribute('inbed');
  if ($include != '') {
    $include = rtrim($include, '.html');
    if (file_exists(THEME . DS . $include . '.html'))
      $html = file_get_contents(THEME . DS . $include . '.html');
    else
      $html = '';
    if (file_exists(THEME . 'view' . DS . $include . '.php'))
      require THEME . 'view' . DS . $include . '.php';
    elseif (file_exists('core' . DS . 'view' . DS . $include . '.php'))
      require 'core' . DS . 'view' . DS . $include . '.php';
    else
      require 'core' . DS . 'view' . DS . 'content.php';
    $req = $include;
  }
  if ($inbed != '') {
    preg_match('/<block inbed="' . $inbed . '">([\w\W]*?)<\/block>/', $template, $matches);
    $html = isset($matches[1]) ? $matches[1] : '';
    if ($view == 'cart')
      $inbed = 'cart';
    if ($view == 'sitemap')
      $inbed = 'sitemap';
    if ($view == 'settings')
      $inbed = 'settings';
    if ($view == 'page')
      $inbed = 'page';
    if (file_exists(THEME . 'view' . DS . $inbed . '.php'))
      require THEME . 'view' . DS . $inbed . '.php';
    elseif (file_exists('core' . DS . 'view' . DS . $inbed . '.php'))
      require 'core' . DS . 'view' . DS . $inbed . '.php';
    else
      require 'core' . DS . 'view' . DS . 'content.php';
    $req = $inbed;
  }
}
if (!isset($metaRobots))
  $metaRobots = empty($page['metaRobots']) ? 'index,follow' : $page['metaRobots'];
$seoTitle = empty($page['seoTitle']) ? $config['seoTitle'] : $page['seoTitle'];
if (!isset($seoCaption) || $seoCaption == '')
  $seoCaption = empty($page['seoCaption']) ? $config['seoCaption'] : $page['seoCaption'];
if (!isset($seoDescription) || $seoDescription == '')
  $seoDescription = empty($page['seoDescription']) ? $config['seoDescription'] : $page['seoDescription'];
if (isset($args[1]) && $args[1] != '' && isset($r['seoKeywords']))
  $seoKeywords = $r['seoKeywords'];
elseif (!isset($seoKeywords) || $seoKeywords == '')
  $seoKeywords = empty($page['seoKeywords']) ? $config['seoKeywords'] : $page['seoKeywords'];
if (!isset($contentTime)) {
  if ($page['eti'] > $config['ti'])
    $contentTime = $page['eti'];
  else
    $contentTime = $config['ti'];
}
if (!isset($canonical) || $canonical == '') {
  if ($view == 'index')
    $canonical = URL;
  else
    $canonical = URL . $view . '/';
}
$head = preg_replace(
  array(
    '/<print meta=[\"\']?metaRobots[\"\']?>/',
    '/<print meta=[\"\']?seoTitle[\"\']?>/',
    '/<print meta=[\"\']?seoCaption[\"\']?>/',
    '/<print meta=[\"\']?seoKeywords[\"\']?>/',
    '/<print meta=[\"\']?dateAtom[\"\']?>/',
    '/<print meta=[\"\']?canonical[\"\']?>/',
    '/<print meta=[\"\']?url[\"\']?>/',
    '/<print meta=[\"\']?view[\"\']?>/',
    '/<print meta=[\"\']?rss[\"\']?>/',
    '/<print meta=[\"\']?ogType[\"\']?>/',
    '/<print meta=[\"\']?shareImage[\"\']?>/',
    '/<print meta=[\"\']?favicon[\"\']?>/',
    '/<print microid>/',
    '/<print meta=[\"\']?author[\"\']?>/',
    '/<print theme>/',
    '/<print google_verification>/',
    '/<!-- Google Analytics -->/'
  ),
  array(
    (empty($metaRobots) ? 'index,follow' : $page['metaRobots']),
    (empty($seoTitle) ? ucfirst($view) . ' - ' . $config['seoTitle'] : $page['seoTitle'] . ' - ' . $config['seoTitle']) . ' - ' . $config['business'],
    (empty($seoDescription) ? $seoDescription : $seoCaption),
    $seoKeywords,
    $contentTime,
    $canonical,
    URL,
    $view,
    URL . 'rss/' . (($args[0] != '') || ($args[0] != 'index') || ($args[0] != 'bookings') || ($args[0] != 'contactus') || ($args[0] != 'cart') || ($args[0] != 'proofs') || ($args[0] != 'settings') || ($args[0] != 'accounts')) ? '' : $view,
    ($view == 'inventory' ? 'product' : $view),
    $shareImage,
    FAVICON,
    microid($config['email'], $canonical),
    (isset($r['name']) ? $r['name'] : $config['business']),
    THEME,
    $config['ga_verification'],
    (isset($config['ga_tracking']) ? '<script>/*<![CDATA[*/' . htmlspecialchars_decode($config['ga_tracking'], ENT_QUOTES) . '/*]]>*/</script>' : '')
  ),
  $head
);
if (isset($_SESSION['rank']) && $_SESSION['rank'] > 899 && $config['development'] == 1) {
  $content .= '<div style="text-align:right;padding:10px;">Page Views: ' . $page['views'] . ' | Memory Used: ' . size_format(memory_get_usage()) . ' | Process Time: ' . elapsed_time() . '</div>';
}
if (MINIFY == 1)
  print minify($head . $content);
else
  print $head . $content;
$current_page = PROTOCOL . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if ($config['maintenance'] == 0 || $config['development'] == 0) {
  if (!isset($_SESSION['current_page']) || (isset($_SESSION['current_page']) && $_SESSION['current_page'] != $current_page)) {
    if (!stristr($current_page, 'core') || !stristr($current_page, 'admin')) {
      $s = $db -> prepare("INSERT INTO tracker (pid,urlDest,urlFrom,userAgent,ip,browser,os,sid,ti) VALUES (:pid,:urlDest,:urlFrom,:userAgent,:ip,:browser,:os,:sid,:ti)");
      $hr = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
      $s -> execute(
        array(
          ':pid'       => isset($page['id']) ? $page['id'] : 0,
          ':urlDest'   => $current_page,
          ':urlFrom'   => $hr,
          ':userAgent' => $_SERVER['HTTP_USER_AGENT'],
          ':ip'        => $_SERVER["REMOTE_ADDR"],
          ':browser'   => getBrowser(),
          ':os'        => getOS(),
          ':sid'       => session_id(),
          ':ti'        => time()
        )
      );
      $_SESSION['current_page'] = $current_page;
    }
  }
}
function getOS () {
  $user_agent = $_SERVER['HTTP_USER_AGENT'];
  $os_platform = "Unknown OS Platform";
  $os_array = array(
    '/windows nt 10|windows nt 6.3|windows nt 6.2|windows nt 6.1|windows nt 6.0|windows nt 5.2|windows nt 5.1|windows xp|windows nt 5.0|windows me|win98|win95|win16/i'=>'Windows',
    '/macintosh|mac os x|mac_powerpc/i'=>'Mac',
    '/linux/i'      => 'Linux',
    '/ubuntu/i'     => 'Ubuntu',
    '/iphone/i'     => 'iPhone',
    '/ipod/i'       => 'iPod',
    '/ipad/i'       => 'iPad',
    '/android/i'    => 'Android',
    '/blackberry/i' => 'BlackBerry',
    '/webos/i'      => 'Mobile'
  );
  foreach ($os_array as $regex => $value) {
    if (preg_match($regex, $user_agent)) $os_platform = $value;
  }
  return $os_platform;
}
function getBrowser () {
  $user_agent = $_SERVER['HTTP_USER_AGENT'];
  $browser = "Unknown Browser";
  $browser_array = array(
    '/msie/i'        => 'Explorer',
    '/firefox/i'     => 'Firefox',
    '/safari/i'      => 'Safari',
    '/chrome/i'      => 'Chrome',
    '/edge/i'        => 'Edge',
    '/opera/i'       => 'Opera',
    '/netscape/i'    => 'Netscape',
    '/maxthon/i'     => 'Maxthon',
    '/konqueror/i'   => 'Konqueror',
    '/mobile/i'      => 'Mobile',
    '/bingbot/i'     => 'Bing',
    '/duckduckbot/i' => 'DuckDuckGo',
    '/googlebot/i'   => 'Google',
    '/msnbot/i'      => 'MSN',
    '/slurp/i'       => 'Inktomi',
    '/yahoo/i'       => 'Yahoo',
    '/askjeeves/i'   => 'AskJeeves',
    '/fastcrawler/i' => 'FastCrawler',
    '/infoseek/i'    => 'InfoSeek',
    '/lycos/i'       => 'Lycos',
    '/yandex/i'      => 'Yandex',
    '/geohasher/i'   => 'GeoHasher',
    '/gigablast/i'   => 'Gigablast',
    '/baidu/i'       => 'Baiduspider',
    '/spinn3r/i'     => 'Spinn3r',
    '/sogou/i'       => 'Sogou',
    '/Exabot/i'      => 'Exabot',
    '/facebook/i'    => 'Facebook',
    '/alexa/i'       => 'Alexa'
  );
  foreach ($browser_array as $regex => $value) {
    if (preg_match($regex, $user_agent)) $browser = $value;
  }
  return $browser;
}
