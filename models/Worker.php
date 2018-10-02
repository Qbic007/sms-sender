<?php

namespace app\models;

use app\interfaces\WorkerInterface;

class Worker implements WorkerInterface
{
    public function begin()
    {
        echo '<pre>';
        var_dump($this->getUnsentSms());
        echo '</pre>';
        exit;
//        while (1) {
//
//        }
    }

    protected function getUnsentSms()
    {
        return Sms::findAll([
            'status' => Sms::STATUS_UNSENT
        ]);
    }
}
