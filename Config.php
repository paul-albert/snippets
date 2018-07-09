<?php

/**
 * Main configuration.
 * 
 * @author Paul Albert <zone.buffer@gmail.com>
 */

namespace classes;

use PhpAmqpLib\Message\AMQPMessage as AMQPMessage;


final class Config {
    
    const MESSAGE_BROKER_HOST           = 'impact.ccat.eu';
    const MESSAGE_BROKER_PORT           = 5672;
    const MESSAGE_BROKER_USER           = 'myjar';
    const MESSAGE_BROKER_PASSWORD       = 'myjar';
    
    const MESSAGE_BROKER_DELIVERY_MODE  = AMQPMessage::DELIVERY_MODE_PERSISTENT;
    const MESSAGE_BROKER_CONTENT_TYPE   = 'application/json';
    
    const QUEUE_LISTEN                  = 'interest-queue';
    const QUEUE_BROADCAST               = 'solved-interest-queue';
    
    const UNIQUE_TOKEN                  = 'token123';
    
    const FIELD_SUM                     = 'sum';
    const FIELD_DAYS                    = 'days';
    const FIELD_INTEREST                = 'interest';
    const FIELD_TOTALSUM                = 'totalSum';
    const FIELD_TOKEN                   = 'token';
    
    const DIV3                          = 3;
    const DIV5                          = 5;
    
    const DIV3_INTEREST                 = 1;
    const DIV5_INTEREST                 = 2;
    const DIV3_AND_5_INTEREST           = 3;
    const NO_DIV3_AND_5_INTEREST        = 4;
    
    const ROUND_PRECISION               = 2;
    const IS_DEBUG                      = true;
}