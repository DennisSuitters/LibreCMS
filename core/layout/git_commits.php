<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);
require_once'..'.DS.'db.php';
$cache_time=3600 * 24 * 7;
$cache_file='..'.DS.'..'.DS.'media'.DS.'cache'.DS.'commits.rss';
$timedif=@(time()-filemtime($cache_file));
if(file_exists($cache_file)&&$timedif<$cache_time)$string=file_get_contents($cache_file);
else{
  $string=get_json('repos/DiemenDesign/LibreCMS/commits');
  if($f=@fopen($cache_file,'w')){
    fwrite($f,$string,strlen($string));
    fclose($f);
  }
}
$commits=json_decode($string,true);
$i=0;
while($i<10){?>
<tr>
  <td class="hidden-xs">
    <img class="table-thumb" src="<?php echo$commits[$i]["author"]["avatar_url"];?>">
  </td>
  <td class="hidden-xs">
<?php $time=strtotime($commits[$i]["commit"]["committer"]["date"]);
echo date('M jS, Y g:i A',$time);?>
  </td>
  <td class="text-center hidden-xs">
    <a href="<?php echo$commits[$i]["author"]["html_url"];?>"><?php echo$commits[$i]["commit"]["committer"]["name"];?></a>
  </td>
  <td>
    <div class="visible-xs">
      <small>
        <a href="<?php echo$commits[$i]["author"]["html_url"];?>"><?php echo$commits[$i]["commit"]["committer"]["name"];?></a><br>
<?php $time=strtotime($commits[$i]["commit"]["committer"]["date"]);
echo date('M jS, Y g:i A',$time);?>
      </small>
    </div>
    <a href="<?php echo$commits[$i]["html_url"];?>"><?php echo$commits[$i]["commit"]["message"];?></a>
  </td>
</tr>
<?php $i++;
}
function get_json($url){
  $base="https://api.github.com/";
  $agent='Mozilla/5.0 (compatible;DiemenDesign/LibreCMS)';
  $curl=curl_init();
  curl_setopt($curl,CURLOPT_USERAGENT,$agent);
  curl_setopt($curl,CURLOPT_URL,$base.$url);
  curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
  $content=curl_exec($curl);
  curl_close($curl);
  return$content;
}
