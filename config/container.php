<?php

return [
    'definitions' => [
        \app\interfaces\WorkerInterface::class => \app\models\Worker::class,
        \app\interfaces\SmsSenderInterface::class => \app\models\SmsSender::class,
        \app\interfaces\SmsCheckerInterface::class => \app\models\SmsChecker::class
    ]
];