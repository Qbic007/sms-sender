<?php

namespace app\commands;

use app\interfaces\WorkerInterface;
use yii\console\Controller;

class SendController extends Controller
{
    public function actionIndex()
    {
        $worker = \Yii::$container->get(WorkerInterface::class);

        $worker->begin();
    }
}
