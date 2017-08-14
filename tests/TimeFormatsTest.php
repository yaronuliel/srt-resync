<?php
/**
 * Created by PhpStorm.
 * User: techmarketing
 * Date: 14/08/2017
 * Time: 2:47
 */


class TimeFormatsTest extends PHPUnit_Framework_TestCase {

	public function __construct() {
		require_once __DIR__ . '/../functions.php';
	}

	public function testFormatToStart() {
		define('OFFSET', 13.23);

		$line = '02:33:56,528 --> 02:34:03,872';

		$expected_line = '02:34:09,758 --> 02:34:17,102';
		$new_line = convertLine($line, 12.3);

		$this->assertEquals($expected_line, $new_line, 'Test if the offset addition is working');

	}

	public function testSecToTime() {
		$this->assertEquals(secToTime(0), '00:00:00,000');

		$this->assertEquals(secToTime(1543.123), '00:25:43,123');

		$this->assertEquals(secToTime(43001.0032), '11:56:41,003');
	}

	public function testTimeToSec() {
		$this->assertEquals(timeToSec(['00:00:00,000', '00', '00', '00', '000']), 0);

		$this->assertEquals(timeToSec(['00:25:43,123', '00', '25', '43', '123']), 1543.123);

		$this->assertEquals(timeToSec(['11:56:41,003', '11', '56', '41', '003']), 43001.003);

	}
}
