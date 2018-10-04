<?php

namespace app\models;

use app\interfaces\SmsSenderInterface;
use yii\httpclient\Client;

class SmsSender implements SmsSenderInterface
{
    const PARAMETER_STATUS = 'status';
    const PARAMETER_SMS_ID = 'smsId';
    const SUCCESS_STATUS = 'inProgress';

    protected $url;
    protected $service_id;
    protected $smsId;

    public function send(Sms $sms): bool
    {
        $result = false;
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

        if ($response->getIsOK() && (($smsId = $this->checkResponse($response->data)) !== false)) {
            $this->smsId = $smsId;

            $result = true;
        }

        return $result;
    }

    public function getServiceId(): int
    {
        return $this->service_id;
    }

    public function getSmsId(): string
    {
        return $this->smsId;
    }

    /**
     * @param String $response
     * @return bool|int
     */
    protected function checkResponse(String $response)
    {
        $responseArray = json_decode($response);

        if (!empty($responseArray[self::PARAMETER_STATUS])
            && !empty($responseArray[self::PARAMETER_SMS_ID])
            && ($responseArray[self::PARAMETER_STATUS] === self::SUCCESS_STATUS)) {

            return (int)$responseArray[self::PARAMETER_SMS_ID];
        }

        return false;
    }
}
