<?php

define('HOME_POLL_FUNCTION', '');


function home_capture($function_name, ...$args){
	if(!function_exists($function_name)){ return ''; }
	ob_start();
	try{
		call_user_func_array($function_name, $args);
	}catch(Throwable $e){
	}
	return ob_get_clean();
}

function home_xpath($html){
	$dom = new DOMDocument();
	libxml_use_internal_errors(true);
	$dom->loadHTML('<?xml encoding="UTF-8"><div>'.$html.'</div>');
	libxml_clear_errors();
	return new DOMXPath($dom);
}

function home_clean($text){
	return trim(preg_replace('/\s+/u', ' ', $text));
}

function home_cards($xp){
	return $xp->query('//*[contains(concat(" ",normalize-space(@class)," ")," card ")]');
}

function home_tilt(){
	return (mt_rand(-30, 30) / 10).'deg';  
}

function home_pick($items, $n = 4){
	shuffle($items);
	return array_slice($items, 0, $n);
}


function home_members($con){
	$html = home_capture('show_class_mates', $con, 1);
	if(trim($html) === ''){ return array(); }
	$xp = home_xpath($html);
	$members = array();

	foreach($xp->query('//a[contains(@href,"user.php")]') as $a){
		if(!preg_match('/id=(\d+)/', $a->getAttribute('href'), $m)){ continue; }
		$id = $m[1];
		if(!isset($members[$id])){
			$members[$id] = array('name' => '', 'img' => '');
		}
		$text = home_clean($a->textContent);
		if($text !== '' && mb_strlen($text) > mb_strlen($members[$id]['name'])){
			$members[$id]['name'] = $text;
		}
		if($members[$id]['img'] === ''){
			$node = $a;
			for($i = 0; $i < 4 && $node; $i++){
				$imgs = $xp->query('.//img', $node);
				if($imgs->length === 1){
					$members[$id]['img'] = $imgs->item(0)->getAttribute('src');
					break;
				}
				if($imgs->length > 1){ break; }
				$node = $node->parentNode;
			}
		}
	}
	return array_values($members);
}

