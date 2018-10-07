<?php

namespace app\models;

use app\interfaces\SmsCheckerInterface;
use yii\httpclient\Client;

class SmsChecker implements SmsCheckerInterface
{
    const PARAMETER_STATUS = 'status';
    const SUCCESS_STATUS = 'sended';
    const IN_PROGRESS_STATUS = 'processed';
    const ERROR_STATUS = 'processed';

    const SERVICE_COMMAND_CHECK = '/check-sms';

    protected $smsId;

    public function check(Sms $sms): int
    {
        $result = Sms::STATUS_UNSENT;
        $client = new Client();
        try {
            $response = $client->createRequest()->data
                ->setMethod('post')
                ->setUrl(Sms::SERVICE_URLS[$sms->service_id] . self::SERVICE_COMMAND_CHECK)
                ->setData($sms->getSendingData())
                ->send();
        } catch (\Throwable $exception) {
            \Yii::error($exception->getMessage());
            return false;
        }

        if ($response->IsOK) {
            $result = $this->checkResponse($response->data);
        }

        return $result;
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

        $result = Sms::STATUS_UNSENT;
        if (!empty($responseArray[self::PARAMETER_STATUS])) {
            switch ($responseArray[self::PARAMETER_STATUS]) {
                case self::SUCCESS_STATUS:
                    $result = Sms::STATUS_SENT;
                    break;
                case self::IN_PROGRESS_STATUS:
                    $result = Sms::STATUS_ENQUEUED;
                    break;
            }
        }

        return $result;
    }
}
