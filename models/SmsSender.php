<?php

namespace app\models;

use app\interfaces\SmsSenderInterface;
use yii\httpclient\Client;

class SmsSender implements SmsSenderInterface
{
    protected $sms;

    public function __construct(Sms $sms)
    {
        $this->sms = $sms;
    }

    public function send()
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl('http://sms-sender/')
            ->setData(['0'])
            ->send();
            echo '<pre>';
            var_dump($response);
            echo '</pre>';
            exit;
    }

    public function check()
    {

    }
}
