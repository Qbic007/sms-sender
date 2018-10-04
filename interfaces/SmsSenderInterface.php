<?php

namespace app\interfaces;

use app\models\Sms;

interface SmsSenderInterface
{
    public function send(Sms $sms): bool;

    public function getServiceId(): int;

    public function getSmsId(): string ;
}
