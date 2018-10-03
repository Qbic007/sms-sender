<?php

return [
    'definitions' => [
        \app\interfaces\SmsInterface::class => \app\models\Sms::class,
        \app\interfaces\WorkerInterface::class => \app\models\Worker::class
    ]
];