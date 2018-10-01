<?php

namespace app\interfaces;

interface SmsSenderInterface
{
    public function send(SmsInterface $sms): bool;
}
