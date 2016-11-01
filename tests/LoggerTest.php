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

    public function testGetColorByLevel()
    {
        $this->assertEquals(
            Logger::COLLOR_RED,
            Logger::getColorByLevel(LogLevel::ALERT),
            'Check alert color'
        );
        $this->assertEquals(
            Logger::COLLOR_RED,
            Logger::getColorByLevel(LogLevel::ERROR),
            'Check error color'
        );
        $this->assertEquals(
            Logger::COLLOR_RED,
            Logger::getColorByLevel(LogLevel::CRITICAL),
            'Check critical color'
        );
        $this->assertEquals(
            Logger::COLLOR_MAGENTA,
            Logger::getColorByLevel(LogLevel::WARNING),
            'Check warning color'
        );
        $this->assertEquals(
            Logger::COLLOR_BLUE,
            Logger::getColorByLevel(LogLevel::EMERGENCY),
            'Check emergency color'
        );
        $this->assertEquals(
            Logger::COLLOR_CYAN,
            Logger::getColorByLevel(LogLevel::NOTICE),
            'Check notice color'
        );
        $this->assertEquals(
            Logger::COLLOR_GREEN,
            Logger::getColorByLevel(LogLevel::INFO),
            'Check info color'
        );
        $this->assertEquals(
            Logger::COLLOR_YELLOW,
            Logger::getColorByLevel(LogLevel::DEBUG),
            'Check debug color'
        );
    }
}
