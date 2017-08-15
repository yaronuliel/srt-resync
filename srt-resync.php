#!/usr/bin/env php
<?php

require_once './vendor/autoload.php';

function help() {
	echo 'Usage: srt-sync.php [START_TIME] < input.srt > output.srt';
	echo "\n";
	exit;
}

if(php_sapi_name() == 'cli') {

	if ( $_SERVER['argc'] != 2 && $_SERVER['argc'] != 3 ) {
		help();
	}

	$file = $_SERVER['argc'] == 3 ? $_SERVER['argv'][2] : 'php://stdin';
	$fh   = fopen( $file, 'r' );

	$start = (float) $_SERVER['argv'][1];

	$conv = new SrtResync($start);
	$conv->convertFile($fh);
	echo $conv;
}