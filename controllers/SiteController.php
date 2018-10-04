<?php

namespace app\controllers;

use app\models\forms\SmsSendForm;
use app\models\Sms;
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
                    $sms = new Sms();
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
