<?php

namespace app\models;

use interfaces\SmsSenderInterface;
use yii\httpclient\Client;

class SmsSender implements SmsSenderInterface
{
    public function send()
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl('http://sms-sender/')
            ->setData([])
            ->send();
            echo '<pre>';
            var_dump($response);
            echo '</pre>';
            exit;
    }
}
