<?php

namespace app\models;

use app\interfaces\SmsCheckerInterface;
use app\interfaces\SmsSenderInterface;
use app\interfaces\WorkerInterface;

class Worker implements WorkerInterface
{
    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function begin()
    {
        while (1) {
            $unsent = $this->getUnsentSms();
            $this->send($unsent);

            $enqueued = $this->getEnqueuedSms();
            $this->check($enqueued);

            $overdue = $this->getOverdueSms();
            $this->overdue($overdue);
        }
    }

    protected function getUnsentSms()
    {
        return Sms::find()
            ->andWhere([
                'status' => Sms::STATUS_UNSENT
            ])
            ->all();
    }

    protected function getEnqueuedSms()
    {
        return Sms::find()
            ->andWhere([
                'status' => Sms::STATUS_ENQUEUED
            ])
            ->all();
    }

    protected function getOverdueSms()
    {
        $limit = (new \DateTime('-' . \Yii::$app->params['lifeTime'] . ' hour'))
            ->format(\Yii::$app->params['dateTimeFormat']);
        return Sms::find()
            ->where(['<', 'create_time', $limit])
            ->andWhere(['NOT IN', 'status', Sms::FINAL_STATUSES])
            ->all();
    }

    /**
     * @param Sms[] $unsentSms
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    protected function send(array $unsentSms)
    {
        foreach ($unsentSms as $sms) {
            foreach (Sms::SERVICE_URLS as $serviceId => $service) {
                $sender = \Yii::$container->get(SmsSenderInterface::class);
                if ($smsId = $sender->send($sms, $serviceId)) {
                    $sms->status = Sms::STATUS_ENQUEUED;
                    $sms->service_id = $serviceId;
                    $sms->sms_id = $sender->getSmsId();
                    $sms->save();
                    break;
                }
            }
        }
    }

    /**
     * @param array $enqueuedSms
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    protected function check(array $enqueuedSms)
    {
        foreach ($enqueuedSms as $sms) {
            $checker = \Yii::$container->get(SmsCheckerInterface::class);
            $sms->status = $checker->check($sms);
            if((int)$sms->status === Sms::STATUS_UNSENT) {
                $sms->service_id = null;
                $sms->sms_id = null;
            }
            $sms->save();
        }
    }

    /**
     * @param Sms[] $overdueSms
     */
    protected function overdue(array $overdueSms)
    {
        foreach ($overdueSms as $sms) {
            $sms->status = Sms::STATUS_ERROR;
            $sms->save();
        }
    }
}
