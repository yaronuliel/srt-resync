#!/usr/bin/env php
<?php

require_once './functions.php';

if(php_sapi_name() == 'cli') {

	if ( $_SERVER['argc'] != 2 && $_SERVER['argc'] != 3 ) {
		help();
	}

	$file = $_SERVER['argc'] == 3 ? $_SERVER['argv'][2] : 'php://stdin';
	$fh   = fopen( $file, 'r' );

	$start = (float) $_SERVER['argv'][1];

	if ( ! is_numeric( $start ) ) {
		help();
	}

	convertFile($fh, $start);
}