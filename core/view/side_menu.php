<?php
/*
 * LibreCMS - Copyright (C) Diemen Design 2018
 * This software may be modified and distributed under the terms
 * of the MIT license (http://opensource.org/licenses/MIT).
 */
if (file_exists(THEME . DS . 'side_menu.html')) {
	$sideTemp = file_get_contents(THEME . DS . 'side_menu.html');
	if ($show == 'item' && ($view == 'service' || $view == 'inventory' || $view == 'events')) {
		$sideCost = '';
		if (is_numeric($r['cost']) && $r['cost'] != 0) {
			$sideCost = '<meta itemprop="priceCurrency" content="AUD">';
			$sideCost .= '<span class="cost" itemprop="price" content="' . $r['cost'] . '">';
			if (is_numeric($r['cost'])) $sideCost .= '&#36;';
			$sideCost .= htmlspecialchars($r['cost'], ENT_QUOTES, 'UTF-8') . '</span>';
		} else
			$sideCost = '<span>' . htmlspecialchars($r['cost'], ENT_QUOTES, 'UTF-8') . '</span>';
		$sideTemp = preg_replace(
			array(
				'/<print content=[\"\']?cost[\"\']?>/',
				'/<print content=[\"\']?id[\"\']?>/'
			),
			array(
				$sideCost,
				$r['id']
			),
			$sideTemp
		);
		$sideQuantity = '';
		if ($r['contentType'] == 'inventory') {
			if (is_numeric($r['quantity']) && $r['quantity'] != 0) {
				$sideQuantity = '<link itemprop="availability" href="http://schema.org/InStock">';
				$sideQuantity .= '<div class="quantity">Quantity<br>' . htmlspecialchars($r['quantity'], ENT_QUOTES, 'UTF-8') . '</div>';
			} elseif(is_numeric($r['quantity']) && $r['quantity'] == 0) {
				$sideQuantity = '<link itemprop="availability" href="http://schema.org/OutOfStock">';
				$sideQuantity .= '<div class="quantity">Out of Stock</div>';
			} else $sideQuantity .= '<div>Quantity<br>' . htmlspecialchars($r['quantity'], ENT_QUOTES, 'UTF-8') . '</div>';
			$sideTemp = str_replace(array('<print content=quantity>', '<print content="quantity">'), $sideQuantity, $sideTemp);
			if (stristr($sideTemp, '<choices>')) {
				$scq = $db -> prepare("SELECT * FROM choices WHERE rid=:id ORDER BY title ASC");
				$scq -> execute(
					array(
						':id' => $r['id']
					)
				);
				if ($scq -> rowCount() > 0) {
					$choices = '<select class="choices form-control" onchange="$(\'.addCart\').data(\'cartchoice\',$(this).val());$(\'.choices\').val($(this).val());"><option value="0">Select an Option</option>';
					while ($rcq = $scq -> fetch(PDO::FETCH_ASSOC)) {
						if ($rcq['ti'] == 0) continue;
						$choices .= '<option value="' . $rcq['id'] . '">' . $rcq['title'] . ':' . $rcq['ti'] . '</option>';
					}
					$choices .= '</select>';
					$sideTemp = str_replace('<choices>', $choices, $sideTemp);
				} else
					$sideTemp = str_replace('<choices>', '', $sideTemp);
			} else
				$sideTemp = str_replace('<choices>', '', $sideTemp);
		} else
			$sideTemp = preg_replace('/<print content=[\"\']?quantity[\"\']?>/', '', $sideTemp);
		if ($r['contentType'] == 'service' || $r['contentType'] == 'events') {
			if ($r['bookable'] == 1) {
				if (stristr($sideTemp, '<service>')) {
					$sideTemp = str_replace(
						array(
							'/<print content=[\"\']?bookservice[\"\']?>/',
							'/<service>/',
							'/<\/service>/',
							'~<inventory>.*?<\/inventory>~is'
						),
						array(
							$r['id'],
							'',
							'',
							''
						),
						$sideTemp
					);
				}
			} else
				$sideTemp = preg_replace('~<service.*?>.*?<\/service>~is', '', $sideTemp, 1);
		} else
			$sideTemp = preg_replace('~<service.*?>.*?<\/service>~is', '', $sideTemp, 1);
		if ($r['contentType'] == 'inventory' && is_numeric($r['cost'])) {
			if (stristr($sideTemp, '<inventory>')) {
				$sideTemp = preg_replace(
					array(
						'/<inventory>/',
						'/<\/inventory>/',
						'~<service>.*?<\/service>~is'
					),
					'',
					$sideTemp
				);
			} elseif (stristr($sideTemp, '<inventory>') && $r['contentType'] != 'inventory')
				$sideTemp = preg_replace('~<inventory>.*?<\/inventory>~is', '', $sideTemp, 1);
		} else
			$sideTemp = preg_replace('~<inventory>.*?<\/inventory>~is', '', $sideTemp, 1);
		$sideTemp = str_replace(
			array(
				'<controls>',
				'</controls>',
				'<review>',
				'</review>'
			),
			'',
			$sideTemp
		);
	} else {
		$sideTemp = preg_replace(
			array(
				'/<controls>([\w\W]*?)<\/controls>/',
				'/<review>([\w\W]*?)<\/review>/',
			),
			'',
			$sideTemp,
			1
		);
	}
	preg_match('/<item>([\w\W]*?)<\/item>/', $sideTemp, $matches);
	$outside = $matches[1];
	$show = '';
	$contentType = $view;
	if (stristr($outside, '<heading>')) {
		preg_match('/<heading>([\w\W]*?)<\/heading>/', $outside, $matches);
		if ($matches[1] != '') {
			$heading = $matches[1];
			$heading = str_replace(
				array(
					'<print viewlink>',
					'<print view>'
				),
				array(
					URL . $view,
					ucfirst($view)
				),
				$heading
			);
		} else
			$heading = '';
		$outside = preg_replace('~<heading>.*?<\/heading>~is', $heading, $outside, 1);
	}
	if (stristr($sideTemp, '<settings')) {
		preg_match('/<settings items="(.*?)" contenttype="(.*?)">/', $outside, $matches);
		if (isset($matches[1])) {
			if ($matches[1] == 'all' || $matches[1] == '')
				$show = '';
			elseif ($matches[1] == 'limit')
				$show = ' LIMIT ' . $config['showItems'];
			else
				$show = ' LIMIT ' . $matches[1];
		} else
			$show = '';
		if (isset($matches[2])) {
			if ($matches[2] == 'current') $contentType = strtolower($view);
			if ($matches[2] == 'all' || $matches[2] == '') $contentType = $heading = '';
		} else
			$contentType = '';
	}
	$r = $db -> query("SELECT * FROM menu WHERE id=17") -> fetch(PDO::FETCH_ASSOC);
	if ($r['active']{0} == 1) {
		$sideTemp = str_replace(
			array(
				'<newsletters>',
				'</newsletters>'
			),
			'',
			$sideTemp
		);
	} else
		$sideTemp = preg_replace('/<newsletters>([\w\W]*?)<\/newsletters>/', '', $sideTemp, 1);
	preg_match('/<items>([\w\W]*?)<\/items>/', $outside, $matches);
	$insides = $matches[1];
	$s = $db -> prepare("SELECT * FROM content WHERE contentType LIKE :contentType AND internal!='1' AND status='published' ORDER BY featured DESC, ti DESC $show");
	$s -> execute(
		array(
			':contentType' => $contentType
		)
	);
	$output = '';
	while ($r = $s -> fetch(PDO::FETCH_ASSOC)) {
		if ($r['contentType'] == 'gallery') {
			preg_match('/<media>([\w\W]*?)<\/media>/', $insides, $matches);
			$inside = $matches[1];
		} else
			$inside = preg_replace('/<media>([\w\W]*?)<\/media>/', '', $insides, 1);
		$items = $inside;
		$time = '<time datetime=' . date('Y-m-d', $r['ti']) . '">' . date($config['dateFormat'], $r['ti']) . '</time>';
		if ($r['contentType'] == 'events' || $r['contentType'] == 'news') {
			if ($r['tis'] != 0) {
				$time = '<time datetime="' . date('Y-m-d', $r['tis']) . '">' . date('dS M H:i', $r['tis']) . '</time>';
				if ($r['tie'] != 0)
					$time.=' &rarr; <time datetime="' . date('Y-m-d', $r['tie']) . '">' . date('dS M H:i', $r['tie']) . '</time>';
			}
		}
		if ($r['seoCaption'] != '')
			$caption = $r['seoCaption'];
		else
			$caption = substr(strip_tags(rawurldecode($r['notes'])), 0, 100) . '...';
		$items = preg_replace(
			array(
				'/<print content=[\"\']?thumb[\"\']?>/',
				'/<print link>/',
				'/<print content=[\"\']?schemaType[\"\']?>/',
				'/<print metaDate>/',
				'/<print content=[\"\']?title[\"\']?>/',
				'/<print time>/',
				'/<print content=[\"\']?caption[\"\']?>/'
			),
			array(
				htmlspecialchars($r['thumb'], ENT_QUOTES, 'UTF-8'),
				URL . $r['contentType'] . '/' . urlencode(str_replace(' ', '-', $r['title'])),
				htmlspecialchars($r['schemaType'], ENT_QUOTES, 'UTF-8'),
				date('Y-m-d', $r['ti']),
				htmlspecialchars($r['title'], ENT_QUOTES, 'UTF-8'),
				$time,
				htmlspecialchars($caption, ENT_QUOTES, 'UTF-8')
			),
			$items
		);
		$output .= $items;
	}
	$outside = preg_replace(
		array(
			'~<items>.*?<\/items>~is',
			'~<settings.*?>~is'
		),
		array(
			$output,
			'',
		),
		$outside,
		1
	);
	$sideTemp = preg_replace('~<item>.*?<\/item>~is', $outside, $sideTemp, 1);
} else
	$sideTemp = '';
$content .= $sideTemp;
