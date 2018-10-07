<?php

namespace app\interfaces;

use app\models\Sms;

interface SmsCheckerInterface
{
    public function check(Sms $sms): int;
}
