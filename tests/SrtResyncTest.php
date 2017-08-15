<?php
/**
 * Created by PhpStorm.
 * User: techmarketing
 * Date: 14/08/2017
 * Time: 2:47
 */

namespace Tests;
require_once __DIR__ . '/../vendor/autoload.php';

class SrtResyncTest extends \PHPUnit_Framework_TestCase {

	public function __construct() {
	}

	public function testFormatToStart() {
		$conv = new \SrtResync(12.3);

		$conv->convertString('02:33:56,528 --> 02:34:03,872');
		$expected_line = '00:00:12,299 --> 00:00:19,643';

		$this->assertEquals($expected_line, $conv->getContents(), 'Test if the offset addition is working');
	}

	public function testOffsetContstant() {
		$sync = new \SrtResync(12.3);
		$sync->convertString('02:34:09,758 --> 02:34:17,102');
		$this->assertEquals($sync->getOffset(), -9237.458);
	}

	public function testSecToTime() {
		$this->assertEquals(\SrtResync::secToTime(0), '00:00:00,000');

		$this->assertEquals(\SrtResync::secToTime(1543.123), '00:25:43,123');

		$this->assertEquals(\SrtResync::secToTime(43001.0032), '11:56:41,003');
	}

	public function testTimeToSec() {
		$this->assertEquals(\SrtResync::timeToSec(['00:00:00,000', '00', '00', '00', '000']), 0);

		$this->assertEquals(\SrtResync::timeToSec(['00:25:43,123', '00', '25', '43', '123']), 1543.123);

		$this->assertEquals(\SrtResync::timeToSec(['11:56:41,003', '11', '56', '41', '003']), 43001.003);

	}
}
