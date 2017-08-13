#!/usr/bin/env php
<?php

$fh = fopen('php://stdin', 'r');

if($_SERVER['argc']!=2) {
	help();
}

$start = (float)$_SERVER['argv'][1];

if(!is_numeric($start)) {
	help();
}

$offset = null;

while($line = fgets($fh)) {
	echo preg_replace_callback('/(\d{2})\:(\d{2}):(\d{2})[\,\.](\d+)/', function($matches) use (&$offset, $start) {
		$sec = timeToS($matches);
		if($offset === null) {

			$offset = $start - $sec;
		}

		return secToTime($sec + $offset);
	}, $line);
}

function secToTime($sec) {
	$h = floor($sec / 3600);
	$m = floor(($sec % 3600) / 60);
	$s = floor($sec % 60);

	$ms = ($sec - floor($sec)) * 1000;//str_pad(($sec - abs($sec)) * 1000, '0', 3, STR_PAD_LEFT);

	return sprintf('%02d:%02d:%02d,%03d', $h, $m, $s, $ms);
}

function timeToS($parts) {
	$sec = intval($parts[1]) * 3600 + intval($parts[2]) * 60 + intval($parts[3])
				+ intval($parts[4]) / 1000;
	return (float)$sec;
}


function help() {
	echo 'Usage: srt-sync.php +12.23 < input.srt > output.srt';
	echo "\n";
	exit;
}
