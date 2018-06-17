<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if (isset($_SESSION['rank']) && $_SESSION['rank'] > 0) {
	$su = $db -> prepare("SELECT avatar,gravatar FROM login WHERE id=:uid");
	$su -> execute(
		array(
			':uid' => $_SESSION['uid']
		)
	);
	$user = $su -> fetch(PDO::FETCH_ASSOC);
	if ($view == 'proofs' || $view == 'proof')
		$html = preg_replace('/<print active=[\"\']?proofs[\"\']?>/', ' class="active"', $html);
	else
		$html = preg_replace('/<print active=[\"\']?proofs[\"\']?>/', '', $html);
	if ($view == 'orders' || $view == 'order')
		$html = preg_replace('/<print active=[\"\']?orders[\"\']?>/', ' class="active"', $html);
	else
		$html = preg_replace('/<print active=[\"\']?orders[\"\']?>/', '', $html);
	if ($view == 'settings')
		$html = preg_replace('/<print active=[\"\']?settings[\"\']?>/', ' class="active"', $html);
	else
		$html = preg_replace('/<print active=[\"\']?settings[\"\']?>/', '', $html);
	if (preg_match('/<print user=[\"\']?avatar[\"\']?>/' ,$html)) {
		if (isset($user) && $user['avatar'] != '' && file_exists('media' . DS . 'avatar' . DS . $user['avatar'])) {
			$html = preg_replace('/<print user=[\"\']?avatar[\"\']?>/', 'media' . DS . 'avatar' . DS . $user['avatar'], $html);
		} elseif (isset($user) && $user['gravatar'] != '') {
			if (stristr('@', $user['gravatar']))
				$html = preg_replace('/<print user=[\"\']?avatar[\"\']?>/', 'http://gravatar.com/avatar/' . md5($user['gravatar']), $html);
			elseif (stristr('gravatar.com/avatar/'))
				$html = preg_replace('/<print user=[\"\']?avatar[\"\']?>/', $user['gravatar'], $html);
			else
				$html = preg_replace('/<print user=[\"\']?avatar[\"\']?>/', $noavatar, $html);
		} else
			$html = preg_replace('/<print user=[\"\']?avatar[\"\']?>/', $noavatar, $html);
	}
	$html = str_replace(
		array(
			'<accountmenu>',
			'</accountmenu>'
		),
		'',
		$html
	);
} else
	$html = preg_replace('~<accountmenu>.*?<\/accountmenu>~is', '', $html, 1);
