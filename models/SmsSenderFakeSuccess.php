<?php

namespace app\models;

use app\interfaces\SmsInterface;
use app\interfaces\SmsSenderInterface;

class SmsSenderFakeSuccess implements SmsSenderInterface
{
    public function send(SmsInterface $sms): bool
    {
        return true;
    }
}
