<?php

namespace app\interfaces;

use app\models\Sms;

interface SmsSenderInterface
{
    public function send(Sms $sms, int $serviceId): bool;

    public function getSmsId(): string ;
}
