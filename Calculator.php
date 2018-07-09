<?php

/**
 * Calculator class.
 * 
 * @author Paul Albert <zone.buffer@gmail.com>
 */

namespace classes;

use classes\Config  as Config;
use classes\Message as Message;


class Calculator {
    
    /**
     * Calculates interest for day.
     * 
     * @param int $day
     * 
     * @return int
     */
    private static function getInterest ($day) {
        if (($day % Config::DIV3 === 0) && ($day % Config::DIV5 === 0)) {
            return Config::DIV3_AND_5_INTEREST;
        } elseif (($day % Config::DIV3 === 0) && ($day % Config::DIV5 !== 0)) {
            return Config::DIV3_INTEREST;
        } elseif (($day % Config::DIV3 !== 0) && ($day % Config::DIV5 === 0)) {
            return Config::DIV5_INTEREST;
        } else {
            return Config::NO_DIV3_AND_5_INTEREST;
        }
    }

    /**
     * Receive interest and total sum for the message (by certain formula).
     * 
     * @param Message $msg
     * 
     * @return array
     */
    public static function getResult (Message $msg) {
        for ($interest = 0, $i = 1; $i <= $msg->days; $i++) {
            $interest += round($msg->sum * self::getInterest($i) / 100, Config::ROUND_PRECISION);
        }
        return [
            Config::FIELD_INTEREST => $interest,
            Config::FIELD_TOTALSUM => round($msg->sum + $interest, Config::ROUND_PRECISION),
        ];
    }
    
}
