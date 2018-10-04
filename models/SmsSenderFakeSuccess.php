<?php

namespace app\models;

use app\interfaces\SmsSenderInterface;

class SmsSenderFakeSuccess implements SmsSenderInterface
{
    /**
     * @param Sms $sms
     * @return bool|int
     */
    public function send(Sms $sms)
    {
        return $sms->getId();
    }
}
