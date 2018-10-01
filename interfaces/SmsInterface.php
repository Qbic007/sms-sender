<?php

namespace app\interfaces;

use app\models\forms\SmsSendForm;

interface SmsInterface
{
    public function create(SmsSendForm $smsSendForm);

    public function getSendingData();
}
