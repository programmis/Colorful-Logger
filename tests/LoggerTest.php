<?php
/**
 * Created by PhpStorm.
 * User: alfred
 * Date: 01.11.16
 * Time: 21:13
 */

namespace tests;

use logger\Logger;
use Psr\Log\LogLevel;

/**
 * Class LoggerTest
 * @package tests
 */
class LoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testLog()
    {
        $test_message = 'this is test';

        $logger = new Logger();

        ob_start();
        $logger->log(LogLevel::ALERT, $test_message);
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertContains(
            $test_message,
            $content,
            'Checking test message content'
        );
        $this->assertStringStartsWith(
            Logger::COLLOR_RED . LogLevel::ALERT . Logger::COLLOR_NORMAL,
            $content,
            'Checking text color'
        );

        ob_start();
        $logger->log(LogLevel::ALERT, $test_message);
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertStringStartsWith(
            Logger::COLLOR_RED . LogLevel::ALERT . Logger::COLLOR_NORMAL . '(2)',
            $content,
            'Checking level counter'
        );
    }
}