function home_photos($con){
	$photos = array();
	try{
		$class = mysqli_real_escape_string($con, $_SESSION['class']);
		$run = mysqli_query($con, "SELECT id, name, comment FROM photos
			WHERE class='".$class."' AND name<>'temp_name' ORDER BY RAND() LIMIT 4");
		while($row = mysqli_fetch_assoc($run)){
			$photos[] = $row;
		}
	}catch(Throwable $e){
		return array();
	}
	return $photos;
}

function home_fetch_page($file){
	if(!ini_get('allow_url_fopen')){ return ''; }
	$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
	$dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
	$url = $scheme.'://'.$_SERVER['HTTP_HOST'].$dir.'/'.$file;
	$cookie = session_name().'='.session_id();
	session_write_close();   
	$context = stream_context_create(array('http' => array(
		'header' => "Cookie: ".$cookie."\r\n",
		'timeout' => 5,
		'ignore_errors' => true
	)));
	$html = @file_get_contents($url, false, $context);
	return $html ? $html : '';
}

function home_parse_stories($html){
	if(trim($html) === ''){ return array(); }
	$xp = home_xpath($html);
	$texts = array();

	$nodes = $xp->query('//*[contains(concat(" ",normalize-space(@class)," ")," bubble ")]');

	if($nodes->length === 0){
		$nodes = $xp->query('//*[self::h1 or self::h2 or self::h3][contains(translate(.,"STORIES","stories"),"stor")]
			/following-sibling::*[not(self::h1 or self::h2 or self::h3 or self::footer or self::script or self::nav or self::form)]');
	}

	foreach($nodes as $node){
		$text = home_clean($node->textContent);
		if($text !== ''){
			$texts[] = mb_strimwidth($text, 0, 140, '…');
		}
	}
	return $texts;
}

function home_stories($con){
	$stories = home_parse_stories(home_capture('show_user_stories', $con, 0));
	if(count($stories) === 0){
		$stories = home_parse_stories(home_fetch_page('stories.php'));
	}
	return $stories;
}

function home_find_poll_function(){
	if(HOME_POLL_FUNCTION !== '' && function_exists(HOME_POLL_FUNCTION)){
		return HOME_POLL_FUNCTION;
	}
	$defined = get_defined_functions();
	$unsafe = '/vote|add|insert|delete|remove|reset|create|update|save|submit|check|count|home_/i';
	foreach($defined['user'] as $fn){
		if(preg_match('/^(show|display|print|render|list)_.*poll/i', $fn) && !preg_match($unsafe, $fn)){
			return $fn;
		}
	}
	return '';
}


function home_parse_polls($html){
	if(trim($html) === ''){ return array(); }
	$xp = home_xpath($html);
	$results = array();

	foreach(home_cards($xp) as $card){
		$q_node = $xp->query('.//h1|.//h2|.//h3|.//h4|.//strong|.//b', $card)->item(0);
		if(!$q_node){ continue; }
		$question = home_clean($q_node->textContent);
		if($question === ''){ continue; }

		$rest = home_clean(preg_replace('/'.preg_quote($question, '/').'/u', '', home_clean($card->textContent), 1));
		if(preg_match_all('/([^\-–—]+?)\s*[-–—]\s*(\d+)\s*(?:votes?|phiếu)/iu', $rest, $all, PREG_SET_ORDER)){
			$best = null;
			foreach($all as $m){
				$votes = (int)$m[2];
				if($best === null || $votes > $best['votes']){
					$best = array('q' => $question, 'name' => trim($m[1]), 'votes' => $votes);
				}
			}
			$results[] = $best;
		}
	}
	return $results;
}


function home_polls($con){
	$results = array();
	$fn = home_find_poll_function();
	if($fn !== ''){
		$results = home_parse_polls(home_capture($fn, $con));
	}
	if(count($results) === 0){
		$results = home_parse_polls(home_fetch_page('polls.php'));
	}
	return $results;
}


function home_section_open($class, $title, $href){
	echo '<section class="card home-section '.$class.'">
		<h2 class="home-sub">
			<a class="home-sub-title" href="'.$href.'">'.$title.'</a>
			<a class="home-more" href="'.$href.'">Xem tất cả →</a>
		</h2>';
}

function home_section_close(){
	echo '</section>';
}

function show_home($con){
	echo '<h2 class="page-heading">Trang chủ</h2>';

	/* 1. Thành viên lớp */
	home_section_open('home-members', 'Thành viên lớp', 'class.php');
	$members = home_pick(home_members($con));
	if(count($members) === 0){
		echo '<div class="home-empty">Chưa có thành viên nào.</div>';
	}else{
		echo '<div class="home-tiles">';
		foreach($members as $m){
			echo '<a class="home-tile" href="class.php" style="--tilt:'.home_tilt().'">
				<div class="frame">'.($m['img'] !== '' ? '<img src="'.htmlspecialchars($m['img']).'" alt="">' : '').'</div>
				<div class="tile-name">'.htmlspecialchars($m['name']).'</div>
			</a>';
		}
		echo '</div>';
	}
	home_section_close();

	home_section_open('home-photos', 'Thư viện ảnh', 'gallery.php');
	$photos = home_photos($con);
	if(count($photos) === 0){
		echo '<a class="home-empty" href="gallery.php">Chưa có ảnh nào. Hãy là người đầu tiên tải ảnh lên!</a>';
	}else{
		echo '<div class="home-tiles">';
		foreach($photos as $p){
			echo '<a class="home-tile" href="gallery.php" style="--tilt:'.home_tilt().'">
				<div class="frame"><img src="'.htmlspecialchars($p['name']).'" alt=""></div>';
			if(trim($p['comment'] ?? '') !== ''){
				echo '<div class="tile-name">'.htmlspecialchars($p['comment']).'</div>';
			}
			echo '</a>';
		}
		echo '</div>';
	}
	home_section_close();

	home_section_open('home-polls', 'Ai có khả năng nhất…', 'polls.php');
	$polls = home_polls($con);
	if(count($polls) === 0){
		echo '<a class="home-empty" href="polls.php">Chưa có bình chọn nào. Hãy bắt đầu bình chọn tại đây!</a>';
	}else{
		foreach(array_slice($polls, 0, 4) as $poll){
			echo '<a class="home-poll-row" href="polls.php">
				<span class="home-poll-q">'.htmlspecialchars($poll['q']).'</span>
				<span class="home-poll-winner">
					<span class="home-dot">'.htmlspecialchars(mb_substr($poll['name'], 0, 1)).'</span>
					'.htmlspecialchars($poll['name']).'
					<small>'.(int)$poll['votes'].' phiếu</small>
				</span>
			</a>';
		}
	}
	home_section_close();

	home_section_open('home-stories-box', 'Câu chuyện ẩn danh', 'stories.php');
	$stories = home_pick(home_stories($con));
	if(count($stories) === 0){
		echo '<a class="home-empty" href="stories.php">Chưa có câu chuyện nào.</a>';
	}else{
		echo '<div class="home-stories">';
		foreach($stories as $story){
			echo '<a class="home-story" href="stories.php">
				<div class="bubble"><span class="anon-icon">🕶️</span>'.htmlspecialchars($story).'</div>
			</a>';
		}
		echo '</div>';
	}
	home_section_close();
}