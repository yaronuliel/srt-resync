<?php

function convertFile($fh, $start) {
	while ( $line = fgets( $fh ) ) {
		echo convertLine( $line, $start);
	}
}

function convertLine($line, $start) {
    return preg_replace_callback( '/(\d{2})\:(\d{2}):(\d{2})[\,\.](\d+)/', function ( $matches ) use ( &$offset, $start ) {
        $sec = timeToSec( $matches );
        if ( !defined('OFFSET') ) {
            define('OFFSET', $start - $sec);
        }

        return secToTime( $sec + OFFSET );
    }, $line );
}

function secToTime($sec) {
	$h = floor($sec / 3600);
	$m = floor(($sec % 3600) / 60);
	$s = floor($sec % 60);

	$ms = bcsub($sec, floor($sec), 3) * 1000;//str_pad(($sec - abs($sec)) * 1000, '0', 3, STR_PAD_LEFT);

	return sprintf('%02d:%02d:%02d,%03d', $h, $m, $s, $ms);
}

function timeToSec($parts) {
	$sec = intval($parts[1]) * 3600 + intval($parts[2]) * 60 + intval($parts[3])
				+ intval($parts[4]) / 1000;
	return (float)$sec;
}


function help() {
	echo 'Usage: srt-sync.php [START_TIME] < input.srt > output.srt';
	echo "\n";
	exit;
}
