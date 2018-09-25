<?php

namespace app\controllers;

use interfaces\SmsSenderInterface;
use app\models\forms\SmsSendForm;
use yii\base\InvalidConfigException;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $smsSendForm = new SmsSendForm();
        if (!empty($smsSendFormData = \Yii::$app->request->post()['SmsSendForm'])) {
            $smsSendForm->setAttributes($smsSendFormData);
            try {
                if ($smsSendForm->validate()) {
                    $smsSender = \Yii::$container->get(SmsSenderInterface::class);
                    $smsSender->send();
                }
                throw new InvalidConfigException();
            } catch (\Throwable $exception) {
                \Yii::warning($exception->getMessage());
                //todo: logs config
            }
        }

        return $this->render('index', [
            'model' => $smsSendForm,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSend()
    {
        return $this->render('about');
    }
}