$html = preg_replace(
	array(
		'/<print config=[\"\']?seoTitle[\"\']?>/',
		'/<print meta=[\"\']?url[\"\']?>/'
	),
	array(
		$config['seoTitle'],
		URL
	),
	$html
);
if (stristr($html, '<buildMenu')) {
//	preg_match('/<buildMenu>([\w\W]*?)<\/buildMenu>/',$html,$matches);
	$htmlMenu = '';
	$s = $db -> query("SELECT * FROM menu WHERE menu='head' AND mid=0 AND active=1 ORDER BY ord ASC");
	while ($r = $s -> fetch(PDO::FETCH_ASSOC)){
		$sm = $db -> prepare("SELECT * FROM menu WHERE mid=:mid AND active=1 ORDER BY ord ASC");
		$sm -> execute(
			array(
				':mid' => $r['id']
			)
		);
		$smc = $sm -> rowCount();
		$sc = $db -> prepare("SELECT DISTINCT(category_1) AS category_1 FROM content WHERE contentType=:contentType AND category_1!='' AND status='published' ORDER BY category_1 ASC");
		$sc -> execute(
			array(
				':contentType' => $r['contentType']
			)
		);
		$scc = $sc -> rowCount();
		$htmlMenu .= '<li class="';
		if ($smc > 0 || $scc > 0)
			$htmlMenu .= 'dropdown';
		if ($r['contentType'] == $view)
			$htmlMenu .= ' active';
		$htmlMenu .= '" role="listitem">';
		$htmlMenu .= '<a href="';
		if ($r['contentType'] != 'index') {
			if (isset($r['url'][0]) && $r['url'][0] == '#')
				$htmlMenu .= URL . $r['url'];
			elseif (isset($r['url']) && filter_var($r['url'], FILTER_VALIDATE_URL))
				$htmlMenu .= $r['url'];
			else {
				$htmlMenu .= URL . $r['contentType'];
				if (!in_array(
					$r['contentType'],
					array(
						'aboutus',
						'article',
						'bookings',
						'cart',
						'contactus',
						'distributors',
						'events',
						'gallery',
						'inventory',
						'news',
						'newsletters',
						'portfolio',
						'proofs',
						'search',
						'service',
						'testimonials',
						'tos'
					),
					true)
				) $htmlMenu .= '/' . str_replace(' ', '-', strtolower($r['title']));
			}
			$htmlMenu .= '" rel="' . $r['contentType'] . '"';
		} else
			$htmlMenu .= URL . '" rel="home"';
		$htmlMenu .= '>' . $r['title'].'</a>';
		if ($smc != 0 || $scc != 0) {
			$htmlMenu .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="caret"></i><span class="sr-only">Toggle dropdown menu</span><span class="toggle drop down"></span></a>';
			$htmlMenu .= '<ul class="dropdown-menu pull-right">';
			if ($smc != 0) {
				while ($rm = $sm -> fetch(PDO::FETCH_ASSOC)) {
					$htmlMenu .= '<li><a href="';
					if ($rm['contentType'] != 'index') {
						if (isset($rm['url'][0]) && $rm['url'][0] == '#')
							$htmlMenu .= URL . $rm['url'];
						elseif (isset($rm['url']) && filter_var($rm['url'], FILTER_VALIDATE_URL))
							$htmlMenu .= $rm['url'];
						else
							$htmlMenu .= URL . strtolower($rm['contentType']);
						if ($rm['contentType'] == 'page')
							$htmlMenu .= '/' . str_replace(' ', '-', strtolower($rm['title']));
						$htmlMenu .= '" rel="' . $rm['contentType'] . '"';
					} else
						$htmlMenu .= URL . '" rel="home"';
					$htmlMenu .= ' role="link" rel="' . $rm['contentType'] . '">' . $rm['title'] . '</a></li>';
				}
			}
			if ($scc != 0) {
				if ($smc != 0)
					$htmlMenu .= '<li class="divider"></li>';
				$htmlMenu .= '<li class="dropdown-header">Categories</li>';
				while ($rc = $sc -> fetch(PDO::FETCH_ASSOC)) {
					$htmlMenu .= '<li><a href="' . strtolower($r['contentType']) . '/' . str_replace(' ', '-', strtolower($rc['category_1'])) . '" role="link" rel="' . $r['contentType'] . '">' . $rc['category_1'] . '</a></li>';
				}
			}
			$htmlMenu .= '</ul>';
		}
		$htmlMenu .= '</li>';
	}
	$html = preg_replace('~<buildMenu>.*?<\/buildMenu>~is', $htmlMenu, $html, 1);
}
if (stristr($html, '<buildSocial')) {
	preg_match('/<buildSocial>([\w\W]*?)<\/buildSocial>/', $html, $matches);
	$htmlSocial = $matches[1];
	$socialItems = '';
	$s = $db -> query("SELECT * FROM choices WHERE contentType='social' AND uid=0 ORDER BY icon ASC");
	if ($s -> rowCount() > 0) {
		while ($r = $s -> fetch(PDO::FETCH_ASSOC)) {
			$buildSocial = $htmlSocial;
			$buildSocial = str_replace('<print sociallink>', $r['url'], $buildSocial);
			$buildSocial = str_replace('<print socialicon>', frontsvg('social-' . $r['icon']), $buildSocial);
			$socialItems .= $buildSocial;
		}
	} else
		$socialItems = '';
	$html = preg_replace('~<buildSocial>.*?<\/buildSocial>~is', $socialItems, $html, 1);
	if ($config['options']{9} == 1) {
		$html = str_replace(
			array(
				'<rss>',
				'</rss>'
			),
			'',
			$html
		);
		if ($page['contentType'] == 'article' || $page['contentType'] == 'portfolio' || $page['contentType'] == 'event' || $page['contentType'] == 'news' || $page['contentType'] == 'inventory' || $page['contentType'] == 'service')
			$html = str_replace('<print rsslink>', 'rss/' . $page['contentType'], $html);
		else
			$html = str_replace('<print rsslink>', 'rss', $html);
		$html = str_replace('<print rssicon>', frontsvg('social-rss'), $html);
	} else
		$html = preg_replace('~<rss>.*?<\/rss>~is', '', $html, 1);
}
if (isset($_GET['activate']) && $_GET['activate'] != '') {
	$activate = filter_input(INPUT_GET, 'activate', FILTER_SANITIZE_STRING);
	$sa = $db -> prepare("UPDATE login SET active='1',activate='',rank='100' WHERE activate=:activate");
	$sa -> execute(
		array(
			':activate' => $activate
		)
	);
	if ($sa -> rowCount() > 0)
		$html = str_replace('<activation>', '<div class="alert alert-success">Your Account is now Active!</div>', $html);
	else
		$html = str_replace('<activation>', '<div class="alert alert-danger">There was an Issue Activating your Account!</div>', $html);
} else
	$html = str_replace('<activation>', '', $html);
if ($config['postcode'] == 0) $config['postcode'] = '';
$html = preg_replace(
	array(
		'/<print config=[\"\']?business[\"\']?>/',
		'/<print config=[\"\']?address[\"\']?>/',
		'/<print config=[\"\']?suburb[\"\']?>/',
		'/<print config=[\"\']?postcode[\"\']?>/',
		'/<print config=[\"\']?country[\"\']?>/',
		'/<print config=[\"\']?email[\"\']?>/',
		'/<print config=[\"\']?phone[\"\']?>/',
		'/<print config=[\"\']?mobile[\"\']?>/'
	),
	array(
		htmlspecialchars($config['business'], ENT_QUOTES, 'UTF-8'),
		htmlspecialchars($config['address'],  ENT_QUOTES, 'UTF-8'),
		htmlspecialchars($config['suburb'],   ENT_QUOTES, 'UTF-8'),
		htmlspecialchars($config['postcode'], ENT_QUOTES, 'UTF-8'),
		htmlspecialchars($config['country'],  ENT_QUOTES, 'UTF-8'),
		htmlspecialchars($config['email'],    ENT_QUOTES, 'UTF-8'),
		htmlspecialchars($config['phone'],    ENT_QUOTES, 'UTF-8'),
		htmlspecialchars($config['mobile'],   ENT_QUOTES, 'UTF-8')
	),
	$html
);
$content .= $html;
