<?php

/**
 * Main file for our service.
 * 
 * @author Paul Albert <zone.buffer@gmail.com>
 */

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

use classes\Config      as Config;
use classes\Data        as Data;
use classes\Message     as Message;
use classes\Calculator  as Calculator;


// connect to AMQP (RabbitMQ) server
$messageBrokerConnection = new AMQPStreamConnection(
    Config::MESSAGE_BROKER_HOST,
    Config::MESSAGE_BROKER_PORT,
    Config::MESSAGE_BROKER_USER,
    Config::MESSAGE_BROKER_PASSWORD);
$messageBrokerChannel = $messageBrokerConnection->channel();

echo 'Press CTRL+C to quit.' . PHP_EOL;

// callback function for messages consuming and their processing
$consumerCallback = function (AMQPMessage $inputMessage) use ($messageBrokerChannel) {
    // for each message calculate the "interest" and total sum by formula
    if (($data = Data::validate(Data::decode($inputMessage->body))) !== false) {
        $msg = new Message($data);
        $result = Calculator::getResult($msg);
        // broadcast the new messages to 'solved-interest-queue' in the same exchange
        $messageBrokerChannel->basic_publish(
            new AMQPMessage(
                Data::encode([
                    Config::FIELD_SUM         => $msg->sum,
                    Config::FIELD_DAYS        => $msg->days,
                    Config::FIELD_INTEREST    => $result[Config::FIELD_INTEREST],
                    Config::FIELD_TOTALSUM    => $result[Config::FIELD_TOTALSUM],
                    Config::FIELD_TOKEN       => Config::UNIQUE_TOKEN,
                ]),
                [   'delivery_mode' => Config::MESSAGE_BROKER_DELIVERY_MODE,
                    'content_type'  => Config::MESSAGE_BROKER_CONTENT_TYPE, ]
            ),
            '',
            Config::QUEUE_BROADCAST
        );
    }
};

// listen on 'interest-queue' queue in default exchange for messages consuming
$messageBrokerChannel->basic_consume(Config::QUEUE_LISTEN, '', false, true, false, false, $consumerCallback);

// main loop for messages processing
while (count($messageBrokerChannel->callbacks)) {
    $messageBrokerChannel->wait();
}

// close both channel and connection
$messageBrokerChannel->close();
$messageBrokerConnection->close();
