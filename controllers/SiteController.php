<?php

namespace app\controllers;

use app\interfaces\SmsInterface;
use app\models\forms\SmsSendForm;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex(): string
    {
        $smsSendForm = new SmsSendForm();
        if (!empty($smsSendFormData = \Yii::$app->request->post()['SmsSendForm'])) {
            $smsSendForm->setAttributes($smsSendFormData);
            try {
                if ($smsSendForm->validate()) {
                    $sms = \Yii::$container->get(SmsInterface::class);
                    $sms->create($smsSendForm);
                    $smsSendForm->clear();
                }
            } catch (\Throwable $exception) {
                \Yii::warning($exception->getMessage());
                //todo: logs config
            }
        }

        return $this->render('index', [
            'model' => $smsSendForm,
        ]);
    }

    public function actionSend()
    {
        var_dump($_POST);
    }
}
