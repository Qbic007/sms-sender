<?php

namespace app\models;

use app\interfaces\SmsSenderInterface;

class SmsSenderFakeSuccess implements SmsSenderInterface
{
    public function send(Sms $sms, int $serviceId): bool
    {
        return true;
    }

    public function getSmsId(): string
    {
        return 0;
    }
}
