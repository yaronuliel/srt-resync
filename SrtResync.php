<?php

class SrtResync {

	private $start;
	private $offset;

	private $lines = [];

	public function __construct($start) {
		$this->start = $start;
	}

	/**
	 * @return mixed
	 */
	public function getOffset() {
		return $this->offset;
	}

	/**
	 * @return mixed
	 */
	public function getStart() {
		return $this->start;
	}

	public function convertString($srt_content) {
		$token = '\r\n';
		$line = strtok($srt_content, $token);

		if($line === false) {
			$token = '\n';
			$line = strtok($srt_content, $token);
		}

		$this->lines = [];

		while($line !== false) {
			$this->lines[] = $this->convertLine($line);
			$line = strtok($token);
		}
		return $this;
	}
	
	public function convertFile($fh) {
		$this->lines = [];
		while ( $line = fgets( $fh ) ) {
			$this->lines[] = $this->convertLine( $line );
		}
	}

	private function convertLine($line ) {
		return preg_replace_callback( '/(\d{2})\:(\d{2}):(\d{2})[\,\.](\d+)/', function ( $matches ) {
			$sec = self::timeToSec( $matches );
			if($this->offset === null) {
				$this->offset = $this->start - $sec;
			}

			return self::secToTime( $sec + $this->offset );
		}, $line );
	}

	public function __toString() {
		return implode('', $this->lines);
	}

	public function getContents() {
		return $this->__toString();
	}

	public function render() {
		echo $this->__toString();
	}

	public static function secToTime($sec) {
		$h = floor($sec / 3600);
		$m = floor(($sec % 3600) / 60);
		$s = floor($sec % 60);

		$ms = bcsub($sec, floor($sec), 3) * 1000;//str_pad(($sec - abs($sec)) * 1000, '0', 3, STR_PAD_LEFT);

		return sprintf('%02d:%02d:%02d,%03d', $h, $m, $s, $ms);
	}


	public static function timeToSec($parts) {
		$sec = intval($parts[1]) * 3600 + intval($parts[2]) * 60 + intval($parts[3])
		       + intval($parts[4]) / 1000;
		return (float)$sec;
	}
}