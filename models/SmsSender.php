<?php

namespace app\models;

use app\interfaces\SmsInterface;
use app\interfaces\SmsSenderInterface;
use yii\httpclient\Client;

class SmsSender implements SmsSenderInterface
{
    const PARAMETER_STATUS = 'status';
    const SUCCESS_STATUS = 'inProgress';

    protected $url = '';

    public function send(SmsInterface $sms): bool
    {
        $client = new Client();
        try {
            $response = $client->createRequest()->data
                ->setMethod('post')
                ->setUrl($this->url)
                ->setData($sms->getSendingData())
                ->send();
        } catch (\Throwable $exception) {
            \Yii::error($exception->getMessage());
            return false;
        }

        if ($response->getIsOK()) {
            return $this->checkResponse($response->data);
        }

    }

    protected function checkResponse(String $response): bool
    {
        $responseArray = json_decode($response);

        return !empty($responseArray[self::PARAMETER_STATUS])
            && ($responseArray[self::PARAMETER_STATUS] === self::SUCCESS_STATUS);
    }
}
