<?php

namespace app\commands;

use app\interfaces\SmsInterface;
use app\interfaces\WorkerInterface;
use app\models\Sms;
use yii\console\Controller;

class SendController extends Controller
{
    public function actionIndex()
    {
//        \Yii::$container->setDefinitions([SmsInterface::class => Sms::class]);
        $sms = \Yii::$container->get(SmsInterface::class);
        echo '<pre>';
        var_dump($sms);
        echo '</pre>';
        exit;
        $worker = \Yii::$container->get(WorkerInterface::class);

        $worker->begin();
    }
}
