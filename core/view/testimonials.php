<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if (stristr($html, '<settings')) {
	preg_match('/<settings items="(.*?)">/', $html, $matches);
	$count = $matches[1];
} else
	$count = 4;
$html = preg_replace(
	array(
		'/<print page=[\"\']?notes[\"\']?>/',
		'~<settings.*?>~is'
	),
	array(
		rawurldecode($page['notes']),
		''
	),
	$html
);
preg_match('/<items>([\w\W]*?)<\/items>/', $html, $matches);
$item = $matches[1];
$s = $db -> query("SELECT * FROM content WHERE contentType='testimonials' AND status='published' ORDER BY ti DESC");
$i = 0;
$items = '';
$testitems = '';
if ($s -> rowCount() > 0) {
	while($r = $s -> fetch(PDO::FETCH_ASSOC)) {
		$items = $item;
		if ($i == 0)
			$items = preg_replace('/<print content=[\"\']?active[\"\']?>/',' active', $items);
		else
			$items = preg_replace('/<print content=[\"\']?active[\"\']?>/', '', $items);
		$items = preg_replace(
			array(
				'/<print content=[\"\']?schemaType[\"\']?>/',
				'/<print config=[\"\']?title[\"\']?>/',
				'/<print datePub>/'
			),
			array(
				$r['schemaType'],
				$config['seoTitle'],
				date('Y-d-m', $r['ti'])
			),
			$items
		);
		if (preg_match('/<print content=[\"\']?avatar[\"\']?>/', $items)) {
			if ($r['cid'] != 0) {
				$su = $db->prepare("SELECT avatar,gravatar FROM login WHERE id=:id");
				$su -> execute(
					array(
						':id' => $r['cid']
					)
				);
				$ru = $su -> fetch(PDO::FETCH_ASSOC);
				if ($ru['avatar'] != '' && file_exists('media' . DS . 'avatar' . DS . $ru['avatar']))
					$items = preg_replace('/<print content=[\"\']?avatar[\"\']?>/', 'media' . DS . 'avatar' . DS . $ru['avatar'], $items);
				elseif ($r['file'] && file_exists('media' . DS . 'avatar' . DS . basename($r['file'])))
					$items = preg_replace('/<print content=[\"\']?avatar[\"\']?>/', 'media' . DS . 'avatar' . DS . $r['file'], $items);
				elseif (stristr($ru['gravatar'], '@'))
					$items = preg_replace('/<print content=[\"\']?avatar[\"\']?>/', 'http://gravatar.com/avatar/' . md5($ru['gravatar']), $items);
				elseif (stristr($ru['gravatar'], 'gravatar.com'))
					$items = preg_replace('/<print content=[\"\']?avatar[\"\']?>/', $ru['gravatar'], $items);
				else
					$items = preg_replace('/<print content=[\"\']?avatar[\"\']?>/', $noavatar, $items);
			} elseif ($r['file'] && file_exists('media' . DS . 'avatar' . DS . basename($r['file'])))
				$items = preg_replace('/<print content=[\"\']?avatar[\"\']?>/', 'media' . DS . 'avatar' . DS . $r['file'], $items);
			else
				$items = preg_replace('/<print content=[\"\']?avatar[\"\']?>/', $noavatar, $items);
		}
		$items = preg_replace(
			array(
				'/<print content=[\"\']?notes[\"\']?>/',
				'/<print content=[\"\']?business[\"\']?>/',
				'/<print content=[\"\']?name[\"\']?>/'
			),
			array(
				strip_tags(rawurldecode($r['notes'])),
				$r['business'],
				$r['name']
			),
			$items
		);
		$testitems .= $items;
		$i++;
	}
}
if ($i > 0) {
	$html = str_replace(
		array(
			'<controls>',
			'</controls>'
		),
		'',
		$html
	);
} else
	$html = preg_replace('~<controls>.*?<\/controls>~is', '', $html, 1);
$html = preg_replace('~<items>.*?<\/items>~is', $testitems, $html, 1);
$content .= $html;
