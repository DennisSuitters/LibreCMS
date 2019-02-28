<?php
/**
 * LibreCMS - Copyright (C) Diemen Design 2019
 *
 * View - Profile Renderer
 *
 * profile.php version 2.0.0
 *
 * LICENSE: This source file may be modifired and distributed under the terms of
 * the MIT license that is available through the world-wide-web at the following
 * URI: http://opensource.org/licenses/MIT.  If you did not receive a copy of
 * the MIT License and are unable to obtain it through the web, please
 * check the root folder of the project for a copy.
 *
 * @category   Administration - View - Profile
 * @package    core/view/profile.php
 * @author     Dennis Suitters <dennis@diemen.design>
 * @copyright  2014-2019 Diemen Design
 * @license    http://opensource.org/licenses/MIT  MIT License
 * @version    2.0.0
 * @link       https://github.com/DiemenDesign/LibreCMS
 * @notes      This PHP Script is designed to be executed using PHP 7+
 */
$rank=0;
$notification='';
$theme=parse_ini_file(THEME.DS.'theme.ini',true);
if($args[0]!=''){
  $s=$db->prepare("SELECT * FROM `".$prefix."login` WHERE LOWER(name)=LOWER(:name)");
  $s->execute([':name'=>str_replace('-',' ',$args[0])]);
  $r=$s->fetch(PDO::FETCH_ASSOC);
  if($r['bio_options']{0}==1){
    if($r['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['avatar'])))
      $r['avatar']='media'.DS.'avatar'.DS.basename($r['avatar']);
    else
      $r['avatar']=NOAVATAR;
    $html=preg_replace([
      '/<profile>/',
      '/<\/profile>/',
      '~<profiles>.*?<\/profiles>~is'
    ],'',$html);
    $html=preg_replace([
      '/<print meta=[\"\']?seoTitle[\"\']?>/',
      '/<print meta=[\"\']?url[\"\']?>/',
      '/<print meta=[\"\']?favicon[\"\']?>/',
      '/<print theme>/',
      '/<print meta=[\"\']?canonical[\"\']?>/',
      '/<print user=[\"\']?name[\"\']?>/',
      '/<print user=[\"\']?image[\"\']?>/',
      '/<print userMenu>/',
      '/<print user=[\"\']?caption[\"\']?>/',
      '/<print user=[\"\']?notes[\"\']?>/',
      '/<print user=[\"\']?url[\"\']?>/',
      '/<print config=[\"\']?url[\"\']?>/',
      '/<print config=[\"\']?business[\"\']?>/',
      '/<print year>/',
      '/<profile>/',
      '/<\/proflie>/',
      '/<profiles>.*?<\/profiles>/'
    ],[
      htmlspecialchars($r['name'].' - Profile'.($config['business']!=''?' - '.$config['business']:''),ENT_QUOTES,'UTF-8'),
      URL,
      htmlspecialchars($r['avatar'],ENT_QUOTES,'UTF-8'),
      THEME,
      htmlspecialchars(URL.'profile/'.strtolower(str_replace(' ','-',$r['name'])),ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['avatar'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars(URL.'profile/'.strtolower(str_replace(' ','-',$r['name'])),ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['caption'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['notes'],ENT_QUOTES,'UTF-8'),
      htmlspecialchars($r['url'],ENT_QUOTES,'UTF-8'),
      URL,
      htmlspecialchars($config['business'],ENT_QUOTES,'UTF-8'),
      date('Y',time())
    ],$html);
    if(stristr($html,'<buildSocial')){
    	preg_match('/<buildSocial>([\w\W]*?)<\/buildSocial>/',$html,$matches);
    	$item=$matches[1];
    	$items='';
    	$sl=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='social' AND uid=:uid ORDER BY icon ASC");
      $sl->execute([':uid'=>$r['id']]);
    	if($sl->rowCount()>0){
    		while($rl=$sl->fetch(PDO::FETCH_ASSOC)){
    			$build=$item;
    			$build=str_replace([
  					'<print sociallink>',
  					'<print socialicon>'
  				],[
  					htmlspecialchars($rl['url'],ENT_QUOTES,'UTF-8'),
  					frontsvg('libre-social-'.$rl['icon'])
  				],$build);
  			$items.=$build;
    		}
    	}else
        $items='';
    	$html=preg_replace('~<buildSocial>.*?<\/buildSocial>~is',$items,$html,1);
    }
    if(stristr($html,'<skills')){
      preg_match('/<skills>([\w\W]*?)<\/skills>/',$html,$matches);
      $skills=$matches[1];
      preg_match('/<item>([\w\W]*?)<\/item>/',$skills,$matches);
      $item=$matches[1];
      $items='';
      $ss=$db->prepare("SELECT * FROM `".$prefix."choices` WHERE contentType='bio_skills' AND uid=:uid ORDER BY title ASC");
      $ss->execute([':uid'=>$r['id']]);
      if($ss->rowCount()>0){
        while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
          $build=$item;
          $build=preg_replace([
            '/<print skill=[\"\']?title[\"\']?>/',
            '/<print skill=[\"\']?value[\"\']?>/'
          ],[
            htmlspecialchars($rs['title'],ENT_QUOTES,'UTF-8'),
            htmlspecialchars($rs['value'],ENT_QUOTES,'UTF-8')
          ],$build);
          $items.=$build;
        }
      }else
        $skills='';
      $skills=preg_replace('~<item>.*?<\/item>~is',$items,$skills,1);
      $html=preg_replace('~<skills>.*?<\/skills>~is',$skills,$html,1);
    }
    if(stristr($html,'<testimonials')){
      preg_match('/<testimonials>([\w\W]*?)<\/testimonials>/',$html,$matches);
      $testimonials=$matches[1];
      preg_match('/<item>([\w\W]*?)<\/item>/',$testimonials,$matches);
      $item=$matches[1];
      $items='';
      $ss=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType='testimonials' AND cid=:cid ORDER BY ti DESC");
      $ss->execute([':cid'=>$r['id']]);
      if($ss->rowCount()>0){
        while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
          if($rs['file']!=''&&file_exists('media'.DS.basename($rs['file'])))
            $rs['file']='media'.DS.basename($rs['file']);
          elseif($rs['file']=='')
            $rs['file']=NOAVATAR;
          $build=$item;
          $build=preg_replace([
            '/<print content=[\"\']?file[\"\']?>/',
            '/<print content=[\"\']?name[\"\']?>/',
            '/<print content=[\"\']?notes[\"\']?>/'
          ],[
            htmlspecialchars($rs['file'],ENT_QUOTES,'UTF-8'),
            htmlspecialchars($rs['name'],ENT_QUOTES,'UTF-8'),
            $rs['notes']
          ],$build);
          $items.=$build;
        }
      }else
        $testimonials='';;
      $testimonials=preg_replace('~<item>.*?<\/item>~is',$items,$testimonials,1);
      $html=preg_replace('~<testimonials>.*?<\/testimonials>~is',$testimonials,$html,1);
    }
    if(stristr($html,'<services')){
      preg_match('/<services>([\w\W]*?)<\/services>/',$html,$matches);
      $services=$matches[1];
      preg_match('/<item>([\w\W]*?)<\/item>/',$services,$matches);
      $item=$matches[1];
      $items='';
      $ss=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType='service' AND cid=:cid ORDER BY ti DESC");
      $ss->execute([':cid'=>$r['id']]);
      if($ss->rowCount()>0){
        while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
          $build=$item;
          $build=preg_replace([
            '/<print content=[\"\']?file[\"\']?>/',
            '/<print content=[\"\']?title[\"\']?>/',
            '/<print content=[\"\']?notes[\"\']?>/'
          ],[
            htmlspecialchars($rs['fileURL'],ENT_QUOTES,'UTF-8'),
            htmlspecialchars($rs['title'],ENT_QUOTES,'UTF-8'),
            $rs['notes']
          ],$build);
          $items.=$build;
        }
      }else
        $services='';;
      $services=preg_replace('~<item>.*?<\/item>~is',$items,$services,1);
      $html=preg_replace('~<services>.*?<\/services>~is',$services,$html,1);
    }
    if(stristr($html,'<resume')){
      preg_match('/<resume>([\w\W]*?)<\/resume>/',$html,$matches);
      $resume=$matches[1];
      if(stristr($resume,'<career')&&$r['bio_options']{2}==1){
        preg_match('/<career>([\w\W]*?)<\/career>/',$resume,$matches);
        $career=$matches[1];
        preg_match('/<item>([\w\W]*?)<\/item>/',$career,$matches);
        $item=$matches[1];
        $items='';
        $ss=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType='career' AND cid=:cid ORDER BY tis ASC");
        $ss->execute([':cid'=>$r['id']]);
        if($ss->rowCount()>0){
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
            $build=$item;
            if(stristr($build,'<print icon')){
              preg_match('/<print icon=[\"\']?([\w\W]*?)[\"\']?>/',$build,$matches);
              $icon=$matches[1];
            }else
              $icon='';
            $build=preg_replace([
              '/<print icon=[\"\']?([\w\W]*?)[\"\']?>/',
              '/<print career=[\"\']?title[\"\']?>/',
              '/<print career=[\"\']?business[\"\']?>/',
              '/<print career=[\"\']?tis[\"\']?>/',
              '/<print career=[\"\']?tie[\"\']?>/',
              '/<print career=[\"\']?notes[\"\']?>/'
            ],[
              $icon==''?'':frontsvg($icon),
              htmlspecialchars($rs['title'],ENT_QUOTES,'UTF-8'),
              htmlspecialchars($rs['business'],ENT_QUOTES,'UTF-8'),
              $rs['tis']!=0?' / '.date('Y-M',$rs['tis']):' / Current',
              $rs['tie']!=0?' - '.date("Y-M",$rs['tie']):$rs['tis']==0?'':' - Current',
              $rs['notes']
            ],$build);
            $items.=$build;
          }
        }else
          $items='';
        $career=preg_replace('~<item>.*?<\/item>~is',$items,$career,1);
      }else
        $career='';
      if(stristr($resume,'<education')&&$r['bio_options']{3}==1){
        preg_match('/<education>([\w\W]*?)<\/education>/',$resume,$matches);
        $education=$matches[1];
        preg_match('/<item>([\w\W]*?)<\/item>/',$education,$matches);
        $item=$matches[1];
        $items='';
        $ss=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType='education' AND cid=:cid ORDER BY tis ASC");
        $ss->execute([':cid'=>$r['id']]);
        if($ss->rowCount()>0){
          while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
            $build=$item;
            if(stristr($build,'<print icon')){
              preg_match('/<print icon=[\"\']?([\w\W]*?)[\"\']?>/',$build,$matches);
              $icon=$matches[1];
            }else
              $icon='';
            $build=preg_replace([
              '/<print icon=[\"\']?([\w\W]*?)[\"\']?>/',
              '/<print education=[\"\']?title[\"\']?>/',
              '/<print education=[\"\']?institute[\"\']?>/',
              '/<print education=[\"\']?tis[\"\']?>/',
              '/<print education=[\"\']?tie[\"\']?>/',
              '/<print education=[\"\']?notes[\"\']?>/'
            ],[
              $icon==''?'':frontsvg($icon),
              htmlspecialchars($rs['title'],ENT_QUOTES,'UTF-8'),
              htmlspecialchars($rs['business'],ENT_QUOTES,'UTF-8'),
              $rs['tis']!=0?' / '.date('Y-M',$rs['tis']):' / Current',
              $rs['tie']!=0?' - '.date("Y-M",$rs['tie']):$rs['tis']==0?'':' - Current',
              $rs['notes']
            ],$build);
            $items.=$build;
          }
        }else
          $items='';
        $education=preg_replace('~<item>.*?<\/item>~is',$items,$education,1);
      }else
        $education='';
      if($career!=''||$education!=''){
        $html=preg_replace([
          '/<print resume=[\"\']?notes[\"\']?>/',
          '~<career>.*?<\/career>~is',
          '~<education>.*?<\/education>~is',
          '~<resumeMenu>~is',
          '~<\/resumeMenu>~is',
          '~<resume>.*?<\/resume>~'
        ],[
          htmlspecialchars($r['resume_notes'],ENT_QUOTES,'UTF-8'),
          $career,
          $education,
          '',
          '',
          $resume
        ],$html,1);
      }
    }else{
      $html=preg_replace([
          '~<resume>.*?<\/resume>~is',
          '~<resumeMenu>.*?<\/resumeMenu>~is'
        ],'',$html,1);
    }
    if(stristr($html,'<content')){
      preg_match('/<content>([\w\W]*?)<\/content>/',$html,$matches);
      $profilecontent=$matches[1];
      preg_match('/<item>([\w\W]*?)<\/item>/',$profilecontent,$matches);
      $item=$matches[1];
      $items='';
      $ss=$db->prepare("SELECT * FROM `".$prefix."content` WHERE contentType='article' AND uid=:uid AND status='published' ORDER BY ti DESC LIMIT 5");
      $ss->execute([':uid'=>$r['id']]);
      if($ss->rowCount()>0){
        while($rs=$ss->fetch(PDO::FETCH_ASSOC)){
          $build=$item;
          $build=preg_replace([
            '/<print content=[\"\']?image[\"\']?>/',
            '/<print content=[\"\']?title[\"\']?>/',
            '/<print content=[\"\']?notes[\"\']?>/',
            '/<print content=[\"\']?link[\"\']?>/'
          ],[
            htmlspecialchars($rs['fileURL'],ENT_QUOTES,'UTF-8'),
            htmlspecialchars($rs['title'],ENT_QUOTES,'UTF-8'),
            htmlspecialchars(strip_tags(substr($rs['notes'], 0, strrpos(substr($rs['notes'], 0, 400), ' '))),ENT_QUOTES,'UTF-8'),
            htmlspecialchars(URL.'article/'.strtolower(str_replace(' ','-',$rs['title'])),ENT_QUOTES,'UTF-8')
          ],$build);
          $items.=$build;
        }
      }else
        $items='';
      $profilecontent=preg_replace('~<item>.*?<\/item>~is',$items,$profilecontent,1);
      $html=preg_replace([
        '~<content>.*?<\/content>~is',
        '~<contentMenu>~is',
        '~<\/contentMenu>~is',
      ],[
        $profilecontent,
        '',
        ''
      ],$html,1);
    }else{
      $html=preg_replace([
        '~<content>.*?<\/content>~is',
        '~<contentMenu>.*?<\/contentMenu>~is'
      ],'',$html,1);
    }
    if(stristr($html,'<contact')&&$r['bio_options']{1}==1){
      preg_match('/<contact>([\w\W]*?)<\/contact>/',$html,$matches);
      $contact=$matches[1];
      $contact=preg_replace([
        '/<print contact=[\"\']?phone[\"\']?>/',
        '/<print contact=[\"\']?mobile[\"\']?>/',
        '/<print contact=[\"\']?email[\"\']?>/',
        '/<print contact=[\"\']?address[\"\']?>/',
        '/<print contact=[\"\']?suburb[\"\']?>/',
        '/<print contact=[\"\']?state[\"\']?>/',
        '/<print contact=[\"\']?country[\"\']?>/',
        '/<print contact=[\"\']?postcode[\"\']?>/',
        '/<print contact=[\"\']?url[\"\']?>/'
      ],[
        htmlspecialchars($r['phone'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['mobile'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['email'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['address'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['suburb'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['state'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['country'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['postcode'],ENT_QUOTES,'UTF-8'),
        htmlspecialchars($r['url'],ENT_QUOTES,'UTF-8')
      ],$contact);
      $html=preg_replace('~<contact>.*?<\/contact>~is',$contact,$html,1);
    }else{
      $html=preg_replace([
          '~<contact>.*?<\/contact>~is',
          '~<contactMenu>.*?<\/contactMenu>~is'
        ],'',$html,1);
    }
    $items=$html;
    //include'core'.DS.'parser.php';
    $html=$items;
    $doc=new DOMDocument();
    @$doc->loadHTML($html);
    $svgs=$doc->getElementsByTagName('icon');
    foreach($svgs as $svg){
      $icon=$svg->getAttribute('svg');
      $html=preg_replace('/<icon svg=[\"\']?'.$icon.'[\"\']?>/',frontsvg($icon),$html,1);
    }
    $seoTitle=empty($r['seoTitle'])?trim(htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8')):htmlspecialchars($r['seoTitle'],ENT_QUOTES,'UTF-8');
    $metaRobots=!empty($r['metaRobots'])?htmlspecialchars($r['metaRobots'],ENT_QUOTES,'UTF-8'):'index,follow';
    $seoCaption=!empty($r['seoCaption'])?htmlspecialchars($r['seoCaption'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoCaption'],ENT_QUOTES,'UTF-8');
    $seoCaption=empty($seoCaption)?htmlspecialchars($config['seoCaption'],ENT_QUOTES,'UTF-8'):$seoCaption;
    $seoDescription=!empty($r['seoDescription'])?htmlspecialchars($r['seoDescription'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoDescription'],ENT_QUOTES,'UTF-8');
    $seoDescription=empty($seoDescrption)?htmlspecialchars($config['seoDescription'],ENT_QUOTES,'UTF-8'):$seoDescription;
    $seoKeywords=!empty($r['seoKeywods'])?htmlspecialchars($r['seoKeywords'],ENT_QUOTES,'UTF-8'):htmlspecialchars($page['seoKeywords'],ENT_QUOTES,'UTF-8');
    $seoKeywords=empty($seoKeywords)?htmlspecialchars($config['seoKeywords'],ENT_QUOTES,'UTF-8'):$seoKeywords;
    $content.=$html;
  }
}else{
  $html=preg_replace([
    '/<profiles>/',
    '/<\/profiles>/',
    '~<profile>.*?<\/profile>~is',
    '/<print meta=[\"\']?seoTitle[\"\']?>/',
    '/<print meta=[\"\']?url[\"\']?>/',
    '/<print meta=[\"\']?favicon[\"\']?>/',
    '/<print theme>/',
    '/<print meta=[\"\']?canonical[\"\']?>/'
  ],[
    '',
    '',
    '',
    htmlspecialchars('Profiles'.($config['business']!=''?' - '.$config['business']:''),ENT_QUOTES,'UTF-8'),
    URL,
    FAVICON,
    THEME,
    URL.'profile'
  ],$html);
  $s=$db->prepare("SELECT * FROM login WHERE bio_options LIKE '1%' ORDER BY name ASC");
  $s->execute();
  if($s->rowCount()>0){
    if(stristr($html,'<items')){
      preg_match('/<items>([\w\W]*?)<\/items>/',$html,$matches);
      $item=$matches[1];
      $items='';
      while($r=$s->fetch(PDO::FETCH_ASSOC)){
        if($r['avatar']!=''&&file_exists('media'.DS.'avatar'.DS.basename($r['avatar'])))
          $r['avatar']='media'.DS.'avatar'.DS.basename($r['avatar']);
        elseif($r['gravatar']!='')
          $r['avatar']=$r['gravatar'];
        else
          $r['avatar']=NOAVATAR;
        $build=$item;
        $build=preg_replace([
          '/<print user=[\"\']?link[\"\']?>/',
          '/<print user=[\"\']?name[\"\']?>/',
          '/<print user=[\"\']?image[\"\']?>/',
          '/<print user=[\"\']?caption[\"\']?>/'
        ],[
          htmlspecialchars(URL.'profile/'.str_replace(' ','-',$r['name']),ENT_QUOTES,'UTF-8'),
          htmlspecialchars($r['name'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($r['avatar'],ENT_QUOTES,'UTF-8'),
          htmlspecialchars($r['caption'],ENT_QUOTES,'UTF-8')
        ],$build);
        $items.=$build;
      }
    }else
      $items='';
    $html=preg_replace('~<items>.*?<\/items>~is',$items,$html,1);
  }
  $content.=$html;
}
