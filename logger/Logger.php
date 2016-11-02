<?php
/**
 * Created by PhpStorm.
 * User: daniil
 * Date: 21.10.16
 * Time: 15:17
 */

namespace logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

/**
 * Class Logger
 *
 * @package chat
 */
class Logger implements LoggerInterface
{
    const COLLOR_YELLOW = "\033[1;33m";
    const COLLOR_GREEN = "\033[1;32m";
    const COLLOR_CYAN = "\033[1;36m";
    const COLLOR_BLUE = "\033[1;34m";
    const COLLOR_MAGENTA = "\033[1;35m";
    const COLLOR_RED = "\033[1;31m";
    const COLLOR_NORMAL = "\033[0;39m";

    use LoggerTrait;

    private static $types_cnt = [];

    /** @inheritdoc */
    public function log($level, $message, array $context = array())
    {
        echo self::createString($level, $message, true);
    }

    /**
     * Create and return log string
     *
     * @param string $level
     * @param string $message
     * @param bool   $colorful
     *
     * @return string
     */
    public static function createString($level, $message, $colorful = false)
    {
        if (!isset(self::$types_cnt[$level])) {
            self::$types_cnt[$level] = 1;
        }
        if ($colorful) {
            $color  = self::getColorByLevel($level);
            $prefix = $color . $level . "\033[0;39m(" . self::$types_cnt[$level] . ")";
        } else {
            $prefix = $level . "(" . self::$types_cnt[$level] . ")";
        }
        self::$types_cnt[$level]++;

        return str_pad($prefix, 30, '.') . "[" . date('Y/m/d H:i:s') . "] -> " . $message . "\n";
    }

    /**
     * @param string $level constant from LogLevel class
     *
     * @return string
     */
    public static function getColorByLevel($level)
    {
        switch ($level) {
            case LogLevel::DEBUG:
                $color = self::COLLOR_YELLOW;
                break;
            case LogLevel::INFO:
                $color = self::COLLOR_GREEN;
                break;
            case LogLevel::NOTICE:
                $color = self::COLLOR_CYAN;
                break;
            case LogLevel::EMERGENCY:
                $color = self::COLLOR_BLUE;
                break;
            case LogLevel::WARNING:
                $color = self::COLLOR_MAGENTA;
                break;
            case LogLevel::ALERT:
            case LogLevel::ERROR:
            case LogLevel::CRITICAL:
                $color = self::COLLOR_RED;
                break;
            default:
                $color = self::COLLOR_NORMAL;
                break;
        }

        return $color;
    }
}
